<form action="{{ route('price_group.update', $price_group->id) }}" method="post" class="box">
    @csrf
    @method('PUT')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>Thông tin nhóm giá</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-4">
                            <label class="control-label">Tên nhóm giá</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $price_group->name) }}" placeholder="Nhập tên nhóm giá">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Phí vận chuyển</label>
                            <input type="number" name="shipping" class="form-control" value="{{ old('shipping', $price_group->shipping) }}" placeholder="Nhập phí vận chuyển">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Tỷ giá hối đoái</label>
                            <input type="number" step="0.01" name="exchange_rate" class="form-control" value="{{ old('exchange_rate', $price_group->exchange_rate) }}" placeholder="Nhập tỷ giá hối đoái">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="priceGroupContainer">
            @foreach($groupedDetails as $key => $details)
            <div class="price-group">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Nhóm giá</h5>
                        <button type="button" class="btn btn-danger btn-sm float-right remove-group" style="display: {{ $key == 0 ? 'none' : 'inline-block' }};">Xóa</button>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Chọn thương hiệu</label>
                                <select name="product_brand_id[]" class="form-control brandSelect">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $details->first()->product_brand_id == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Chọn dải giá</label>
                                <select name="sub_brand_id[]" class="form-control subBrandSelect">
                                    <option value="">-- Chọn dải giá --</option>
                                    @foreach($sub_brands as $subBrand)
                                    @if($subBrand->brand_id == $details->first()->product_brand_id)
                                    <option value="{{ $subBrand->id }}" {{ $details->first()->sub_brand_id == $subBrand->id ? 'selected' : '' }}>
                                        {{ $subBrand->name }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group mt-3">
                            <label>Danh mục & Chiết khấu</label>
                            <div class="row">
                                @foreach($categorys as $category)
                                @php
                                $selectedDetail = $details->firstWhere('product_catalogue_id', $category->id);
                                @endphp
                                <div class="col-md-6 d-flex align-items-center">
                                    <input type="checkbox" name="product_catalogue_id[{{ $key }}][]" value="{{ $category->id }}"
                                        class="mr-2 discountCheckbox" {{ $selectedDetail ? 'checked' : '' }}>
                                    <span>{{ optional($category->product_catalogue_language->first())->name ?? 'Không có tên' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="discount[{{ $key }}][]" class="form-control discountInput"
                                        value="{{ $selectedDetail ? $selectedDetail->discount : '' }}"
                                        {{ $selectedDetail ? '' : 'readonly' }}>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-12 text-right mt-3">
            <button type="button" id="addPriceGroup" class="btn btn-primary">Thêm mới nhóm</button>
        </div>

        @include('backend.dashboard.component.button')
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let subBrands = @json($sub_brands);

        function updateSubBrandOptions(brandSelect) {
            let selectedBrand = $(brandSelect).val();
            let subBrandSelect = $(brandSelect).closest('.ibox').find('.subBrandSelect');
            let currentValue = subBrandSelect.val();
            let usedSubBrands = [];

            // Lấy danh sách sub-brand đã chọn bởi cùng thương hiệu trong các nhóm khác
            $('#priceGroupContainer .price-group').each(function() {
                let otherBrandSelect = $(this).find('.brandSelect');
                let otherSubBrandSelect = $(this).find('.subBrandSelect');
                if (otherBrandSelect.val() === selectedBrand && otherSubBrandSelect.val() &&
                    otherSubBrandSelect[0] !== subBrandSelect[0]) {
                    usedSubBrands.push(otherSubBrandSelect.val());
                }
            });

            subBrandSelect.empty().append('<option value="">-- Chọn dải giá --</option>');
            if (selectedBrand) {
                let filteredSubBrands = subBrands.filter(sub => sub.brand_id == selectedBrand);
                if (filteredSubBrands.length > 0) {
                    filteredSubBrands.forEach(sub => {
                        if (!usedSubBrands.includes(sub.id.toString()) || sub.id.toString() === currentValue) {
                            subBrandSelect.append(`<option value="${sub.id}">${sub.name ?? 'Không có tên'}</option>`);
                        }
                    });
                    subBrandSelect.prop('disabled', false);
                    if (currentValue) subBrandSelect.val(currentValue);
                } else {
                    subBrandSelect.prop('disabled', true);
                }
            } else {
                subBrandSelect.prop('disabled', true);
            }
        }

        function updateAllSubBrandOptions() {
            $('#priceGroupContainer .brandSelect').each(function() {
                updateSubBrandOptions(this);
            });
        }

        function updateGroupIndex() {
            $('#priceGroupContainer .price-group').each(function(index) {
                $(this).attr('data-index', index);
                $(this).find('select, input').each(function() {
                    let name = $(this).attr('name');
                    if (name) {
                        let newName = name.replace(/\[\d+\]/g, `[${index}]`);
                        $(this).attr('name', newName);
                    }
                });
            });
        }

        $(document).on('change', '.brandSelect', function() {
            updateSubBrandOptions(this);
            updateAllSubBrandOptions(); // Cập nhật lại tất cả sub-brand để loại bỏ các sub-brand đã chọn
        });

        $(document).on('change', '.subBrandSelect', function() {
            updateAllSubBrandOptions(); // Cập nhật lại khi thay đổi sub-brand
        });

        $('#addPriceGroup').click(function() {
            let newIndex = $('#priceGroupContainer .price-group').length;
            let newGroup = $('#priceGroupContainer .price-group').first().clone(true);

            newGroup.find('input, select').each(function() {
                if ($(this).is('input[type="checkbox"]')) {
                    $(this).prop('checked', false);
                } else if ($(this).is('input[type="number"]')) {
                    $(this).val('').prop('readonly', true);
                } else {
                    $(this).val('');
                }
            });

            newGroup.find('[name]').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    let newName = name.replace(/\[\d+\]/g, `[${newIndex}]`);
                    $(this).attr('name', newName);
                }
            });

            newGroup.find('.remove-group').show();
            newGroup.find('.subBrandSelect').prop('disabled', true).empty().append('<option value="">-- Chọn dải giá --</option>');
            newGroup.attr('data-index', newIndex);

            $('#priceGroupContainer').append(newGroup);
            updateAllSubBrandOptions();
        });

        $(document).on('click', '.remove-group', function() {
            if ($('#priceGroupContainer .price-group').length > 1) {
                $(this).closest('.price-group').remove();
                updateGroupIndex();
                updateAllSubBrandOptions();
            }
        });

        $(document).on('change', '.discountCheckbox', function() {
            let discountInput = $(this).closest('.col-md-6').next().find('.discountInput');
            if ($(this).is(':checked')) {
                discountInput.prop('readonly', false);
            } else {
                discountInput.prop('readonly', true).val('');
            }
        });

        $('form').submit(function(e) {
            $('#priceGroupContainer .price-group').each(function(index) {
                $(this).find('.discountCheckbox').each(function(i) {
                    let checkbox = $(this);
                    let name = `product_catalogue_id[${index}][]`;
                    checkbox.attr('name', name);
                    checkbox.siblings('input[type="hidden"]').remove();
                });

                $(this).find('.discountInput').each(function(i) {
                    let discountInput = $(this);
                    let checkbox = $(this).closest('.col-md-6').prev().find('.discountCheckbox');
                    let name = `discount[${index}][]`;
                    if (!checkbox.is(':checked') || !discountInput.val()) {
                        discountInput.removeAttr('name');
                    } else {
                        discountInput.attr('name', name);
                    }
                });
            });
        });

        // Khởi tạo
        updateAllSubBrandOptions();
    });
</script>