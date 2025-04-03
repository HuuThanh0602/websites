@extends('frontend.homepage.layout')
@section('content')
{{-- <div class="profile-container pt20 pb20">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-1-4">
                    @include('frontend.auth.customer.components.sidebar')
                </div>
                <div class="uk-width-large-2-4">
                    <div class="panel-profile">
                        <div class="panel-head">
                            <h2 class="heading-2"><span>Thay đổi mật khẩu</span></h2>
                            <div class="description">
                                Quản lý thông tin hồ sơ để bảo mật tài khoản, nhập đầy đủ thông tin dể tiến hành thay đổi mật khẩu
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('backend/dashboard/component/formError')
                            <form action="{{ route('customer.password.recovery') }}" method="post" class="uk-form uk-form-horizontal login-form profile-form">
@csrf


<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Mật khẩu cũ</label>
    <div class="uk-form-controls">
        <input
            type="password"
            class="form-control"
            placeholder="Nhập vào mật khẩu cũ"
            name="password"
            value="">
    </div>
</div>
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Mật khẩu mới</label>
    <div class="uk-form-controls">
        <input
            type="password"
            class="form-control"
            placeholder="Nhập vào mật khẩu mới"
            name="new_password"
            value="">
    </div>
</div>
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Nhập lại mật khẩu mới</label>
    <div class="uk-form-controls">
        <input
            type="password"
            class="form-control"
            placeholder="Nhập lại mật khẩu mới"
            name="re_new_password"
            value="">
    </div>
</div>


<button type="submit" name="send" value="create">Đổi mật khẩu</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div> --}}




<div class="container p-5">
    <div class="row">
        <!-- Navigation Tabs Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex flex-row flex-wrap border-bottom">
                    <a href="{{ route('customer.profile') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.profile') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                        Tài khoản của tôi
                    </a>
                    <a href="{{ route('customer.password.change') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.password.change') ? 'fw-bold border-bottom border-3' : 'text-dark' }}" style="color: #7995a3; font-weight: 500;">
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
            @include('backend/dashboard/component/formError')
            <form action="{{ route('customer.password.recovery') }}" method="post"
                class="px-5">
                @csrf
                <h4 class="text-center mb-3">Thay đổi mật khẩu</h4>
                <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>


                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Mật khẩu cũ</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Nhập vào mật khẩu cũ"
                            name="password"
                            value="">
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Mật khẩu mới</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Nhập vào mật khẩu mới"
                            name="new_password"
                            value="">
                    </div>
                </div>


                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-2" for=""></label>Xác nhận mật khẩu</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="password"
                            class="form-control"
                            placeholder="Nhập lại mật khẩu mới"
                            name="re_new_password"
                            value="">
                    </div>
                </div>






                <div class="d-flex justify-content-start align-items-center">
                    <button type="submit" class="btn-main">Đổi mật khẩu</button>


                </div>


            </form>
        </div>


    </div>
</div>


@endsection




@section('css')
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection