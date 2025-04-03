@extends('frontend.homepage.layout')
@section('content')

<div class="cart-container">
    <div class="page-breadcrumb background">      
        <div class="uk-container uk-container-center">
            <ul class="uk-list uk-clearfix">
                <li><a href="/"><i class="fi-rs-home mr5"></i>Trang chủ</a></li>
                <li><a title="Hệ thống phân phối">giỏ hàng</a></li>
            </ul>
        </div>
    </div>
    <div class="uk-container uk-container-center">
        @if ($errors->any())
        <div class="uk-alert uk-alert-danger" style="margin-top: 20px">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('cart.store') }}" class="uk-form form" method="post">
            @csrf
            <h2 class="heading-1"><span>Giỏ hàng</span></h2>
            <div class="cart-wrapper">
                <div class="panel-cart">
                    <div class="panel-head">
                        <h2 class="cart-heading"><span>Đơn hàng</span></h2>
                    </div>
                    
            <div class="panel-body">
                @if (!empty($carts))
                <div class="cart-list">
                    @php
                    $carts = $carts ?? []; 

                    $tongTien = empty($carts) ? 0 : collect($carts)->sum(fn($cart) => ($cart->price ?? 0) * ($cart->qty ?? 0));

                        
                    @endphp
                    @foreach($carts as $keyCart => $cart)
                                <div class="cart-item">
                                    <div class="uk-grid uk-grid-medium">
                                        <div class="uk-width-small-1-1 uk-width-medium-1-5">
                                            <div class="cart-item-image">
                                                <span class="image img-scaledown"><img src="{{ $cart->image }}" alt=""></span>
                                                <span class="cart-item-number">{{ $cart->qty }}</span>
                                            </div>
                                        </div>
                                        <div class="uk-width-small-1-1 uk-width-medium-4-5">
                                            <div class="cart-item-info">
                                                <h3 class="title"><span>{{ $cart->name }}</span></h3>
                                                <div class="cart-item-action uk-flex uk-flex-middle uk-flex-space-between">
                                                    <div class="cart-item-qty" style="display: flex; align-items: center;">
                                                        <form action="{{ route('cart.update_1') }}" method="POST">
                                                            @csrf                                                         
                                                        </form>
                                                        <form action="{{ route('cart.update_1') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $cart->id }}">
                                                            <input type="hidden" name="change" value="-1">
                                                            <button type="submit" class="btn-qty2 minus">-</button>
                                                        </form>
                                                        <input type="text" class="input-qty" value="{{ $cart->qty }}" readonly>
                                                        <form action="{{ route('cart.update_1') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $cart->id }}">
                                                            <input type="hidden" name="change" value="1">
                                                            <button type="submit" class="btn-qty2 plus">+</button>
                                                        </form>
                                                    </div>
                                                    <div class="cart-item-price">
                                                        <span class="cart-price-sale">{{ convert_price($cart->price * $cart->qty, true) }}đ</span>
                                                    </div>
                                                    <form action="{{ route('cart.remove') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="product_id" value="{{ $cart->id }}">
                                                        <button type="submit" class="cart-item-remove">✕</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach  
                        </div>
                        @endif
                    </div>
                    <button type="button" class="cart-checkout" onclick="window.location.href='{{ route('cart.checkout3', ['type' => 2]) }}'">
                        Thanh toán đơn hàng
                    </button>                      
                </div>
            </div>
        </form>
    </div>
</div>
<style>
  .cart-container {
   
    padding: 20px 0;
    background-color: #f8f8f8;
}

.page-breadcrumb {
    background: #fff;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.page-breadcrumb ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.page-breadcrumb ul li {
    display: inline;
    font-size: 14px;
    color: #555;
}

.page-breadcrumb ul li a {
    text-decoration: none;
    color: #333;
}

.cart-wrapper {
    width: 50%;

    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin: 20px auto;
}

.panel-cart {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background: #fff;
}

.panel-head {
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 15px;
}

.cart-heading {
    font-size: 22px;
    font-weight: bold;
    color: #333;
}

.cart-checkout {
    width: 100%;
    display: block;
    background: #ff6600;
    color: #fff;
    padding: 12px;
    border: none;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 15px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.cart-checkout:hover {
    background: #e65c00;
}

/* Hiển thị lỗi */
.uk-alert {
    padding: 10px;
    border-radius: 5px;
    font-size: 14px;
}

.uk-alert-danger {
    background: #ffdddd;
    color: #d8000c;
    border: 1px solid #d8000c;
}

.uk-alert-danger ul {
    margin: 0;
    padding: 0;
}

.uk-alert-danger ul li {
    list-style: none;
}
  
</style>
@endsection