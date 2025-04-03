@php
$segment = request()->segment(1);
@endphp
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">           
                <div class="dropdown profile-element"> <span>         
                    </span>
                    <a href="#" class="dropdown-toggle d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                        <div class="ml-2 text-center">
                        <img alt="avatar" class="img-circle" src="{{ asset(auth()->user()->image) }}" width="50" height="50"><br>
                            <strong class="font-bold">{{ auth()->user()->name }}</strong>
                            <div class="text-muted text-xs">Cài đặt <b class="caret"></b></div>
                        </div>
                        </a>


                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="">Hồ sơ cá nhân</a></li>

                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>
            @foreach(__('sidebar.module') as $key => $val)
            <li class=" {{ (isset($val['class'])) ? $val['class'] : '' }} {{ (in_array($segment, $val['name'])) ? 'active' : '' }}">
                <a href="{{ (isset($val['route'])) ? $val['route'] : '' }}">
                    <i class="{{ $val['icon'] }}"></i>
                    <span class="nav-label">{{ $val['title'] }}</span>
                    @if(isset($val['subModule']) && count($val['subModule']))
                    <span class="fa arrow"></span>
                    @endif
                </a>
                @if(isset($val['subModule']))
                <ul class="nav nav-second-level">
                    @foreach($val['subModule'] as $module)
                    <li><a href="{{ $module['route'] }}">{{ $module['title'] }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</nav>