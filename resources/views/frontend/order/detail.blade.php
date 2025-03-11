<html>

<head>
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f5f5f5;
        }

        .profile-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .profile-section img {
            border-radius: 50%;
        }

        .profile-section .username {
            font-size: 18px;
            font-weight: bold;
        }

        .profile-section .edit-profile {
            font-size: 14px;
            color: #888;
        }

        .nav-link {
            color: #333;
            font-size: 16px;
        }

        .nav-link.active {
            color: #ee4d2d;
        }

        .order-section {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .order-header .shop-name {
            font-size: 18px;
            font-weight: bold;
        }

        .order-header .btn {
            font-size: 14px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .order-item img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .order-item .item-details {
            flex-grow: 1;
            margin-left: 20px;
        }

        .order-item .item-details .item-name {
            font-size: 16px;
            font-weight: bold;
        }

        .order-item .item-details .item-category {
            font-size: 14px;
            color: #888;
        }

        .order-item .item-details .item-quantity {
            font-size: 14px;
            color: #888;
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-footer .total-price {
            font-size: 18px;
            font-weight: bold;
            color: #ee4d2d;
        }

        .order-footer .btn {
            font-size: 14px;
        }
    </style>



    <style>
        body {
            background-color: #f5f5f5;
        }

        .product-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .product-item img {
            width: 60px;
            height: 60px;
            margin-right: 10px;
        }

        .product-item .badge {
            background-color: #ff424f;
            color: white;
            font-size: 12px;
            margin-right: 5px;
        }

        .product-item .product-details {
            flex-grow: 1;
        }

        .product-item .product-details p {
            margin: 0;
        }

        .product-item .product-details .product-name {
            font-size: 14px;
            font-weight: bold;
        }

        .product-item .product-details .product-type {
            font-size: 12px;
            color: #666;
        }

        .product-item .product-details .product-quantity {
            font-size: 12px;
            color: #666;
        }

        .summary-table {
            width: 100%;
            margin-top: 20px;
        }

        .summary-table td {
            padding: 10px 0;
        }

        .summary-table .total-amount {
            font-size: 18px;
            color: #ff424f;
            font-weight: bold;
        }

        .summary-table .total-amount-cell {
            text-align: right;
        }

        .summary-table .info-icon {
            font-size: 12px;
            color: #999;
        }

        .payment-method {
            margin-top: 20px;
            padding: 10px;
            background-color: #fff8e1;
            border: 1px solid #ffecb3;
            color: #ff9800;
            font-size: 14px;
        }

        .payment-method .payment-amount {
            font-size: 18px;
            color: #ff424f;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3">
                <div class="profile-section text-center">
                    <img alt="User profile picture" height="100"
                        src="https://storage.googleapis.com/a1aa/image/F20ybQFkEpoQH9YP8b46FDQHfxgUi88veXsvNpnvHak62MzTA.jpg"
                        width="100" />
                    <div class="username mt-2">
                        Bảo Minh
                    </div>
                    <div class="edit-profile">
                        <i class="fas fa-edit">
                        </i>
                        Sửa Hồ Sơ
                    </div>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-user">
                            </i>
                            Tài Khoản Của Tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-shopping-bag">
                            </i>
                            Đơn Mua
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-bell">
                            </i>
                            Thông Báo
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9">
                <div class="order-section">

                    <div class="product-item">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d149498.57983001356!2d105.84611573691804!3d10.055947492398122!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1732190959809!5m2!1sen!2s"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                    <div class="product-item">
                        <img alt="Product image of a black face mask with a hat" height="60"
                            src="https://storage.googleapis.com/a1aa/image/3pwjc6dA2OrwKhAjSTDf5pe93f3mW31qZ9qgxk7WS2xMgamnA.jpg"
                            width="60" />
                        <div class="product-details">
                            <span class="badge">
                                Quà Tặng
                            </span>
                            <p class="product-name">
                                Khẩu Trang Có Nón Che Mặt Cổ Vai Chống Tia UV Vải Nhung Cao Cấp Thoáng Mát ( Fashion Hat Mask Co
                                Giãn Tản Nhiệt Tốt )
                            </p>
                            <p class="product-type">
                                Phân loại hàng: ✤ 1 Khẩu Trang 5D
                            </p>
                            <p class="product-quantity">
                                x1
                            </p>
                        </div>
                    </div>
                    <div class="product-item">
                        <img alt="Product image of a black face mask with a hat" height="60"
                            src="https://storage.googleapis.com/a1aa/image/3pwjc6dA2OrwKhAjSTDf5pe93f3mW31qZ9qgxk7WS2xMgamnA.jpg"
                            width="60" />
                        <div class="product-details">
                            <span class="badge">
                                Quà Tặng
                            </span>
                            <p class="product-name">
                                Bịt Mặt Chống Nắng Nam Khăn Ống Đa Năng Đi Phượt Chống Tia UV ( Khẩu Trang Trùm Đầu Full Kín Vải Dày
                                Logo Đổi Màu )
                            </p>
                            <p class="product-type">
                                Phân loại hàng: ✤ 1 Khẩu Trang 5D
                            </p>
                            <p class="product-quantity">
                                x1
                            </p>
                        </div>
                    </div>
                    <div class="product-item">
                        <img alt="Product image of a UV test card and a small UV flashlight" height="60"
                            src="https://storage.googleapis.com/a1aa/image/JRhZLKCOEvaoMVfSeE9IE2GJ1FbzM1hf6MqYsK35WcNRgamnA.jpg"
                            width="60" />
                        <div class="product-details">
                            <span class="badge">
                                Quà Tặng
                            </span>
                            <p class="product-name">
                                [ Thẻ Test UV ] Đèn Pin UV Mini Nhỏ Gọn Có Móc Khóa Soi Huỳnh Quang Vi Khuẩn Đa Năng ( Đèn Tia Cực
                                Tím )
                            </p>
                            <p class="product-type">
                                Phân loại hàng: 1 Thẻ Nhựa UV / Ánh Tím
                            </p>
                            <p class="product-quantity">
                                x1
                            </p>
                        </div>
                    </div>
                    <table class="summary-table">
                        <tr>
                            <td>
                                Tổng tiền hàng
                            </td>
                            <td class="total-amount-cell">
                                ₫51.800
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phí vận chuyển
                            </td>
                            <td class="total-amount-cell">
                                ₫32.200
                            </td>
                        </tr>


                        <tr>
                            <td>
                                Thành tiền
                            </td>
                            <td class="total-amount total-amount-cell">
                                ₫58.300
                            </td>
                        </tr>
                    </table>
                    <div class="payment-method">
                        <span>
                            Vui lòng thanh toán
                            <span class="payment-amount">
                                ₫58.300
                            </span>
                            khi nhận hàng.
                        </span>
                    </div>


                    <hr>




                </div>
            </div>
        </div>
    </div>
</body>

</html>