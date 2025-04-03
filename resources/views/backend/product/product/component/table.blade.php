@php
$query= base64_encode(http_build_query(request()->query()));
$queryUrl = rtrim($query,'=');
@endphp
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="width:100px;">ID</th>
            <th style="width:700px;">{{ __('messages.tableName') }}</th>
            @include('backend.dashboard.component.languageTh')
            <th class="text-center" style="width:100px;">{{ __('messages.tableStatus') }}</th>
            <th class="text-center" style="width:100px;">{{ __('messages.tableAction') }}</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($products) && is_object($products))
        @foreach($products as $product)
        <tr id="{{ $product->id }}">
            <td class="text-center">
                {{ $product->id }}
            </td>
            <td>
                <div class="uk-flex uk-flex-middle">
                    <div class="image mr5">
                        <div class="img-scaledown image-product"><img src="{{ image($product->image) }}" alt=""></div>
                    </div>
                    <div class="main-info">
                        <div class="name"><span class="maintitle">{{ $product->name }}</span></div>
                        <div class="catalogue">
                            <span class="text-danger">{{ __('messages.tableGroup') }} </span>
                            @foreach($product->product_catalogues as $val)
                            @foreach($val->product_catalogue_language as $cat)
                            <a href="{{ route('product.index', ['product_catalogue_id' => $val->id]) }}" title="">{{ $cat->name }}</a>
                            @endforeach
                            @endforeach
                        </div>

                    </div>
                </div>
            </td>
            @include('backend.dashboard.component.languageTd', ['model' => $product, 'modeling' => 'Product'])

            <td class="text-center">
                <form action="{{ route('product.togglePublish', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="publish" value="1">
                    <input type="checkbox" name="publish" value="2" class="js-switch status "
                        onchange="this.form.submit()" {{ $product->publish == 2 ? 'checked' : '' }}>
                </form>
            </td>

            <td class="text-center">
                <a href="{{ route('product.edit', [$product->id, $queryUrl ?? 'p']) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                <!-- <a href="{{ route('product.delete', $product->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a> -->
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
{{ $products->links('pagination::bootstrap-4') }}