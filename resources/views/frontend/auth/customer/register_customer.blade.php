@extends('frontend.homepage.layout')
@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-12 col-md-4 col-lg-3 mx-auto">
        <div class="list-group">
            <a href="{{ route('customer.profile') }}" class="list-group-item list-group-item-action" aria-current="true">
                Tài khoản của tôi
            </a>
            <a href="{{ route('customer.password.change') }}" class="list-group-item list-group-item-action">Đổi mật khẩu</a>
            
            @if(auth()->guard('customer')->check())
                @php
                    $customer = auth()->guard('customer')->user();
                @endphp

                @if($customer->customer_catalogue_id == 1 ||$customer->customer_catalogue_id == 2)
                    
                    <a href="{{ route('customer.registerCustomer') }}" class="list-group-item list-group-item-action active">Đăng ký cộng tác viên</a>
                @else
                    <a href="{{ route('customer.wallet') }}" class="list-group-item list-group-item-action">Quản lý ví</a>
                    <a href="{{ route('customer.createCustomer') }}" class="list-group-item list-group-item-action">Thêm mới cộng tác viên</a>
                @endif
            @endif

            <a href="{{ route('customer.order') }}" class="list-group-item list-group-item-action">Đơn hàng</a>
            <a href="{{ route('customer.logout') }}" class="list-group-item list-group-item-action">Đăng xuất</a>
        </div>

        </div>
        <div class="col-12 col-md-8 col-lg-9 mx-auto">
            @include('backend/dashboard/component/formError')
            <form action="{{ route('customer.registerCustomer2') }}" method="post" class="box">
            @csrf
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <div class="panel-title">Thông tin chung</div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row mb15">
                                    <div class="col-lg-6">
                                        <input type="hidden" name="referral_by" value="{{ $code }}" class="form-control">
                                        <div class="form-row">
                                            <label>Email <span class="text-danger">(*)</span></label>
                                            <input type="text" name="email" readonly value="{{ old('email', $customer->email) }}" class="form-control">
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label>Họ Tên <span class="text-danger">(*)</span></label>
                                            <input type="text" name="name" readonly value="{{ old('name', $customer->name) }}" class="form-control">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label>Số điện thoại</label>
                                            <input type="text" name="phone" readonly value="{{ old('phone',$customer->phone) }}" class="form-control">
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-5">
                        <div class="panel-head">
                            <div class="panel-title">Thông tin liên hệ</div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="ibox">
                            <div class="ibox-content">
                                <div class="row mb15">
                                    <div class="col-lg-6" hidden>
                                        <div class="form-row">
                                            <label>Thành Phố</label>
                                            <select name="province_id" class="form-control setupSelect2 province location">
                                                <option value="0">[Chọn Thành Phố]</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province->code }}" {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                                        {{ $province->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-row">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="address" value="{{ old('address') }}" class="form-control">
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input
                                        type="text"
                                        name="referral_by"
                                        value="{{ old('referral_by') }}"
                                        placeholder="Mã giới thiệu"
                                        class="form-control">
                                    @if($errors->has('referral_by'))
                                    <span class="text-danger">* {{ $errors->first('referral_by') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input
                                        type="number"
                                        name="min_orders"
                                        value="{{ old('min_orders') }}"
                                        placeholder="Số đơn hàng tối thiểu/tháng"
                                        class="form-control">
                                    @if($errors->has('min_orders'))
                                    <span class="text-danger">* {{ $errors->first('min_orders') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <input
                                        type="number"
                                        name="monthly_spending"
                                        value="{{ old('monthly_spending') }}"
                                        placeholder="Tổng chi tiêu/tháng"
                                        class="form-control">
                                    @if($errors->has('monthly_spending'))
                                    <span class="text-danger">* {{ $errors->first('monthly_spending') }}</span>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <textarea
                                        name="about_me"
                                        placeholder="Giới thiệu bản thân"
                                        class="form-control">{{ old('about_me') }}</textarea>
                                    @if($errors->has('about_me'))
                                    <span class="text-danger">* {{ $errors->first('about_me') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-right mb15">
                    <button class="btn btn-primary" type="submit">Đăng ký</button>
                </div>
            </div>
        </form>

        </div>
    </div>
</div>

@endsection

@section('css')
<style>
    .btn-main {
        height: 33px;
        background: #7995a3;
        text-transform: uppercase;
        color: #fff;
        font-weight: 600;
        right: 5px;
        top: 6px;
        border: 12px;
        padding: 0 20px;
        border-radius: 5px;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection