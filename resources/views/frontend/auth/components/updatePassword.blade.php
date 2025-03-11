
@extends('frontend.homepage.layout')
@section('content')
    

    <div class="row">
        <div class="col-4"></div>
        <div class="col-12 col-md-8 col-lg-4 mx-auto">
            <form action="{{ route($route, $email) }}" method="post"
                class="border px-5 py-4 rounded my-5">
                @csrf
                <h4 class="text-center mb-3">Cập nhật mật khẩu</h4>
            
                <div class="mb-3">
                    <input 
                        type="password" 
                        class="form-control" 
                        name="password"
                        placeholder="Mật khẩu"
                    >
                </div>

                <div class="mb-3">
                    <input 
                        type="password" 
                        class="form-control" 
                        name="re_password"
                        placeholder="Nhập lại mật khẩu"
                    >
                </div>

                    <button type="submit" class="btn-main">Đổi mật khẩu</button> 

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
