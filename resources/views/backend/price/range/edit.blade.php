@include('backend.dashboard.component.breadcrumb', ['title' => 'Chỉnh sửa dải giá'])
@include('backend.dashboard.component.formError')

<form action="{{ route('price_range.update', $price_range->id) }}" method="post" class="box">
    @csrf
    @method('PUT')

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Thông tin dải giá</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Tên dải giá</label>
                                    <input readonly type="text" name="value" class="form-control" 
                                        value="{{ old('value', $price_range->name) }}" placeholder="Nhập giá trị dải giá">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Loại giá trị</label>
                                    <select name="value_type" class="form-control">
                                        <option value="percentage" {{ old('value_type', $price_range->value_type) == 'percentage' ? 'selected' : '' }}>Phần trăm (%)</option>
                                        <option value="fixed" {{ old('value_type', $price_range->value_type) == 'fixed' ? 'selected' : '' }}>Giá trị cố định</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Giá trị và Dải giá -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Giá trị</label>
                                    <input type="number" step="0.01" name="value" class="form-control" 
                                        value="{{ old('value', $price_range->value) }}" placeholder="Nhập giá trị dải giá">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Dải giá từ</label>
                                    <input type="number" step="0.01" name="price_min" class="form-control" 
                                        value="{{ old('price_min', $price_range->price_min) }}" placeholder="Nhập giá trị bắt đầu">
                                </div>
                            </div>
                        </div>

                        <!-- Dải giá đến -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Dải giá đến</label>
                                    <input type="number" step="0.01" name="price_max" class="form-control" 
                                        value="{{ old('price_max', $price_range->price_max) }}" placeholder="Nhập giá trị kết thúc">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('backend.dashboard.component.button')
    </div>
</form>
