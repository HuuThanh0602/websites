<form action="{{ route('price_range.index') }}">
    <div class="filter-wrapper">
        <div class="uk-flex uk-flex-middle uk-flex-space-between">
            @include('backend.dashboard.component.perpage')
            <div class="action">
                <div class="uk-flex uk-flex-middle">
                    @php
                        $attributeCatalogueId = request('attribute_catalogue_id') ?: old('attribute_catalogue_id');
                    @endphp
                    @include('backend.dashboard.component.keyword')
                    <a href="{{ route('price_range.create') }}" class="btn btn-danger"><i class="fa fa-plus mr5"></i>Thêm mới dải giá</a>
                </div>
            </div>
        </div>
    </div>
</form>

