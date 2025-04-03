<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông báo cập nhật hạng khách hàng</title>
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
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #7A95A1;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #7A95A1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
        <h2>A'NISTA</h2>
        <p>Thông báo về trạng thái của bạn ở <strong>Công ty chúng tôi</strong> </p>
        </div>
        <div class="content">
            <h2>Xin chào {{ $customer->name }},</h2>
            <p>Chúng tôi xin thông báo rằng trạng thái cộng tác viên của bạn đã được cập nhật.</p>
            <p>Loại cộng tác viên mới của bạn: <strong>{{ $newCatalogue->name }}</strong></p>
            <p>Vui lòng đăng nhập vào hệ thống để kiểm tra quyền lợi và thông tin chi tiết.</p>
            <a href="[LINK_DANG_NHAP]" class="button">Đăng nhập ngay</a>
        </div>
        <div class="footer">
            <p>Nếu bạn có bất kỳ câu hỏi nào, vui lòng liên hệ <a href="mailto:24a4040617@hvnh.edu.vn">24a4040617@hvnh.edu.vn</a> hoặc hotline <strong>0399725203</strong>.</p>
            <p>Cảm ơn bạn đã đồng hành cùng chúng tôi!</p>
        </div>
    </div>
</body>
</html>
