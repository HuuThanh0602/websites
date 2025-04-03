<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FrontendController;
use App\Http\Requests\StoreCartRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

use App\Services\Interfaces\OrderServiceInterface  as OrderService;
use App\Repositories\Interfaces\OrderRepositoryInterface as OrderRepository;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Services\CartService;
use App\Services\WidgetService;

class OrderController extends FrontendController
{
    protected $orderService;
    protected $orderRepository;
    protected $widgetService;
    protected $provinceRepository;
    protected $cartService;


    public function __construct(
        OrderService $orderService,
        OrderRepository $orderRepository,
        WidgetService $widgetService,
        CartService $cartService,
        ProvinceRepository $provinceRepository,

    ) {
        $this->cartService = $cartService;
        $this->widgetService = $widgetService;
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
        $this->provinceRepository = $provinceRepository;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $order_new = Order::where('confirm', 'pending')
            ->where('delivery', 'pending')
            ->where('by_order', '!=', 1)
            ->count();

        $confirmed = Order::where('confirm', 'confirm')
            ->where('delivery', 'pending')
            ->where('by_order', '!=', 1)
            ->count();

        $packed = Order::where('confirm', 'confirm')
            ->where('delivery', 'pending')
            ->where('by_order', '!=', 1)
            ->count();

        $processing = Order::where('confirm', 'confirm')
            ->where('delivery', 'processing')
            ->where('by_order', '!=', 1)
            ->count();

        $success = Order::where('confirm', 'confirm')
            ->where('delivery', 'success')
            ->where('by_order', '!=', 1)
            ->count();

        $cancel = Order::where('confirm', 'cancel')
            ->where('delivery', 'pending')
            ->where('by_order', '!=', 1)
            ->count();

        $this->authorize('modules', 'order.index');
        $orders = $this->orderService->paginate($request);
        $config = [
            'js' => [
                'backend/library/order.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
                'backend/js/plugins/daterangepicker/daterangepicker.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'backend/css/plugins/daterangepicker/daterangepicker-bs3.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Order'
        ];
        //dd($orders->where('id','=',126));
        $config['seo'] = __('messages.order');
        $template = 'backend.order.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'orders',
            'order_new',
            'confirmed',
            'packed',
            'processing',
            'success',
            'cancel',
        ));
    }
    public function updateStatus(Request $request, $code)
    {
        $order = Order::where('code', $code)->firstOrFail();
        $order->confirm = $request->confirm;
        $order->save();

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật!');
    }


    public function detail(Request $request, $id)
    {
        $order = $this->orderRepository->getOrderById($id, ['products']);
        $order = $this->orderService->getOrderItemImage($order);

        $provinces = $this->provinceRepository->all();
        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/order.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
        ];

        $config['seo'] = __('messages.order');
        $template = 'backend.order.detail';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'order',
            'provinces',
        ));
    }
    public function create()
    {
        $provinces = $this->provinceRepository->all();
        $products = Product::with('product_language')->get();

        $config = [
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/order.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ],
        ];

        $config['seo'] = __('messages.order');
        $template = 'backend.order.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'products',
            'provinces'
        ));
    }
    public function store(StoreCartRequest $request)
    {
        $request['method'] = 'cod';

        $system = $this->system;
        $order = $this->cartService->order($request, $system);
        if ($order['flag']) {
            return redirect()->back()->with('success', 'Đặt hàng thành công');
        }
        return redirect()->back()->with('error', 'Đặt hàng không thành công. Hãy thử lại');
    }
}
