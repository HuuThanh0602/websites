<?php

namespace App\Http\Controllers\Backend\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProductServiceInterface  as ProductService;
use App\Repositories\Interfaces\ProductRepositoryInterface  as ProductRepository;
use App\Repositories\Interfaces\AttributeRepositoryInterface  as AttributeRepository;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface  as AttributeCatalogueRepository;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Classes\Nestedsetbie;
use App\Models\Language;
use App\Models\Price_group;
use App\Models\Price_range;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCatalogue;
use App\Models\Sub_brand;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected $productService;
    protected $productRepository;
    protected $languageRepository;
    protected $language;
    protected $attributeCatalogue;
    protected $attributeRepository;

    public function __construct(
        ProductService $productService,
        ProductRepository $productRepository,
        AttributeCatalogueRepository $attributeCatalogue,
        AttributeRepository $attributeRepository,
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale(); // vn en cn
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });

        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->attributeCatalogue = $attributeCatalogue;
        $this->attributeRepository = $attributeRepository;
        $this->initialize();
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    }

    public function togglePublish(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $currentPublish = $product->publish;
        $newPublish = $request->publish;

        $hasStock = $product->product_variants()->where('quantity', '>', 0)->exists();

        if ($hasStock && $currentPublish == 1 && $newPublish == 2) {
            return redirect()->back()->with('error', 'Sản phẩm còn hàng, không thể ẩn.');
        }

        $product->update(['publish' => $newPublish]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
    }



    public function index(Request $request)
    {
        $this->authorize('modules', 'product.index');
        $products = $this->productService->paginate($request, $this->language);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Product'
        ];
        $config['seo'] = __('messages.product');
        $template = 'backend.product.product.index';
        $dropdown  = $this->nestedset->Dropdown();
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'products',
        ));
    }

    public function create()
    {
        $price_ranges = Price_range::select(
            'price_ranges.id as price_range_id',
            'sub_brands.id as sub_brand_id',
            'price_ranges.*',
            'product_brand_language.name as brand_name',
            'sub_brands.name as sub_name'
        )
            ->leftJoin('sub_brands', 'price_ranges.sub_brand_id', '=', 'sub_brands.id')
            ->leftJoin('product_brand_language', 'sub_brands.brand_id', '=', 'product_brand_language.product_brand_id')->get();
        //dd($price_ranges);

        $price_groups = DB::table('price_group')
            ->leftJoin('price_group_detail', 'price_group.id', '=', 'price_group_detail.price_group_id')
            ->leftJoin('product_brand_language', 'price_group_detail.product_brand_id', '=', 'product_brand_language.product_brand_id')
            ->leftJoin('product_catalogue_language', 'price_group_detail.product_catalogue_id', '=', 'product_catalogue_language.product_catalogue_id')
            ->leftJoin('sub_brands', 'price_group_detail.sub_brand_id', '=', 'sub_brands.id')
            ->select(
                'price_group.id as price_group_id',
                'price_group.name as price_group_name',
                'price_group.shipping',
                'price_group.exchange_rate',
                'price_group_detail.product_brand_id',
                'product_brand_language.name as brand_name',
                'price_group_detail.sub_brand_id',
                'sub_brands.name as sub_brand_name',
                'price_group_detail.product_catalogue_id',
                'product_catalogue_language.name as catalogue_name',
                'price_group_detail.discount'
            )->get();
        //dd($price_groups);
        $codeProduct = time();
        $this->authorize('modules', 'product.create');
        $attributeCatalogue = $this->attributeCatalogue->getAll($this->language);
        $config = $this->configData();
        $config['seo'] = __('messages.product');
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.product.product.store';
        $sub_brands = Sub_brand::with('prices')->get();
        //dd($sub_brands);
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'attributeCatalogue',
            'brands',
            'sub_brands',
            'price_ranges',
            'price_groups',
            'codeProduct'
        ));
    }

    public function store(StoreProductRequest $request)
    {
        $request->merge([
            'change_discount' => $request->change_discount ?? 1
        ]);
        if ($this->productService->create($request, $this->language)) {
            return redirect()->route('product.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('product.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id, Request $request)
    {
        $price_ranges = Price_range::select(
            'price_ranges.id as price_range_id',
            'sub_brands.id as sub_brand_id',
            'price_ranges.*',
            'product_brand_language.name as brand_name',
            'sub_brands.name as sub_name'
        )
            ->leftJoin('sub_brands', 'price_ranges.sub_brand_id', '=', 'sub_brands.id')
            ->leftJoin('product_brand_language', 'sub_brands.brand_id', '=', 'product_brand_language.product_brand_id')->get();
        //dd($price_ranges);

        $price_groups = DB::table('price_group')
            ->leftJoin('price_group_detail', 'price_group.id', '=', 'price_group_detail.price_group_id')
            ->leftJoin('product_brand_language', 'price_group_detail.product_brand_id', '=', 'product_brand_language.product_brand_id')
            ->leftJoin('product_catalogue_language', 'price_group_detail.product_catalogue_id', '=', 'product_catalogue_language.product_catalogue_id')
            ->leftJoin('sub_brands', 'price_group_detail.sub_brand_id', '=', 'sub_brands.id')
            ->select(
                'price_group.id as price_group_id',
                'price_group.name as price_group_name',
                'price_group.shipping',
                'price_group.exchange_rate',
                'price_group_detail.product_brand_id',
                'product_brand_language.name as brand_name',
                'price_group_detail.sub_brand_id',
                'sub_brands.name as sub_brand_name',
                'price_group_detail.product_catalogue_id',
                'product_catalogue_language.name as catalogue_name',
                'price_group_detail.discount'
            )->get();
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();
        $sub_brands = Sub_brand::all();
        $this->authorize('modules', 'product.update');
        $product = $this->productRepository->getProductById($id, $this->language);
        $attributeCatalogue = $this->attributeCatalogue->getAll($this->language);
        $queryUrl = $request->getQueryString();
        $config = $this->configData();
        $config['seo'] = __('messages.product');
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $album = json_decode($product->album);
        //dd($product);
        $template = 'backend.product.product.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'product',
            'album',
            'attributeCatalogue',
            'queryUrl',
            'brands',
            'sub_brands',
            'price_ranges',
            'price_groups'
        ));
    }

    public function update($id, UpdateProductRequest $request)
    {
        $queryUrl = base64_decode($request->getQueryString());
        //dd($request->All());
        if ($this->productService->update($id, $request, $this->language)) {
            return redirect()->route('product.index', $queryUrl)->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('product.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        $this->authorize('modules', 'product.destroy');
        $config['seo'] = __('messages.product');
        $product = $this->productRepository->getProductById($id, $this->language);
        $template = 'backend.product.product.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'product',
            'config',
        ));
    }

    public function destroy($id)
    {
        if ($this->productService->destroy($id, $this->language)) {
            return redirect()->route('product.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('product.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }

    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'backend/library/variant.js',
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/plugins/nice-select/js/jquery.nice-select.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                'backend/plugins/nice-select/css/nice-select.css',
                'backend/css/plugins/switchery/switchery.css',
            ]

        ];
    }
}
