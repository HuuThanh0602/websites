@extends('frontend.homepage.layout')
@section('content')
<div id="homepage" class="homepage">
    <!-- Main Slide -->
    <div class="panel-main-slide">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large">
                    @include('frontend.component.slide')
                </div>
            </div>
        </div>
    </div>


    <!-- Flash Sale / New Products -->
    @if(isset($widgets['flash-sale']))
    <div class="panel-flash-sale">
        <div class="uk-container uk-container-center">
            <div class="panel-head text-center">
                <h2 class="heading-1">SẢN PHẨM MỚI</h2>
            </div>
            <div class="panel-body">
                @php
                $productsPerPage = 5;
                $totalProducts = $widgets['flash-sale']->object->count();
                $currentPage = request()->query('page', 1);
                $totalPages = ceil($totalProducts / $productsPerPage);
                $currentPageProducts = $widgets['flash-sale']->object->forPage($currentPage, $productsPerPage);
                @endphp

                <div class="uk-grid uk-grid-medium">
                    @foreach ($currentPageProducts as $product)
                    <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-5 mb20">
                        @include('frontend.component.product-item', ['product' => $product])
                    </div>
                    @endforeach
                </div>

                @if($totalProducts > $productsPerPage)
                <div class="pagination-dots text-center mt20">
                    <ul class="uk-dotnav uk-flex-center">
                        @for($i = 1; $i <= $totalPages; $i++)
                            <li class="{{ $currentPage == $i ? 'uk-active' : '' }}">
                            <a href="{{ request()->fullUrlWithQuery(['page' => $i]) }}"></a>
                            </li>
                            @endfor
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif
    <!--poster-->
    <div class="anista-container">
        <!-- Left Section: Fashion Model with Labels -->
        <div class="fashion-display">
            <div class="model-image">
                <img src="https://scontent.fhan18-1.fna.fbcdn.net/v/t39.30808-6/486147961_122142851258532873_1653660984337176660_n.jpg?_nc_cat=100&ccb=1-7&_nc_sid=127cfc&_nc_ohc=4HEv7Yz5wKQQ7kNvgFZ5phT&_nc_oc=Adlod6cXYGLP79hyhCpbVTnYrnGascBeUlVkdodWdJsx1MAosfYgcwzrMKKGtz4xWuRbZxtJlR251jP894BHUT1H&_nc_zt=23&_nc_ht=scontent.fhan18-1.fna&_nc_gid=R39mRML-SiWECdMpRvqzig&oh=00_AYGZgMz1GFZ5S1_tKyJe59V5ChlBn70_yT2rfIo8K6fLyw&oe=67EFA3E0" alt="Fashion model wearing A'nista clothing">

                <!-- Product Labels -->
                <div class="product-label hat-label">
                    <div class="label-line"></div>
                    <div class="label-dot"></div>
                    <div class="label-box">Kính</div>
                </div>

                <div class="product-label shirt-label">
                    <div class="label-box">Đồng hồ</div>
                    <div class="label-dot"></div>
                    <div class="label-line"></div>

                </div>

                <div class="product-label watch-label">
                    <div class="label-line"></div>
                    <div class="label-dot"></div>
                    <div class="label-box">Chân váy</div>
                </div>

                <div class="product-label pants-label">
                    <div class="label-box">Áo khoác</div>
                    <div class="label-dot"></div>
                    <div class="label-line"></div>


                </div>

                <div class="product-label shoes-label">
                    <div class="label-line"></div>
                    <div class="label-dot"></div>
                    <div class="label-box">Giày</div>
                </div>
            </div>
        </div>

        <!-- Right Section: Brand Introduction -->
        <div class="brand-intro">
            <div class="content-wrapper" style="position: relative;
    z-index: 1;
    max-width: 80%;
    margin-left: auto;">
                <h2 class="brand-name">A'NISTA</h2>
                <p class="brand-description" style="margin-left: auto;">
                    Anista là một thương hiệu có doanh số đứng đầu với các thương
                    hiệu MLB, ADLV tại Việt Nam trong việc cung cấp sản phẩm tới
                    các cộng tác viên.
                </p>
                <a href="#" class="view-more-btn">Xem thêm</a>
            </div>

        </div>

        <!-- Benefits Section -->
        <div class="benefits-section">
            <div class="benefit-item">
                <div class="benefit-icon quality-icon">
                    <i class='bx bx-badge-check'></i>
                </div>
                <div class="benefit-content">
                    <h4>Chất lượng sản phẩm</h4>
                    <p style="font-size: 12px;">Chất lượng tốt</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon security-icon">
                    <i class='bx bx-lock-alt'></i>
                </div>
                <div class="benefit-content">
                    <h4>Chính sách bảo mật</h4>
                    <p style="font-size: 12px;">Hóa đơn của bạn sẽ được bảo mật an toàn</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon shipping-icon">
                    <i class='bx bxs-truck'></i>
                </div>
                <div class="benefit-content">
                    <h4>Miễn phí vận chuyển</h4>
                    <p style="font-size: 12px;">Miễn phí vận chuyển cho đơn hàng trên 100tr</p>
                </div>
            </div>

            <div class="benefit-item">
                <div class="benefit-icon support-icon">
                    <i class='bx bx-support'></i>
                </div>
                <div class="benefit-content">
                    <h4>Hỗ trợ 24/7</h4>
                    <p style="font-size: 12px;">Đội hỗ trợ của chúng tôi sẽ luôn có mặt khi bạn cần</p>
                </div>
            </div>
        </div>
    </div>


    <style>
        .anista-container {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            max-width: 1200px;
            margin: 0 auto;
            font-family: 'Quicksand';
            color: #333;
            border-radius: 8px;
            overflow: hidden;
        }


        /* Fashion Display Section */
        .fashion-display {
            flex: 1;
            min-width: 300px;
            position: relative;
            background-color: white;
            padding: 20px;
        }


        .model-image {
            position: relative;
            min-height: 400px;
        }


        .model-image img {
            max-width: 100%;
            height: auto;
        }


        /* Product Labels */
        .product-label {
            position: absolute;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            /* Add transition for smooth hover effects */
            cursor: pointer;
            /* Add pointer cursor to indicate interactivity */
        }


        .label-line {
            width: 40px;
            height: 1px;
            background-color: #F5F5F5;
            transition: all 0.3s ease;
        }


        .label-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 1px solid #F5F5F5;
            background-color: #fff;
            margin: 0 5px;
            transition: all 0.3s ease;
        }


        .label-box {
            padding: 5px 15px;
            border: 1px dashed #F5F5F5;
            border-radius: 10px;
            background-color: #fff;
            font-size: 14px;
            transition: all 0.3s ease;
        }


        /* Hover effect for all product labels */
        .product-label:hover .label-line {
            width: 60px;
            background-color: #7A95A1;
        }


        .product-label:hover .label-dot {
            background-color: #7A95A1;
            border-color: #7A95A1;
            transform: scale(1.2);
        }


        .product-label:hover .label-box {
            background-color: #7A95A1;
            color: white;
            border-color: #7A95A1;
            transform: translateX(5px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }


        .hat-label {
            top: 4%;
            right: 18%;
        }


        .shirt-label {
            top: 25%;
            left: 0%;
        }


        .watch-label {
            top: 40%;
            right: 8%;
        }


        .pants-label {
            top: 40%;
            left: 13%;
        }


        .shoes-label {
            bottom: 15%;
            right: 7%;
        }


        /* Brand Introduction Section */
        .brand-intro {
            flex: 1;
            min-width: 300px;
            background-color: #F5F5F5;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Tạo hình thang */
            clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
            margin: 3px;
            border-left: 1px dashed #DADADA;
        }

        .brand-intro {
            flex: 1;
            min-width: 300px;
            background-color: #F5F5F5;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;

            /* Tạo hình thang */
            clip-path: polygon(20% 0, 100% 0, 100% 100%, 0% 100%);
            position: relative;
            /* Cần để pseudo-element định vị chính xác */
        }


        /* Khi màn hình >= 770px, bỏ hình thang */
        @media (max-width: 770px) {
            .brand-intro {
                clip-path: none;
                /* Trở về hình chữ nhật */
            }


        }

        .brand-name {
            font-size: 30px;
            font-weight: 500;
            margin-left: auto;
            margin-bottom: 20px;
            color: #333;
        }


        .brand-description {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            color: #555;
        }


        .view-more-btn {
            display: inline-block;
            color: #7A95A1;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 300;
            width: max-content;
            transition: background-color 0.3s;
        }


        .view-more-btn:hover {
            color: #7A95A1;
            font-weight: 500;
            text-decoration: underline;
        }


        /* Benefits Section */
        .benefits-section {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 20px;
            background-color: white;
        }


        .benefit-item {
            flex: 1;
            min-width: 220px;
            display: flex;
            align-items: center;
            padding: 15px;
        }


        .benefit-icon {
            margin-right: 15px;
            display: flex;
            font-size: 4vh;
            justify-content: center;
            align-items: center;
            font-weight: lighter;
        }




        .benefit-content {
            flex: 1;
        }


        .benefit-content h4 {
            font-size: 16px;
            font-weight: 500;
            margin: 0 0 5px 0;
            color: #333;
        }


        .benefit-content p {
            font-size: 14px;
            margin: 0;
            color: #666;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .anista-container {
                flex-direction: column;
            }

            .benefits-section {
                flex-direction: column;
            }

            .benefit-item {
                margin-bottom: 15px;
            }
        }
    </style>
    <!--end poster-->
    <!-- Product Categories -->
    <div class="panel-general page">
        <div class="uk-container uk-container-center">
            <div class="panel-head text-center">
                <h2 class="heading-1">SẢN PHẨM HOT</h2>
            </div>
            @if(isset($widgets['product']->object) && count($widgets['product']->object))
            <div class="category-buttons text-center">
                @foreach($widgets['product']->object as $key => $category)
                @php
                $catName = $category->languages->first()->pivot->name;
                @endphp
                <button class="category-btn" data-category="category-{{ $key }}">{{ $catName }}</button>
                @endforeach
            </div>


            @foreach($widgets['product']->object as $key => $category)
            @php
            $catName = $category->languages->first()->pivot->name;
            $catCanonical = write_url($category->languages->first()->pivot->canonical);
            @endphp
            <div class="panel-product category-content" id="category-{{ $key }}" style="display: none;">
                <div class="panel-body">
                    @if(count($category->products))
                    <div class="uk-grid uk-grid-medium">
                        @foreach($category->products as $product)
                        <div class="uk-width-1-2 uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-5 mb20">
                            @include('frontend.component.product-item', ['product' => $product])
                        </div>
                        @endforeach
                    </div>
                    @endif
                    <div class="panel-footer text-center">
                        <a href="{{ $catCanonical }}" class="btn-view-all">Tất cả sản phẩm</a>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>


    <!-- Blog Posts -->
    @if(isset($widgets['posts']->object))
    @foreach($widgets['posts']->object as $key => $val)
    @php
    $catName = $val->languages->first()->pivot->name;
    $catCanonical = write_url($val->languages->first()->pivot->canonical);
    $latestPosts = $val->posts->sortByDesc('created_at')->take(3);
    @endphp
    <div class="panel-news">
        <div class="uk-container uk-container-center">
            <div class="panel-head">
                <h2 class="heading-1">{{ $catName }}</h2>
            </div>
            <div class="panel-body">
                @if(count($latestPosts))
                <div class="uk-grid uk-grid-medium blog-grid">
                    <!-- Featured post column -->
                    <div class="uk-width-1-2 uk-width-medium-2-5 uk-width-large-1-3 featured-column">
                        <div class="featured-card">
                            <div class="featured-image-wrapper">
                                <div class="featured-image">
                                    <img src="https://images.pexels.com/photos/5480690/pexels-photo-5480690.jpeg" alt="Nhà A'nistanista">
                                </div>
                            </div>
                            <div class="featured-content">
                                <div class="description">Khám phá bộ sưu tập bài viết mới nhất của chúng tôi về thời trang</div>
                                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                    <a href="{{ $catCanonical }}" class="readmore">Tìm hiểu thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Posts list column -->
                    <div class="uk-width-1-2 uk-width-medium-3-5 uk-width-large-2-3 posts-column">
                        <div class="posts-list">
                            @foreach($latestPosts as $post)
                            @php
                            $name = $post->languages->first()->pivot->name;
                            $canonical = write_url($post->languages->first()->pivot->canonical);
                            $createdAt = convertDateTime($post->created_at, 'd/m/Y');
                            $description = cutnchar(strip_tags($post->languages->first()->pivot->description), 100);
                            $image = $post->image;
                            @endphp
                            <div class="post-item">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-1-3 uk-width-small-1-4">
                                        <a href="{{ $canonical }}" class="image img-cover">
                                            <img src="{{ $image }}" alt="{{ $name }}">
                                        </a>
                                    </div>
                                    <div class="uk-width-2-3 uk-width-small-3-4">
                                        <div class="info">
                                            <h3 class="title"><a href="{{ $canonical }}">{{ $name }}</a></h3>
                                            <div class="description">{!! $description !!}</div>
                                            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                                                <a href="{{ $canonical }}" class="readmore">Xem thêm</a>
                                                <span class="created_at">{{ $createdAt }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    @endif
</div>


@endsection


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hide all category content initially
        document.querySelectorAll(".category-content").forEach(el => el.style.display = "none");


        // Show first category by default and activate its button
        let firstCategory = document.querySelector(".category-content");
        if (firstCategory) {
            firstCategory.style.display = "block";
            document.querySelector(".category-btn").classList.add("active");
        }


        // Add click event listeners to category buttons
        document.querySelectorAll(".category-btn").forEach(button => {
            button.addEventListener("click", function() {
                // Remove active class from all buttons
                document.querySelectorAll(".category-btn").forEach(btn => btn.classList.remove("active"));
                // Add active class to clicked button
                this.classList.add("active");


                // Hide all category content and show the selected one
                let categoryId = this.getAttribute("data-category");
                document.querySelectorAll(".category-content").forEach(el => el.style.display = "none");
                document.getElementById(categoryId).style.display = "block";
            });
        });
    });
</script>


<style>
    /* General styling */
    .text-center {
        text-align: center;
    }


    .mb20 {
        margin-bottom: 20px;
    }


    .mt20 {
        margin-top: 20px;
    }


    /* Section headers */
    .panel-head {
        margin-bottom: 30px;
        text-align: center;
    }


    .heading-1 {
        position: relative;
        display: inline-block;
        padding-bottom: 10px;
        color: #333;
        margin: 0 0 10px;
        text-transform: uppercase;
    }


    .heading-1:after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 3px;
        background-color: #7A95A2;
    }


    /* Category buttons */
    .category-buttons {
        margin-bottom: 20px;
    }


    .category-btn {
        color: #7A95A2;
        border: 0.55px dashed #7A95A2;
        padding: 10px 10px;
        margin: 5px;
        cursor: pointer;
        border-radius: 15px;
        background-color: transparent;
        transition: all 0.3s ease;
    }


    .category-btn.active {
        background-color: #7A95A2;
        color: white;
        font-weight: bold;
    }


    .category-btn:hover {
        background-color: #7A95A2;
        color: white;
    }


    /* View all button */
    .panel-footer {
        margin-top: 20px;
    }


    .btn-view-all {
        color: white;
        background-color: #7A95A2;
        padding: 10px 15px;
        text-decoration: none;
        border-radius: 100px;
        font-weight: 100;
        transition: all 0.3s ease;
    }


    .btn-view-all:hover {
        font-weight: 200;
    }


    /* Blog section styling */
    .panel-news {
        padding: 40px 0;
        background-color: white;
    }


    .blog-grid {
        display: flex;
        min-height: 400px;
    }


    /* Featured post card */
    .featured-column {
        display: flex;
        align-items: stretch;
        height: 100%;
    }


    .featured-card {
        width: 100%;
        display: flex;
        flex-direction: column;
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 5vh;
    }


    .featured-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }


    .featured-image-wrapper {
        width: 100%;
        border-radius: 12px 12px 0 0;
        overflow: hidden;
    }


    .featured-image {
        display: block;
        height: 260px;
        width: 100%;
        overflow: hidden;
    }


    .featured-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }


    .featured-image:hover img {
        transform: scale(1.08);
    }


    .featured-content {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }


    .featured-content .description {
        margin-bottom: 1vh;
        color: #666;
        flex: 1;
    }


    .featured-content .readmore {
        text-align: center;
        color: #7A95A2;
        font-weight: 500;
        margin-bottom: 2px;
    }


    /* Posts list */
    .posts-column {
        display: flex;
        align-items: stretch;
        height: 100%;
    }


    .posts-list {
        width: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }


    .post-item {
        margin-bottom: 2vh;
        flex: 1;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }


    .post-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.12);
    }


    .post-item:last-child {
        margin-bottom: 0;
    }


    .post-item .uk-grid {
        width: 100%;
        margin: 0;
    }


    /* Post image */
    .post-item .image {
        height: 100%;
        border-radius: 10px 0 0 10px;
        overflow: hidden;
        display: block;
    }


    .post-item .image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }


    .post-item .image:hover img {
        transform: scale(1.08);
    }


    /* Post content */
    .post-item .uk-width-1-3,
    .post-item .uk-width-2-3 {
        padding: 0;
    }


    .post-item .uk-width-2-3 {
        padding: 15px;
    }


    .post-item .info {
        display: flex;
        flex-direction: column;
        height: 100%;
    }


    .post-item .title {
        margin-top: 0;
        margin-bottom: 10px;
        order: 1;
        font-size: 1em;
    }


    .post-item .title a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }


    .post-item .title a:hover {
        color: #7A95A2;
    }


    .post-item .description {
        margin-bottom: 15px;
        order: 2;
        color: #666;
        flex: 1;
        line-height: 1.5;
        font-size: 0.8em;
    }


    .post-item .uk-flex {
        margin-top: auto;
        order: 3;
    }


    .post-item .readmore {
        color: #7A95A2;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }


    .post-item .readmore:hover {
        text-decoration: underline;
    }


    .post-item .created_at {
        color: #999;
        font-size: 0.9em;
    }


    /* Pagination dots */
    .pagination-dots {
        margin: 30px 0;
    }


    .pagination-dots .uk-dotnav {
        margin: 0;
        padding: 0;
    }


    .pagination-dots .uk-dotnav>* {
        padding-left: 8px;
    }


    .pagination-dots .uk-dotnav>*>* {
        width: 8px;
        height: 8px;
        border: 1px solid #ccc;
        background: transparent;
        transition: all 0.3s ease;
    }


    .pagination-dots .uk-dotnav>.uk-active>* {
        background-color: #7A95A2;
        border-color: #7A95A2;
        transform: scale(1.08);
    }


    .pagination-dots .uk-dotnav>*>*:hover {
        background-color: #7A95A2;
    }


    /* Animations */
    .uk-grid>div {
        animation: fadeIn 0.5s ease-in-out;
    }


    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }


    /* Responsive styles */
    @media (max-width: 767px) {
        .blog-grid {
            flex-direction: column;
            min-height: auto;
        }

        .featured-column,
        .posts-column {
            width: 100% !important;
        }

        .featured-column {
            margin-bottom: 20px;
        }

        .featured-card {
            height: auto;
        }

        .featured-image {
            height: 200px;
        }

        .posts-list {
            display: block;
        }

        .post-item {
            margin-bottom: 15px;
        }

        .post-item .uk-grid {
            display: block;
        }

        .post-item .uk-width-1-3,
        .post-item .uk-width-2-3 {
            width: 100% !important;
            padding: 0;
        }

        .post-item .image {
            margin-bottom: 0;
            height: 180px;
            border-radius: 10px 10px 0 0;
        }

        .post-item .uk-width-2-3 {
            padding: 15px;
        }
    }
</style>