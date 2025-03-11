@extends('frontend.homepage.layout')
@section('content')

<div class="row">
    <div class="col-4"></div>
    <div class="col-12 col-md-8 col-lg-4 mx-auto">
        <form action="{{ route('customer.reg')}}" method="post"
            class="border px-5 py-4 rounded my-5">
            @csrf
            <h4 class="text-center mb-3">Đăng ký</h4>
            <div class="mb-3">
                <input
                    type="text"

                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Họ tên"
                    class="form-control">
                @if($errors->has('name'))
                <span class="text-danger">* {{ $errors->first('name') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <input
                    type="text"

                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Email"
                    class="form-control">
                @if($errors->has('email'))
                <span class="text-danger">* {{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <input
                    type="password"
                    name="password"

                    placeholder="Mật khẩu"
                    autocomplete="off"
                    class="form-control">
                @if($errors->has('password'))
                <span class="text-danger">* {{ $errors->first('password') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <input
                    type="password"
                    class="form-control"
                    name="re_password"
                    placeholder="Nhập lại mật khẩu"
                    autocomplete="off">
                @if($errors->has('re_password'))
                <span class="text-danger">* {{ $errors->first('re_password') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Số điện thoại"
                    class="form-control">
            </div>

            <div class="mb-3">
                <input
                    type="text"
                    name="address"
                    value="{{ old('address') }}"
                    placeholder="Địa chỉ"
                    class="form-control">
                <input type="hidden" name="customer_catalogue_id" value="1">
            </div>
            <div class="mb-3">
                <input
                    type="text"
                    name="referral_by"
                    value="{{ old('referral_by') }}"
                    placeholder="Mã giới thiệu"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Đăng ký</button>
        </form>
    </div>
    <div class="col-4"></div>
</div>

@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection