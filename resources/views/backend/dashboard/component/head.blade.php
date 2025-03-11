<base href="{{ config('app.url') }}">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Hệ thống quản trị</title>
<link rel="icon" href="/userfiles/image/mau-sac/favicon-x.png" type="image/png" sizes="30x30">
<link href="backend/css/bootstrap.min.css" rel="stylesheet">
<link href="backend/font-awesome/css/font-awesome.css" rel="stylesheet">
<link href="backend/css/animate.css" rel="stylesheet">
<link href="backend/plugins/jquery-ui.css" rel="stylesheet">
@if(isset($config['css']) && is_array($config['css']))
    @foreach($config['css'] as $key => $val)
        {!! '<link rel="stylesheet" href="'.$val.'"></script>' !!}
    @endforeach
@endif

<link href="backend/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="backend/css/style.css" rel="stylesheet">
<link href="backend/css/customize.css" rel="stylesheet">
<script src="backend/js/jquery-3.1.1.min.js"></script>
<script>
    var BASE_URL = '{{ config('app.url')  }}'
    var SUFFIX = '{{ config('apps.general.suffix')  }}'
</script>