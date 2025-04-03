Resources\views\frontend\cart\cart.blade.php 
@extends('frontend.homepage.layout')
@section('content')


<div class="cart-container">
    <!-- Breadcrumb navigation -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $type == 2 ? 'Giỏ hàng' : 'Giỏ hàng Order' }}</li>
                </ol>
            </nav>
        </div>
    </div>


    <!-- Main Cart Content -->
    <div class="container">
        <!-- Display errors if any -->
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif


        <!-- Cart Toggle Buttons -->
        <div class="cart-toggle-container">
            <div class="cart-toggle-buttons">
               
                <a href="#" class="cart-toggle-btn {{ $type == 2 ? 'active' : '' }}">
                    <i class="fas fa-shopping-cart"></i> Giỏ hàng
                </a>


                <a href="#" class="cart-toggle-btn {{ $type == 3 ? 'active' : '' }}">
                    <i class="fas fa-clipboard-list"></i> Giỏ hàng Order
                </a>
            </div>
        </div>


        <!-- Cart form -->
        <form action="{{ route('cart.store') }}" method="post" id="cart-form">
            @csrf
         


            <div class="cart-content">
            <div class="select-all-container">
                    <label class="select-all-label">
                        <input type="checkbox" id="select-all-products" class="select-all-checkbox">
                        <span class="checkmark"></span>
                        Chọn tất cả
                    </label>
                </div>
                @if (!empty($carts) && count($carts) > 0)
                    @php
                    $carts = $carts ?? [];
                    $tongTien = empty($carts) ? 0 : collect($carts)->sum(fn($cart) => ($cart->price ?? 0) * ($cart->qty ?? 0));
                    @endphp
                   
                    <div class="cart-items-table">
                        <div class="cart-header-row d-none d-md-flex">
                            <div class="header-item col-md-1"></div>
                            <div class="header-item col-md-5">Sản phẩm</div>
                            <div class="header-item col-md-2 text-center">Số lượng</div>
                            <div class="header-item col-md-2 text-center">Giá</div>
                            <div class="header-item col-md-2 text-center">Thao tác</div>
                        </div>
                       
                        @foreach($carts as $keyCart => $cart)
                        <div class="cart-item">
                            <div class="row align-items-center">
                                <!-- Checkbox Selection -->
                                <div class="col-md-1">
                                    <div class="product-select">
                                        <label class="product-checkbox">
                                            <input type="checkbox" name="selected_products[]" value="{{ $cart->product_id ?? $cart->id }}" class="product-checkbox-input">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                               
                                <!-- Product Image & Info -->
                                <div class="col-md-5">
                                    <div class="product-info d-flex align-items-center">
                                        <div class="product-image">
                                            <img src="{{ $cart->image }}" alt="{{ $cart->name }}" class="img-fluid">
                                        </div>
                                        <div class="product-details">
                                            <h3 class="product-title">{{ $cart->name }}</h3>
                                           
                                            <!-- Product Attributes Selection -->
                                            <div class="product-attributes">
                                                <div class="attribute-group">
                                                    <label>Size:</label>
                                                    <select name="attribute[{{ $cart->product_id ?? $cart->id }}]" class="attribute-select size-select">
                                                        <option value="S" {{ $cart->attribute == 'S' ? 'selected' : '' }}>S</option>
                                                        <option value="M" {{ $cart->attribute == 'M' ? 'selected' : '' }}>M</option>
                                                        <option value="L" {{ $cart->attribute == 'L' ? 'selected' : '' }}>L</option>
                                                        <option value="XL" {{ $cart->attribute == 'XL' ? 'selected' : '' }}>XL</option>
                                                    </select>
                                                </div>
                                            </div>
                                           
                                            <!-- Product Inventory Status -->
                                            <div class="product-inventory">
                                                <i class="fas fa-warehouse"></i>
                                                <span class="inventory-status {{ ($cart->stock ?? 10) > 5 ? 'in-stock' : 'low-stock' }}">
                                                    Còn lại: {{ $cart->stock ?? rand(1, 20) }} sản phẩm
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
                                <!-- Quantity Controls -->
                                <div class="col-md-2">
                                    <div class="quantity-control">
                                        <form action="{{ route('cart.update_1') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <input type="hidden" name="product_id" value="{{ $cart->product_id ?? $cart->id }}">
                                            <input type="hidden" name="product_variant_id" value="{{ $cart->product_variant_id ?? '' }}">
                                            <input type="hidden" name="change" value="-1">
                                            <button type="submit" class="btn-quantity">-</button>
                                        </form>
                                       
                                        <input type="text" class="quantity-input" value="{{ $cart->qty }}" readonly>
                                       
                                        <form action="{{ route('cart.update_1') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="type" value="{{ $type }}">
                                            <input type="hidden" name="product_id" value="{{ $cart->product_id ?? $cart->id }}">
                                            <input type="hidden" name="product_variant_id" value="{{ $cart->product_variant_id ?? '' }}">
                                            <input type="hidden" name="change" value="1">
                                            <button type="submit" class="btn-quantity">+</button>
                                        </form>
                                    </div>
                                </div>
                               
                                <!-- Price -->
                                <div class="col-md-2">
                                    <div class="product-price">
                                        {{ convert_price($cart->price * $cart->qty, true) }}đ
                                    </div>
                                </div>
                               
                                <!-- Remove Action -->
                                <div class="col-md-2">
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="type" value="{{ $type }}">
                                        <input type="hidden" name="product_id" value="{{ $cart->product_id ?? $cart->id }}">
                                        <input type="hidden" name="product_variant_id" value="{{ $cart->product_variant_id ?? '' }}">
                                        <button type="submit" class="btn-remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                   
                    <!-- Cart Summary -->
                    <div class="cart-summary">
                        <div class="row">
                            <div class="col-md-6 offset-md-6">
                                <div class="summary-card">
                                    <div class="summary-row">
                                        <span class="summary-label">Sản phẩm đã chọn:</span>
                                        <span class="summary-value" id="selected-count">0</span>
                                    </div>
                                    <div class="summary-row">
                                        <span class="summary-label">Tổng tiền:</span>
                                        <span class="summary-value">{{ convert_price($tongTien, true) }}đ</span>
                                    </div>
                                    <button type="button" id="checkout-selected" class="btn-checkout">
                                        Thanh toán sản phẩm đã chọn
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="empty-cart">
                        <div class="empty-cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h3>{{ $type == 2 ? 'Giỏ hàng' : 'Giỏ hàng Order' }} của bạn đang trống</h3>
                        <p>Hãy thêm sản phẩm vào giỏ hàng để tiếp tục mua sắm</p>
                        <a href="/" class="btn-continue-shopping">Tiếp tục mua sắm</a>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>


<style>
/* Modern Cart Styles */
.cart-container {
    padding: 40px 0;
    background-color: #f8f9fa;
    min-height: 70vh;
}


/* Breadcrumbs */




.breadcrumb-item {
    font-size: 14px;
}


.breadcrumb-item a {
    color: #333;
    text-decoration: none;
    transition: color 0.2s;
}


.breadcrumb-item a:hover {
    color: #7A95A1;
}


.breadcrumb-item.active {
    color: #6c757d;
}


.breadcrumb-item+.breadcrumb-item::before {
    content: "›";
    color: #6c757d;
}


/* Cart Toggle Buttons */
.cart-toggle-container {
    margin-bottom: 30px;
}


.cart-toggle-buttons {
    display: flex;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    overflow: hidden;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
}


.cart-toggle-btn {
    flex: 1;
    padding: 15px;
    text-align: center;
    color: #555;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
    border-bottom: 3px solid transparent;
}


.cart-toggle-btn:hover {
    color: #7A95A1;
}


.cart-toggle-btn.active {
    color: #7A95A1;
    border-bottom: 3px solid #7A95A1;
    font-weight: 600;
}


.cart-toggle-btn i {
    margin-right: 6px;
}


/* Cart Header */
.cart-header {
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}




/* Select All Checkbox */
.select-all-container {
    display: flex;
    align-items: center;
}


.select-all-label {
    display: flex;
    align-items: center;
    font-size: 15px;
    color: #555;
    cursor: pointer;
    position: relative;
    padding-left: 35px;
    margin-bottom: 0;
    user-select: none;
}


.select-all-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}


.checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 20px;
    width: 20px;
    background-color: #fff;
    border: 2px solid #ddd;
    border-radius: 4px;
}


.select-all-label:hover .checkmark {
    border-color: #7A95A1;
}


.select-all-checkbox:checked ~ .checkmark {
    background-color: #7A95A1;
    border-color: #7A95A1;
}


.checkmark:after {
    content: "";
    position: absolute;
    display: none;
}


.select-all-checkbox:checked ~ .checkmark:after {
    display: block;
}


.select-all-label .checkmark:after {
    left: 6px;
    top: 2px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}


/* Cart Content */
.cart-content {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.08);
    padding: 20px;
}


/* Cart Table */
.cart-header-row {
    padding: 15px;
    border-bottom: 1px solid #eee;
    font-weight: 600;
    color: #555;
}


.cart-item {
    padding: 20px 15px;
    border-bottom: 1px solid #eee;
    transition: background-color 0.2s;
}


.cart-item:hover {
    background-color: #f9f9f9;
}


.cart-item:last-child {
    border-bottom: none;
}


/* Product Checkbox */
.product-checkbox {
    display: block;
    position: relative;
    padding-left: 35px;
    margin-bottom: 0;
    cursor: pointer;
    font-size: 16px;
    user-select: none;
    height: 24px;
}


.product-checkbox-input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}


.product-checkbox .checkmark {
    position: absolute;
    top: 0;
    left: 0;
    height: 22px;
    width: 22px;
    background-color: #fff;
    border: 2px solid #ddd;
    border-radius: 4px;
}


.product-checkbox:hover .checkmark {
    border-color: #7A95A1;
}


.product-checkbox-input:checked ~ .checkmark {
    background-color: #7A95A1;
    border-color: #7A95A1;
}


.product-checkbox .checkmark:after {
    left: 7px;
    top: 3px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}


/* Product Info */
.product-info {
    display: flex;
    align-items: center;
    gap: 15px;
}


.product-image {
    width: 80px;
    height: 80px;
    border-radius: 5px;
    overflow: hidden;
    background-color: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
}


.product-image img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}


.product-details {
    flex-grow: 1;
}


.product-title {
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #333;
}


/* Product Attributes */
.product-attributes {
    margin-bottom: 8px;
}


.attribute-group {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 5px;
}


.attribute-group label {
    font-size: 14px;
    color: #555;
    margin-bottom: 0;
}


.attribute-select {
    padding: 4px 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    background-color: #fff;
    cursor: pointer;
}


.attribute-select:focus {
    border-color: #7A95A1;
    outline: none;
}


/* Inventory Status */
.product-inventory {
    font-size: 13px;
    margin-top: 5px;
    color: #666;
}


.inventory-status {
    margin-left: 4px;
}


.in-stock {
    color: #28a745;
}


.low-stock {
    color: #ffc107;
}


/* Quantity Control */
.quantity-control {
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #ddd;
    border-radius: 5px;
    overflow: hidden;
    width: fit-content;
    margin: 0 auto;
}


.btn-quantity {
    width: 32px;
    height: 32px;
    background: #f5f5f5;
    border: none;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;
}


.btn-quantity:hover {
    background: #e5e5e5;
}


.quantity-input {
    width: 40px;
    height: 32px;
    border: none;
    text-align: center;
    font-weight: 500;
    background: transparent;
}


/* Price */
.product-price {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    text-align: center;
}


/* Remove Button */
.btn-remove {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 18px;
    cursor: pointer;
    transition: color 0.2s;
    padding: 5px;
    display: block;
    margin: 0 auto;
}


.btn-remove:hover {
    color: #c82333;
}


/* Cart Summary */
.cart-summary {
    margin-top: 30px;
}


.summary-card {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
}


.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}


.summary-row:last-of-type {
    margin-bottom: 15px;
}


.summary-label {
    font-size: 16px;
    color: #555;
}


.summary-value {
    font-size: 18px;
    font-weight: 600;
    color: #333;
}


/* Checkout Button */
.btn-checkout {
    width: 100%;
    padding: 14px;
    background: #7A95A1;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.3s;
    text-align: center;
}


.btn-checkout:hover {
    background: #7A95A1; font-weight: 700; color: white;
}


/* Empty Cart */
.empty-cart {
    text-align: center;
    padding: 40px 20px;
}


.empty-cart-icon {
    font-size: 60px;
    color: #ccc;
    margin-bottom: 20px;
}


.empty-cart h3 {
    font-size: 22px;
    color: #333;
    margin-bottom: 10px;
}


.empty-cart p {
    color: #777;
    margin-bottom: 25px;
}
.btn-continue-shopping {
    padding: 12px 24px;
    background: #7A95A1;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    transition: background 0.3s;
}
.btn-continue-shopping:hover {
    background: #7A95A1;
    cursor: pointer;
}


/* Responsive styles */
@media (max-width: 767px) {
    .cart-header {
        flex-direction: column;
        align-items: flex-start;
    }
   
    .select-all-container {
        margin-top: 15px;
    }
   
    .product-info {
        flex-direction: column;
        text-align: center;
    }
   
    .product-image {
        margin: 0 auto 15px;
    }
   
    .product-select {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
   
    .cart-item .row {
        text-align: center;
    }
   
    .quantity-control {
        margin: 15px auto;
    }
   
    .product-price {
        margin: 15px 0;
    }


    .cart-toggle-btn {
        padding: 12px 8px;
        font-size: 14px;
    }
   
    .attribute-group {
        justify-content: center;
    }
}
</style>


<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Add Bootstrap for responsive grid -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All functionality
    const selectAllCheckbox = document.getElementById('select-all-products');
    const productCheckboxes = document.querySelectorAll('.product-checkbox-input');
    const selectedCountDisplay = document.getElementById('selected-count');
    const checkoutButton = document.getElementById('checkout-selected');
   
    // Update the count of selected items
    function updateSelectedCount() {
        const selectedCount = document.querySelectorAll('.product-checkbox-input:checked').length;
        selectedCountDisplay.textContent = selectedCount;
    }
   
    // Handle Select All
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const isChecked = this.checked;
           
            productCheckboxes.forEach(checkbox => {
                checkbox.checked = isChecked;
            });
           
            updateSelectedCount();
        });
    }
   
    // Handle individual checkbox changes
    productCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
           
            // Check if all checkboxes are checked
            const allChecked = [...productCheckboxes].every(cb => cb.checked);
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = allChecked;
            }
        });
    });
   
    // Handle Checkout Selected Products
    if (checkoutButton) {
        checkoutButton.addEventListener('click', function() {
            const selectedProducts = [...document.querySelectorAll('.product-checkbox-input:checked')].map(cb => cb.value);
           
            if (selectedProducts.length === 0) {
                alert('Vui lòng chọn ít nhất một sản phẩm để thanh toán');
                return;
            }
           
            // Create a hidden form to submit
            const form = document.getElementById('cart-form');
           
            // Add selected products as hidden inputs
            selectedProducts.forEach(productId => {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'checkout_products[]';
                hiddenInput.value = productId;
                form.appendChild(hiddenInput);
            });
           
            // Update the form action to checkout
            form.action = "{{ route('cart.checkout3', ['type' => $type]) }}";
            form.submit();
        });
    }
   
    // Handle attribute change
    const attributeSelects = document.querySelectorAll('.attribute-select');
    attributeSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Can add AJAX update here to update the product attribute
            console.log('Attribute changed:', this.name, this.value);
           
            // This would typically be an AJAX request to update the attribute
            // For now, we'll just show an alert to simulate the change
            alert(`Thuộc tính đã được thay đổi thành ${this.value}`);
        });
    });
   
    // Initialize selected count
    updateSelectedCount();
});
</script>
@endsection

