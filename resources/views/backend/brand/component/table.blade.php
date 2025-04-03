<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="width:50px;">
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Tên thương hiệu</th>
            <th class="text-center" style="width:100px;">{{ __('messages.tableStatus') }} </th>
            <th class="text-center" style="width:100px;">{{ __('messages.tableAction') }} </th>
        </tr>
    </thead>
    <tbody>
        @foreach($product_brands as $product_brand)
        <tr>
            <td>
                
                
                <input type="checkbox" value="{{ $product_brand->id }}" class="input-checkbox checkBoxItem">
            </td>
            <td>
            <div class="uk-flex uk-flex-middle">
            <div class="image mr5">
                    <div class="img-scaledown image-product"><img src="{{ image($product_brand->image) }}" alt=""></div>
                </div>
                        <div class="main-info">
                            <div class="name"><span class="maintitle">{{ optional($product_brand->brand_language)->name ?? 'Không có dữ liệu' }}</span></div>
                        </div>
                    </div>
                {{ optional($product_brand->brand_language)->name ?? 'Không có dữ liệu' }}
            </td>
            <td class="text-center js-switch">
                <form action="{{ route('update.status') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product_brand->id }}">
                    <input type="hidden" name="value" value="{{ $product_brand->publish == 2 ? 1 : 2 }}">
                    <input type="checkbox" class="js-switch status" 
                        onchange="this.form.submit()" 
                        {{ $product_brand->publish == 2 ? 'checked' : '' }}
                    />
                </form>
            </td>
            <td class="text-center">
                <a href="{{ route('brand.edit', [$product_brand->id]) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <a href="{{ route('brand.delete', $product_brand->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
{{ $product_brands->links('pagination::bootstrap-4') }}
