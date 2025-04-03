@extends('frontend.homepage.layout')
@section('content')
    <div class="contact-page">
        <div class="page-breadcrumb ">      
            <div class="uk-container uk-container-center">
                <ul class="uk-list uk-clearfix">
                    <li><a href="/"><i class="fi-rs-home mr5"></i>{{ __('frontend.home') }}</a></li>
                    <li><a href="{{ route('distribution.list.index') }}" title="Hệ thống phân phối">Liên Hệ</a></li>
                </ul>
            </div>
        </div>
       
        <!-- Main Content -->
        <div class="uk-container uk-container-center">
            <div class="contact-container">
                <!-- Section Title -->
               
                <!-- Contact Content -->
                <div class="uk-grid uk-grid-large uk-margin-large-bottom">
                    <!-- Contact Information -->
                    <div class="uk-width-large-1-2">
                        <div class="contact-info-box">
                            <h3 class="box-title" style="color: #7A95A1; text-align: center;">Liên hệ A'nista</h3>
                                <div class="intro-content"style=" text-align: center;">
                                    {!! $system['homepage_short_intro'] !!}
                                </div>
                            <div class="contact-info-list">
                                <div class="contact-info-item">
                                    <div class="icon">
                                        <i class="fi-rs-marker"></i>
                                    </div>
                                    <div class="content">
                                        <h4>Trụ sở văn phòng</h4>
                                        <p><?php echo $system['contact_address'] ?></p>
                                    </div>
                                </div>
                               
                                <div class="contact-info-item">
                                    <div class="icon">
                                    <i class="fa-solid fa-phone"></i>
                                                                 </div>
                                    <div class="content">
                                        <h4>Hotline hỗ trợ</h4>
                                        <p><?php echo $system['contact_hotline'] ?></p>
                                    </div>
                                </div>
                               
                                <div class="contact-info-item">
                                    <div class="icon">
                                        <i class="fi-rs-envelope"></i>
                                    </div>
                                    <div class="content">
                                        <h4>Email</h4>
                                        <p><?php echo $system['contact_email'] ?></p>
                                    </div>
                                </div>
                               
                                <div class="contact-info-item">
                                    <div class="icon">
                                    <i class="fa-solid fa-clock"></i>                                    </div>
                                    <div class="content">
                                        <h4>Giờ làm việc</h4>
                                        <p>Từ 08:00 đến 18:00<br>Từ thứ 2 đến thứ 7</p>
                                    </div>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                   
                    <!-- Contact Form -->
                    <div class="uk-width-large-1-2">
                        <div class="contact-form-box">
                            <h3 class="box-title" style="text-align: center; color: white;">Gửi email tới A'nista</h3>
                            <p class="form-description" style="color: white; text-align: center;">Thắc mắc của bạn sẽ được phản hồi trong 24h. Xin cảm ơn!</p>
                           
                            <form onsubmit="return false;" action="" method="post" class="contact-form">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-large">
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                id="fullname"
                                                name="fullname"
                                                class="form-control"
                                                placeholder="Nhập họ và tên của bạn"
                                                required
                                                style=" border: 0.5px solid white;"
                                            >
                                        </div>
                                    </div>
                                   
                                    <div class="uk-width-large">
                                        <div class="form-group">
                                            <input
                                                type="tel"
                                                id="phone"
                                                name="phone"
                                                class="form-control"
                                                placeholder="Nhập số điện thoại của bạn"
                                                required
                                                style=" border: 0.55px solid white;"
                                            >
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-large">
                                        <div class="form-group">
                                            <input
                                                type="email"
                                                id="email"
                                                name="email"
                                                class="form-control"
                                                placeholder="Nhập địa chỉ email của bạn"
                                                required
                                                style=" border: 0.55px solid white;"
                                            >
                                        </div>
                                    </div>
                                   
                                    <div class="uk-width-large">
                                        <div class="form-group">
                                            <input
                                                type="text"
                                                id="subject"
                                                name="subject"
                                                class="form-control"
                                                placeholder="Nhập chủ đề"
                                                required
                                                style=" border: 0.55px solid white;"
                                            >
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <textarea
                                        id="message"
                                        name="message"
                                        class="form-control"
                                        placeholder="Nhập nội dung tin nhắn của bạn..."
                                        rows="5"
                                        required style=" border: 0.55px solid white;"
                                    ></textarea>
                                </div>
                               
                                <div class="form-group uk-text-center uk-margin-medium-top" style="text-align: center;">
                                    <button type="submit" name="send" value="create" class="btn-submit" style="text-align: center;">
                                    <i class="fi-rs-paper-plane"></i>
                                    <span style="padding-left: 10px;">Gửi Ngay</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
               
                <!-- Google Map -->
                <div class="map-container uk-margin-large-bottom">
                    <h3 class="map-title uk-text-center">Địa chỉ làm việc</h3>
                    <div class="map-wrapper">
                        {!! $system['contact_map'] !!}
                    </div>
                </div>
            </div>        
        </div>
    </div>


<style>
/* Main Styles for Contact Page */
.contact-page {
    font-family: 'Roboto', sans-serif;
    color: #333;
}


/* Breadcrumb Styles */
.page-breadcrumb {
    background-color: #f8f9fa;
    padding: 15px 0;
    margin-bottom: 40px;
}


.page-breadcrumb ul {
    margin: 0;
    padding: 0;
}
/* Tất cả các input và textarea */
.form-control {
    background-color: transparent; /* Nền trong suốt */
    border: 1px solid white; /* Viền màu trắng */
    color: #7A95A1; /* Màu chữ khi nhập vào */
    padding: 10px; /* Khoảng cách bên trong */
    margin-bottom: 20px;
}


/* Placeholder màu #7A95A1 */
.form-control::placeholder {
    color: white;
    opacity: 1; /* Giảm độ đậm để phân biệt với nội dung nhập vào */
}


.page-breadcrumb li {
    display: inline-block;
    font-size: 14px;
}


.page-breadcrumb li:not(:last-child):after {
    content: ">";
    margin: 0 8px;
    color: #999;
}


.page-breadcrumb a {
    color: #666;
    text-decoration: none;
}


.page-breadcrumb a:hover {
    color:#7A95A1;
}


/* Section Title Styles */
.section-title {
    position: relative;
    margin-bottom: 40px;
}


.section-title .title {
    font-size: 32px;
    font-weight: 600;
    margin-bottom: 15px;
    color: #212529;
}


.section-title .divider {
    text-align: center;
    margin-top: 15px;
}


.section-title .divider .line {
    display: inline-block;
    width: 80px;
    height: 3px;
    background-color:#7A95A1;
}


/* Contact Container */
.contact-container {
    padding: 40px 0;
}


/* Contact Info Box */
.contact-info-box {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    height: 100%;
}


.contact-info-box .box-title {
    font-size: 24px;
    margin-bottom: 25px;
    color: #fff;
    position: relative;
    padding-bottom: 12px;
}




/* Contact Info Items */
.contact-info-list {
    margin: 0;
    padding: 0;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
}


.contact-info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 25px;
}


.contact-info-item .icon {
    margin-right: 15px;
    flex-shrink: 0;
}


.contact-info-item .icon i {
    color: #7A95A1;
    font-size: 18px;
}


.contact-info-item .content h4 {
    margin: 0 0 10px;
    font-size: 18px;
    font-weight: 500;
    color: #212529;
}


.contact-info-item .content p {
    margin: 0;
    color:  #212529;
    line-height: 1.6;
}


@media (max-width: 768px) {
    .contact-info-list {
        grid-template-columns: 1fr;
    }
}
/* Company Intro */
.company-intro .intro-title {
    font-size: 20px;
    margin-bottom: 15px;
    color: #212529;
}


.company-intro .intro-content {
    color: #6c757d;
    line-height: 1.8;
}


/* Social Links */
.social-links {
    display: flex;
}


.social-links .social-link {
    width: 36px;
    height: 36px;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: #6c757d;
    transition: all 0.3s ease;
}
.contact-form button{
    background-color: #7A95A1;
}
.social-links .social-link:hover {
    background-color:#7A95A1;
    color: #fff;
}
.contact-form{
    background-color: #BCD5E2;
    border: none;
}
/* Contact Form Box */
.contact-form-box {
    background-color:#BCD5E2;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    height: 100%;
}


.contact-form-box .box-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #212529;
    position: relative;
    padding-bottom: 12px;
}




.contact-form-box .form-description {
    color: #6c757d;
    margin-bottom: 25px;
}


/* Form Styles */
.form-group {
    margin-bottom: 20px;
}


.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: white;
}


.form-control {
    width: 100%;
    height: 48px;
    border-radius: 10px;
    padding: 0 15px;
    font-size: 14px;
    color: #495057;
    border: none;
    transition: all 0.3s ease;
}


.form-control:focus {
    border-color:#7A95A1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.15);
}


textarea.form-control {
    height: auto;
    padding: 15px;
    resize: vertical;
}


/* Submit Button */
.btn-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 48px;
    padding: 0 30px;
    font-size: 15px;
    font-weight: 500;
    color: #fff;
    background-color:#7A95A1;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s ease;
}


.btn-submit:hover {
    background-color:#7A95A1;
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(66, 133, 244, 0.3);
}


.btn-submit i {
    margin-left: 8px;
}


/* Map Container */
.map-container {
    background-color: #fff;
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
}


.map-container .map-title {
    font-size: 24px;
    margin-bottom: 25px;
    color: #212529;
}


.map-wrapper {
    border-radius: 10px;
    overflow: hidden;
    height: 400px;
}


.map-wrapper iframe {
    width: 100%;
    height: 100%;
    border: none;
}


/* Responsive Styles */
@media (max-width: 960px) {
    .contact-info-box, .contact-form-box {
        margin-bottom: 30px;
    }
}


@media (max-width: 768px) {
    .section-title .title {
        font-size: 28px;
    }
   
    .contact-info-box .box-title,
    .contact-form-box .box-title,
    .map-container .map-title {
        font-size: 22px;
    }
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const contactForm = document.querySelector('.contact-form');
   
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
           
            // Simple validation
            let valid = true;
            const fields = contactForm.querySelectorAll('[required]');
           
            fields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('error');
                } else {
                    field.classList.remove('error');
                }
            });
           
            if (valid) {
                // Show success message (replace with your actual form submission logic)
                alert('Thông tin của bạn đã được gửi thành công! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.');
                contactForm.reset();
            }
        });
    }
});
</script>
@endsection
