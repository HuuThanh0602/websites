@include('backend.dashboard.component.breadcrumb', ['title' => 'Quản lý thương hiệu'])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Quản lý thương hiệu </h5>
                @include('backend.dashboard.component.toolbox', ['model' => 'productBrand'])
            </div>
            <div class="ibox-content">
                @include('backend.brand.component.filter')
                @include('backend.brand.component.table')
            </div>
        </div>
    </div>
</div>