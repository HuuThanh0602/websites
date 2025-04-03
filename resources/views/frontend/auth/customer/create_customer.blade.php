@extends('frontend.homepage.layout')
@section('content')


<div class="container p-5">



    <!-- Navigation Tabs Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-row flex-wrap border-bottom">
                <a href="{{ route('customer.profile') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.profile') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Tài khoản của tôi
                </a>
                <a href="{{ route('customer.password.change') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.password.change') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đổi mật khẩu
                </a>
                @if(auth()->guard('customer')->check())
                @php
                $customer = auth()->guard('customer')->user();
                @endphp


                @if($customer->customer_catalogue_id == 1 || $customer->customer_catalogue_id == 2)
                <a href="{{ route('customer.registerCustomer') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.registerCustomer') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đăng ký cộng tác viên
                </a>
                @else
                <a href="{{ route('customer.wallet') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.wallet') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Quản lý ví
                </a>
                <a href="{{ route('customer.createCustomer') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.createCustomer') ? 'fw-bold border-bottom border-3' : 'text-dark' }}" style="color:#7A95A2;">
                    Giới thiệu cộng tác viên
                </a>
                @endif
                @endif
                <a href="{{ route('customer.order') }}" class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.order') ? 'fw-bold border-bottom border-3' : 'text-dark' }}">
                    Đơn hàng
                </a>
                <a href="{{ route('customer.logout') }}" class="btn btn-link text-decoration-none px-3 py-2 text-danger">
                    Đăng xuất
                </a>
            </div>
        </div>
    </div>


    <div class="container">
        <!-- Form Error Messages -->
        @include('backend/dashboard/component/formError')
        <h5 class="mb-1 text-center">Giới thiệu cộng tác viên</h5>
        <p class="text-muted mb-2 text-center">Điền thông tin đăng ký cho cộng tác viên bạn muốn giới thiệu</p>
        <!-- Form Content -->
        <form action="{{ route('customer.store123') }}" method="post">
            @csrf
            <input type="hidden" name="referral_by" value="{{ $code ?? '' }}" class="form-control">

            <!-- Personal Information Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class=" bg-opacity-10 rounded-circle p-2 me-3" style="background-color: #7A95A2; color: white;">
                            <i class="bi bi-person"></i>
                        </div>
                        <h6 class="mb-0">Thông tin cá nhân</h6>
                    </div>

                    <div class="ms-5">
                        <!-- Row 1: Name and Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Họ Tên <span class="text-danger">(*)</span></label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Nhập họ tên cộng tác viên">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Email <span class="text-danger">(*)</span></label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Nhập email cộng tác viên">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Password and Confirm Password -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Mật khẩu <span class="text-danger">(*)</span></label>
                                <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu cộng tác viên">
                                @error('password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Nhập lại mật khẩu <span class="text-danger">(*)</span></label>
                                <input type="password" name="re_password" class="form-control" placeholder="Nhập lại mật khẩu cộng tác viên">
                            </div>
                        </div>

                        <!-- Row 4: Max Orders and Min Revenue -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Số đơn hàng tối đa/tháng <span class="text-danger">(*)</span></label>
                                <input type="number" name="max_orders" value="{{ old('max_orders') }}" class="form-control" placeholder="Nhập số đơn hàng tối đa/ tháng cộng tác viên có thể mua">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Doanh số tối đa/tháng <span class="text-danger">(*)</span></label>
                                <input type="number" name="min_revenue" value="{{ old('min_revenue') }}" class="form-control" placeholder="Nhập doanh số tối đa/ tháng cộng tác viên có thể mua">
                            </div>
                        </div>

                        <!-- Row 5: Birthday -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Sinh nhật <span class="text-danger">(*)</span></label>
                                <input type="date" name="birthday" value="{{ old('birthday') }}" class="form-control">
                            </div>
                            <div class="col-md-6" style="height: 80px;">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Mô tả kinh nghiệm</label>
                                <textarea name="experience" class="form-control" placeholder="Nhập mô tả ngắn gọn về cộng tác viên để làm cơ sở cho chúng tôi xem xét!">{{ old('experience') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class=" bg-opacity-10 rounded-circle p-2  me-3" style="background-color: #7A95A2; color: white; border-radius: 100%;">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <h6 class="mb-0">Thông tin liên hệ</h6>
                    </div>

                    <div class="ms-5">
                        <!-- Row 6: Province and Address -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Thành Phố</label>
                                <select name="province_id" class="form-select setupSelect2 province location">
                                    <option value="0">[Chọn Thành Phố]</option>
                                    @foreach($provinces as $province)
                                    <option value="{{ $province->code }}" {{ old('province_id') == $province->code ? 'selected' : '' }}>
                                        {{ $province->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Địa chỉ</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control" placeholder="Nhập vào địa chỉ của cộng tác viên">
                                @error('address')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 7: Phone -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label" style="color: #676a6c;font-weight: 500;">Số điện thoại <span class="text-danger">(*)</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Nhập vào số điện thoại của cộng tác viên">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="text-end">
                        <button type="submit" class="btn  px-4 py-2 " style="background-color: #7A95A2; color: white; border-radius: 5px;">Lưu lại</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .profile-image img {
        object-fit: cover;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        height: 40px;
        transition: all .2s ease-out;
        border: 1px solid #c4cdd5;
    }

    .card {
        border-radius: 10px;
        border: none;

    }

    .card-body {
        padding: 1.5rem;
    }

    .shadow-sm {
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        box-shadow: 2px 6px 16px rgba(0, 0, 0, 0.16);
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection


@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection