@extends('frontend.homepage.layout')
@section('content')
<div class="container p-5">
    <!-- Navigation Tabs Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-row flex-wrap border-bottom">
                <a href="{{ route('customer.profile') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.profile') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Tài khoản của tôi
                </a>
                <a href="{{ route('customer.password.change') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.password.change') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đổi mật khẩu
                </a>
                @if(auth()->guard('customer')->check())
                @php
                $customer = auth()->guard('customer')->user();
                @endphp


                @if($customer->customer_catalogue_id == 1 || $customer->customer_catalogue_id == 2)
                <a href="{{ route('customer.registerCustomer') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.registerCustomer') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đăng ký cộng tác viên
                </a>
                @else
                <a href="{{ route('customer.wallet') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.wallet') ? 'fw-bold border-bottom border-3' : 'text-dark' }}" style="color: #7995a3; font-weight: 500;">
                    Quản lý ví
                </a>
                <a href="{{ route('customer.createCustomer') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.createCustomer') ? 'fw-bold border-bottom border-3' : 'text-dark' }}" style="color:#7A95A2;">
                    Giới thiệu cộng tác viên
                </a>
                @endif
                @endif
                <a href="{{ route('customer.order') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.order') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đơn hàng
                </a>
                <a href="{{ route('customer.logout') }}" class="btn btn-link text-decoration-none px-3 py-2 text-danger">
                    Đăng xuất
                </a>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="col-12 col-md-8 col-lg-9 mx-auto">
            @include('backend/dashboard/component/formError')


            <h5 class="text-center mb-3">Quản lý ví</h5>


            <div class="alert alert-info text-center">
                Số dư hiện tại: <strong>{{ number_format($balance, 0, ',', '.') }} VND</strong>
            </div>
            <div class=" mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateBankModal">
                    Cập nhật tài khoản ngân hàng
                </button>
            </div>


            <div class="modal fade" id="updateBankModal" tabindex="-1" aria-labelledby="updateBankModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="updateBankModalLabel">Cập nhật tài khoản ngân hàng</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('wallet.updateBank') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="bank_account_name" class="form-label">Chủ tài khoản</label>
                                    <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" value="{{ old('bank_account_name', $wallet->bank_account_name) }}" required>
                                </div>


                                <div class="mb-3">
                                    <label for="bank_account_number" class="form-label">Số tài khoản</label>
                                    <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" value="{{ old('bank_account_number', $wallet->bank_account_number) }}" required>
                                </div>


                                <div class="mb-3">
                                    <label for="bank_name" class="form-label">Ngân hàng</label>
                                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ old('bank_name', $wallet->bank_name) }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-success">Cập nhật</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">Thông tin tài khoản ngân hàng</div>
                <div class="card-body">
                    <p><strong>Chủ tài khoản:</strong> {{ $wallet->bank_account_name }}</p>
                    <p><strong>Số tài khoản:</strong> {{ $wallet->bank_account_number }}</p>
                    <p><strong>Ngân hàng:</strong> {{ $wallet->bank_name }}</p>
                </div>
            </div>




            <h5 class="mb-3">Lịch sử giao dịch</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ngày</th>
                        <th>Loại giao dịch</th>
                        <th>Số tiền</th>
                        <th>Ghi chú</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ date('d/m/Y H:i', strtotime($transaction->created_at)) }}</td>
                        <td>
                            @if($transaction->type == 'commission') Hoa hồng
                            @elseif($transaction->type == 'deduction') Khoản trừ
                            @elseif($transaction->type == 'withdrawal') Khoản rút về
                            @elseif($transaction->type == 'deposit') Khoản nhận thêm
                            @else Không xác định
                            @endif
                        </td>
                        <td>
                            {{ number_format($transaction->amount, 0, ',', '.') }} VND
                            @if($transaction->type == 'deduction' || $transaction->type == 'withdrawal')
                            <span class="text-danger">(-)</span>
                            @else
                            <span class="text-success">(+)</span>
                            @endif
                        </td>
                        <td>{{ $transaction->note }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-center mt-4">
                <form action="#" method="POST">
                    @csrf
                    <button type="button" class="btn btn-success">Rút tiền về tài khoản ngân hàng</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .btn-main {
        height: 33px;
        background: #7995a3;
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
@endsection