@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo'][$config['method']]['title']])
@include('backend.dashboard.component.formError')
@php
$url = ($config['method'] == 'create') ? route('product.store') : route('product.update', [$product->id, $queryUrl ?? '']);
@endphp
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-9">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>{{ __('messages.tableHeading') }}</h5>
                    </div>
                    <div class="ibox-content">
                        @include('backend.dashboard.component.content', ['model' => ($product) ?? null])
                    </div>
                </div>
                @include('backend.dashboard.component.album', ['model' => ($product) ?? null])
                @include('backend.product.product.component.variant')
                @include('backend.dashboard.component.seo', ['model' => ($product) ?? null])
            </div>
            <div class="col-lg-3">
                <div class="ibox w">
                    <div class="ibox-title">
                        <h5>CHỌN THƯƠNG HIỆU</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label class="control-label">Chọn thương hiệu</label>
                                    <select name="product_brand_id" class="form-control setupSelect2" id="brandSelect">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach($brands as $brand)
                                        <option
                                            value="{{ $brand->id }}"
                                            {{ (old('product_brand_id', $product->product_brand_id ?? '') == $brand->id) ? 'selected' : '' }}>
                                            {{ $brand->name ?? 'Không có tên' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-12">
                                <div class="form-row">
                                    <label class="control-label">Chọn giải giá</label>
                                    <select name="sub_brand_id" class="form-control setupSelect2" id="subBrandSelect" style="display: none;">
                                        <option value="">-- Chọn giải giá --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mb15">
                            <label class="control-label text-left">
                                <input type="checkbox" name="allow_order" value="1"
                                    {{ old('allow_order') ? 'checked' : '' }}>
                                Cho phép order
                                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" data-placement="right"
                                    title="Chọn để đánh dấu cho phép order khi hết hàng"
                                    style="background-color: white; color: red;"></i>
                            </label>
                        </div>
                        <input type="hidden" name="price_group_id" id="priceGroupId" value="">
                    </div>

                    @php
                    $priceRangesJson = json_encode($price_ranges ?? []);
                    $priceGroupsJson = json_encode($price_groups ?? []);
                    $subBrandsJson = json_encode($sub_brands ?? []);
                    $productJson = json_encode($product ?? []);
                    @endphp

                    <script>
                        $(document).ready(function() {
    let priceGroups = @json($price_groups);
    let priceRanges = @json($price_ranges);
    let subBrands = @json($sub_brands);
    let product = @json($product ?? null);

    // Khi chọn thương hiệu
    $('#brandSelect').change(function() {
        let selectedBrand = $(this).val();
        let subBrandSelect = $('#subBrandSelect');

        subBrandSelect.empty().append('<option value="">-- Chọn giải giá --</option>');

        if (selectedBrand) {
            let filteredSubBrands = subBrands.filter(subBrand => parseInt(subBrand.brand_id) === parseInt(selectedBrand));
            if (filteredSubBrands.length > 0) {
                filteredSubBrands.forEach(subBrand => {
                    let isSelected = product && product.sub_brand_id && parseInt(subBrand.id) === parseInt(product.sub_brand_id) ? 'selected' : '';
                    subBrandSelect.append(
                        `<option value="${subBrand.id}" ${isSelected}>${subBrand.name || 'Không có tên'}</option>`
                    );
                });
                subBrandSelect.show();
            } else {
                subBrandSelect.hide();
            }
        } else {
            subBrandSelect.hide();
        }
        resetInputs();
        if (typeof $('.setupSelect2').select2 !== 'undefined') {
            $('#subBrandSelect').trigger('change.select2');
        }
    });

    // Khi chọn sub_brand hoặc thay đổi input
    $('#subBrandSelect').change(calculateOrderPrice);
    $('input[name="price"], input[name="weight"]').on('input', calculateOrderPrice);
    $('#discountInput').on('input', function() {
        updateHiddenInput(this);
        calculateOrderPrice();
    });

    // Hàm tính giá order
    function calculateOrderPrice() {
        let selectedSubBrand = $('#subBrandSelect').val();
        let basePrice = parseFloat($('input[name="price"]').val().replace(/[^0-9.-]+/g, '')) || 0;
        let weight = parseFloat($('input[name="weight"]').val().replace(/[^0-9.-]+/g, '')) || 0;

        if (weight < 0) weight = 0;

        if (selectedSubBrand && basePrice > 0) {
            let group = priceGroups.find(g => g.sub_brand_id == selectedSubBrand) || {};
            let exchangeRate = parseFloat(group.exchange_rate) || 1;
            let shipping = parseFloat(group.shipping) || 0;
            if (shipping < 0) shipping = 0;

            // Lấy discount: từ input nếu checkbox được chọn, nếu không thì từ product.discount hoặc group.discount
            let discount;
            if ($('#enableChange').is(':checked')) {
                discount = parseFloat($('#discountInput').val()) || 0;
            } else {
                discount = product && product.discount !== undefined && product.discount !== null ? 
                    parseFloat(product.discount) : 
                    parseFloat(group.discount) || 0;
                // Cập nhật giá trị hiển thị cho discountInput khi chưa click checkbox
                $('#discountInput').val(discount.toFixed(2));
                $('#hiddenDiscount').val(discount);
            }

            let shippingCost = weight * shipping;
            let orderPrice = (basePrice * exchangeRate + shippingCost) * (1 - discount / 100);

            let filteredRanges = priceRanges.filter(range => range.sub_brand_id == selectedSubBrand);
            if (filteredRanges.length > 0) {
                let selectedRange = filteredRanges.find(range => 
                    basePrice >= parseFloat(range.price_min) && basePrice <= parseFloat(range.price_max)
                );
                if (selectedRange) {
                    let rangeValue = parseFloat(selectedRange.value) || 0;
                    if (selectedRange.value_type === 'percentage') {
                        rangeValue = basePrice * (rangeValue / 100);
                    }
                    orderPrice += rangeValue;
                }
            }
            // Cập nhật các trường hiển thị
            $('input[name="price_group_id"]').prev('input').val(group.price_group_id || '');
            $('input[name="exchange_rate"]').prev('input').val(group.exchange_rate || '');
            $('input[name="shipping"]').prev('input').val(group.shipping || '');
            $('input[name="order_price"]').prev('input').val(orderPrice.toLocaleString('vi-VN'));
            $('input[name="shipping_cost_display"]').val(shippingCost.toLocaleString('vi-VN'));

            // Cập nhật các trường ẩn
            $('input[name="price_group_id"]').val(group.price_group_id || '');
            $('input[name="exchange_rate"]').val(group.exchange_rate || '');
            $('input[name="shipping"]').val(group.shipping || '');
            $('#hiddenDiscount').val(discount);
            $('input[name="order_price"]').val(orderPrice);
            $('#shippingCost').val(shippingCost);
            $('#priceGroupId').val(group.price_group_id || '');
        } else {
            resetInputs();
        }
    }

    // Reset tất cả input
    function resetInputs() {
        $('input[name="price_group_id"]').prev('input').val('');
        $('input[name="exchange_rate"]').prev('input').val('');
        $('input[name="shipping"]').prev('input').val('');
        $('input[name="order_price"]').prev('input').val('');
        $('input[name="shipping_cost_display"]').val('');
        $('input[name="price_group_id"]').val('');
        $('input[name="exchange_rate"]').val('');
        $('input[name="shipping"]').val('');
        $('input[name="order_price"]').val('');
        $('#shippingCost').val('');
        $('#priceGroupId').val('');
        if (!$('#enableChange').is(':checked')) {
            $('#discountInput').val('');
            $('#hiddenDiscount').val('');
        }
    }

    // Toggle ô discount
    window.toggleInputs = function(checked) {
        let discountInput = $('#discountInput');
        if (checked) {
            discountInput.removeAttr('disabled').focus();
        } else {
            discountInput.attr('disabled', 'true');
            calculateOrderPrice(); // Cập nhật lại để lấy giá trị từ product hoặc group
        }
    };

    // Cập nhật hidden input
    window.updateHiddenInput = function(input) {
        $('#hiddenDiscount').val(input.value);
    };

    // Khởi tạo
    if (typeof $('.setupSelect2').select2 !== 'undefined') {
        $('.setupSelect2').select2();
    }
    $('#brandSelect').trigger('change');
    if ($('#subBrandSelect').val()) {
        $('#subBrandSelect').trigger('change');
    }

    // Khởi tạo giá trị discount ban đầu
    if (product && product.discount !== undefined && product.discount !== null) {
        $('#discountInput').val(parseFloat(product.discount).toFixed(2));
        $('#hiddenDiscount').val(product.discount);
    }
});
                    </script>
                </div>

                @include('backend.product.product.component.aside')
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>

<!-- 
<script>
    $(document).ready(function() {
        let subBrands = @json($sub_brands);

        $('#brandSelect').change(function() {
            let selectedBrand = $(this).val();
            let subBrandSelect = $('#subBrandSelect');
            subBrandSelect.empty().append('<option value="">-- Chọn giải giá --</option>');

            if (selectedBrand) {
                let filteredSubBrands = subBrands.filter(sub => sub.brand_id == selectedBrand);

                if (filteredSubBrands.length > 0) {
                    filteredSubBrands.forEach(sub => {
                        subBrandSelect.append(`<option value="${sub.id}">${sub.name ?? 'Không có tên'}</option>`);
                    });
                    subBrandSelect.show();
                } else {
                    subBrandSelect.hide();
                }
            } else {
                subBrandSelect.hide();
            }
        });
        $('#brandSelect').trigger('change');
    });
</script> -->