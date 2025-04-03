@include('backend.dashboard.component.breadcrumb', ['title' => 'Thêm mới loại khách hàng'])
@include('backend.dashboard.component.formError')
@php
$url = ($config['method'] == 'create') ? route('customer.catalogue.store') : route('customer.catalogue.update', $customerCatalogue->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-4">
            <div class="panel-head">
                    <div class="panel-title">Thông tin phân loại</div>
                    <div class="panel-description">
                        <p>Nhập thông tin chi tiết về loại khách hàng</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                    <div class="mt-4">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Phân loại khách hàng giúp doanh nghiệp quản lý và chăm sóc khách hàng hiệu quả hơn, đồng thời xây dựng chính sách ưu đãi phù hợp với từng đối tượng.
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="ibox">
                <div class="ibox-title">
                        <h5>Thông tin cơ bản</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left font-bold">Tên loại khách hàng <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($customerCatalogue->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder="VD: Khách hàng VIP"
                                        autocomplete="off">
                                </div>
                            </div>
                  
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-bold">Mã loại khách hàng</label>
                                    @if($config['method'] == 'create')
                                        <input
                                            type="text"
                                            value="Mã sẽ được tạo tự động"
                                            class="form-control bg-muted"
                                            readonly
                                            disabled>
                                        <small class="text-muted">Mã sẽ được tạo tự động sau khi lưu</small>
                                    @else
                                        <input
                                            type="text"
                                            value="{{ ($customerCatalogue->id) ?? '' }}"
                                            class="form-control bg-muted"
                                            readonly
                                            disabled>
                                        <input type="hidden" name="code" value="{{ ($customerCatalogue->id) ?? '' }}">
                                        <small class="text-muted">Mã loại không thể thay đổi</small>
                                    @endif
                                </div>
                            </div>
                           
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-title">
                    <h5>Điều kiện phân loại</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                       
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Số đơn hàng tối thiểu / tháng<span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        name="quantity_condition"
                                        value="{{ old('quantity_condition', ($customerCatalogue->quantity_condition) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Tổng chi tiêu / tháng<span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        name="money_condition"
                                        value="{{ old('money_condition', ($customerCatalogue->money_condition) ?? '' ) }}"
                                        class="form-control"
                                        placeholder="5000000 VND"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-bold">Thời gian duy trì (tháng)</label>
                                    <input
                                        type="number"
                                        name="duration_condition"
                                        value="{{ old('duration_condition', ($customerCatalogue->duration_condition) ?? '3' ) }}"
                                        class="form-control"
                                        placeholder="VD: 3"
                                        autocomplete="off">
                                    <small class="text-muted">Số tháng khách hàng cần duy trì điều kiện để giữ hạng</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            
                <div class="ibox">
                    <div class="ibox-title">
                    <h5>Quyền lợi khách hàng</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label class="font-bold">Phần trăm giảm giá <span class="text-danger">(*)</span></label>
                                <div class="input-group">
                                    <input
                                        type="number"
                                        name="percent"
                                        value="{{ old('percent', ($customerCatalogue->percent) ?? '' ) }}"
                                        class="form-control"
                                        placeholder="VD: 10"
                                        autocomplete="off"
                                        step="0.01" min="0">
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                        <input type="text" name="publish" value="1" hidden>
                    <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nội dung quyền lợi</label>
                                    <input
                                        type="text"
                                        name="description"
                                        value="{{ old('description', ($customerCatalogue->description) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="text-right mb15">
                    <a href="{{ route('customer.catalogue.index') }}" class="btn btn-white">Hủy</a>
                    <button class="btn btn-primary" type="submit" name="send" value="send">
                     Lưu lại
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>