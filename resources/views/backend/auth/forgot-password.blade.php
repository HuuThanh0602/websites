<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu - Hệ thông quản trị A'nista</title>
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
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 12px;
        }
        .back-to-login {
            text-align: center;
            margin-top: 20px;
        }
        .back-to-login a {
            color:#7A95A2;
            text-decoration: none;
            font-weight: bold;
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ea4335;
            font-size: 12px;
            margin-top: -15px;
            margin-bottom: 15px;
            display: block;
        }
        .success-message {
            color: #28a745;
            font-size: 14px;
            padding: 10px;
            background-color: #d4edda;
            border-radius: 5px;
            margin-bottom: 20px;
            display: block;
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
            <p style="
            font-size: 13px;
            font-weight: bolder;
            text-align: center;
            letter-spacing: 3px;
            margin-bottom: 100px;">THỜI TRANG ĐỈNH CAO - DẪN ĐẦU XU HƯỚNG</p>
             
            </div>
            <div class="login-right">
                <h1 style="text-align: center;">Quên mật khẩu</h1>
                <p>Vui lòng nhập email của bạn để lấy lại mật khẩu.</p>
                
                @if (session('status'))
                    <div class="success-message">
                        {{ session('status') }}
                    </div>
                @endif
                
                <form method="post" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Email"
                            autofocus
                            value="{{ old('email') }}"
                            required
                        >
                        @if ($errors->has('email'))
                            <span class="error-message">* {{ $errors->first('email') }}</span>
                        @endif
                    </div>
                   
                    <button type="submit" class="btn btn-login">Gửi link lấy lại mật khẩu</button>
                </form>
                
                <div class="back-to-login">
                    <a href="{{ route('auth.login') }}">Quay lại trang đăng nhập</a>
                </div>
                
                <div class="login-footer">
                    Copyright nhóm 2 - HVNH | <small>© 2025</small>
                </div>
            </div>
        </div>
    </div>
</body>
</html>