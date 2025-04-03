<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.parent') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <select name="product_catalogue_id" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option {{ 
                            $key == old('product_catalogue_id', (isset($product->product_catalogue_id)) ? $product->product_catalogue_id : '') ? 'selected' : '' 
                            }} value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @php
        $catalogue = [];
        if(isset($product)){
        foreach($product->product_catalogues as $key => $val){
        $catalogue[] = $val->id;
        }
        }
        @endphp
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    <label class="control-label">{{ __('messages.subparent') }}</label>
                    <select multiple name="catalogue[]" class="form-control setupSelect2" id="">
                        @foreach($dropdown as $key => $val)
                        <option
                            @if(is_array(old('catalogue', (
                            isset($catalogue) && count($catalogue)) ? $catalogue : [])
                            ) && isset($product->product_catalogue_id) && $key !== $product->product_catalogue_id && in_array($key, old('catalogue', (isset($catalogue)) ? $catalogue : []))
                            )
                            selected
                            @endif value="{{ $key }}">{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>{{ __('messages.product.information') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">{{ __('messages.product.code') }}</label>
                    <input
                        type="text"
                        name="code"
                        value="{{ old('code', ($product->code) ?? time()) }}"
                        class="form-control" readonly>
                </div>
            </div>
        </div>
        <div class="form-row">
            <label for="iframe">Mã Nhúng</label>
            <textarea
                type="text"
                name="iframe"
                class="form-control"
                style="height:168px;">{{ old('iframe', ($product->iframe) ?? '') }}</textarea>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">{{ __('messages.product.made_in') }}</label>
                    <input
                        type="text"
                        name="made_in"
                        value="{{ old('made_in', ($product->made_in) ?? null) }}"
                        class="form-control ">
                </div>
            </div>
        </div>
        <!--  -->
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Cân nặng</label>
                    <input
                        type="text"
                        name="weight"
                        value="{{ old('weight', (isset($product)) ? number_format($product->weight, 0 , ',', '.') : '') }}"
                        class="form-control ">
                </div>
            </div>
        </div>
        <!--thêm mới phí lưu kho - HÀ thêm, thêm vào cột storage_fee -- không thể null, nếu không có thì để bằng 00-->
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Phí lưu kho</label>
                    <input
                        type="text"
                        name="storage_fee"
                        value="{{ old('storage_fee', (isset($product)) ? number_format($product->storage_fee, 0 , ',', '.') : '') }}"
                        class="form-control ">
                </div>
            </div>
        </div>
        <!--END PHÍ LƯU KHO-->
        <div class="form-row mb20">
            <label for="" class="control-label text-left">Giá nhập kho</label>
            <div class="guarantee">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <input
                        type="text"
                        name="price"
                        class="text-right form-control "
                        value="{{ old('price', (isset($product)) ? number_format($product->price, 0 , ',', '.') : '') }}"
                        style="margin-right:10px;">
                    <select
                        name="currency"
                        class="setupSelect2">
                        <option value="VND" {{ (old('currency', $product->currency ?? '') == 'VND') ? 'selected' : '' }}>VND</option>
                        <option value="WON" {{ (old('currency', $product->currency ?? '') == 'WON') ? 'selected' : '' }}>WON</option>
                        <option value="USD" {{ (old('currency', $product->currency ?? '') == 'USD') ? 'selected' : '' }}>USD</option>
                    </select>
                </div>
            </div>
        </div>



        <!-- <div class="form-row mb20">
            <label for="" class="control-label text-left">Thời gian BH</label>
            <div class="guarantee">
                <div class="uk-flex uk-flex-middle uk-flex-space-between">
                    <input 
                        type="text"
                        name="guarantee"
                        value="{{ old('guarantee', $product->guarantee  ?? null) }}"
                        class="text-right form-control "
                        placeholder=""
                        autocomplete="off"
                        style="margin-right:10px;"
                    >
                    <select class="setupSelect2" name="" id="">
                        <option value="month">tháng</option>
                    </select>
                </div>
            </div>
        </div> -->

    </div>
</div>
<div class="ibox w">
    <div class="ibox-title">
        <h5>Thông tin nhóm giá</h5>
    </div>
    <div class="ibox-content">
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Mã nhóm giá</label>
                    <input type="text" class="form-control" value="{{ old('price_group_id', $product->price_group_id ?? '') }}" disabled>
                    <input type="hidden" name="price_group_id" value="{{ old('price_group_id', $product->price_group_id ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Tỷ giá</label>
                    <input type="text" class="form-control" value="{{ old('exchange_rate', isset($product->exchange_rate) ? number_format($product->exchange_rate, 2) : '') }}" disabled>
                    <input type="hidden" name="exchange_rate" value="{{ old('exchange_rate', $product->exchange_rate ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Phí vận chuyển</label>
                    <input type="text" class="form-control" value="{{ old('shipping', isset($product->shipping) ? number_format($product->shipping, 2) : '') }}" disabled>
                    <input type="hidden" name="shipping" value="{{ old('shipping', $product->shipping ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Chiết khấu</label>
                    <input type="text" id="discountInput" name="discount" class="form-control"
                        value="{{ old('discount', isset($product->discount) ? number_format($product->discount, 2) : '') }}"
                        disabled oninput="updateHiddenInput(this)">
                    <input type="hidden" id="hiddenDiscount" name="discount"
                        value="{{ old('discount', $product->discount ?? '') }}">
                </div>
            </div>
        </div>
        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Cho phép thay đổi</label>
                    <input type="checkbox" name="change_discount" id="enableChange" value="2"
                        {{ old('change_discount', $product->change_discount ?? 0) ? 'checked' : '' }}
                        onclick="toggleInputs(this.checked)">
                </div>
            </div>
        </div>

        <div class="row mb15">
            <div class="col-lg-12">
                <div class="form-row">
                    <label for="">Giá order</label>
                    <input type="text" class="form-control" value="{{ old('order_price', isset($product->order_price) ? number_format($product->order_price, 2) : '') }}" disabled>
                    <input type="hidden" name="order_price" value="{{ old('order_price', $product->order_price ?? '') }}">
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleInputs(enabled) {
        document.getElementsByName('discount').forEach(function(element) {
            element.disabled = !enabled;
        });
    }
</script>

<!--THÔNG TIN NHÓM GIÁ - HÀ THÊM -->

@include('backend.dashboard.component.publish', ['model' => ($product) ?? null])

@if(!empty($product->qrcode))
<div class="ibox w">
    <div class="ibox-title">
        <h5>Mã QRCODE</h5>
    </div>
    <div class="ibox-content qrcode">
        <div class="row">
            <div class="col-lg-12">
                <div class="form-row">
                    {!! $product->qrcode !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endif