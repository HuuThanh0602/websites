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
                            <h2 class="heading-2"><span>Hồ sơ của tôi</span></h2>
                            <div class="description">
                                Quản lý thông tin hồ sơ để bảo mật tài khoản
                            </div>
                        </div>
                        <div class="panel-body">
                            @include('backend/dashboard/component/formError')
                            <form action="{{ route('customer.profile.update') }}" method="post" class="uk-form uk-form-horizontal login-form profile-form">
@csrf
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Tài khoản đăng nhập</label>
    <div class="uk-form-controls">
        {{ $customer->email }}
    </div>
</div>

<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Họ Tên</label>
    <div class="uk-form-controls">
        <input
            type="text"
            class="form-control"
            placeholder="Họ Tên"
            name="name"
            value="{{ old('name', $customer->name) }}">
    </div>
</div>
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Email</label>
    <div class="uk-form-controls">
        <input
            type="text"
            class="form-control"
            placeholder="Email"
            name="email"
            value="{{ old('email', $customer->email) }}">
    </div>
</div>
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Số điện thoại</label>
    <div class="uk-form-controls">
        <input
            type="text"
            class="form-control"
            placeholder="Số điện thoại"
            name="phone"
            value="{{ old('phone', $customer->phone) }}">
    </div>
</div>
<div class="uk-form-row form-row">
    <label class="uk-form-label" for="form-h-it">Địa chỉ</label>
    <div class="uk-form-controls">
        <input
            type="text"
            class="form-control"
            placeholder="Địa chỉ"
            name="address"
            value="{{ old('address', $customer->address) }}">
    </div>
</div>
<button type="submit" name="send" value="create">Lưu thông tin</button>
</form>
</div>
</div>
</div>
</div>
</div>
</div> --}}



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
            <form action="{{ route('customer.profile.update') }}" method="post"
                class="px-5">
                @csrf
                <h4 class="text-center mb-3">Hồ sơ của tôi</h4>
                <h5>Quản lý thông tin hồ sơ để bảo mật tài khoản</h5>
                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Mã giới thiệu</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="code"
                            name="code" readonly
                            value="{{ old('code', $customer->code) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Email</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Email"
                            name="email" readonly
                            value="{{ old('email', $customer->email) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Họ tên</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Họ Tên"
                            name="name"
                            value="{{ old('name', $customer->name) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Số điện thoại</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Số điện thoại"
                            name="phone"
                            value="{{ old('phone', $customer->phone) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-2">
                        <label class="mt-1" for="">Địa chỉ</label>
                    </div>
                    <div class="col-lg-8">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Địa chỉ"
                            name="address"
                            value="{{ old('address', $customer->address) }}">
                    </div>
                </div>

                <div class="d-flex justify-content-start align-items-center">
                    <button type="submit" class="btn-main">Lưu thông tin</button>

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