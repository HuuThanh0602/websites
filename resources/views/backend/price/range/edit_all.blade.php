<form action="{{ route('price_range.update2', $price_ranges[0]->id) }}" method="post" class="box">
    @csrf
    @method('PUT')
    @include('backend.dashboard.component.breadcrumb', ['title' => 'Sửa dải giá'])
    @include('backend.dashboard.component.formError')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin dải giá</h5>
                    </div>

                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Chọn thương hiệu</label>
                                    <select name="brand_id" class="form-control setupSelect2">
                                        <option value="">-- Chọn thương hiệu --</option>
                                        @foreach($brands as $brand)
                                        <option
                                            {{ $price_ranges[0]->brand_id == $brand->id ? 'selected' : '' }}
                                            value="{{ $brand->id }}">
                                            {{ $brand->name ?? 'Không có tên' }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="control-label">Tên dải giá</label>
                                    <input type="text" name="range_name" class="form-control" value="{{ $price_ranges[0]->name }}" placeholder="Nhập tên dải giá">
                                    <small id="error-message" class="text-danger" style="display: none;">Tên dải giá này đã tồn tại.</small>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="ranges_data" id="ranges_data" value="{{ json_encode($price_ranges[0]->prices->map(function($price) {
                            return [
                                'from' => floatval($price->price_min),
                                'to' => floatval($price->price_max),
                                'valueType' => $price->value_type,
                                'value' => floatval($price->value)
                            ];
                        })->toArray()) }}">

                        <!-- Nhập khoảng giá -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Dải giá từ</label>
                                    <input type="number" step="0.01" id="range_from" class="form-control money-format" placeholder="Nhập giá trị bắt đầu">
                                    <small id="range_from_display" class="text-muted"></small>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Dải giá đến</label>
                                    <input type="number" step="0.01" id="range_to" class="form-control money-format" placeholder="Nhập giá trị kết thúc">
                                    <small id="range_to_display" class="text-muted"></small>
                                </div>
                            </div>
                        </div>

                        <!-- Loại Giá Trị -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Loại giá trị</label>
                                    <select name="value_type" id="value_type" class="form-control">
                                        <option value="percentage">Phần trăm (%)</option>
                                        <option value="fixed">Giá trị cố định</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="control-label">Giá trị</label>
                                    <input type="number" step="0.01" id="value" name="value" class="form-control" placeholder="Nhập giá trị dải giá">
                                </div>
                            </div>
                        </div>

                        <!-- Nút Thêm và Danh Sách Dải Giá -->
                        <button type="button" class="btn btn-primary mt-3" id="addRangeBtn" onclick="validateRange(-1)">Thêm khoảng giá</button>

                        <table class="table table-bordered mt-3">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Dải giá từ</th>
                                    <th>Dải giá đến</th>
                                    <th>Loại giá trị</th>
                                    <th>Giá trị</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody id="ranges_list"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @include('backend.dashboard.component.button')
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Kiểm tra tên dải giá đã tồn tại
        $('input[name="range_name"]').on('blur', function() {
            const rangeName = $(this).val().trim();
            const errorMessage = $('#error-message');
            const currentId = {{ $price_ranges[0]->id }};

            if (rangeName) {
                $.ajax({
                    url: '/check-range-name',
                    type: 'GET',
                    data: { range_name: rangeName, id: currentId },
                    success: function(response) {
                        errorMessage.toggle(response.exists);
                        $('input[name="range_name"]').toggleClass('is-invalid', response.exists);
                    }
                });
            }
        });

        // Format tiền khi nhập
        $('.money-format').on('input', function() {
            const val = parseFloat($(this).val()) || 0;
            const displayId = $(this).attr('id') + '_display';
            $('#' + displayId).text(formatMoney(val) + ' đồng');
        });

        // Load dữ liệu ban đầu
        ranges = JSON.parse($('#ranges_data').val());
        renderRanges();
    });

    let ranges = [];
    let editIndex = -1; // -1: thêm mới, >=0: chỉnh sửa

    function validateRange(index) {
        const from = parseFloat($('#range_from').val());
        const to = parseFloat($('#range_to').val());
        const valueType = $('#value_type').val();
        const value = parseFloat($('#value').val());

        if (isNaN(from) || isNaN(to) || from >= to) {
            alert("Khoảng giá không hợp lệ! Giá trị bắt đầu phải nhỏ hơn giá trị kết thúc.");
            return;
        }

        if (isNaN(value) || value < 0) {
            alert("Vui lòng nhập giá trị hợp lệ.");
            return;
        }

        const newRange = { from, to, valueType, value };

        // Kiểm tra chồng lấn, bỏ qua range đang chỉnh sửa
        for (let i = 0; i < ranges.length; i++) {
            if (i === index) continue; // Bỏ qua chính range đang chỉnh sửa
            const existingRange = ranges[i];
            if (!(to <= existingRange.from || from >= existingRange.to)) {
                alert(`Khoảng giá bị chồng lấn với: ${formatMoney(existingRange.from)} - ${formatMoney(existingRange.to)}`);
                return;
            }
        }

        // Thêm hoặc cập nhật range
        if (index >= 0) {
            ranges[index] = newRange; // Cập nhật range hiện tại
        } else {
            ranges.push(newRange); // Thêm mới
        }

        // Cập nhật và reset
        updateRangesData();
        resetForm();
        renderRanges();
    }

    function editRange(index) {
        const range = ranges[index];
        $('#range_from').val(range.from);
        $('#range_to').val(range.to);
        $('#value_type').val(range.valueType);
        $('#value').val(range.value);
        $('#range_from_display').text(formatMoney(range.from) + ' đồng');
        $('#range_to_display').text(formatMoney(range.to) + ' đồng');
        editIndex = index;
        $('#addRangeBtn').text('Cập nhật khoảng giá').off('click').on('click', () => validateRange(editIndex));
    }

    function removeRange(index) {
        ranges.splice(index, 1);
        updateRangesData();
        renderRanges();
    }

    function resetForm() {
        $('#range_from, #range_to, #value').val('');
        $('#range_from_display, #range_to_display').text('');
        $('#addRangeBtn').text('Thêm khoảng giá').off('click').on('click', () => validateRange(-1));
        editIndex = -1;
    }

    function renderRanges() {
        const tableBody = $('#ranges_list');
        tableBody.empty();
        ranges.forEach((range, index) => {
            const valueDisplay = range.valueType === 'percentage' ? range.value + '%' : formatMoney(range.value) + ' đồng';
            tableBody.append(`
                <tr>
                    <td>${index + 1}</td>
                    <td>${formatMoney(range.from)} đồng</td>
                    <td>${formatMoney(range.to)} đồng</td>
                    <td>${range.valueType === 'percentage' ? 'Phần trăm (%)' : 'Giá trị cố định'}</td>
                    <td>${valueDisplay}</td>
                    <td>
                        <button type="button" class="btn btn-warning btn-sm" onclick="editRange(${index})">Sửa</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRange(${index})">Xóa</button>
                    </td>
                </tr>
            `);
        });
    }

    function updateRangesData() {
        $('#ranges_data').val(JSON.stringify(ranges));
    }

    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount);
    }
</script>