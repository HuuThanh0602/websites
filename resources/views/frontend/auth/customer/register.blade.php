@extends('frontend.homepage.layout')
@section('content')

<div class="row justify-content-center login-container">
    <div class="col-12 col-md-5 brand-col">
        <div class="brand-content">
            <h1 class="brand-title">A'nista</h1>
            <p class="brand-tagline">THỜI TRANG ĐỈNH CAO - DẪN ĐẦU XU HƯỚNG</p>

        </div>
    </div>
    <div class="col-12 col-md-7 form-col">
        <div class="login-form-container">
            <form action="{{ route('customer.reg')}}" method="post">
                <h2 class="login-title">Đăng ký</h2>
                <p class="welcome-text">Chào mừng thành viên của A'nista!</p>
                @csrf
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
                    @if($errors->has('phone'))
                    <span class="text-danger">* {{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div class="mb-3">
                    <input
                        type="number"
                        name="min_orders"
                        value="2"
                        hidden
                        placeholder="Số đơn hàng tối thiểu/tháng"
                        class="form-control">
                </div>

                <div class="mb-3">
                    <input
                        type="number"
                        name="monthly_spending"
                        value="1"
                        hidden
                        placeholder="Tổng chi tiêu/tháng"
                        class="form-control" >
                </div>

                <div class="mb-3">
                    <textarea
                        name="about_me"
                        hidden
                        placeholder="Giới thiệu bản thân"
                        class="form-control" value="1">123123123</textarea>
                </div>

                <button type="submit" class="btn btn-login">Đăng ký</button>
            </form>
        </div>

    </div>
</div>

@endsection


@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .login-container {
        margin: 50px auto;
        max-width: 1000px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        background-color: #fff;
    }

    .brand-col {
        background-color: #fff;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .brand-title {
        font-size: 70px;
        font-weight: 400;
        color: #333;
        margin-bottom: 20px;
    }

    .brand-tagline {
        font-size: 14px;
        letter-spacing: 1px;
        color: #555;
        text-transform: uppercase;
    }

    .form-col {
        background-color: #f8f9fa;
        padding: 40px 20px;
    }

    .login-form-container {
        max-width: 450px;
        margin: 0 auto;
    }

    .login-title {
        font-size: 36px;
        font-weight: 600;
        color: #333;
        text-align: center;
        margin-bottom: 10px;
    }

    .welcome-text {
        text-align: center;
        color: #666;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        padding: 15px;
        border: none;
        border-radius: 5px;
        background-color: #e9ecef;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .form-check-label {
        color: #555;
        font-size: 14px;
    }

    .forgot-password a {
        color: #666;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-login {
        width: 100%;
        padding: 15px;
        background-color: #7A95A2;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-weight: 600;
        margin-bottom: 20px;
        cursor: pointer;
    }

    .register-link {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 40px;
    }

    .register-link a {
        color: #7A95A2;
        text-decoration: none;
        font-weight: 500;
    }

    .copyright-text {
        text-align: center;
        font-size: 14px;
        color: #999;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .brand-col {
            padding: 30px 15px;
        }

        .brand-title {
            font-size: 50px;
        }

        .form-col {
            padding: 30px 15px;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection