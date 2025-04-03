@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])
@include('backend.dashboard.component.formError')
@php
$url = ($config['method'] == 'create') ? route('customer.store') : route('customer.update', $customer->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Nhập thông tin chung của Khách hàng</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                <div class="ibox-title">
                    <h5>Thông tin chung</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-5">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Email <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="email"
                                        value="{{ old('email', ($customer->email) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mã khách hàng</label>
                                    <div class="code">
                                        <input
                                            type="text"
                                            name="code"
                                            value="{{ old('code', ($customer->code) ?? time() ) }}"
                                            class="form-control"
                                            placeholder=""
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Họ Tên <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($customer->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                     
                        <div class="row mb15">
    <div class="col-lg-6">
        <div class="form-row">
            <label class="control-label text-left">
                Là khách hàng mặc định 
                <i class="fa fa-info-circle text-primary" data-toggle="tooltip" data-placement="right"
                   title="Chọn để đánh dấu khách hàng này là mặc định (mã loại khách hàng 1)." style="background-color: white; color: red;"></i>
            </label>
            <div class="mt5">
                <input type="checkbox"
                       name="iscustomer"
                       id="iscustomer"
                       class="mr5"
                       {{ old('iscustomer', isset($customer->customer_catalogue_id) && $customer->customer_catalogue_id == 1 ? 'checked' : '') }}
                       onchange="toggleCustomerType(this)">
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-row customerWrapper" id="customerTypeSelector">
            <label class="control-label text-left">
                Loại cộng tác viên <span class="text-danger">(*)</span>
                
            </label>
            <select name="customer_catalogue_id" id="customer_catalogue_id" class="form-control setupSelect2">
                <option value="0">[Chọn Loại cộng tác viên phù hợp]</option>
                @foreach($customerCatalogues as $key => $item)
                <option {{ 
                    $item->id == old('customer_catalogue_id', (isset($customer->customer_catalogue_id)) ? $customer->customer_catalogue_id : '') ? 'selected' : '' 
                    }} value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>



<!-- Bootstrap Tooltip Script -->
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
        toggleCustomerType(document.getElementById('iscustomer')); // Gọi hàm kiểm tra khi tải trang
    });

    function toggleCustomerType(checkbox) {
        let customerTypeSelector = document.getElementById("customerTypeSelector");
        if (checkbox.checked) {
            customerTypeSelector.style.display = "none";
        } else {
            customerTypeSelector.style.display = "block";
        }
    }
</script>
           @if($config['method'] == 'create')
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Mật khẩu <span class="text-danger">(*)</span></label>
                                    <input
                                        type="password"
                                        name="password"
                                        value=""
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                    <input
                                        type="password"
                                        name="re_password"
                                        value=""
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Ảnh đại diện </label>
                                    <input
                                        type="text"
                                        name="image"
                                        value="{{ old('image', ($customer->image) ?? '') }}"
                                        class="form-control upload-image"
                                        placeholder=""
                                        autocomplete="off"
                                        data-upload="Images">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Ngày sinh </label>
                                    <input
                                        type="date"
                                        name="birthday"
                                        value="{{ old('birthday', (isset($customer->birthday)) ? date('Y-m-d', strtotime($customer->birthday)) : '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin liên hệ</div>
                    <div class="panel-description">Nhập thông tin liên hệ của người sử dụng</div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                <div class="ibox-title">
                    <h5>Thông tin liên hệ</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Thành Phố</label>
                                    <select name="province_id" class="form-control setupSelect2 province location" data-target="districts">
                                        <option value="0">[Chọn Thành Phố]</option>
                                        @if(isset($provinces))
                                        @foreach($provinces as $province)
                                        <option @if(old('province_id')==$province->code) selected @endif value="{{ $province->code }}">{{ $province->name }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Quận/Huyện </label>
                                    <select name="district_id" class="form-control districts setupSelect2 location" data-target="wards">
                                        <option value="0">[Chọn Quận/Huyện]</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Phường/Xã </label>
                                    <select name="ward_id" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Địa chỉ </label>
                                    <input
                                        type="text"
                                        name="address"
                                        value="{{ old('address', ($customer->address) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Số điện thoại</label>
                                    <input
                                        type="text"
                                        name="phone"
                                        value="{{ old('phone', ($customer->phone) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Ghi chú</label>
                                    <input
                                        type="text"
                                        name="description"
                                        value="{{ old('description', ($customer->description) ?? '') }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-right mb15">
            <button class="btn btn-primary" type="submit" name="send" value="send">Lưu lại</button>
        </div>
    </div>
</form>

<script>
    var province_id = '{{ (isset($customer->province_id)) ? $customer->province_id : old('
    province_id ') }}'
    var district_id = '{{ (isset($customer->district_id)) ? $customer->district_id : old('
    district_id ') }}'
    var ward_id = '{{ (isset($customer->ward_id)) ? $customer->ward_id : old('
    ward_id ') }}'
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Run the toggle function on page load to set correct initial state
        toggleCustomerType(document.getElementById('iscustomer'));
    });

    function toggleCustomerType(checkbox) {
        var customerTypeSelector = document.getElementById('customerTypeSelector');
        var customerCatalogueId = document.getElementById('customer_catalogue_id');
        
        if (checkbox.checked) {
            // Hide dropdown and set value to 1 (default customer)
            customerTypeSelector.style.display = 'none';
            customerCatalogueId.value = '1';
        } else {
            // Show dropdown and allow selection of other customer types
            customerTypeSelector.style.display = 'block';
            
            // If the current value is 1, reset it to 0 (prompt user to select)
            if (customerCatalogueId.value === '1') {
                customerCatalogueId.value = '0';
            }
        }
    }
</script>