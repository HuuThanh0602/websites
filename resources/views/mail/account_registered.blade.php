<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng bạn đến với A'nistanista</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
            border-bottom: 2px solid #7A95A1;
        }
        .header img {
            max-width: 150px;
        }
        .content {
            padding: 20px 0;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .info ul {
            list-style: none;
            padding: 0;
        }
        .info ul li {
            padding: 5px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
           <h2>A'NISTA</h2>
           <p>Chúc mừng bạn đã đăng ký tài khoản tại <strong>Công ty chúng tôi</strong> thành công!</p>
        </div>
        <div class="content">
            <h2>Xin chào {{ $customer->name }},</h2>
            <p>Dưới đây là thông tin tài khoản của bạn:</p>
            <div class="info">
                <ul>
                    <li><strong>Email:</strong> {{ $customer->email }}</li>
                    <li><strong>Số điện thoại:</strong> {{ $customer->phone }}</li>
                    <li><strong>Mật khẩu:</strong> {{ str_repeat('*', strlen($password)) }}</li>
                    </ul>
            </div>
            <p>Bạn hãy truy cập website để <a href="#" style="color: #7A95A1; text-decoration: none;">đăng nhập</a> để bắt đầu sử dụng dịch vụ.</p>
        </div>
        <div class="footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ <a href="mailto:support@tencongty.com">24a4040617@hvnh.edu.vn</a> hoặc hotline <strong>0399725203</strong>.</p>
            <p>Cảm ơn bạn đã tin tưởng sử dụng dịch vụ của chúng tôi!</p>
        </div>
    </div>
</body>
</html>
