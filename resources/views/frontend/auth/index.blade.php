@extends('frontend.homepage.layout')
@section('content')
<div class="row justify-content-center login-container">
    <div class="col-12 col-md-5 brand-col">
        <div class="brand-content">
            <h1 class="brand-title">A'nista</h1>
            <p class="brand-tagline">THỜI TRANG ĐỈNH CAO - DẪN ĐẦU XU HƯỚNG</p>
            <div class="register-link">
                <!--  TẠO 1 FORM MỚI --- Đổi tên thành đăng ký làm đối tác
                Các trường bắt buộc điền: Họ tên, email, mk, xác nhận mk, sđt, ngày sinh
                Thêm trường: số đơn hàng tối đa/tháng, daonh số tối thiểu/tháng, kinh nghiệm làm ctv(trường textarea) -> 3 trường này cũng bắt buộc nhập 
                Validate: email, sđt đúng định dạng, mk 8 - 16 ký tự (có ký tự đặc biệt, in hóa, có chữ số, viết thường)
                Mã giới thiệu không bắt buộc (đổi thành sđt )
                Sau khi đăng ký thì vẫn đăng nhập vào được hệ thống, tuy nhiên ở dạng khách lẻ. BAO GIỜ CÓ NGƯỜI DUYỆT THÌ MỚI LÀ CTV 
                Sau khi đăng ký có mail "thông báo tiếp nhận yêu cầu làm ctv, hiện tại bạn có thể đăng nhập vào tk với tư cách là khách hàng. Khi nào A'nista duyệt sẽ nâng cấp tài khoản của bạn."-->
                <p>Bạn có muốn làm đối tác của chúng tôi không? <br><a href="{{ route('collaborator.register') }}"><strong>Đăng ký</strong> làm cộng tác viên ngay!!!</a></p>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-7 form-col">
        <div class="login-form-container">
            <h2 class="login-title">Đăng nhập</h2>
            <p class="welcome-text">Chào mừng thành viên của A'nista!</p>

            <form action="{{ route('fe.auth.dologin') }}">
                @csrf
                <div class="form-group">
                    <input type="text" name="email" class="form-control" placeholder="Email đăng nhập" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                    @if($errors->has('email'))
                    <span class="text-danger">* {{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ tôi</label>
                    </div>
                    <div class="forgot-password">
                        <a href="{{ route('forgot.customer.password') }}">Quên mật khẩu?</a>
                    </div>
                </div>

                <div class="form-submit">
                    <button type="submit" class="btn-login">Đăng nhập</button>
                </div>

                <div class="register-link">
                    <p>Bạn chưa có tài khoản? <a href="{{ route('customer.register') }}"><strong>Đăng ký ngay!!!</strong></a></p>
                </div>
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