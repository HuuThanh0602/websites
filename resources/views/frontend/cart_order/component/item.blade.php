
<div class="panel-body">
    @if (!empty($carts))
    <div class="cart-list">
        @if ($type == 2)
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
                                            </div>`

                                        <div class="cart-item-price">
                                            <div class="uk-flex uk-flex-bottom">
                                                {{-- @if($cart->price  != $cart->priceOriginal)
                                                <span class="cart-price-old mr10">{{ convert_price($cart->priceOriginal, true) }}đ</span>
                                                @endif --}}
                                                <span class="cart-price-sale">{{ convert_price($cart->price * $cart->qty, true) }}đ</span>
                                            </div>
                                        </div>
                                        <div class="cart-item-remove" data-row-id="{{ $cart->rowId }}">
                                            <span>✕</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach  
                @else
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
                                        <div class="cart-item-qty">
                                            <button type="button" class="btn-qty minus">-</button>
                                            <input 
                                                type="text" 
                                                class="input-qty" 
                                                value="{{ $cart->qty }}"
                                            >
                                            <input type="hidden" class="rowId" value="{{ $cart->rowId }}">
                                            <button type="button" class="btn-qty plus">+</button>
                                        </div>
                                        <div class="cart-item-price">
                                            <div class="uk-flex uk-flex-bottom">
                                                {{-- @if($cart->price  != $cart->priceOriginal)
                                                <span class="cart-price-old mr10">{{ convert_price($cart->priceOriginal, true) }}đ</span>
                                                @endif --}}
                                                <span class="cart-price-sale">{{ convert_price($cart->price * $cart->qty, true) }}đ</span>
                                            </div>
                                        </div>
                                        <div class="cart-item-remove" data-row-id="{{ $cart->rowId }}">
                                            <span>✕</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach  
                @endif
            </div>
            @endif
        </div>

<div class="panel-foot mt30 pay">
    <div class="cart-summary mb20">
        <div class="cart-summary-item">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <span class="summay-title">Giảm giá</span>
                <div class="summary-value discount-value">-{{ convert_price($cartPromotion['discount'], true) }}đ</div>
            </div>
        </div>
        <div class="cart-summary-item">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <span class="summay-title">Phí giao hàng</span>
                <div class="summary-value">Miễn phí</div>
            </div>
        </div>
        <div class="cart-summary-item">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <span class="summay-title bold">Tổng tiền</span>
                <div class="summary-value cart-total">
                     @if ($type == 2)
                     {{ number_format($tongTien ?? 0, 0, ',', '.') }}đ
                    @else
                    {{ (count($carts) && !is_null($carts) ) ? convert_price($cartCaculate['cartTotal'] - $cartPromotion['discount'], true) : 0   }}đ
                    @endif
                </div>
            </div>
        </div>
        <div class="buy-more">
            <a href="{{ write_url('san-pham') }}" class="btn-buymore">Chọn thêm sản phẩm khác</a>
        </div>
    </div>
</div>
