<?php

namespace App\Http\Controllers\Backend\Price;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Interfaces\AttributeCatalogueServiceInterface  as AttributeCatalogueService;
use App\Repositories\Interfaces\AttributeCatalogueRepositoryInterface  as AttributeCatalogueRepository;
use App\Classes\Nestedsetbie;
use App\Models\Language;
use App\Models\Price_group;
use App\Models\Price_range;
use App\Models\ProductBrand;
use App\Models\ProductCatalogue;
use App\Models\Sub_brand;
use Illuminate\Support\Facades\DB;

class PriceRangeController extends Controller
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
        $query = Price_range::select(
            'price_ranges.id as price_range_id',
            'sub_brands.id as sub_brand_id',
            'price_ranges.*',
            'product_brand_language.name as brand_name',
            'sub_brands.name as sub_name'
        )
            ->leftJoin('sub_brands', 'price_ranges.sub_brand_id', '=', 'sub_brands.id')
            ->leftJoin('product_brand_language', 'sub_brands.brand_id', '=', 'product_brand_language.product_brand_id');
        if ($request->has('keyword') && !empty($request->keyword)) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('product_brand_language.name', 'LIKE', "%$keyword%")
                    ->orWhere('sub_brands.name', 'LIKE', "%$keyword%")
                    ->orWhere('price_ranges.name', 'LIKE', "%$keyword%");
            });
        }

        $query->orderBy('product_brand_language.name');


        $price_ranges = $query->paginate($perPage);

        //dd($price_ranges);
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'Price_range',
        ];
        $config['seo'] = __('messages.attributeCatalogue');
        $template = 'backend.price.range.index';
        return view('backend.dashboard.layout', compact(
            'template',
            'config',
            'price_ranges'
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
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();

        //dd($categorys);
        $template = 'backend.price.range.store';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'brands'
        ));
    }
    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|integer',
            'range_name' => 'required|string|max:255|unique:sub_brands,name',
            'ranges_data' => 'required|json',
        ], [
            'brand_id.required' => 'Trường thương hiệu là bắt buộc.',
            'brand_id.integer' => 'Thương hiệu phải là một số nguyên hợp lệ.',

            'range_name.required' => 'Tên khoảng giá là bắt buộc.',
            'range_name.string' => 'Tên khoảng giá phải là một chuỗi ký tự.',
            'range_name.max' => 'Tên khoảng giá không được vượt quá 255 ký tự.',
            'range_name.unique' => 'Tên khoảng giá đã tồn tại, vui lòng chọn tên khác.',

            'ranges_data.required' => 'Dữ liệu khoảng giá là bắt buộc.',
            'ranges_data.json' => 'Dữ liệu khoảng giá phải ở định dạng JSON hợp lệ.',
        ]);



        // Kiểm tra dữ liệu nhận được từ request
        //dd($request->all()); // Debug: Xem toàn bộ dữ liệu trước khi xử lý

        $ranges = json_decode($request->ranges_data, true);

        if (!is_array($ranges)) {
            return back()->with('error', 'Dữ liệu không hợp lệ.');
        }

        try {
            DB::beginTransaction();

            $subBrand = Sub_brand::create([
                'brand_id' => $request->brand_id,
                'name' => $request->range_name ?? 'Không xác định',
            ]);


            $level = 1;
            foreach ($ranges as $range) {


                Price_range::create([
                    'sub_brand_id' => $subBrand->id,
                    'name' => 'Mức ' . $level,
                    'price_min' => $range['from'] ?? 0,
                    'price_max' => $range['to'] ?? 0,
                    'value_type' => $range['valueType'] ?? 'fixed',
                    'value' => $range['value'] ?? 0,
                ]);
                $level++;
            }

            DB::commit();

            return redirect()->route('price_range.index')->with('success', 'Thêm mới bản ghi thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Lỗi khi thêm dữ liệu: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
        $price_range = Price_range::findOrfail($id);
        //dd($price_range);
        //dd($categorys);
        $template = 'backend.price.range.edit';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'price_range'
        ));
    }


    public function edi_sub_price_range(string $sub_name)
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
        $price_ranges = Sub_brand::where('name', $sub_name)->with('prices')->get();
        $brands = ProductBrand::select(
            'product_brands.*',
            'product_brand_language.*'
        )
            ->leftJoin('product_brand_language', 'product_brands.id', '=', 'product_brand_language.product_brand_id')
            ->get();
        // dd($price_ranges);
        //dd($categorys);
        $template = 'backend.price.range.edit_all';
        return view('backend.dashboard.layout', compact(
            'template',
            'dropdown',
            'config',
            'price_ranges',
            'brands'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('send');
        if (Price_range::findOrfail($id)->update($data)) {
            return redirect()->route('price_range.index')->with('success', 'Sửa bản ghi thành công');
        }
        return back()->with('error', 'Sửa bản ghi thất bại');
    }


    public function update2(Request $request, string $id)
    {
       //dd($request->all());
        $sub_brand = Sub_brand::where('name', $request->range_name)
                ->where('brand_id', $request->brand_id)
                ->first();

                
        $price_ranges=Price_range::where('sub_brand_id',$sub_brand->id)->get();
        foreach($price_ranges as $price_range){
            $price_range->delete();
        }
        $ranges = json_decode($request->ranges_data, true);
        $level = 1;
        foreach ($ranges as $range) {
            Price_range::create([
                'sub_brand_id' => $sub_brand->id,
                'name' => 'Mức ' . $level,
                'price_min' => $range['from'] ?? 0,
                'price_max' => $range['to'] ?? 0,
                'value_type' => $range['valueType'] ?? 'fixed',
                'value' => $range['value'] ?? 0,
            ]);
            $level++;
        }
        return redirect()->route('price_range.index')->with('success', 'Sửa bản ghi thành công');
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $priceRange = Price_range::findOrFail($id);

        $subBrandId = $priceRange->sub_brand_id;

        if ($priceRange->delete()) {
            $remainingRecords = Price_range::where('sub_brand_id', $subBrandId)->count();

            if ($remainingRecords == 0) {
                Sub_brand::where('id', $subBrandId)->delete();
            }

            return redirect()->route('price_range.index')->with('success', 'Xoá bản ghi thành công');
        }

        return back()->with('error', 'Xoá bản ghi thất bại');
    }
}
