<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\ProductCatalogueServiceInterface  as ProductCatalogueService;
use App\Repositories\Interfaces\ProductCatalogueRepositoryInterface  as ProductCatalogueRepository;
use App\Http\Requests\Product\StoreProductCatalogueRequest;
use App\Http\Requests\Product\UpdateProductCatalogueRequest;
use App\Http\Requests\Product\DeleteProductCatalogueRequest;
use App\Classes\Nestedsetbie;

use App\Models\Language;
use App\Models\ProductBrand;
use App\Models\ProductBrandLanguage;
use Illuminate\Support\Facades\DB;
use PayPal\Api\Transaction;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $productCatalogueService;
    protected $productCatalogueRepository;
    protected $nestedset;
    protected $language;

    public function __construct(
        ProductCatalogueService $productCatalogueService,
        ProductCatalogueRepository $productCatalogueRepository
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });


        $this->productCatalogueService = $productCatalogueService;
        $this->productCatalogueRepository = $productCatalogueRepository;
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'product_catalogues',
            'foreignkey' => 'product_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    }

    public function updateStatus(Request $request)
    {
        // dd($request->value);
        $item = ProductBrand::findOrfail($request->id);
        $a=$item->update(['publish' => $request->value]);
        //dd($item);
        if ($a) {
            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy bản ghi.');
    }
    

//     public function index(Request $request)
// {
//     $this->authorize('modules', 'product.catalogue.index');
//     $perPage = $request->get('perpage', 20);
//     $publish = $request->get('publish', null);
//     $keyword = $request->get('keyword', '');
    
//     $product_brands = ProductBrand::select('product_brands.*', 'product_brand_language.name as brand_name')
//         ->join('product_brand_language', 'product_brand_language.product_brand_id', '=', 'product_brands.id')
//         ->when(!is_null($publish) && $publish != 0, function ($query) use ($publish) {
//             return $query->where('product_brands.publish', $publish);
//         })
//         ->when(!empty($keyword), function ($query) use ($keyword) {
//             return $query->where('product_brand_language.name', 'LIKE', "%{$keyword}%");
//         })
//         ->paginate($perPage);
    
//     $config = [
//         'js' => [
//             'backend/js/plugins/switchery/switchery.js',
//             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
//         ],
//         'css' => [
//             'backend/css/plugins/switchery/switchery.css',
//             'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
//         ],
//         'model' => 'ProductCatalogue',
//     ];
//     $config['seo'] = __('messages.productCatalogue');
//     $template = 'backend.brand.index';

//     return view('backend.dashboard.layout', compact(
//         'template',
//         'config',
//         'product_brands'
//     ));
// }

public function index(Request $request)
{
    $this->authorize('modules', 'product.catalogue.index');


    // Lấy giá trị từ request, nếu không có thì sử dụng giá trị mặc định
    $perPage = $request->get('perpage', 20);
    $publish = $request->get('publish', null);
    $keyword = $request->get('keyword', '');


    // Query danh sách thương hiệu
    $product_brands = ProductBrand::with('brand_language');


    // Nếu `publish` không tồn tại trong request hoặc rỗng, lấy mặc định cả 1 và 2
    if ($publish === null || $publish === ''|| $publish === '0') {
        $product_brands = $product_brands->whereIn('publish', [1, 2]);
    } else {
        // Nếu `publish` có giá trị (kể cả `0`), lọc theo giá trị đó
        $product_brands = $product_brands->where('publish', $publish);
    }


    // Nếu có từ khóa tìm kiếm
    if (!empty($keyword)) {
        $product_brands = $product_brands->whereHas('brand_language', function ($query) use ($keyword) {
            $query->where('name', 'LIKE', "%{$keyword}%");
        });
    }


    // Phân trang dữ liệu
    $product_brands = $product_brands->paginate($perPage);


    // Cấu hình giao diện
    $config = [
        'js' => [
            'backend/js/plugins/switchery/switchery.js',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
        ],
        'css' => [
            'backend/css/plugins/switchery/switchery.css',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
        ],
        'model' => 'ProductCatalogue',
    ];
    $config['seo'] = __('messages.productCatalogue');
    $template = 'backend.brand.index';


    // Render giao diện với dữ liệu
    return view('backend.dashboard.layout', compact(
        'template',
        'config',
        'product_brands'
    ));
}

    public function create()
    {
        $this->authorize('modules', 'product.catalogue.create');
        $config = $this->configData();
        $config['seo'] = __('messages.productCatalogue');
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.brand.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical'        => 'nullable|string|max:255',
            'image'            => 'nullable',
            'publish'          => 'required|integer|in:0,1,2',
            'follow'           => 'nullable|integer|in:0,1', 
        ], [
            'name.required'        => 'Tên thương hiệu không được để trống!',
            'name.max'             => 'Tên thương hiệu không được vượt quá 255 ký tự!',
            'publish.required'     => 'Trạng thái là bắt buộc!',
            'publish.in'           => 'Trạng thái không hợp lệ!',
            'image.max'            => 'Đường dẫn ảnh không được vượt quá 255 ký tự!',
            'follow.in'            => 'Giá trị Follow không hợp lệ!',
        ]);
            DB::transaction(function () use ($request) {
                $brand = ProductBrand::create([
                    'image'   => $request->image,
                    'publish' => $request->publish,
                    'user_id' => auth()->id(), 
                ]);
                ProductBrandLanguage::create([
                    'language_id'=>1,
                    'name'             => $request->name,
                    'description'      => $request->description,
                    'content'          => $request->content,
                    'meta_title'       => $request->meta_title,
                    'meta_keyword'     => $request->meta_keyword,
                    'meta_description' => $request->meta_description,
                    'product_brand_id' => $brand->id,
                ]);
            });
    
            return redirect()->route('brand.index')->with('success', 'Tạo thương hiệu thành công!');

            return redirect()->back()->with('error', 'Lỗi khi tạo thương hiệu: ' . $e->getMessage());
        
    }
    

    public function edit($id, Request $request)
    {
        $productBrand = ProductBrand::select(
            'product_brands.*', 
            'product_brand_language.*'
        )
        ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
        ->where('product_brands.id', $id)
        ->first();
        $queryUrl = $request->getQueryString();
        $config = $this->configData();
        $config['seo'] = __('messages.productCatalogue');
        $config['method'] = 'edit';
        $dropdown  = $this->nestedset->Dropdown();
        $template = 'backend.brand.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'dropdown',
            'productBrand',
            'queryUrl'
        ));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_keyword'     => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'canonical'        => 'nullable|string|max:255',
            'image'            => 'nullable|string|max:255',
            'publish'          => 'required|integer|in:0,1,2',
            'follow'           => 'nullable|integer|in:0,1', 
        ], [
            'name.required'        => 'Tên thương hiệu không được để trống!',
            'name.max'             => 'Tên thương hiệu không được vượt quá 255 ký tự!',
            'publish.required'     => 'Trạng thái là bắt buộc!',
            'publish.in'           => 'Trạng thái không hợp lệ!',
            'image.max'            => 'Đường dẫn ảnh không được vượt quá 255 ký tự!',
            'follow.in'            => 'Giá trị Follow không hợp lệ!',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $brand = ProductBrand::findOrFail($id);
                $brand->update([
                    'image'   => $request->image,
                    'publish' => $request->publish,
                    'user_id' => auth()->id(), 
                ]);

                ProductBrandLanguage::updateOrCreate(
                    ['product_brand_id' => $id],
                    [
                        'language_id'      => 1,
                        'name'             => $request->name,
                        'description'      => $request->description,
                        'content'          => $request->content,
                        'meta_title'       => $request->meta_title,
                        'meta_keyword'     => $request->meta_keyword,
                        'meta_description' => $request->meta_description,
                    ]
                );
                
            });
            return redirect()->route('brand.index')->with('success', 'Cập nhật bản ghi thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật bản ghi không thành công. Lỗi: ' . $e->getMessage());
        }
    }


    public function delete($id)
    {
        $this->authorize('modules', 'product.catalogue.destroy');
        $config['seo'] = __('messages.productCatalogue');
        $productBrand = ProductBrand::select(
            'product_brands.*', 
            'product_brand_language.*'
        )
        ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
        ->where('product_brands.id', $id)
        ->first();
        $template = 'backend.brand.delete';
        return view('backend.dashboard.layout', compact(
            'template',
            'productBrand',
            'config',
        ));
    }

    public function destroy(Request $request, $id)
{

    try {
        DB::transaction(function () use ($id) {
            
            ProductBrandLanguage::where('product_brand_id', $id)->delete();

            ProductBrand::where('id', $id)->delete();
        });

        return redirect()->route('brand.index')->with('success', 'Xóa bản ghi thành công');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }
}


    private function configData()
    {
        return [
            'js' => [
                'backend/plugins/ckeditor/ckeditor.js',
                'backend/plugins/ckfinder_2/ckfinder.js',
                'backend/library/finder.js',
                'backend/library/seo.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ]

        ];
    }
}
