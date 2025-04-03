@include('backend.dashboard.component.breadcrumb', ['title' => 'Thêm mới thương hiệu' ])
@include('backend.dashboard.component.formError')
@php
$url = ($config['method'] == 'create') ? route('brand.store') : route('brand.update', [$productBrand->id, $queryUrl ?? '']);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.tableHeading') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content', ['model' => ($productBrand) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.component.album', ['model' => ($productBrand) ?? null])
                @include('backend.dashboard.component.seo', ['model' => ($productBrand) ?? null])
            </div>
            <div></div>
            <div class="col-lg-3">
                @include('backend.brand.component.aside')
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>