<?php

namespace App\Http\Controllers\Backend\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\AttributeCatalogueServiceInterface  as AttributeCatalogueService;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface  as AttributeCatalogueRepository;
use App\Classes\Nestedsetbie;
use App\Models\Language;
use App\Models\Price_group;
use App\Models\Price_group_deatil;
use App\Models\Price_group_history;
use App\Models\Price_group_history_deatil;
use App\Models\PriceGroupDetail;
use App\Models\ProductBrand;
use App\Models\ProductCatalogue;
use App\Models\Sub_brand;
use Illuminate\Support\Facades\DB;

class PriceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $attributeCatalogueService;
    protected $attributeCatalogueRepository;
    protected $nestedset;
    protected $language;
    protected $attributeCatalogue;

    public function __construct(
        AttributeCatalogueService $attributeCatalogueService,
        AttributeCatalogueRepository $attributeCatalogueRepository,

        AttributeCatalogueRepository $attributeCatalogue,
    ) {
        $this->middleware(function ($request, $next) {
            $locale = app()->getLocale();
            $language = Language::where('canonical', $locale)->first();
            $this->language = $language->id;
            $this->initialize();
            return $next($request);
        });


        $this->attributeCatalogueService = $attributeCatalogueService;
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;;
        $this->attributeCatalogue = $attributeCatalogue;
    }

    private function initialize()
    {
        $this->nestedset = new Nestedsetbie([
            'table' => 'attribute_catalogues',
            'foreignkey' => 'attribute_catalogue_id',
            'language_id' =>  $this->language,
        ]);
    }
    public function index(Request $request)
    {
        $perPage = $request->perpage ?? 20;
        $keyword = $request->keyword ?? null;

        $query = Price_group::query();

        if (request()->has('publish')) {
            $query->where('publish', request('publish'));
        }

        if (!empty(request('keyword'))) {
            $query->where('name', 'LIKE', '%' . request('keyword') . '%');
        }
        $price_groups = $query->paginate($perPage);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Price_group',
        ];
        $config['seo'] = __('messages.attributeCatalogue');
        $template = 'backend.price.group.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'price_groups'
        ));
    }

    public function create()
    {
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Price_group',
        ];
        $config['seo'] = __('messages.attributeCatalogue');
        $config['method'] = 'create';
        $dropdown  = $this->nestedset->Dropdown();

        $categorys = ProductCatalogue::with('product_catalogue_language')->get();
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();

        $sub_brands = Sub_brand::all();

        $template = 'backend.price.group.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'categorys',
            'brands',
            'sub_brands'
        ));
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:price_group,name|max:255',
            'shipping' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',

            'product_brand_id' => 'required|array',
            'product_brand_id.*' => 'integer|exists:product_brands,id',

            'sub_brand_id' => 'nullable|array',
            'sub_brand_id.*' => 'integer|exists:sub_brands,id',

            'product_catalogue_id' => 'required|array',
            'product_catalogue_id.*' => 'exists:product_catalogues,id',

            'discount' => 'nullable|array',
            'discount.*' => 'array',
            'discount.*.*' => 'numeric|min:0',
        ], [
            'name.required' => 'Tên nhóm giá không được để trống.',
            'name.string' => 'Tên nhóm giá phải là chuỗi ký tự.',
            'name.unique' => 'Tên nhóm giá đã tồn tại, vui lòng chọn tên khác.',
            'name.max' => 'Tên nhóm giá không được vượt quá 255 ký tự.',

            'shipping.required' => 'Phí vận chuyển không được để trống.',
            'shipping.numeric' => 'Phí vận chuyển phải là số.',
            'shipping.min' => 'Phí vận chuyển không được nhỏ hơn 0.',

            'exchange_rate.required' => 'Tỷ giá không được để trống.',
            'exchange_rate.numeric' => 'Tỷ giá phải là số.',
            'exchange_rate.min' => 'Tỷ giá không được nhỏ hơn 0.',

            'product_brand_id.required' => 'Thương hiệu sản phẩm là bắt buộc.',
            'product_brand_id.array' => 'Thương hiệu sản phẩm phải là mảng.',
            'product_brand_id.*.integer' => 'Mã thương hiệu sản phẩm phải là số nguyên.',
            'product_brand_id.*.exists' => 'Thương hiệu sản phẩm không hợp lệ.',

            'sub_brand_id.array' => 'Thương hiệu phụ phải là mảng.',
            'sub_brand_id.*.integer' => 'Mã thương hiệu phụ phải là số nguyên.',
            'sub_brand_id.*.exists' => 'Thương hiệu phụ không hợp lệ.',

            'product_catalogue_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'product_catalogue_id.array' => 'Danh mục sản phẩm phải là mảng.',
            'product_catalogue_id.*.exists' => 'Danh mục sản phẩm không hợp lệ.',

            'discount.array' => 'Danh sách giảm giá phải là mảng.',
            'discount.*.array' => 'Mỗi giá trị trong giảm giá phải là mảng.',
            'discount.*.*.numeric' => 'Mức giảm giá phải là số.',
            'discount.*.*.min' => 'Mức giảm giá không được nhỏ hơn 0.',
        ]);

        $user_id = auth()->check() ? auth()->user()->id : null;

        DB::beginTransaction();
        try {
            $priceGroup = Price_group::create([
                "name" => $request->name,
                "shipping" => $request->shipping,
                "exchange_rate" => $request->exchange_rate,
                'user_id' =>  $user_id
            ]);
    
            $priceGroupDetails = [];
            foreach ($request->product_catalogue_id as $index => $catalogueIds) {
                foreach ($catalogueIds as $key => $catalogueId) {
                    if (!is_null($request->discount[$index][$key])) {
                        $priceGroupDetails[] = [
                            "price_group_id" => $priceGroup->id,
                            "product_brand_id" => $request->product_brand_id[$index],
                            "sub_brand_id" => $request->sub_brand_id[$index] ?? null,
                            "product_catalogue_id" => $catalogueId,
                            "discount" => $request->discount[$index][$key],
                            'user_id' =>  $user_id
                        ];
                    }
                }
            }
    
            if (!empty($priceGroupDetails)) {
                Price_group_deatil::insert($priceGroupDetails);
            }
    
            DB::commit();
            return redirect()->route('price_group.index')->with('success', 'Thêm mới bản ghi thành công');
    
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('price_group.index')->with('error', 'Lỗi khi thêm mới bản ghi: ' . $e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Lấy thông tin price_group cùng với các details
        $price_group = Price_group::with('details')->findOrFail($id);

        // Nhóm details theo product_brand_id và sub_brand_id
        $groupedDetails = $price_group->details->groupBy(function ($detail) {
            return $detail->product_brand_id . '-' . $detail->sub_brand_id;
        });

        // Lấy danh sách brands và sub_brands
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();

        $sub_brands = Sub_brand::all(); // Giả định bảng sub_brands và model SubBrand
        $categorys = ProductCatalogue::with('product_catalogue_language')->get();

        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'PriceGroup',
        ];
        $config['seo'] = 'Sửa nhóm giá';
        $config['method'] = 'edit';
        $dropdown = $this->nestedset->Dropdown();

        $template = 'backend.price.group.edit';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'categorys',
            'brands',
            'sub_brands',
            'price_group',
            'groupedDetails' // Truyền nhóm details vào view
        ));
    }

public function update(Request $request, string $id)
{
    DB::beginTransaction();

    try {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'shipping' => 'required|numeric|min:0',
            'exchange_rate' => 'required|numeric|min:0',
            'product_brand_id' => 'required|array',
            'product_brand_id.*' => 'integer|exists:product_brands,id',
            'sub_brand_id' => 'array',
            'sub_brand_id.*' => 'integer|exists:sub_brands,id',
            'product_catalogue_id' => 'required|array',
            'product_catalogue_id.*' => 'required|array',
            'product_catalogue_id.*.*' => 'integer|exists:product_catalogues,id',
            'discount' => 'nullable|array',
            'discount.*' => 'nullable|array',
            'discount.*.*' => 'nullable|numeric|min:0',
        ]);

        $user_id = auth()->check() ? auth()->user()->id : null;

        // **Tìm và cập nhật price_group**
        $priceGroup = Price_group::findOrFail($id);
        $priceGroupData = $priceGroup->toArray();
        unset($priceGroupData['created_at'], $priceGroupData['updated_at'], $priceGroupData['delete_at'], $priceGroupData['id']);

        $priceGroup->update([
            "name" => $request->name,
            "shipping" => $request->shipping,
            "exchange_rate" => $request->exchange_rate,
            'user_id' =>  $user_id
        ]);

        // **Lưu bản ghi vào price_group_history**
        $priceGroupHistory = Price_group_history::Create(
            array_merge($priceGroupData, ['user_id' => $priceGroup->user_id, 'price_group_id' => $priceGroup->id])
        );

        // **Lưu chi tiết lịch sử vào price_group_history_detail**
        $oldDetails = Price_group_deatil::where('price_group_id', $id)->get();
        $historyDetails = [];

        foreach ($oldDetails as $detail) {
            $detailData = $detail->toArray();
            unset($detailData['created_at'], $detailData['updated_at'], $detailData['deleted_at'], $detailData['id']);

            $historyDetails[] = array_merge($detailData, [
                "user_id" => $user_id,
                'updated_at' => now()
            ]);
        }

        if (!empty($historyDetails)) {
            Price_group_history_deatil::insert($historyDetails);
        }

        // **Xóa dữ liệu cũ trong price_group_detail**
        Price_group_deatil::where('price_group_id', $id)->delete();

        // **Thêm dữ liệu mới vào price_group_detail**
        $subBrandId = $request->sub_brand_id[0] ?? null;
        $productBrandId = $request->product_brand_id[0] ?? null;
        $priceGroupDetails = [];

        foreach ($request->product_catalogue_id as $key => $catalogueIds) {
            foreach ($catalogueIds as $index => $catalogueId) {
                if (!empty($request->discount[$key][$index])) {
                    $priceGroupDetails[] = [
                        "price_group_id" => $id,
                        "product_brand_id" => $productBrandId,
                        "sub_brand_id" => $subBrandId,
                        "product_catalogue_id" => $catalogueId,
                        "discount" => $request->discount[$key][$index],
                        'user_id' =>  $user_id,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
        }

        if (!empty($priceGroupDetails)) {
            Price_group_deatil::insert($priceGroupDetails);
        }

        // **Commit transaction nếu không có lỗi**
        DB::commit();

        return redirect()->route('price_group.index')->with('success', 'Sửa bản ghi thành công');
    } catch (\Exception $e) {
        // **Rollback nếu có lỗi**
        DB::rollBack();
        return redirect()->route('price_group.index')->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
    }
}




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Price_group::findOrfail($id)->delete()) {
            return redirect()->route('price_group.index')->with('success', 'Xoá bản ghi thành công');
        }
        return back()->with('error', 'Xoá bản ghi thất bại');
    }
}
