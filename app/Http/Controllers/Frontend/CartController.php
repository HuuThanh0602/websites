<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Services\CartService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface  as ProvinceRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface  as PromotionRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface  as OrderRepository;
use App\Http\Requests\StoreCartRequest;
use Cart;
use App\Classes\Vnpay;
use App\Classes\Momo;
use App\Classes\Paypal;
use App\Classes\Zalo;
use App\Models\Cart as ModelsCart;
use App\Models\CartDetail;
use App\Models\CartOrderDetail;
use App\Models\CartOrders;
use App\Models\Price_group;
use App\Models\Price_group_deatil;
use App\Models\Price_range;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stringable;
use Illuminate\Support\Str;


class CartController extends FrontendController
{

    protected $provinceRepository;
    protected $promotionRepository;
    protected $orderRepository;
    protected $cartService;
    protected $vnpay;
    protected $momo;
    protected $paypal;
    protected $zalo;

    public function __construct(
        ProvinceRepository $provinceRepository,
        PromotionRepository $promotionRepository,
        OrderRepository $orderRepository,
        CartService $cartService,
        Vnpay $vnpay,
        Momo $momo,
        Paypal $paypal,
        Zalo $zalo,
    ) {

        $this->provinceRepository = $provinceRepository;
        $this->promotionRepository = $promotionRepository;
        $this->orderRepository = $orderRepository;
        $this->cartService = $cartService;
        $this->vnpay = $vnpay;
        $this->momo = $momo;
        $this->paypal = $paypal;
        $this->zalo = $zalo;
        parent::__construct();
    }


    public function checkout(Request $request,$type = null )
    {
        $customer_id = auth()->guard('customer')->id();

        if (!$customer_id) {
            return redirect()->route('fe.auth.login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $provinces = $this->provinceRepository->all();
        $customer_id = auth()->guard('customer')->id();
        $carts = Cart::instance('shopping')->content();
        $cartCaculate = $this->cartService->reCaculateCart();
        $cartPromotion = $this->cartService->cartPromotion($cartCaculate['cartTotal']);
        $seo = [
            'meta_title' => 'Trang thanh toán đơn hàng',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => write_url('thanh-toan', TRUE, TRUE),
        ];
        if ($type != null) {
            $selectedProducts = $request->selected_products; // Mảng JSON từ form
            $decodedProducts = []; // Mảng chứa dữ liệu sau khi giải mã
            
            if (!empty($selectedProducts)) {
                foreach ($selectedProducts as $product) {
                    $productData = json_decode($product, true); // Giải mã JSON thành mảng
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $decodedProducts[] = $productData; // Lưu vào mảng
                    }
                }
            }
        
            // Kiểm tra kết quả
            //dd($decodedProducts);
        
            if ($type == 2) {
                $cart_id = ModelsCart::where('customer_id', $customer_id)->first();
                $carts = CartDetail::with('product', 'product_name', 'variant')->where('cart_id', $cart_id->ID)->get();
            } else {
                $cart_id = CartOrders::where('customer_id', $customer_id)->first();
                $carts = CartOrderDetail::with('product', 'product_name', 'variant')->where('cart_order_id', $cart_id->id)->get();
            }
        
            $convertedItems = [];
            
            foreach ($carts as $cart) {
                // Kiểm tra xem sản phẩm trong $carts có khớp với thông tin trong $decodedProducts không
                foreach ($decodedProducts as $decodedProduct) {
                    if (
                        $cart->product_id == $decodedProduct['product_id'] && // So sánh _product_id
                        $cart->product_variant_id == $decodedProduct['product_variant_id'] 
                    ) {
                        $rowId = Str::uuid()->toString();
                        // Nếu khớp, thêm sản phẩm vào mảng $convertedItems
                        $convertedItems[$rowId] = (object) [
                            'rowId' => $rowId,
                            'id' => $cart->product_id,
                            'qty' => (string) $cart->quantity,
                            'name' => optional($cart->product_name)->name ?? 'Sản phẩm không tồn tại',
                            'price' => (float) $cart->unit_price,
                            'attribute' => ($cart->variant)->name,
                            'options' => (object) [],
                            'associatedModel' => null,
                            'product_variant_id' => $cart->product_variant_id,
                            'taxRate' => 0,
                            'priceOriginal' => (float) $cart->unit_price,
                            'image' => optional($cart->product)->image ?? '',
                            'cart' => 2, // Đây là giá trị bạn cần tùy chỉnh
                        ];
                    }
                }
            }
            $carts = $convertedItems;
            //dd($carts);
        }
        
        $system = $this->system;
        $config = $this->config();
        return view('frontend.cart.index', compact(
            'config',
            'seo',
            'system',
            'provinces',
            'carts',
            'cartPromotion',
            'cartCaculate',
            'type'
        ));
    }

    public function store(StoreCartRequest $request)
    {
        $customer_id = auth()->guard('customer')->id();

        if (!$customer_id) {
            return redirect()->route('fe.auth.login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $customerID = Auth::guard('customer')->id();
        $request['customer_id'] = $customerID;
        if ($request->type != null) {
            if ($request->type  == 2) {
                $cart_id = ModelsCart::where('customer_id', $customer_id)->first();
                $carts = CartDetail::with('product', 'product_name', 'variant')->where('cart_id', $cart_id->ID)->get();
            } else {
                $cart_id = CartOrders::where('customer_id', $customer_id)->first();
                $carts = CartOrderDetail::with('product', 'product_name', 'variant')->where('cart_order_id', $cart_id->id)->get();
            }
        
            $convertedItems = [];
            
            foreach ($carts as $cart) {
                // Kiểm tra xem sản phẩm trong $carts có khớp với thông tin trong $decodedProducts không
                foreach ($request->products as $p) {
                    if (
                        $cart->product_id == $p['product_id'] && // So sánh _product_id
                        $cart->product_variant_id == $p['product_variant_id'] 
                    ) {
                        $rowId = Str::uuid()->toString();
                        $convertedItems[$rowId] = (object) [
                            'rowId' => $rowId,
                            'id' => $cart->product_id,
                            'qty' => (string) $p['quantity'],
                            'name' => optional($cart->product_name)->name ?? 'Sản phẩm không tồn tại',
                            'price' => (float) $cart->unit_price,
                            'attribute' => ($cart->variant)->name,
                            'options' => (object) [],
                            'associatedModel' => null,
                            'product_variant_id' => $cart->product_variant_id,
                            'taxRate' => 0,
                            'priceOriginal' => (float) $cart->unit_price,
                            'image' => optional($cart->product)->image ?? '',
                            'cart' => 2, // Đây là giá trị bạn cần tùy chỉnh
                        ];
                    }
                }
            }

            $carts = $convertedItems;
            //dd($carts);
            $convertedItems = [];
            foreach ($carts as $cart) {
                $rowId = Str::uuid()->toString();
                $convertedItems[$rowId] = (object) [
                    'rowId' => $rowId,
                    'id' => $cart->id,
                    'qty' => (string) $cart->qty,
                    'name' => $cart->name?? 'Sản phẩm không tồn tại',
                    'price' => (float) $cart->price,
                    'attribute' => $cart->attribute,
                    'product_variant_id' => $cart->product_variant_id,
                    'options' => (object) [],
                    'associatedModel' => null,
                    'taxRate' => 0,
                    'priceOriginal' => (float) $cart->priceOriginal,
                    'image' => $cart->image ?? '',
                    'cart' => 2,
                ];
            }
            $carts = $convertedItems;
            //dd($carts);
            $request->merge(['carts' => $carts]);
        }

        $system = $this->system;
        $order = $this->cartService->order($request, $system,);

        if ($order['flag']) {

            if ($request->type == 2) {
                $order['order']->update(['by_order' => 0]);
            } else {
                $order['order']->update(['by_order' => 1]);
            }
                
            if ($order['order']->method !== 'cod') {
                $response = $this->paymentMethod($order);
                if ($response['errorCode'] == 0) {
                    return redirect()->away($response['url']);
                }
            }
            //dd($order['order']->code);
            return redirect()->route('cart.success', ['code' => $order['order']->code])
                ->with('success', 'Đặt hàng thành công');
        }

        return redirect()->route('cart.checkout')->with('error', 'Đặt hàng không thành công. Hãy thử lại');
    }


    public function success($code)
    {
        $order = $this->orderRepository->findByCondition([
            ['code', '=', $code],
        ], false, ['products']);
        //dd($order);
        $seo = [
            'meta_title' => 'Thanh toán đơn hàng thành công',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => write_url('cart/success', TRUE, TRUE),
        ];
        $system = $this->system;
        $config = $this->config();
        return view('frontend.cart.success', compact(
            'config',
            'seo',
            'system',
            'order'
        ));
    }

    public function paymentMethod($order = null)
    {
        $class = $order['order']->method;
        $response = $this->{$class}->payment($order['order']);
        return $response;
    }

    private function config()
    {
        return [
            'language' => $this->language,
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/location.js',
                'frontend/core/library/cart.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
    }

    public function storeCart(Request $request)
    {
//dd($request->all());
        $customer_id = auth()->guard('customer')->id();

        if (!$customer_id) {
            return redirect()->route('fe.auth.login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }
        //dd($request->all());
        $customer_id = auth()->guard('customer')->id();
        $qty = $request->input('qty_cart', 1);
        $unit_price = $request->input('price_cart', 0);
        $product_id = $request->input('id_item');
        $product_variant_id = $request->input('variant');

        // Kiểm tra giỏ hàng đã tồn tại chưa
        $cart = ModelsCart::where('customer_id', $customer_id)->first();

        if (!$cart) {
            $cart = ModelsCart::create(['customer_id' => $customer_id]);
            $cart->refresh();
        }

        $cart_id = $cart->ID; 

        if (!$cart_id) {
            return redirect()->back()->with('error', 'Lỗi khi tạo giỏ hàng.');
        }

        // Kiểm tra sản phẩm có trong giỏ hàng chưa
        $item = CartDetail::where('cart_id', $cart_id)
            ->where('product_id', $product_id)
            ->where('product_variant_id', $product_variant_id)
            ->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartDetail::create([
                'cart_id' => $cart_id,
                'product_id' => $product_id,
                'product_variant_id' => $product_variant_id,
                'unit_price' => $unit_price,
                'quantity' => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công');
    }
    public function storeCartOrder(Request $request)
    {
        $customer_id = auth()->guard('customer')->id();

        if (!$customer_id) {
            return redirect()->route('fe.auth.login')->with('error', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $qty = $request->input('qty_cart', 1);
        $unit_price = $request->input('price_cart', 0);
        $product_id = $request->input('id_item');
        $product_variant_id = $request->input('variant');

        // Kiểm tra giỏ hàng đã tồn tại chưa
        $cart = CartOrders::where('customer_id', $customer_id)->first();

        if (!$cart) {
            $cart = CartOrders::create(['customer_id' => $customer_id]);
            $cart->refresh();
        }

        // Chắc chắn $cart đã có ID
        $cart_id = $cart->id;

        // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
        $item = CartOrderDetail::where('cart_order_id', $cart_id)
            ->where('product_id', $product_id)
            ->where('product_variant_id', $product_variant_id)
            ->first();

        if ($item) {
            $item->quantity += $qty;
            $item->save();
        } else {
            CartOrderDetail::create([
                'cart_order_id' => $cart_id,
                'product_id' => $product_id,
                'product_variant_id' => $product_variant_id,
                'unit_price' => $unit_price,
                'quantity' => $qty
            ]);
        }

        return redirect()->back()->with('success', 'Thêm vào giỏ hàng thành công');
    }


    public function cart($type = null)
    {
        $provinces = $this->provinceRepository->all();
        $customer_id = auth()->guard('customer')->id();

        if (!$customer_id) {
            return redirect()->route('fe.auth.login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $cartCaculate = $this->cartService->reCaculateCart();
        $cartPromotion = $this->cartService->cartPromotion($cartCaculate['cartTotal']);

        $seo = [
            'meta_title' => 'Trang thanh toán đơn hàng',
            'meta_keyword' => '',
            'meta_description' => '',
            'meta_image' => '',
            'canonical' => write_url('thanh-toan', TRUE, TRUE),
        ];

        if ($type == 2) {
            $cart = ModelsCart::where('customer_id', $customer_id)->first();

            if ($cart) {
                $carts1 = CartDetail::select('cart_details.*', 'product_variant_language.name')
                    ->join('product_variant_language', 'cart_details.product_variant_id', '=', 'product_variant_language.product_variant_id')
                    ->where('cart_details.cart_id', $cart->ID)
                    ->get();
                // dd($carts1);
            } else {
                $carts1 = collect();
            }
        } else {
            $cart = CartOrders::where('customer_id', $customer_id)->first();

            if ($cart) {
                $carts1 = CartOrderDetail::select('cart_order_details.*', 'product_variant_language.name')
                    ->join('product_variant_language', 'cart_order_details.product_variant_id', '=', 'product_variant_language.product_variant_id')
                    ->where('cart_order_details.cart_order_id', $cart->id)
                    ->get();
            } else {
                $carts1 = collect();
            }
        }
        

        $convertedItems = [];

        foreach ($carts1 as $cartItem) {
            $rowId = Str::uuid()->toString();
            $attributes = ProductVariant::select(
                'product_variants.*', 
                'product_variant_attribute.*', 
                'attributes.*', 
                'attribute_language.*'
            )
            ->join('product_variant_attribute', 'product_variants.id', '=', 'product_variant_attribute.product_variant_id')
            ->join('attributes', 'product_variant_attribute.attribute_id', '=', 'attributes.id')
            ->join('attribute_language', 'attributes.id', '=', 'attribute_language.attribute_id')
            ->where('product_variants.product_id', $cartItem->product_id)
            ->get();
            $totalQuantity = $attributes->sum('quantity');
            $convertedItems[$rowId] = (object) [
                'rowId' => $rowId,
                'id' => $cartItem->product_id,
                'qty' => (string) $cartItem->quantity,
                'quantity'=>$totalQuantity,
                'name' => optional($cartItem->product_name)->name ?? 'Sản phẩm không tồn tại',
                'price' => (float) $cartItem->unit_price,
                'attribute' => $cartItem->name,
                'product_variant_id' => $cartItem->product_variant_id,
                'options' => (object) [],
                'associatedModel' => null,
                'taxRate' => 0,
                'priceOriginal' => (float) $cartItem->unit_price,
                'image' => optional($cartItem->product)->image ?? '',
                'cart' => $type,
                'attribute'=>$attributes,
            ];
        }
        $carts = $convertedItems;
        //dd($carts);
        $system = $this->system;
        $config = $this->config();
        return view('frontend.cart.cart', compact(
            'config',
            'seo',
            'system',
            'provinces',
            'carts',
            'cartPromotion',
            'cartCaculate',
            'type',
        ));
    }


    public function update2(Request $request)
    {
        //dd(1);
        $customer_id = auth()->guard('customer')->id();

        if ($request->type == 2) {
            $cart = ModelsCart::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }
            CartDetail::where('cart_id', $cart->ID)
                ->where('product_id', $request->product_id)
                ->where('product_variant_id', $request->product_variant_id)
                ->update(['quantity' => DB::raw("GREATEST(quantity + {$request->change}, 1)")]);
        } else {
            $cart = CartOrders::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }
            CartOrderDetail::where('cart_order_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->where('product_variant_id', $request->product_variant_id)
                ->update(['quantity' => DB::raw("GREATEST(quantity + {$request->change}, 1)")]);
        }

        return redirect()->back()->with('success', 'Cập nhật giỏ hàng thành công!');
    }


    public function remove(Request $request)
    {
        $customer_id = auth()->guard('customer')->id();

        // Kiểm tra loại giỏ hàng (type)
        if ($request->type == 2) {
            // Giỏ hàng thông thường
            $cart = ModelsCart::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }

            // Sử dụng DB để xóa sản phẩm cụ thể trong giỏ hàng
            $deleted = DB::table('cart_details')
                ->where('cart_id', $cart->ID)
                ->where('product_id', $request->product_id)
                ->where('product_variant_id', $request->product_variant_id)
                ->delete();
        } else {
            // Giỏ hàng order
            $cart = CartOrders::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }

            // Sử dụng DB để xóa sản phẩm cụ thể trong giỏ hàng order
            $deleted = DB::table('cart_order_details')
                ->where('cart_order_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->where('product_variant_id', $request->product_variant_id)
                ->delete();
        }

        // Kiểm tra xem có sản phẩm nào bị xóa không
        if ($deleted) {
            return redirect()->back()->with('success', 'Xóa sản phẩm khỏi giỏ hàng thành công!');
        }

        // Nếu không tìm thấy sản phẩm
        return redirect()->back()->with('error', 'Không tìm thấy sản phẩm trong giỏ hàng!');
    }


    public function updateAttribute(Request $request)
    {
        $customer_id = auth()->guard('customer')->id();
        $type = $request->type;
        $product_id = $request->product_id;
        $old_product_variant_id = $request->product_variant_id; // Giá trị cũ
        $new_product_variant_id = $request->new_product_variant_id; // Giá trị mới
    
        if ($old_product_variant_id == $new_product_variant_id) {
            return redirect()->back()->with('success', 'Không có thay đổi trong thuộc tính sản phẩm!');
        }
    
        if ($type == 2) {
            $cart = ModelsCart::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }
    
            // Lấy bản ghi trước để lấy unit_price
            $cartDetail = DB::table('cart_details')
                ->where('cart_id', $cart->ID)
                ->where('product_id', $product_id)
                ->where('product_variant_id', $old_product_variant_id)
                ->first();
    
            if (!$cartDetail) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
            }
    
            $unit_price = $cartDetail->unit_price; // Lấy unit_price từ bản ghi
    
            // Xóa bản ghi cũ
            $deleted = DB::table('cart_details')
                ->where('cart_id', $cart->ID)
                ->where('product_id', $product_id)
                ->where('product_variant_id', $old_product_variant_id)
                ->delete();
    
            if ($deleted) {
                // Thêm bản ghi mới với unit_price cũ
                CartDetail::create([
                    'cart_id' => $cart->ID,
                    'product_id' => $product_id,
                    'product_variant_id' => $new_product_variant_id,
                    'quantity' => 1,
                    'unit_price' => $unit_price // Sử dụng unit_price từ bản ghi cũ
                ]);
            }
        } else {
            $cart = CartOrders::where('customer_id', $customer_id)->first();
            if (!$cart) {
                return redirect()->back()->with('error', 'Giỏ hàng không tồn tại!');
            }
    
            // Lấy bản ghi trước để lấy unit_price
            $cartOrderDetail = DB::table('cart_order_details')
                ->where('cart_order_id', $cart->id)
                ->where('product_id', $product_id)
                ->where('product_variant_id', $old_product_variant_id)
                ->first();
    
            if (!$cartOrderDetail) {
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại trong giỏ hàng!');
            }
    
            $unit_price = $cartOrderDetail->unit_price; // Lấy unit_price từ bản ghi
    
            // Xóa bản ghi cũ
            $deleted = DB::table('cart_order_details')
                ->where('cart_order_id', $cart->id)
                ->where('product_id', $product_id)
                ->where('product_variant_id', $old_product_variant_id)
                ->delete();
    
            if ($deleted) {
                // Thêm bản ghi mới với unit_price cũ
                DB::table('cart_order_details')->insert([
                    'cart_order_id' => $cart->id,
                    'product_id' => $product_id,
                    'product_variant_id' => $new_product_variant_id,
                    'quantity' => 1,
                    'unit_price' => $unit_price // Sử dụng unit_price từ bản ghi cũ
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Cập nhật thuộc tính sản phẩm thành công!');
    }

}
