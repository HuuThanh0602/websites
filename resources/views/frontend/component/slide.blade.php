@php
$slideKeyword = App\Enums\SlideEnum::MAIN;
@endphp
@if(count($slides[$slideKeyword]['item']))
<div class="panel-slide page-setup" data-setting="{{ json_encode($slides[$slideKeyword]['setting']) }}">
    <div class="swiper-container">
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-wrapper">
            @foreach($slides[$slideKeyword]['item'] as $key => $val )
            <div class="swiper-slide">
                <div class="slide-item">
                    <div class="slide-overlay">
                        <div class="slide-title">{!! $val['name'] !!}</div>
                        <div class="slide-description">{!! $val['description'] !!} </div>
                    </div>
                    {{-- <div class="subcribe-form">
                        <form action="" class="uk-form form">
                            <input type="text" name="email" value="" class="input-text" placeholder="Nhập vào Email Của bạn">
                            <button type="submit" name="submit" class="btn-send">Subcribe</button>
                        </form>
                    </div> --}}
                    <span class="image img-cover">
                        <img class="banner-custom-laptop" src="{{ $val['image'] }}" alt="{{ $val['name'] }}">
                    </span>

                    <style>
                        /* Mặc định cho các kích thước lớn hơn laptop */
                        .banner-custom-laptop {
                            height: 380px !important;
                            object-fit: cover;
                            /* Giữ hình ảnh cân đối */
                            width: 100%;
                            /* Phủ toàn bộ chiều rộng */
                        }

                        /* Responsive: Giảm chiều cao trên các thiết bị nhỏ hơn */
                        @media (max-width: 1200px) {

                            /* Laptop */
                            .banner-custom-laptop {
                                height: 300px !important;
                            }
                        }

                        @media (max-width: 992px) {

                            /* Tablet */
                            .banner-custom-laptop {
                                height: 250px !important;
                            }
                        }

                        @media (max-width: 768px) {

                            /* Mobile lớn */
                            .banner-custom-laptop {
                                height: 200px !important;
                            }
                        }

                        @media (max-width: 576px) {

                            /* Mobile nhỏ */
                            .banner-custom-laptop {
                                height: 150px !important;
                            }
                        }
                    </style>


                </div>
            </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>
@endif