@extends('frontend.homepage.layout')
@section('content')
    {{-- <div class="forgotpassword-container">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-medium">
                <div class="uk-width-large-2-3"></div>
                <div class="uk-width-large-1-3">
                    <div class="register-form">
                        <form action="{{ route($route) }}" method="get">
                            @csrf
                                <div class="form-heading">Quên mật khẩu</div>
                                <p>Nhập địa chỉ email của bạn và mật khẩu của bạn sẽ được đặt lại và gửi qua email cho bạn.</p>
                                <div class="form-row">
                                    <input 
                                        type="text" 
                                        class="input-text" 
                                        name="email"
                                        value="{{ old('email') }}" 
                                        placeholder="Email"
                                    >
                                    @if($errors->has('email'))
                                        <span class="error-message">* {{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                                <button type="submit" class="btn block full-width m-b">Gửi mật khẩu mới</button>  
                        </form>
                        <p class="m-t mt5">
                            <small>{{ $system['homepage_brand'] }} © 2023</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-4"></div>
        <div class="col-12 col-md-8 col-lg-4 mx-auto">
            <form action="{{ route($route) }}" method="get"
                class="border px-5 py-4 rounded my-5">
                @csrf
                <h4 class="text-center mb-3">Quên mật khẩu</h4>
                <p>Nhập địa chỉ email của bạn và mật khẩu của bạn sẽ được đặt lại và gửi qua email cho bạn.</p>
                <div class="mb-3">
                    <input 
                        type="text" 
                        class="form-control" 
                        name="email"
                        value="{{ old('email') }}" 
                        placeholder="Email"
                    >
                    @if($errors->has('email'))
                        <span class="error-message">* {{ $errors->first('email') }}</span>
                    @endif
                </div>

                    <button type="submit" class="btn-main">Gửi mật khẩu mới</button> 

                <div>
                    
                </div>
            </form>
        </div>
        <div class="col-4"></div>
    </div>
@endsection

@section('css')
    <style>
        .btn-main {
            height: 33px;
            background: #da2229;
            text-transform: uppercase;
            color: #fff;
            font-weight: 600;
            border: 12px;
            padding: 0 20px;
            border-radius: 5px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
@endsection
