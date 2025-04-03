@extends('frontend.homepage.layout')
@section('content')


<div class="container p-5">
    <!-- Navigation Tabs Card -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <div class="d-flex flex-row flex-wrap border-bottom">
                <a href="{{ route('customer.profile') }}"
                    class="btn btn-link text-decoration-none px-3 py-2 {{ request()->routeIs('customer.profile') ? 'fw-bold border-bottom border-3' : 'text-dark' }}"
                    style="color: #7995a3; font-weight: 500;">
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
        @include('backend/dashboard/component/formError')
        <form action="{{ route('customer.profile.update') }}" method="post" enctype="multipart/form-data" class="px-5">
            @csrf
            <h4 class="text-center mb-11">Hồ sơ cá nhân của tôi</h4>
            <p class="mb-4 text-center">Quản lý thông tin hồ sơ để bảo mật tài khoản</p>

            <!-- Basic Information Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thông tin cơ bản</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="name">Họ tên <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="name" value="{{ old('name', $customer->name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-9">
                            <input type="email" class="form-control" name="email" value="{{ old('email', $customer->email ?? '') }}" readonly>
                            <small class="text-muted">Không thể thay đổi email đã đăng ký</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="phone">Số điện thoại <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="phone" value="{{ old('phone', $customer->phone ?? '') }}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="birthday">Ngày sinh</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="date" class="form-control" name="birthday" value="{{ old('birthday', $customer->birthday ?? '') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="address">Địa chỉ cụ thể</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="address" value="{{ old('address', $customer->address ?? '') }}" placeholder="Số nhà, đường, thôn/xóm...">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Ảnh đại diện</h5>


                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="image">Ảnh đại diện</label>
                        </div>
                        <div class="col-lg-9">
                            <div class="mb-2">
                                @if(isset($customer->image) && !empty($customer->image))
                                <img src="{{ asset($customer->image) }}" alt="Avatar" class="img-thumbnail" style="max-width: 150px;">
                                @endif
                            </div>
                            <input type="file" class="form-control" name="image" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information Section -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Thông tin bổ sung</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="customer_catalogue_id">Loại tài khoản</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" value="{{ $customer->customer_catalogue_id == 1 ? 'Khách hàng' : ($customer->customer_catalogue_id == 2 ? 'Khách hàng VIP' : 'Cộng tác viên') }}" readonly>
                            <input type="hidden" name="customer_catalogue_id" value="{{ old('customer_catalogue_id', $customer->customer_catalogue_id ?? '') }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="description">Mô tả</label>
                        </div>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="description" rows="3">{{ old('description', $customer->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-label" for="referral_by">Được giới thiệu bởi</label>
                        </div>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="referral_by" value="{{ old('referral_by', $customer->referral_by ?? '') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>



            <div class="d-flex justify-content-start align-items-center mb-5">
                <button type="submit" class="btn-main me-3">Lưu thông tin</button>
                <a href="{{ route('customer.profile') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>
    </div>
</div>


@endsection


@section('css')
<style>
    .btn-main {
        height: 40px;
        background: #7995a3;
        text-transform: uppercase;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 0 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-main:hover {
        background: #617d8a;
    }

    .form-label {
        font-weight: 500;
        margin-top: 8px;
    }

    .card-header {
        background-color: #f8f9fa;
    }

    .text-danger {
        color: #dc3545;
    }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
@endsection


@section('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection