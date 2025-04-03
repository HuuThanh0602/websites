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
                <a href="{{ route('customer.wallet') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.wallet') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
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
        <!-- Form Error Messages -->
        @include('backend/dashboard/component/formError')

        <div class="d-flex justify-content-between mb-3">
            <h5 class="mb-1 text-center">Cộng tác viên đã giới thiệu</h5>
            <a href="{{ route('customer.customer123') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Giới thiệu CTV
            </a>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>STT</th>
                        <th>Họ tên CTV</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($collaborators as $index => $ctv)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $ctv->name }}</td>
                        <td>{{ $ctv->email }}</td>
                        <td>{{ $ctv->phone }}</td>
                        <td>{{ $ctv->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if((int) $ctv->publish === 1)

                            <span class="badge bg-danger">Ngừng hoạt động</span>
                            @elseif((int) $ctv->publish === 2)
                            <span class="badge bg-success">Hoạt động</span>
                            @elseif((int) $ctv->publish === 3)
                            <span class="badge bg-warning text-dark">Đang chờ duyệt</span>
                            @else
                            <span class="badge bg-secondary">Không xác định</span>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .profile-image img {
        object-fit: cover;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        height: 40px;
        transition: all .2s ease-out;
        border: 1px solid #c4cdd5;
    }

    .card {
        border-radius: 10px;
        border: none;

    }

    .card-body {
        padding: 1.5rem;
    }

    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        box-shadow: 2px 6px 16px rgba(0, 0, 0, 0.16);
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection


@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection