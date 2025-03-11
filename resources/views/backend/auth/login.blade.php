<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>LARAVEL CMS 01</title>

        <link href="{{ asset('backend/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

        <link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('backend/css/customize.css') }}" rel="stylesheet">

    </head>

    <body class="gray-bg">

        <div class="loginColumns animated fadeInDown">
            <div class="row">

                <div class="col-md-6">
                    <h2 class="font-bold">Dashboard</h2>

                    <p>
                        Chào mừng bạn đến với Bảng điều khiển Quản trị!
                    </p>

                    <p>
                         Vui lòng đăng nhập để truy cập và quản lý các chức năng cốt lõi của trang web.
                    </p>

                    <p>
                        Tại đây, bạn có thể theo dõi hiệu suất, cập nhật nội dung, quản lý người dùng và nhiều hơn nữa. 
            
                    </p>

                    <p>
                        Hãy đảm bảo rằng thông tin đăng nhập của bạn được bảo mật và chỉ những người có thẩm quyền mới được truy cập.
                    </p>

                    <p>
                        Hãy bắt đầu và giữ cho hoạt động của bạn luôn suôn sẻ!
                    </p>

                </div>
                <div class="col-md-6">
                    <div class="ibox-content">
                      
                        <form method="post" class="m-t" role="form" action="{{ route('auth.login') }}">
                            @csrf
                            <div class="form-group">
                                <input 
                                    type="text" 
                                    name="email"
                                    class="form-control" 
                                    placeholder="Email" autofocus
                                    value="{{ old('email') }}"
                                >
                                @if ($errors->has('email'))
                                    <span class="error-message">* {{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <input 
                                    type="password" 
                                    name="password"
                                    class="form-control" 
                                    placeholder="Password" 
                                >
                                @if ($errors->has('password'))
                                    <span class="error-message">* {{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success block full-width m-b">Đăng nhập</button>

                            {{-- <a href="#">
                                <small>Forgot password?</small>
                            </a> --}}
                        </form>
                        <p class="m-t">
                            <small>Đăng nhập để vào trang quản trị</small>
                        </p>
                    </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-6">
                    Copyright Khoa Nguyen
                </div>
                <div class="col-md-6 text-right">
                <small>© 2024</small>
                </div>
            </div>
        </div>

    </body>

</html>
