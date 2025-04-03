
@extends('frontend.homepage.layout')
@section('content')
    

    <div class="row justify-content-center updatePassword-container">
    <div class="col-12 col-md-5 brand-col">
        <div class="brand-content">
            <h1 class="brand-title">A'nista</h1>
            <p class="brand-tagline">THỜI TRANG ĐỈNH CAO - DẪN ĐẦU XU HƯỚNG</p>
         
        </div>
    </div>
        <div class="col-12 col-md-7 form-col">
        <form action="{{ route($route, $email) }}" method="post" id="resetPasswordForm">
    <h2 class="updatePassword-title">Lấy lại mật khẩu</h2>
    <p class="mb-4">Lấy lại mật khẩu tài khoản để nhận thêm nhiều ưu đãi từ A'nista!</p>
    @csrf

    <div class="mb-3">
        <input 
            type="password" 
            class="form-control" 
            required
            name="password"
            id="password"
            placeholder="Mật khẩu"
        >
    </div>

    <div class="mb-3">
        <input 
            type="password" 
            class="form-control" 
            name="re_password"
            required
            id="re_password"
            placeholder="Nhập lại mật khẩu"
        >
    </div>

    <button type="submit" class="btn-updatePassword">Đổi mật khẩu</button> 

    <div id="passwordError" style="color: red; margin-top: 10px;"></div>
</form>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var rePassword = document.getElementById('re_password').value;
        var errorDiv = document.getElementById('passwordError');

        // Biểu thức chính quy kiểm tra mật khẩu hợp lệ
        var passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,16}$/;

        if (!passwordRegex.test(password)) {
            errorDiv.innerText = "Mật khẩu phải từ 8 - 16 ký tự, chứa ít nhất một chữ hoa, một chữ thường, một số và một ký tự đặc biệt.";
            event.preventDefault(); // Ngăn không cho gửi form nếu mật khẩu không hợp lệ
            return;
        }

        if (password !== rePassword) {
            errorDiv.innerText = "Mật khẩu nhập lại không khớp!";
            event.preventDefault();
            return;
        }

        errorDiv.innerText = ""; // Xóa lỗi nếu tất cả đều hợp lệ
    });
</script>

        </div>
       
    </div>
@endsection

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<style>
    .updatePassword-container {
        margin: 50px auto;
        max-width: 1000px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
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
    
    .updatePassword-form-container {
        max-width: 450px;
        margin: 0 auto;
    }
    
    .updatePassword-title {
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
    
    .btn-updatePassword {
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
    
    .updatePassword-link {
        text-align: center;
        margin-top: 20px;
        margin-bottom: 40px;
    }
    
    .updatePassword-link a {
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
@endsection
