<div id="header" class="pc-header uk-visible-large">
    <!-- <div class="upper">
        <div class="uk-container uk-container-center">
            <div class="company-name">{{ $system['homepage_company'] }}</div>
        </div>
    </div> -->
    <div class="middle">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="logo">
                    <a href="/"><img src="{{ $system['homepage_logo'] }}" alt="Logo"></a>
                </div>
                <div class="header-search">
                    <form action="{{ write_url('tim-kiem') }}" class="uk-form form">
                        <input type="text" name="keyword" placeholder="Nhập từ khóa" value="" class="input-text">
                        <button type="submit" value="" name="">
                            Tìm kiếm <i class="fa fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="header-toolbox">
                    <div class="uk-flex uk-flex-middle">
                        <div class="header-cart12">
                            <div class="cart-mini12" style="margin-right: 15px;">
                                <svg width="15" height="15" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g>
                                        <path d="M24.4941 3.36652H4.73614L4.69414 3.01552C4.60819 2.28593 4.25753 1.61325 3.70863 1.12499C3.15974 0.636739 2.45077 0.366858 1.71614 0.366516L0.494141 0.366516V2.36652H1.71614C1.96107 2.36655 2.19748 2.45647 2.38051 2.61923C2.56355 2.78199 2.68048 3.00626 2.70914 3.24952L4.29414 16.7175C4.38009 17.4471 4.73076 18.1198 5.27965 18.608C5.82855 19.0963 6.53751 19.3662 7.27214 19.3665H20.4941V17.3665H7.27214C7.02705 17.3665 6.79052 17.2764 6.60747 17.1134C6.42441 16.9505 6.30757 16.7259 6.27914 16.4825L6.14814 15.3665H22.3301L24.4941 3.36652ZM20.6581 13.3665H5.91314L4.97214 5.36652H22.1011L20.6581 13.3665Z" fill="#FFFFFF"></path>
                                        <path d="M7.49414 24.3665C8.59871 24.3665 9.49414 23.4711 9.49414 22.3665C9.49414 21.2619 8.59871 20.3665 7.49414 20.3665C6.38957 20.3665 5.49414 21.2619 5.49414 22.3665C5.49414 23.4711 6.38957 24.3665 7.49414 24.3665Z" fill="#FFFFFF"></path>
                                        <path d="M17.4941 24.3665C18.5987 24.3665 19.4941 23.4711 19.4941 22.3665C19.4941 21.2619 18.5987 20.3665 17.4941 20.3665C16.3896 20.3665 15.4941 21.2619 15.4941 22.3665C15.4941 23.4711 16.3896 24.3665 17.4941 24.3665Z" fill="#FFFFFF"></path>
                                    </g>
                                </svg>
                                <a class="cart-link12">
                                    <!-- <img src="frontend/resources/img/shopping-cart.png" alt="cart image" class="cart-icon"> -->
                                    <i class='bx bx-cart-alt' style="width: 25px;  height: 25px;  vertical-align: middle; font-size: large; color: #2E0100;"></i>
                                    <span class="cart-count12">
                                        {{ isset($carts) && is_array($carts) ? collect($carts)->sum('qty') : 0 }}
                                    </span>
                                </a>
                            </div>
                            <ul class="cart-list12">
                                <li>
                                    <a href="{{ route('cart.checkout2', ['type' => 2]) }}" class="cart-text12">Giỏ Hàng</a>
                                </li>
                                <li>
                                    <a href="{{ route('cart.checkout2', ['type' => 3]) }}" class="cart-text12">Giỏ Hàng Order</a>
                                </li>
                            </ul>


                            <style>
                                .header-cart12 {
                                    position: relative;
                                    display: inline-block;
                                }


                                .cart-mini12 {
                                    display: flex;
                                    align-items: center;
                                    cursor: pointer;
                                }


                                .cart-link12 {
                                    position: relative;
                                    display: inline-block;
                                    text-decoration: none;
                                }


                                .cart-count12 {
                                    position: absolute;
                                    top: -8px;
                                    /* Điều chỉnh vị trí cho icon nhỏ hơn */
                                    right: -8px;
                                    background-color: #7A95A1;
                                    color: #fff;
                                    border-radius: 50%;
                                    width: 15px;
                                    /* Giảm kích thước vòng tròn */
                                    height: 15px;
                                    display: flex;
                                    align-items: center;
                                    justify-content: center;
                                    font-size: 10px;
                                    /* Giảm kích thước chữ */
                                    font-weight: bold;
                                }


                                .cart-list12 {
                                    display: none;
                                    position: absolute;
                                    top: 100%;
                                    right: 0;
                                    background-color: #fff;
                                    border: 1px solid #ddd;
                                    border-radius: 4px;
                                    padding: 10px;
                                    list-style: none;
                                    margin: 0;
                                    z-index: 1000;
                                    min-width: 150px;
                                }


                                .cart-list12 li {
                                    margin: 5px 0;
                                }


                                .cart-text12 {
                                    text-decoration: none;
                                    color: #333;
                                    font-size: 14px;
                                    display: block;
                                }


                                .cart-text12:hover {
                                    color: #7A95A1;
                                }


                                /* Hiển thị cart-list12 khi hover vào cart-mini12 */
                                .cart-mini12:hover+.cart-list12,
                                .cart-list12:hover {
                                    display: block;
                                }
                            </style>
                        </div>


                        @if(auth()->guard('customer')->check())
                        <div class="header-cart">
                            <div class="uk-flex uk-flex-middle">
                                <a href="{{ route('customer.profile') }}" class="cart-text">
                                <i class='bx bx-user' style="width: 25px;  height: 25px;  vertical-align: middle; font-size: large; color: #2E0100;"></i>


                                    {{ auth()->guard('customer')->user()->name }} -
                                </a>
                                <a style="color: red;" href="{{ route('customer.logout') }}" class="cart-text"> [Đăng xuất]</a>
                            </div>
                        </div>


                        @else
                        <div class="">
                            <div class="uk-flex uk-flex-middle">
                                <a style="color: #000;font-weight: 700;"  href="{{ route('fe.auth.login') }}" class="cart-text">
                                    <i class='bx bx-user' style="width: 25px;  height: 25px;  vertical-align: middle; font-size: large; color: #2E0100;"></i>
                                    Đăng nhập</a>
                            </div>
                        </div>


                        @endif




                        {{-- <div class="header-hotline">
                            <div class="text">Hotline</div>
                            <div class="hotline-number">{{ $system['contact_hotline'] }}
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</div>
</div>
<div class="lower" data-uk-sticky>
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium uk-flex uk-flex-middle">
            <div class="uk-width-large-1-5">
                @if(count($categories))
                {{-- <div class="logoScroll">
                        <a href="" class="image img-cover">
                            <img src="{{ $system['homepage_logo'] }}" alt="">
                </a>
            </div> --}}
            <div class="categories">
                <div class="category-heading">Danh mục sản phẩm</div>
                <div class="category-dropdown">
                    <ul class="uk-list uk-clearfix">
                        @foreach($categories as $key => $val)
                        @php
                        $name = $val->languages->first()->pivot->name;
                        $canonical = write_url($val->languages->first()->pivot->canonical);
                        @endphp
                        <li><a href="{{ $canonical }}" title="{{ $name }}">{{ $name }} </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif
        </div>
        <div class="uk-width-large-4-5">
            @include('frontend.component.navigation')
        </div>
    </div>
</div>
</div>








</div>






</div>
<div class="mobile-header uk-hidden-large">
    <div class="mobile-upper">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-middle uk-flex-space-between">
                <div class="mobile-logo">
                    <a href="." title="{{ $system['seo_meta_title'] }}">
                        <img src="{{ $system['homepage_logo'] }}" alt="Mobile Logo">
                    </a>
                </div>
                <div class="mobile-widget">
                    <div class="uk-flex uk-flex-middle">
                        @if(auth()->guard('customer')->check())
                        <a href="{{ route('customer.profile') }}" class="btn btn-addCart">
                            <div style="font-size: 28px; color: #111;" class="fa fa-user"></div>
                        </a>


                        @else
                        <a href="{{ route('fe.auth.login') }}" class="btn btn-addCart">
                            <div style="font-size: 28px; color: #111;" class="fa fa-user"></div>
                        </a>
                        @endif




                        <a href="" class="btn btn-addCart">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path d="M24.4941 3.36652H4.73614L4.69414 3.01552C4.60819 2.28593 4.25753 1.61325 3.70863 1.12499C3.15974 0.636739 2.45077 0.366858 1.71614 0.366516L0.494141 0.366516V2.36652H1.71614C1.96107 2.36655 2.19748 2.45647 2.38051 2.61923C2.56355 2.78199 2.68048 3.00626 2.70914 3.24952L4.29414 16.7175C4.38009 17.4471 4.73076 18.1198 5.27965 18.608C5.82855 19.0963 6.53751 19.3662 7.27214 19.3665H20.4941V17.3665H7.27214C7.02705 17.3665 6.79052 17.2764 6.60747 17.1134C6.42441 16.9505 6.30757 16.7259 6.27914 16.4825L6.14814 15.3665H22.3301L24.4941 3.36652ZM20.6581 13.3665H5.91314L4.97214 5.36652H22.1011L20.6581 13.3665Z" fill="#253D4E"></path>
                                    <path d="M7.49414 24.3665C8.59871 24.3665 9.49414 23.4711 9.49414 22.3665C9.49414 21.2619 8.59871 20.3665 7.49414 20.3665C6.38957 20.3665 5.49414 21.2619 5.49414 22.3665C5.49414 23.4711 6.38957 24.3665 7.49414 24.3665Z" fill="#253D4E"></path>
                                    <path d="M17.4941 24.3665C18.5987 24.3665 19.4941 23.4711 19.4941 22.3665C19.4941 21.2619 18.5987 20.3665 17.4941 20.3665C16.3896 20.3665 15.4941 21.2619 15.4941 22.3665C15.4941 23.4711 16.3896 24.3665 17.4941 24.3665Z" fill="#253D4E"></path>
                                </g>
                                <defs>
                                    <clipPath>
                                        <rect width="24" height="24" fill="white" transform="translate(0.494141 0.366516)"></rect>
                                    </clipPath>
                                </defs>
                            </svg>
                        </a>


                        <a href="#mobileCanvas" class="mobile-menu-button" data-uk-offcanvas>
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="100%" height="100%" preserveAspectRatio="none"
                                viewBox="0 0 1536 1896.0833" class="" fill="#7A95A2">
                                <path d="M1536 1344v128q0 26-19 45t-45 19H64q-26 0-45-19t-19-45v-128q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19H64q-26 0-45-19T0 960V832q0-26 19-45t45-19h1408q26 0 45 19t19 45zm0-512v128q0 26-19 45t-45 19H64q-26 0-45-19T0 448V320q0-26 19-45t45-19h1408q26 0 45 19t19 45z"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="search-mobile">


        <form action="{{ write_url('tim-kiem') }}" class="uk-form form mobile-form">
            <div class="form-row">
                <input type="text" name="keyword" value="" class="input-text" placeholder="Từ khóa tìm kiếm...">
                <button name="btn-search" type="submit"><i class="fa fa-search"></i></button>
            </div>
        </form>
    </div>
</div>
<div id="mobileCanvas" class="uk-offcanvas offcanvas">
    <div class="uk-offcanvas-bar">
        @if(isset($menu['mobile']))
        <ul class="l1 uk-nav uk-nav-offcanvas uk-nav uk-nav-parent-icon" data-uk-nav>
            @foreach ($menu['mobile'] as $key => $val)
            @php
            $name = $val['item']->languages->first()->pivot->name;
            $canonical = write_url($val['item']->languages->first()->pivot->canonical, true, true);
            @endphp
            <li class="l1 {{ (count($val['children']))?'uk-parent uk-position-relative':'' }}">
                <?php echo (isset($val['children']) && is_array($val['children']) && count($val['children'])) ? '<a href="#" title="" class="dropicon"></a>' : ''; ?>
                <a href="{{ $canonical }}" title="{{ $name }}" class="l1">{{ $name }}</a>
                @if(count($val['children']))
                <ul class="l2 uk-nav-sub">
                    @foreach ($val['children'] as $keyItem => $valItem)
                    @php
                    $name_2 = $valItem['item']->languages->first()->pivot->name;
                    $canonical_2 = write_url($valItem['item']->languages->first()->pivot->canonical, true, true);
                    @endphp
                    <li class="l2">
                        <a href="{{ $canonical_2 }}" title="{{ $name_2 }}" class="l2">{{ $name_2 }}</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
        @endif
    </div>
</div>

