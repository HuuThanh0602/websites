@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['index']['title']])
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Arial, sans-serif;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        padding: 20px;
    }

    .box {
        padding: 20px;
        color: white;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        border-radius: 8px;
    }

    .red {
        background: #7995a3;
    }

    .blue {
        background: #3498DB;
    }

    .purple {
        background: #8E44AD;
    }

    .green {
        background: #2ECC71;
    }

    .yellow {
        background: #F1C40F;
        color: black;
    }

    .black {
        background: #2C3E50;
    }

    .number {
        font-size: 18px;
        display: block;
    }

    @media (max-width: 768px) {
        .dashboard {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .dashboard {
            grid-template-columns: repeat(1, 1fr);
        }
    }
</style>

<div class="dashboard">
    <div class="box red">
        <span class="number">{{$order_new}}</span>
        Đơn mới
    </div>
    <div class="box purple">
        <span class="number">{{$confirmed}}</span>
        Đơn xác nhận
    </div>
    <div class="box yellow">
        <span class="number">{{$packed}}</span>
        Đã đóng gói
    </div>
    <div class="box blue">
        <span class="number">{{$processing}}</span>
        Đang giao hàng
    </div>
    <div class="box green">
        <span class="number">{{$success}}</span>
        Hoàn thành
    </div>
    <div class="box black">
        <span class="number">{{$cancel}}</span>
        Đơn hủy
    </div>
</div>

<div class="row mt20">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title uk-flex uk-flex-middle uk-flex-space-between">
                <h5>{{ $config['seo']['index']['table']; }} </h5>
                @include('backend.dashboard.component.toolbox', ['model' => $config['model']])
            </div>
            <div class="ibox-content">
                @include('backend.order.component.filter')
                @include('backend.order.component.table')
            </div>
        </div>
    </div>
</div>