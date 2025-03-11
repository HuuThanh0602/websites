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
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                Tất cả
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Chờ thanh toán
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Vận chuyển
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Chờ giao hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Hoàn thành
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Đã hủy
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Trả hàng/Hoàn tiền
                            </a>
                        </li>
                    </ul>
                    <div class="order-header mt-3">
                        
                    
                    </div>
                    <div class="order-item">
                        <img alt="Product image" height="100"
                            src="https://storage.googleapis.com/a1aa/image/nDfObiktJlVzLaot0RhyX6P3jmAhniwofqPpnTFzHn342MzTA.jpg"
                            width="100" />
                        <div class="item-details">
                            <div class="item-name">
                                Dầu Gội Head &amp; Shoulder 400ml Giảm Gàu, Nấm Vảy Nến Chính Hãng
                            </div>
                            <div class="item-category">
                                Phân loại hàng: Cam Tóc Gàu Khô
                            </div>
                            <div class="item-quantity">
                                x2
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="text-decoration-line-through text-muted">
                                ₫360.000
                            </div>
                            <div class="text-danger">
                                ₫295.000
                            </div>
                        </div>
                    </div>
                    <div class="order-item">
                        <img alt="Product image" height="100"
                            src="https://storage.googleapis.com/a1aa/image/nDfObiktJlVzLaot0RhyX6P3jmAhniwofqPpnTFzHn342MzTA.jpg"
                            width="100" />
                        <div class="item-details">
                            <div class="item-name">
                                Dầu Gội Head &amp; Shoulder 400ml Giảm Gàu, Nấm Vảy Nến Chính Hãng
                            </div>
                            <div class="item-category">
                                Phân loại hàng: Cam Tóc Gàu Khô
                            </div>
                            <div class="item-quantity">
                                x2
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="text-decoration-line-through text-muted">
                                ₫360.000
                            </div>
                            <div class="text-danger">
                                ₫295.000
                            </div>
                        </div>
                    </div>
                    <div class="order-footer">
                        <div class="total-price">
                            Thành tiền: ₫590.000
                        </div>
                        <div>
                            
                            <button class="btn btn-outline-secondary">
                                Chi tiết
                            </button>
                        
                        </div>
                    </div>
                


                    <hr>

                    <div class="order-header mt-3">
                        
                    
                    </div>
                    <div class="order-item">
                        <img alt="Product image" height="100"
                            src="https://storage.googleapis.com/a1aa/image/nDfObiktJlVzLaot0RhyX6P3jmAhniwofqPpnTFzHn342MzTA.jpg"
                            width="100" />
                        <div class="item-details">
                            <div class="item-name">
                                Dầu Gội Head &amp; Shoulder 400ml Giảm Gàu, Nấm Vảy Nến Chính Hãng
                            </div>
                            <div class="item-category">
                                Phân loại hàng: Cam Tóc Gàu Khô
                            </div>
                            <div class="item-quantity">
                                x2
                            </div>
                        </div>
                        <div class="item-price">
                            <div class="text-decoration-line-through text-muted">
                                ₫360.000
                            </div>
                            <div class="text-danger">
                                ₫295.000
                            </div>
                        </div>
                    </div>
                    
                    <div class="order-footer">
                        <div class="total-price">
                            Thành tiền: ₫590.000
                        </div>
                        <div>
                            <button class="btn btn-outline-secondary">
                                Chi tiết
                            </button>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
    </div>
</body>

</html>