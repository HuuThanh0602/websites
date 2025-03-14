@extends('frontend.homepage.layout')
@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 mx-auto">
            <div class="list-group">
                <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action" aria-current="true">
                    Tài khoản của tôi
                </a>
                <a href="{{ route('customer.password.change') }}" class="list-group-item list-group-item-action">Đổi mật khẩu</a>
                <a href="{{ route('customer.wallet') }}" class="list-group-item list-group-item-action">Quản lý ví</a>
                <a href="{{ route('customer.order') }}" class="list-group-item list-group-item-action active">Đơn hàng</a>
                <a href="{{ route('customer.createCustomer') }}" class="list-group-item list-group-item-action">Thêm mới cộng tác viên</a>
                <a href="{{ route('customer.logout') }}" class="list-group-item list-group-item-action">Đăng xuất</a>
            </div>

        </div>
        <div class="col-12 col-md-8 col-lg-9 mx-auto">
            @include('backend/dashboard/component/formError')
            <h4 class="text-center mb-3">Đơn hàng của tôi</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Người nhận</th>
                        <th>Tình trạng</th>
                        <th>Thanh toán</th>
                        <th>Vận chuyển</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->code}}</td>
                        <td>
                            <div><b>N:</b> {{ $order->fullname }}</div>
                            <div><b>P:</b> {{ $order->phone }}</div>
                            <div><b>A:</b> {{ $order->address }}</div>
                        </td>
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
                        <td>
                            @if($order->confirm == 'pending')
                            <button type="button" class="btn btn-danger" style="width:80px" data-bs-toggle="modal" data-bs-target="#cancelOrderModal{{$order->id}}">
                                Hủy đơn
                            </button>
                            <div class="modal fade" id="cancelOrderModal{{$order->id}}" tabindex="-1" aria-labelledby="cancelOrderLabel{{$order->id}}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cancelOrderLabel{{$order->id}}">Xác nhận hủy đơn hàng</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Bạn có chắc chắn muốn hủy đơn hàng này không?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Không</button>
                                            <form action="{{ route('customer.cancelOrder', $order->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Có, Hủy đơn</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <button class="btn btn-secondary" style="width:80px" disabled>Hủy đơn</button>
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