@include('backend.dashboard.component.breadcrumb', ['title' => 'Thêm mới nhóm giá'])
@include('backend.dashboard.component.formError')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form action="{{ route('price_group.store') }}" method="post" class="box">
    @csrf
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
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Nhập tên nhóm giá">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Phí vận chuyển</label>
                            <input type="number" name="shipping" class="form-control" value="{{ old('shipping') }}" placeholder="Nhập phí vận chuyển">
                        </div>
                        <div class="col-md-4">
                            <label class="control-label">Tỷ giá hối đoái</label>
                            <input type="number" step="0.01" name="exchange_rate" class="form-control" value="{{ old('exchange_rate') }}" placeholder="Nhập tỷ giá hối đoái">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="priceGroupContainer">
            <div class="price-group">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin chi tiết nhóm giá</h5>
                        <button type="button" class="btn btn-danger btn-sm float-right remove-group" style="display: none;">Xóa</button>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="control-label">Chọn thương hiệu</label>
                                <select name="product_brand_id[]" class="form-control brandSelect">
                                    <option value="">-- Chọn thương hiệu --</option>
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name ?? 'Không có tên' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="control-label">Chọn dải giá</label>
                                <select name="sub_brand_id[]" class="form-control subBrandSelect" disabled>
                                    <option value="">-- Chọn dải giá --</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="control-label">Danh mục & Chiết khấu</label>
                            <div class="row">
                                @foreach($categorys as $category)
                                <div class="col-md-6 d-flex align-items-center">
                                    <input type="checkbox" name="product_catalogue_id[0][]" value="{{ $category->id }}" class="mr-2 discountCheckbox">
                                    <span>{{ optional($category->product_catalogue_language->first())->name ?? 'Không có tên' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <input type="number" name="discount[0][]" class="form-control discountInput" placeholder="Nhập chiết khấu" readonly>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 text-right mt-3">
            <button type="button" id="addPriceGroup" class="btn btn-primary">Thêm mới nhóm</button>
        </div>

        @include('backend.dashboard.component.button')
    </div>
</form>
<script>
    $(document).ready(function() {
        let subBrands = @json($sub_brands);

        function updateSubBrandOptions(brandSelect) {
            let selectedBrand = $(brandSelect).val();
            let subBrandSelect = $(brandSelect).closest('.ibox').find('.subBrandSelect');
            let currentSubBrandValue = subBrandSelect.val(); // Lưu giá trị hiện tại của subBrandSelect
            let allSelectedSubBrands = [];

            // Lấy danh sách tất cả sub_brand_id đã được chọn trong các form khác
            $('#priceGroupContainer .subBrandSelect').not(subBrandSelect).each(function() {
                let selectedValue = $(this).val();
                if (selectedValue) {
                    allSelectedSubBrands.push(selectedValue);
                }
            });

            // Làm mới subBrandSelect
            subBrandSelect.empty().append('<option value="">-- Chọn dải giá --</option>');

            if (selectedBrand) {
                let filteredSubBrands = subBrands.filter(sub => sub.brand_id == selectedBrand);
                if (filteredSubBrands.length > 0) {
                    filteredSubBrands.forEach(sub => {
                        // Thêm tất cả sub_brand nếu nó chưa được chọn ở form khác hoặc là giá trị hiện tại
                        if (!allSelectedSubBrands.includes(sub.id.toString()) || sub.id.toString() === currentSubBrandValue) {
                            subBrandSelect.append(`<option value="${sub.id}">${sub.name ?? 'Không có tên'}</option>`);
                        }
                    });
                    subBrandSelect.prop('disabled', false);
                    // Khôi phục giá trị đã chọn nếu có
                    if (currentSubBrandValue) {
                        subBrandSelect.val(currentSubBrandValue);
                    }
                } else {
                    subBrandSelect.prop('disabled', true);
                }
            } else {
                subBrandSelect.prop('disabled', true);
            }
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
            // Cập nhật lại tất cả subBrandSelect khác
            $('#priceGroupContainer .brandSelect').not(this).each(function() {
                updateSubBrandOptions(this);
            });
        });

        $(document).on('change', '.subBrandSelect', function() {
            // Khi thay đổi subBrandSelect, cập nhật lại tất cả subBrandSelect khác
            $('#priceGroupContainer .brandSelect').each(function() {
                updateSubBrandOptions(this);
            });
        });

        $('#addPriceGroup').click(function() {
            let newIndex = $('#priceGroupContainer .price-group').length;
            let newGroup = $('.price-group').first().clone();

            // Reset giá trị và trạng thái của input/select
            newGroup.find('input, select').each(function() {
                if ($(this).is('input[type="checkbox"]')) {
                    $(this).prop('checked', false);
                } else {
                    $(this).val('');
                }
                $(this).prop('disabled', false);
            });

            // Cập nhật name cho tất cả input/select
            newGroup.find('[name]').each(function() {
                let name = $(this).attr('name');
                if (name) {
                    let newName = name.replace(/\[\d+\]/g, `[${newIndex}]`);
                    $(this).attr('name', newName);
                }
            });

            // Đảm bảo checkbox và discount input có name đúng
            newGroup.find('input[type="checkbox"].discountCheckbox').each(function() {
                let newName = `product_catalogue_id[${newIndex}][]`;
                $(this).attr('name', newName);
            });
            newGroup.find('input.discountInput').each(function() {
                let newName = `discount[${newIndex}][]`;
                $(this).attr('name', newName).prop('readonly', true);
            });

            // Reset và cập nhật lại subBrandSelect
            newGroup.find('.subBrandSelect').prop('disabled', true).empty().append('<option value="">-- Chọn dải giá --</option>');
            newGroup.find('.remove-group').show();
            newGroup.removeAttr('id');
            newGroup.attr('data-index', newIndex);

            $('#priceGroupContainer').append(newGroup);

            // Cập nhật lại tất cả subBrandSelect sau khi thêm nhóm mới
            $('#priceGroupContainer .brandSelect').each(function() {
                updateSubBrandOptions(this);
            });
        });

        $(document).on('click', '.remove-group', function() {
            $(this).closest('.price-group').remove();
            updateGroupIndex();
            $('#priceGroupContainer .brandSelect').each(function() {
                updateSubBrandOptions(this);
            });
        });

        // Khởi tạo lần đầu cho form mặc định
        $('.brandSelect').each(function() {
            updateSubBrandOptions(this);
        });

        $(document).on('change', 'input.discountCheckbox', function() {
            let discountInput = $(this).closest('.col-md-6').next().find('input.discountInput');
            if ($(this).is(':checked')) {
                discountInput.prop('readonly', false);
            } else {
                discountInput.prop('readonly', true).val('');
            }
        });

        // Kiểm tra dữ liệu trước khi submit
        $('form').submit(function(e) {
            $('#priceGroupContainer .price-group').each(function(index) {
                $(this).find('input[type="checkbox"].discountCheckbox').each(function(i) {
                    let checkbox = $(this);
                    let name = `product_catalogue_id[${index}][]`;
                    checkbox.attr('name', name);
                    checkbox.siblings('input[type="hidden"]').remove();
                });

                $(this).find('input.discountInput').each(function(i) {
                    let discountInput = $(this);
                    let checkbox = $(this).closest('.col-md-6').prev().find('input.discountCheckbox');
                    let name = `discount[${index}][]`;
                    if (!checkbox.is(':checked') || !discountInput.val()) {
                        discountInput.removeAttr('name');
                    } else {
                        discountInput.attr('name', name);
                    }
                });
            });
        });
    });
</script>