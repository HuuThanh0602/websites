@php
$name = $product->languages->first() && $product->languages->first()->pivot
? $product->languages->first()->pivot->name
: 'Tên mặc định'; // Hoặc giá trị mặc định khác
//dd($product);
$canonical = $product->languages->first() && $product->languages->first()->pivot
? write_url($product->languages->first()->pivot->canonical)
: '#'; // Canonical mặc định nếu không có dữ liệu

$image = image($product->image);
$price = getPrice($product);
$catName = $product->product_catalogues->first()
&& $product->product_catalogues->first()->languages->first()
&& $product->product_catalogues->first()->languages->first()->pivot
? $product->product_catalogues->first()->languages->first()->pivot->name
: 'Danh mục mặc định'; // Giá trị mặc định

$review = getReview($product);
$discount = isset($price['original']) && $price['original'] > $price['final']
? round((($price['original'] - $price['final']) / $price['original']) * 100)
: 0;
$quantity = $product->product_variants->sum('quantity');
$allowOrder = $product->allow_order;
//dd($allowOrder);
@endphp
<div class="product-item product">
    <a href="{{ $canonical }}" class="image img-scaledown img-zoomin">
        <img src="{{ $image }}" alt="{{ $name }}">
        @if ($discount > 0)
        <span class="discount-badge"><i class="fa-solid fa-tag"></i> -{{ $discount }}%</span>
        @endif
        <span class="favorite-icon" onclick="toggleFavorite(this)">
            <i class="fa-solid fa-heart"></i>
        </span>
    </a>

    <div class="info">
        <h3 class="title"><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></h3>
        <div class="product-group">
            @if ($quantity <= 0 && $allowOrder==1)
                <span class="order-now">Order</span>
                @elseif ($quantity <= 0 && $allowOrder != 1)
                <span class="out-of-stock">Hết hàng</span>
            
                @else
                {!! $price['html'] !!}
                @endif
        </div>
    </div>
</div>

<script>
    function toggleFavorite(element) {
        element.classList.toggle('active');
        let icon = element.querySelector("i");
        if (element.classList.contains("active")) {
            icon.style.color = "#ff0000"; // Đổi màu đỏ khi chọn
        } else {
            icon.style.color = "#ffffff"; // Trở về màu mặc định
        }
    }
</script>

<style>
    .product-item {
        background: #fff;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .product-item:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.15);
    }

    .product-item .image {
        position: relative;
        display: block;
        overflow: hidden;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-item .info {
        padding: 15px;
    }

    .product-item .title {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .product-item .product-group {
        font-size: 14px;
        font-weight: bold;
        color: #e60000;
    }

    .order-now {
        color: #007bff;
        font-weight: bold;
    }

    .out-of-stock {
        color: #ff0000;
        font-weight: bold;
    }

    /* Cải thiện icon yêu thích và giảm giá */
    .favorite-icon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        color: rgba(255, 77, 77, 0.9);
        padding: 8px;
        font-size: 14px;
        font-weight: bold;
        cursor: pointer;
    }

    .favorite-icon i {
        transition: color 0.3s ease-in-out;
    }

    .favorite-icon.active i {
        color: #ff0000;
    }

    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: rgba(255, 153, 0, 0.9);
        color: #fff;
        padding: 5px 10px;
        font-size: 14px;
        font-weight: bold;
        border-radius: 5px;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    }
</style>