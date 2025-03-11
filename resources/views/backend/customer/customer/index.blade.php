@include('backend.dashboard.component.breadcrumb', ['title' => 'Quản lý Cộng tác viên'])
<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <h5>Quản lý Cộng tác viên </h5>
                    @include('backend.dashboard.component.toolbox', ['model' => $config['model']])
                </div>
            </div>
            <div class="ibox-content">
                @include('backend.customer.customer.component.filter')
                @include('backend.customer.customer.component.table')
            </div>
        </div>
    </div>
</div>