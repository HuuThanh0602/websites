@include('backend.dashboard.component.breadcrumb', ['title' => $config['seo']['create']['title']])

<form action="{{ route('review.destroy', $review->id) }}" method="post" class="box">
    @csrf
    @method('DELETE')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-5">
                <div class="panel-head">
                    <div class="panel-title">Thông tin chung</div>
                    <div class="panel-description">
                        <p>Bạn đang muốn xóa đánh giá</p>
                        <p>Lưu ý: Không thể khôi phục bản ghi sau khi xóa. Hãy chắc chắn bạn muốn thực hiện chức năng này</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row mb15">
                            <div class="col-lg-12">
                                 <div class="form-row">
                                    <label for="" class="control-label text-left">Khách hàng <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="fullname"
                                        value="{{ old('fullname', ($review->fullname) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                </div>
                                <br>
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Số sao<span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="score"
                                        value="{{ old('score', ($review->score) ?? '' ) }} sao"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                </div>
                                <br>
                                <div class="form-row">
                                    <label for="" class="control-label text-left">Nội dung đánh giá <span class="text-danger">(*)</span></label>
                                    <input 
                                        type="text"
                                        name="description"
                                        value="{{ old('description', ($review->description) ?? '' ) }}"
                                        class="form-control"
                                        placeholder=""
                                        autocomplete="off"
                                        readonly
                                    >
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="text-right mb15">
            <button class="btn btn-danger" type="submit" name="send" value="send">Xóa dữ liệu</button>
        </div>
    </div>
</form>
