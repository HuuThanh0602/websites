@include('backend.dashboard.component.breadcrumb', ['title' => 'Thêm mới loại cộng tác viên'])
@include('backend.dashboard.component.formError')
@php
$url = ($config['method'] == 'create') ? route('customer.catalogue.store') : route('customer.catalogue.update', $customerCatalogue->id);
@endphp
<form action="{{ $url }}" method="post" class="box">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Nhập thông tin chung của loại cộng tác viên</p>
                        <p>Lưu ý: Những trường đánh dấu <span class="text-danger">(*)</span> là bắt buộc</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Tên Loại <span class="text-danger">(*)</span></label>
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{ old('name', ($customerCatalogue->name) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Phần trăm giảm<span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        name="percent"
                                        value="{{ old('percent', ($customerCatalogue->percent) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Điều kiện về số đơn / tháng<span class="text-danger">(*)</span></label>
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
                                    <label for="" class="control-label text-left">Điều kiện về tổng chi tiêu / tháng<span class="text-danger">(*)</span></label>
                                    <input
                                        type="number"
                                        name="money_condition"
                                        value="{{ old('money_condition', ($customerCatalogue->money_condition) ?? '' ) }}"
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
                                        value="{{ old('description', ($customerCatalogue->description) ?? '' ) }}"
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