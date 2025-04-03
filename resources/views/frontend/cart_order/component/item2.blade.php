
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
                                    <form id="cart-form-{{ $cart->id }}" action="{{ route('cart.update') }}" method="POST">
                                        @csrf
                                        <div class="cart-item-qty">
                                            <button 
                                                type="submit" 
                                                name="change" 
                                                value="-1" 
                                                class="btn-qty2 minus"
                                                form="cart-form-{{ $cart->id }}"
                                            >-</button>
                                            <input 
                                                type="text" 
                                                class="input-qty" 
                                                value="{{ $cart->qty }}" 
                                                readonly
                                            >
                                            <input type="hidden" name="rowId" value="{{ $cart->id }}">

                                            <button 
                                                type="submit" 
                                                name="change" 
                                                value="1" 
                                                class="btn-qty2 plus"
                                                form="cart-form-{{ $cart->id }}"
                                            >+</button>
                                        </div>
                                    </form>

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
            </div>
            @endif
        </div>
