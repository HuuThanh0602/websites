<div class="panel-body">
    @if (!empty($carts))
    <form action="{{ route('cart.checkout') }}" method="POST" id="cart-form">
        @csrf
        <div class="cart-list">
            @php
            $tongTien = collect($carts)->sum(fn($cart) => ($cart->price ?? 0) * ($cart->qty ?? 0));
            @endphp
            @foreach($carts as $key => $cart)
            <div class="cart-item" data-product-id="{{ $cart->product_id ?? $cart->id }}">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-small-1-1 uk-width-medium-1-5">
                        <div class="cart-item-image">
                            <span class="image img-scaledown"><img src="{{ $cart->image }}" alt=""></span>
                            <span class="cart-item-number qty-display">{{ $cart->qty }}</span>
                        </div>
                    </div>
                    <div class="uk-width-small-1-1 uk-width-medium-4-5">
                        <div class="cart-item-info">
                            <h3 style="max-width: 90%;" class="title">
                                <span>{{ $cart->name }} <em>{{ $cart->attribute }}</em></span>
                            </h3>
                            <div class="cart-item-action uk-flex uk-flex-middle uk-flex-space-between">
                                <div class="cart-item-qty" style="display: flex; align-items: center;">
                                    <!-- Hidden inputs để gửi dữ liệu -->
                                    <input type="hidden" name="products[{{$key}}][product_id]" value="{{ $cart->product_id ?? $cart->id }}" class="product-id">
                                    <input type="hidden" name="products[{{$key}}][product_variant_id]" value="{{ $cart->product_variant_id ?? '' }}" class="product-variant-id">
                                    <input type="hidden" name="products[{{$key}}][quantity]" class="input-qty-hidden" value="{{ $cart->qty }}">
                                    <!-- Nút + - chỉ để hiển thị -->
                                    <button type="button" class="btn-qty2 minus">-</button>
                                    <input type="text" class="input-qty" value="{{ $cart->qty }}" readonly data-price="{{ $cart->price }}">
                                    <button type="button" class="btn-qty2 plus">+</button>
                                </div>
                                <div class="cart-item-price">
                                    <span class="cart-price-sale">{{ convert_price($cart->price * $cart->qty, true) }}đ</span>
                                </div>
                                <!-- Nút xóa để ẩn sản phẩm -->
                                <button type="button" class="cart-item-remove">✕</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="panel-foot mt30 pay">
            <div class="cart-summary mb20">
                <div class="cart-summary-item">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <span class="summary-title">Giảm giá</span>
                        <div class="summary-value discount-value">-{{ convert_price($cartPromotion['discount'] ?? 0, true) }}đ</div>
                    </div>
                </div>
                <div class="cart-summary-item">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <span class="summary-title">Phí giao hàng</span>
                        <div class="summary-value">Miễn phí</div>
                    </div>
                </div>
                <div class="cart-summary-item">
                    <div class="uk-flex uk-flex-middle uk-flex-space-between">
                        <span class="summary-title bold">Tổng tiền</span>
                        <div class="summary-value cart-total" id="total-price">
                            {{ number_format($tongTien ?? 0, 0, ',', '.') }}đ
                        </div>
                    </div>
                </div>
                <div class="buy-more">
                    <a href="{{ write_url('san-pham') }}" class="btn-buymore">Chọn thêm sản phẩm khác</a>
                    <button type="submit" class="btn-checkout">Thanh toán</button>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>

<style>
/* Basic styles for cart */
.cart-item {
    border-bottom: 1px solid #eee;
    padding: 15px 0;
}
.cart-item-image {
    position: relative;
}
.img-scaledown img {
    max-width: 100px;
    max-height: 100px;
}
.cart-item-number {
    position: absolute;
    top: 0;
    right: 0;
    background: #7A95A1;
    color: white;
    padding: 2px 6px;
    border-radius: 50%;
}
.cart-item-info .title {
    font-size: 16px;
    margin-bottom: 10px;
}
.cart-item-qty {
    display: flex;
    align-items: center;
}
.btn-qty2 {
    width: 30px;
    height: 30px;
    background: #f5f5f5;
    border: none;
    font-size: 16px;
    cursor: pointer;
    transition: background 0.2s;
}
.btn-qty2:hover {
    background: #e5e5e5;
}
.input-qty {
    width: 40px;
    height: 30px;
    text-align: center;
    border: 1px solid #ddd;
    margin: 0 5px;
    background: transparent;
}
.cart-price-sale {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}
.cart-item-remove {
    background: none;
    border: none;
    color: #dc3545;
    font-size: 18px;
    cursor: pointer;
}
.cart-item-remove:hover {
    color: #c82333;
}
.cart-summary-item {
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}
.summary-title {
    font-size: 16px;
    color: #555;
}
.summary-value {
    font-size: 16px;
    font-weight: 500;
    color: #333;
}
.bold {
    font-weight: 700;
}
.btn-buymore, .btn-checkout {
    padding: 10px 20px;
    background: #7A95A1;
    color: white;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    margin-top: 10px;
    display: inline-block;
}
.btn-buymore:hover, .btn-checkout:hover {
    background: #6b8290;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const minusButtons = document.querySelectorAll('.btn-qty2.minus');
    const plusButtons = document.querySelectorAll('.btn-qty2.plus');
    const removeButtons = document.querySelectorAll('.cart-item-remove');
    const totalPriceElement = document.getElementById('total-price');

    // Function to update total price
    function updateTotalPrice() {
        let total = 0;
        document.querySelectorAll('.cart-item:not([style*="display: none"])').forEach(item => {
            const qty = parseInt(item.querySelector('.input-qty').value);
            const price = parseFloat(item.querySelector('.input-qty').dataset.price);
            total += qty * price;
        });
        totalPriceElement.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    // Handle minus button
    minusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            const hiddenInput = this.previousElementSibling; // input hidden quantity
            const qtyDisplay = this.closest('.cart-item').querySelector('.qty-display');
            let qty = parseInt(input.value);
            if (qty > 1) {
                qty--;
                input.value = qty;
                hiddenInput.value = qty; // Update hidden input
                qtyDisplay.textContent = qty;
                const price = parseFloat(input.dataset.price);
                const priceDisplay = this.parentElement.nextElementSibling.querySelector('.cart-price-sale');
                priceDisplay.textContent = convertPrice(qty * price) + 'đ';
                updateTotalPrice();
            }
        });
    });

    // Handle plus button
    plusButtons.forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const hiddenInput = input.previousElementSibling.previousElementSibling; // input hidden quantity
            const qtyDisplay = this.closest('.cart-item').querySelector('.qty-display');
            let qty = parseInt(input.value);
            qty++;
            input.value = qty;
            hiddenInput.value = qty; // Update hidden input
            qtyDisplay.textContent = qty;
            const price = parseFloat(input.dataset.price);
            const priceDisplay = this.parentElement.nextElementSibling.querySelector('.cart-price-sale');
            priceDisplay.textContent = convertPrice(qty * price) + 'đ';
            updateTotalPrice();
        });
    });

    // Handle remove button (hide item and disable inputs)
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            cartItem.style.display = 'none'; // Ẩn sản phẩm trên giao diện
            // Xóa các input hidden để không gửi dữ liệu của sản phẩm này
            cartItem.querySelectorAll('input[type="hidden"]').forEach(input => input.remove());
            updateTotalPrice();
        });
    });

    // Function to format price
    function convertPrice(price) {
        return price.toLocaleString('vi-VN');
    }

    // Handle form submission (optional, để debug)
    const form = document.getElementById('cart-form');
    form.addEventListener('submit', function(e) {
        // Không cần xóa lại input ở đây vì đã xử lý khi nhấn X
        console.log('Form submitted');
    });
});
</script>