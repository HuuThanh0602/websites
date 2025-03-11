@extends('frontend.homepage.layout')
@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 mx-auto">
            <div class="list-group">
                <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action active" aria-current="true">
                    Tài khoản của tôi
                </a>
                <a href="{{ route('customer.password.change') }}" class="list-group-item list-group-item-action">Đổi mật khẩu</a>
                <a href="{{ route('customer.logout') }}" class="list-group-item list-group-item-action">Đăng xuất</a>
                <a href="{{ route('customer.wallet') }}" class="list-group-item list-group-item-action">Quản lý ví</a>
                <a href="{{ route('customer.order') }}" class="list-group-item list-group-item-action">Đơn hàng</a>
            </div>

        </div>
        <div class="col-12 col-md-8 col-lg-9 mx-auto">
            @include('backend/dashboard/component/formError')
            <h4 class="text-center mb-3">Đơn hàng của tôi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Địa chỉ</th>
                        <th>Tình trạng</th>
                        <th>Thanh toán</th>
                        <th>Vận chuyển</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->code}}</td>
                        <td>{{$order->address}}</td>
                        <td>
                            @if($order->confirm == 'pending')
                            Đang chờ xác nhận
                            @elseif($order->confirm == 'confirm')
                            Đã xác nhận
                            @elseif($order->confirm == 'cancel')
                            Đã huỷ
                            @else
                            Trạng thái không xác định
                            @endif
                        </td>
                        <td>
                            @if($order->payment == 'unpaid')
                            Chưa thanh toán
                            @elseif($order->payment == 'paid')
                            Đã thanh toán
                            @else
                            Trạng thái thanh toán không xác định
                            @endif
                        </td>
                        <td>
                            @if($order->delivery == 'processing')
                            Đang xử lý
                            @elseif($order->delivery == 'pending')
                            Chưa giao hàng
                            @elseif($order->delivery == 'success')
                            Giao hàng thành công
                            @else
                            Trạng thái giao hàng không xác định
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection

@section('css')
<style>
    .btn-main {
        height: 33px;
        background: #da2229;
        text-transform: uppercase;
        color: #fff;
        font-weight: 600;
        right: 5px;
        top: 6px;
        border: 12px;
        padding: 0 20px;
        border-radius: 5px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection