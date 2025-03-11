@extends('frontend.homepage.layout')
@section('content')

<div class="row">
    <div class="col-4"></div>
    <div class="col-12 col-md-8 col-lg-4 mx-auto">
        <form action="{{ route('fe.auth.dologin') }}"
            class="border px-5 py-4 rounded my-5">
            @csrf
            <h4 class="text-center mb-3">Đăng nhập</h4>
            <div class="mb-3">
                <input
                    type="text"
                    name="email"
                    value=""
                    placeholder="Email đăng nhập"
                    class="form-control">
            </div>
            <div class="mb-3">
                <input
                    type="password"
                    name="password"
                    value=""
                    placeholder="Mật khẩu"
                    class="form-control">
                @if($errors->has('email'))
                <span class="text-danger">* {{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="d-flex  ">
                <button type="submit" class="btn-main">Đăng nhập</button>
                <a class="d-block" style="margin-left: 35%"
                    href="{{ route('forgot.customer.password') }}">Quên mật khẩu</a>

            </div>


            <div class="text-center mt-5">
                <span>Bạn chưa có tài khoản</span>
                <a href="{{ route('customer.register') }}">Đăng ký ngay</a>
            </div>

            <div>

            </div>
        </form>
    </div>
    <div class="col-4"></div>
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