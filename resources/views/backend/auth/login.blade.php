<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hệ thông quản trị A'nista</title>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500&display=swap" rel="stylesheet">


    <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9fa;
            font-family: 'Segoe UI', Arial, sans-serif;
            color: #333;
        }
        .login-container {
            display: flex;
            min-height: 100vh;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            display: flex;
            margin: 20px;
        }
        .login-left {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #f5f7fa;
        }
        .login-right {
            flex: 1;
            padding: 40px;
            background-color: white;
        }
        .login-illustration {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
        .form-control {
            height: 50px;
            background-color: #f5f7fa;
            border: none;
            border-radius: 8px;
            padding: 10px 15px;
            margin-bottom: 20px;
        }
        .btn-login {
            height: 50px;
            background-color:#7A95A2;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color:#BAD4E3;
            transform: translateY(-2px);
        }
        .social-login {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 15px;
        }
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s;
        }
        .social-btn:hover {
            transform: translateY(-3px);
        }
        .facebook {
            background-color: #3b5998;
        }
        .twitter {
            background-color: #1da1f2;
        }
        .google {
            background-color: #ea4335;
        }
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 12px;
        }
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .forgot-link {
            color:#7A95A2;
            text-decoration: none;
            font-weight: bold;
        }
        .error-message {
            color: #ea4335;
            font-size: 12px;
            margin-top: -15px;
            margin-bottom: 15px;
            display: block;
        }
        h1 {
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 30px 0;
            color: #888;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #eee;
        }
        .divider span {
            padding: 0 10px;
        }
        @media (max-width: 768px) {
            .login-card {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-left">
                <h1 style="font-family: 'Playfair Display', serif;
            font-size: 72px;
            font-weight: 500;
            text-align: center;
            letter-spacing: 3px;">A'nista</h1>
            <P style="
            font-size: 13px;
            font-weight: bolder;
            text-align: center;
            letter-spacing: 3px;
            margin-bottom: 100px;">THỜI TRANG ĐỈNH CAO - DẪN ĐẦU XU HƯỚNG</P>
             
            </div>
            <div class="login-right">
                <h1 style="text-align: center;">Đăng nhập</h1>
                <p>Chào mừng thành viên của A'nista!</p>
             
                <form method="post" role="form" action="{{ route('auth.login') }}">
                    @csrf
                    <div class="form-group">
                        <input
                            type="text"
                            name="email"
                            class="form-control"
                            placeholder="Email"
                            autofocus
                            value="{{ old('email') }}"
                        >
                        @if ($errors->has('email'))
                            <span class="error-message">* {{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Mật khẩu"
                        >
                        @if ($errors->has('password'))
                            <span class="error-message">* {{ $errors->first('password') }}</span>
                        @endif
                    </div>
                   
                    <div class="remember-forgot">
    <div>
        <input type="checkbox" id="remember" name="remember">
        <label for="remember">Ghi nhớ tôi</label>
    </div>
    <a href="{{ route('password.request') }}" class="forgot-link">Quên mật khẩu?</a>
</div>


                   
                    <button type="submit" class="btn btn-login">Đăng nhập</button>
                </form>
                <div class="login-footer">
                    Copyright nhóm 2 - HVNH | <small>© 2025</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Kiểm tra xem localStorage có lưu email không
        if (localStorage.getItem("rememberEmail")) {
            document.querySelector("input[name='email']").value = localStorage.getItem("rememberEmail");
            document.querySelector("#remember").checked = true;
        }


        // Khi form được submit
        document.querySelector("form").addEventListener("submit", function () {
            if (document.querySelector("#remember").checked) {
                // Lưu email vào localStorage nếu checkbox được chọn
                localStorage.setItem("rememberEmail", document.querySelector("input[name='email']").value);
            } else {
                // Xóa email khỏi localStorage nếu checkbox không được chọn
                localStorage.removeItem("rememberEmail");
            }
        });
    });
</script>



