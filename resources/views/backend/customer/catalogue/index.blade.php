@include('backend.dashboard.component.breadcrumb', ['title' => 'Quản lý loại cộng tác viên'])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Quản lý loại cộng tác viên </h5>
                @include('backend.dashboard.component.toolbox', ['model' => $config['model']])
            </div>
            <div class="ibox-content">
                @include('backend.customer.catalogue.component.filter')
                @include('backend.customer.catalogue.component.table')
            </div>
        </div>
    </div>
</div>