<?php
// 1. Nhúng db.php (db.php đã tự đọc .env và tạo sẵn biến $conn rồi)
require_once __DIR__ . '/db.php';

// 2. Khởi động session
session_start();
$user = $_SESSION['user'] ?? null;

// Xóa hoàn toàn các dòng $servername, $password, $dbname và $conn = new mysqli(...)
// Bây giờ bạn đã có sẵn biến $conn kết nối CSDL an toàn từ db.php để sử dụng!
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>THTRAVEL - Khám Phá Việt Nam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
<script src="https://dadevmikey.github.io/The-Holiday-Library/ChristmasOverlay.js"></script>

<script src="https://dadevmikey.github.io/The-Holiday-Library/NewYearsOverlay.js"></script> 

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<body>
    
<audio id="festiveMusic" loop>
   
    <source src="video/4.mp3" type="audio/mpeg"> 
    
    Your browser does not support the audio element.
</audio>
    
    <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3 text-success" href="index.php">
            <i class="fas fa-plane"></i> THTRAVEL
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#flash-sale">Nổi bật</a></li>
                <li class="nav-item"><a class="nav-link" href="#favorite-destinations-container">Điểm đến</a></li>
                <li class="nav-item"><a class="nav-link" href="#lienhe">Liên Hệ</a></li>
                <li class="nav-item"><a class="nav-link" href="#tintuc">Tin tức</a></li>
                <li class="nav-item position-relative">
                    <span id="toggleFestiveBtn" class="ms-2" style="font-size: 1.4rem; cursor: pointer;" title="Menu lễ hội">☰</span>
                    <div id="festiveMenu" class="position-absolute bg-white shadow rounded p-3" style="top: 100%; right: 0; min-width: 180px; display: none; z-index: 1050;">
                        <button id="toggleEffectsBtn" class="btn btn-outline-success w-100 mb-2">
                            <i class="fas fa-snowflake me-2"></i> Hiệu ứng: <span id="effectsStatus">BẬT</span>
                        </button>
                        <button id="toggleSoundBtn" class="btn btn-outline-primary w-100">
                            <i class="fas fa-volume-up me-2"></i> Âm thanh: <span id="soundStatus">BẬT</span>
                        </button>
                        <button id="toggleBrightnessBtn" class="btn btn-outline-warning w-100">
                            <i class="fas fa-sun me-2"></i> Độ sáng: <span id="brightnessStatus">BÌNH THƯỜNG</span>
                        </button>
                    </div>
                </li>
            </ul>
            <!-- Phần tài khoản / đăng nhập - ĐỘNG THEO ROLE -->
<div class="d-flex align-items-center ms-lg-4 mt-3 mt-lg-0 gap-2">
    <?php if ($user): ?>
        <!-- Đã đăng nhập: Hiện dropdown theo role -->
        <div class="dropdown">
            <button class="btn <?= $user['role'] === 'admin' ? 'btn-primary' : 'btn-success' ?> dropdown-toggle" 
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user me-2"></i>
                <?= htmlspecialchars($user['username']) ?>
                <?php if ($user['role'] === 'admin'): ?>
                    <span class="badge bg-danger ms-1">Admin</span>
                <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php if ($user['role'] === 'admin'): ?>
                    <!-- ===== MENU CHO ADMIN ===== -->
                    <li><h6 class="dropdown-header text-primary"><i class="fas fa-crown me-2"></i>Quản trị viên</h6></li>
                    <li><a class="dropdown-item" href="admin/dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a></li>
                    <li><a class="dropdown-item" href="admin/tours.php">
                        <i class="fas fa-map-marked-alt me-2"></i>Quản lý Tour
                    </a></li>
                    <li><a class="dropdown-item" href="admin/orders.php">
                        <i class="fas fa-shopping-cart me-2"></i>Quản lý Đơn hàng
                    </a></li>
                    <li><a class="dropdown-item" href="admin/customers.php">
                        <i class="fas fa-users me-2"></i>Quản lý Khách hàng
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="admin/settings.php">
                        <i class="fas fa-cog me-2"></i>Cài đặt
                    </a></li>
                <?php else: ?>
                    <!-- ===== MENU CHO CUSTOMER ===== -->
                    <li><h6 class="dropdown-header text-success"><i class="fas fa-user me-2"></i>Tài khoản</h6></li>
                    <li><a class="dropdown-item" href="customer/profile.php">
                        <i class="fas fa-user-circle me-2"></i>Hồ sơ cá nhân
                    </a></li>
                    <li><a class="dropdown-item" href="customer/orders.php">
                        <i class="fas fa-receipt me-2"></i>Đơn hàng của tôi
                    </a></li>
                    <li><a class="dropdown-item" href="customer/favorites.php">
                        <i class="fas fa-heart me-2"></i>Tour yêu thích
                    </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="customer/support.php">
                        <i class="fas fa-headset me-2"></i>Hỗ trợ
                    </a></li>
                <?php endif; ?>
                
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="auth/logout.php">
                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                </a></li>
            </ul>
        </div>
    <?php else: ?>
        <!-- Chưa đăng nhập: Hiện nút Đăng nhập + Đăng ký -->
        <a href="auth/login.php" class="btn btn-outline-success me-2">
            <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
        </a>
        <a href="auth/register.php" class="btn btn-success">
            <i class="fas fa-user-plus me-2"></i>Đăng ký
        </a>
    <?php endif; ?>
</div>
        </div>
    </div>
</nav>
    <!-- Hero with Video Background -->
    <section class="hero">
        <video class="video-bg" autoplay muted loop playsinline>
            <source src="video/hi.mp4" type="video/mp4">
            <!-- Video dự phòng nếu link trên không chạy -->
            <source src="https://assets.mixkit.co/videos/preview/12345/12345-large.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="video-overlay"></div>
        <div class="container h-100 d-flex align-items-center position-relative">
            <div class="row w-100">
                <div class="col-lg-8">
                    <p class="text-white mb-2">KHÁM PHÁ VIỆT NAM CÙNG CHÚNG TÔI</p>
                    <h1>HÃY CÙNG NHAU<br>KHÁM PHÁ VIỆT NAM</h1>
                    <p class="lead">Muốn đi nhanh hãy đi một mình.<br>Muốn đi xa hãy đi cùng THTRAVEL.</p>
                  
                    <div class="mt-4 d-flex gap-3 flex-wrap">
                        <a href="#" class="btn btn-success btn-lg px-5 py-3 rounded-pill">TRẢI NGHIỆM NGAY</a>
                        <a href="#" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">Xem video</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- -->
    <!-- SECTION: ĐỐI TÁC UY TÍN - Logo fix lỗi, hiện 100% -->
<section class="py-5 bg-light" id="cala-sale-partners">
    <div class="container text-center">
        <h2 class="display-6 fw-bold text-success mb-4">TH Travel - Hợp Tác Cùng Các Đối Tác Uy Tín</h2>
        <p class="lead text-muted mb-5">
            Chúng tôi đồng hành cùng những thương hiệu hàng đầu Việt Nam và quốc tế để mang đến trải nghiệm du lịch an toàn, tiện lợi và chất lượng cao nhất.
        </p>
      
        <div class="logo-marquee overflow-hidden position-relative">
            <div class="marquee-track d-flex animate-marquee">
            
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/02/Vietnam-Airlines-logo.jpg" alt="Vietnam Airlines" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/04/VietJet-Air-logo.png" alt="VietJet Air" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://mondialbrand.com/wp-content/uploads/2024/02/bamboo_airways-logo_brandlogos.net_xhqsu-1200x900.png" alt="Bamboo Airways" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/05/Booking.Com-logo.png" alt="Booking.com" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Agoda_logo_2019.svg/1280px-Agoda_logo_2019.svg.png" alt="Agoda" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/11/VISA-logo.png" alt="Visa" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://logos-world.net/wp-content/uploads/2024/12/MoMo-Logo-New.png" alt="MoMo" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://cdn.prod.website-files.com/6598f69d5c74962847bd6852/66674c8def62117b1bbbd28b_ZaloPay-ngang.png" alt="ZaloPay" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Icon-VNPAY-QR.png" alt="VNPAY" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://www.freelogovectors.net/wp-content/uploads/2023/10/shopeepay-logo-freelogovectors.net_.png" alt="ShopeePay" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2022/01/Lazada-Logo.png" alt="Lazada" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <!-- Duplicate để marquee chạy vòng lặp mượt -->
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/02/Vietnam-Airlines-logo.jpg" alt="Vietnam Airlines" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/04/VietJet-Air-logo.png" alt="VietJet Air" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://mondialbrand.com/wp-content/uploads/2024/02/bamboo_airways-logo_brandlogos.net_xhqsu-1200x900.png" alt="Bamboo Airways" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/05/Booking.Com-logo.png" alt="Booking.com" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/Agoda_logo_2019.svg/1280px-Agoda_logo_2019.svg.png" alt="Agoda" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2021/11/VISA-logo.png" alt="Visa" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://logos-world.net/wp-content/uploads/2024/12/MoMo-Logo-New.png" alt="MoMo" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://cdn.prod.website-files.com/6598f69d5c74962847bd6852/66674c8def62117b1bbbd28b_ZaloPay-ngang.png" alt="ZaloPay" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://cdn.haitrieu.com/wp-content/uploads/2022/10/Icon-VNPAY-QR.png" alt="VNPAY" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://www.freelogovectors.net/wp-content/uploads/2023/10/shopeepay-logo-freelogovectors.net_.png" alt="ShopeePay" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
                <div class="marquee-item flex-shrink-0 mx-3 mx-md-4">
                    <img src="https://1000logos.net/wp-content/uploads/2022/01/Lazada-Logo.png" alt="Lazada" class="img-fluid" style="height: 60px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>
</section>
   
    <script>
// Placeholder động cho điểm đến
const destinations = [
    "Hạ Long hùng vĩ",
    "Phú Quốc biển xanh",
    "Đà Nẵng cầu Rồng",
    "Sapa mùa lúa chín",
    "Nha Trang nắng vàng",
    "Cà Mau đất mũi cực Nam"
];
let index = 0;
const searchInput = document.querySelector('.search-box select.form-select'); // hoặc input nếu bạn đổi
if (searchInput) {
    setInterval(() => {
        index = (index + 1) % destinations.length;
        searchInput.options[0].text = `Tìm tour ${destinations[index]}...`;
    }, 4000); // chuyển mỗi 4 giây
}
</script>
   
    <!-- II. BANNER ƯU ĐÃI TẾT 2026 - 7 banner, cao 315x420, ban đầu 3 cái, auto chuyển 3s -->
    <!-- II. Banner Tết (load động) -->
    <section class="promo-tet py-4 bg-white">
    <div class="container">
      
        <div id="tetPromoCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <!-- Slide 1: Banner 1-3 (hiển thị ban đầu) -->
                <div class="carousel-item active">
                    <div class="row g-4 justify-content-center">
                        <!-- Banner 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=420&h=315" class="d-block w-100" alt="Tet Promo 1" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">MẸ TẾT SẴN SÀNG</h5>
                                        <p class="small mb-1">Nhập mã <strong>VTR100</strong></p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM 100.000 VNĐ</p>
                                        <p class="tiny mb-2">Áp dụng trong nước</p>
                                        <small>Từ 1/1 - 14/2/2026</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Banner 2 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.pexels.com/photos/29093891/pexels-photo-29093891.jpeg?auto=compress&cs=tinysrgb&w=420&h=315" class="d-block w-100" alt="Tet Promo 2" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">THƯỞNG LÂM QUỐC TẾ</h5>
                                        <p class="small mb-1">Nhập mã <strong>VTR200</strong></p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM 200.000 VNĐ</p>
                                        <p class="tiny mb-2">Quốc tế & visa</p>
                                        <small>Tại app & website</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Banner 3 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="anhgioithieu/1.png" class="d-block w-100" alt="Tet Promo 3" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">KHÁM PHÁ CHÂU ÂU & MỸ</h5>
                                        <p class="small mb-1">Nhập mã <strong>VTR500</strong></p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM 500.000 VNĐ</p>
                                        <p class="tiny mb-2">Booking sớm</p>
                                        <small>Hotline 1800 646 888</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 2: Banner 4-6 (chuyển sau 3s) -->
                <div class="carousel-item">
                    <div class="row g-4 justify-content-center">
                        <!-- Banner 4 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=420&h=315" class="d-block w-100" alt="Tet Promo 4" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">ƯU ĐÃI ĐOÀN VIÊN</h5>
                                        <p class="small mb-1">Mua nhóm lớn</p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM ĐẾN 3 TRIỆU / KHÁCH</p>
                                        <small>Tết Nguyên Đán 2026</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Banner 5 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=420&h=315" class="d-block w-100" alt="Tet Promo 5" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">TẾT GẦN KẾT</h5>
                                        <p class="small mb-1">Quà Tết + boardgame</p>
                                        <p class="fs-6 fw-bold text-warning mb-0">ĐẶT NGAY KHÔNG BỎ LỠ</p>
                                        <small>travel.com.vn</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Banner 6 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.pexels.com/photos/29093891/pexels-photo-29093891.jpeg?auto=compress&cs=tinysrgb&w=420&h=315" class="d-block w-100" alt="Tet Promo 6" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">ƯU ĐÃI KÈO BÃO</h5>
                                        <p class="small mb-1">Tour nội địa giảm sâu</p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM 2 TRIỆU / KHÁCH</p>
                                        <small>Từ nay đến 18/2/2026</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Slide 3: Banner 7 + lặp 1-2 (để đủ 7 và loop mượt) -->
                <div class="carousel-item">
                    <div class="row g-4 justify-content-center">
                        <!-- Banner 7 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="anhgioithieu/5.png" class="d-block w-100" alt="Tet Promo 7" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">TẾT VI VU NƯỚC NGOÀI</h5>
                                        <p class="small mb-1">Nhập mã đặc biệt</p>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM THÊM + QUÀ TẾT</p>
                                        <small>Châu Á & Châu Âu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lặp Banner 1 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.unsplash.com/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&q=80&w=420&h=315" class="d-block w-100" alt="Tet Promo 1 repeat" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">MẸ TẾT SẴN SÀNG</h5>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM 100.000 - 500.000 VNĐ</p>
                                        <small>Nhập VTR series</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Lặp Banner 4 -->
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-tet position-relative rounded-3 overflow-hidden shadow">
                                <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&q=80&w=420&h=315" class="d-block w-100" alt="Tet Promo 4 repeat" style="height: 315px; width: 420px; object-fit: cover;">
                                <div class="banner-overlay-tet d-flex align-items-center justify-content-center text-center text-white">
                                    <div class="p-3">
                                        <h5 class="fw-bold fs-5 mb-2">ƯU ĐÃI ĐOÀN VIÊN</h5>
                                        <p class="fs-6 fw-bold text-warning mb-0">GIẢM ĐẾN 3 TRIỆU</p>
                                        <small>Nhóm từ 4 người</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Indicators (chấm nhỏ) -->
            <div class="carousel-indicators mt-4">
                <button type="button" data-bs-target="#tetPromoCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#tetPromoCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#tetPromoCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
  
    <!-- Popular Destinations -->
  
            <div class="row g-4" id="destinations">
                <!-- Cards sẽ được JS thêm vào hoặc bạn copy 4 card như bên dưới -->
            </div>
        </div>
        <div class="text-center" style="margin-top: 50px; margin-bottom: 10px;">
          
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
    <!-- Script fade-in cho phần Điểm đến yêu thích (tự động add .show) -->
    <script>
        // Chờ trang load xong
        window.addEventListener('load', function() {
            const grids = document.querySelectorAll('.destinations-grid');
            grids.forEach(grid => {
                grid.classList.add('show');
            });
        });
        // Nếu muốn animation mỗi khi switch tab (tùy chọn nâng cao)
        const tabButtons = document.querySelectorAll('#regionTabs .nav-link');
        tabButtons.forEach(btn => {
            btn.addEventListener('shown.bs.tab', function() {
                const target = document.querySelector(this.getAttribute('data-bs-target'));
                const grid = target.querySelector('.destinations-grid');
                if (grid) {
                    grid.classList.remove('show'); // reset để animate lại
                    setTimeout(() => grid.classList.add('show'), 50);
                }
            });
        });
    </script>
    <!-- III. ĐANG SALE - Flash Sale Style -->
<section id="flash-sale" class="py-5" style="background: #f0f8ff;">
    <div class="container">
        <div class="text-left mb-4">
            <h2 class="display-5 fw-bold text-danger">ƯU ĐÃI CỰC SỐC!</h2>
            <p class="lead text-muted fw-bold">
                Nhanh tay nắm bắt cơ hội giảm giá cuối cùng. Đặt ngay để không bỏ lỡ!
            </p>
        </div>
        <div class="row g-3">
           <!-- Card 1: mũi cà mau - cực nam tổ quốc -->
<div class="col-lg-3 col-md-6">
    <!-- Thẻ <a> bao quanh toàn bộ card để click bất kỳ đâu (trừ nút) đều chuyển trang -->
    <a href="tour-detail.php?id=mui-ca-mau" class="card-link text-decoration-none text-dark">
        <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4 h-100">
            <img src="anhsale/1.png" class="card-img-top" alt="Mũi Cà Mau" style="height: 220px; object-fit: cover;">
            
            <div class="position-absolute top-0 end-0 m-2">
                <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
            </div>
            
            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-bolt text-warning"></i>
                    <span class="fw-bold">Giờ chót</span>
                    <span class="countdown text-danger fw-bold" data-end-time="2026-12-05T23:59:59">Đang tính...</span>
                </div>
            </div>

            <div class="card-body bg-white">
                <h6 class="card-title fw-bold">Mũi Cà Mau – Điểm cực Nam Tổ quốc (5 sao, Biển đẹp)</h6>
                <div class="mt-2 small">
                    <i class="bi bi-aspect-ratio-fill text-success"></i> NNNSGN161-013-310127VJ-V-LF<br>
                    <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                    <i class="bi bi-calendar-week-fill text-success"></i> Ngày 31/01/2027<br>
                    <div class="mt-2 small d-flex align-items-center gap-3 flex-wrap">
                        <div><i class="bi bi-alarm-fill text-success"></i> 6N5Đ</div>
                        <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 9 chỗ</span>
                    </div>
                </div>
                
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <del class="text-muted small">6.990.000 đ</del><br>
                        <span class="fs-5 fw-bold text-danger">5.990.000 đ</span>
                    </div>
                    
                    <!-- Đổi <a> thành <button> để không lồng thẻ <a> trong <a> và không chuyển trang khi bấm -->
                    <button type="button" 
        onclick="window.location.href='tour-detail.php?id=mui-ca-mau'"
        class="btn btn-outline-danger btn-sm px-4 open-detail">
    Đặt ngay
</button>
                </div>
            </div>
        </div>
    </a>
</div>
            <!-- Card 2: Cánh đồng điện gió Bạc Liêu -->
            <div class="col-lg-3 col-md-6">
                <a href="tour-detail.php?id=canh-dong-gio-bac-lieu" class="card-link text-decoration-none text-dark">
                <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
                    <img src="anhsale/2.png" class="card-img-top" alt="Sapa" style="height: 220px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-bolt text-warning"></i>
                            <span class="countdown text-danger fw-bold" data-end-time="2027-02-27T23:59:59">Đang tính...</span>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <h6 class="card-title fw-bold">Cánh đồng điện gió Bạc Liêu - Thư giãn loại bỏ âu lo</h6>
                        <div class="mt-2 small">
                            <i class="bi bi-aspect-ratio-fill text-success"></i> NNNSGN161-013-310127VJ-V-KF<br>
                            <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: Hà Nội/TP.HCM<br>
                            <i class="bi bi-calendar-week-fill text-success"></i> Hàng tuần<br>
                            <div class="mt-2 small d-flex gap-3 flex-wrap">
                                <div><i class="bi bi-alarm-fill text-success"></i> 3N2D</div>
                                <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 7 chỗ</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <del class="text-muted small">2.490.000 đ</del><br>
                                <span class="fs-5 fw-bold text-danger">1.890.000 đ</span>
                            </div>
                             <a href="tour-detail.php?id=canh-dong-gio-bac-lieu"
                       onclick="event.stopPropagation();"
                       class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </a>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <!-- Card 3: vườn quốc gia u minh hạ -->
            <div class="col-lg-3 col-md-6">
                <a href="tour-detail.php?id=vuon-quoc-gia-u-minh-ha" class="card-link text-decoration-none text-dark">
                <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
                    <img src="anhsale/3.png" class="card-img-top" alt="Phú Quốc" style="height: 220px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-bolt text-warning"></i>
                            <span class="countdown text-danger fw-bold" data-end-time="2076-02-23T23:59:59">Đang tính...</span>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <h6 class="card-title fw-bold">Vườn Quốc gia U Minh Hạ - hoà mình với thiên nhiên</h6>
                        <div class="mt-2 small">
                            <i class="bi bi-aspect-ratio-fill text-success"></i> UMHSGN178-009-280227VN-FGGF<br>
                            <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                            <i class="bi bi-calendar-week-fill text-success"></i> Tháng 2-3/2026<br>
                            <div class="mt-2 small d-flex gap-3 flex-wrap">
                                <div><i class="bi bi-alarm-fill text-success"></i> 3N2D</div>
                                <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 8 chỗ</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <del class="text-muted small">4.990.000 đ</del><br>
                                <span class="fs-5 fw-bold text-danger">3.990.000 đ</span>
                            </div>
                            
                             <a href="tour-detail.php?id=vuon-quoc-gia-u-minh-ha"
                       onclick="event.stopPropagation();"
                       class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </a>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <!-- Card 4: Hòn đá bạc - độc đáo giữa hoang sơ nơi biển trời -->
            <div class="col-lg-3 col-md-6">
            <a href="tour-detail.php?id=hon-da-bac" class="card-link text-decoration-none text-dark">
                <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
                    <img src="anhsale/4.png" class="card-img-top" alt="Đà Nẵng" style="height: 220px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-bolt text-warning"></i>
                            <span class="countdown text-danger fw-bold" data-end-time="2027-02-19T23:59:59">Đang tính...</span>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <h6 class="card-title fw-bold">Hòn Đá Bạc - độc đáo với vẻ đẹp hoang sơ giữa biển trời</h6>
                        <div class="mt-2 small">
                            <i class="bi bi-aspect-ratio-fill text-success"></i> UMHSGN178-009-280227VN-BBFF<br>
                            <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                            <i class="bi bi-calendar-week-fill text-success"></i> Tháng 2-3/2026<br>
                            <div class="mt-2 small d-flex gap-3 flex-wrap">
                                <div><i class="bi bi-alarm-fill text-success"></i> 3N2D</div>
                                <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 11 chỗ</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <del class="text-muted small">5.990.000 đ</del><br>
                                <span class="fs-5 fw-bold text-danger">4.490.000 đ</span>
                            </div>
                           <button type="button"
                            onclick="window.location.href='tour-detail.php?id=hon-da-bac'"
                            class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </button>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <!-- Card 5: Nhà hát Cao Văn Lầu -->
            <div class="col-lg-3 col-md-6">
            <a href="tour-detail.php?id=nha-hat-cao-van-lau" class="card-link text-decoration-none text-dark">    
                <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
                    <img src="anhsale/5.png" class="card-img-top" alt="Hạ Long" style="height: 220px; object-fit: cover;">
                    <div class="position-absolute top-0 end-0 m-2">
                        <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
                    </div>
                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <i class="fas fa-bolt text-warning"></i>
                            <span class="countdown text-danger fw-bold" data-end-time="2028-02-19T23:59:59">Đang tính...</span>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <h6 class="card-title fw-bold">Nhà hát Cao Văn Lầu - văn hóa gắn liền với nghệ thuật Đờn ca tài tử</h6>
                        <div class="mt-2 small">
                            <i class="bi bi-aspect-ratio-fill text-success"></i> UMHSGN178-009-280227VNF<br>
                            <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                            <i class="bi bi-calendar-week-fill text-success"></i> Tháng 2-5/2027<br>
                            <div class="mt-2 small d-flex gap-3 flex-wrap">
                                <div><i class="bi bi-alarm-fill text-success"></i> 5N2D</div>
                                <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 12 chỗ</span>
                            </div>
                        </div>
                      
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <div>
                                <del class="text-muted small">5.990.000 đ</del><br>
                                <span class="fs-5 fw-bold text-danger">3.290.000 đ</span>
                            </div>
                            <button type="button"
                            onclick="window.location.href='tour-detail.php?id=nha-hat-cao-van-lau'"
                            class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </button>
                        </div>
                    </div>
                </div>
                </a>
            </div>
            <!-- Card 6: biển đất mũi -->
            <!-- Card 6: Biển Đất Mũi -->
<div class="col-lg-3 col-md-6">
    <a href="tour-detail.php?id=bien-dat-mui" class="card-link text-decoration-none text-dark">
        <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4 h-100">
            <img src="anhsale/6.png" class="card-img-top" alt="Biển Đất Mũi" style="height: 220px; object-fit: cover;">
            
            <div class="position-absolute top-0 end-0 m-2">
                <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
            </div>
            
            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-bolt text-warning"></i>
                    <span class="fw-bold">Flash Sale</span>
                    <span class="countdown text-danger fw-bold" data-end-time="2027-04-10T23:59:59">Đang tính...</span>
                </div>
            </div>

            <div class="card-body bg-white">
                <h6 class="card-title fw-bold">Biển Đất Mũi - Duy nhất Việt Nam nhìn ra cả biển Đông và biển Tây</h6>
                <div class="mt-2 small">
                    <i class="bi bi-aspect-ratio-fill text-success"></i> BDM2026006<br>
                    <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                    <i class="bi bi-calendar-week-fill text-success"></i> Từ 01/04/2026<br>
                    <div class="mt-2 small d-flex align-items-center gap-3 flex-wrap">
                        <div><i class="bi bi-alarm-fill text-success"></i> 3N2Đ</div>
                        <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 12 chỗ</span>
                    </div>
                </div>
                
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <del class="text-muted small">4.990.000 đ</del><br>
                        <span class="fs-5 fw-bold text-danger">3.290.000 đ</span>
                    </div>
                    
                    <button type="button"
                            onclick="window.location.href='tour-detail.php?id=bien-dat-mui'"
                            class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>  <!-- thẻ div đóng đúng, có dấu > -->
            <!-- Card 7: cánh đồng muối bạc liêu -->
            <!-- Card 7: Cánh đồng muối Bạc Liêu -->
<div class="col-lg-3 col-md-6">
    <a href="tour-detail.php?id=canh-dong-muoi-bac-lieu" class="card-link text-decoration-none text-dark">
        <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
            <img src="anhsale/7.png" class="card-img-top" alt="Cánh đồng muối Bạc Liêu" style="height: 220px; object-fit: cover;">
            <div class="position-absolute top-0 end-0 m-2">
                <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
            </div>
            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-bolt text-warning"></i>
                    <span class="countdown text-danger fw-bold" data-end-time="2027-03-20T23:59:59">Đang tính...</span>
                </div>
            </div>
            <div class="card-body bg-white">
                <h6 class="card-title fw-bold">Cánh đồng muối Bạc Liêu - Nét đẹp lao động mộc mạc của diêm dân</h6>
                <div class="mt-2 small">
                    <i class="bi bi-aspect-ratio-fill text-success"></i> CDM2026007<br>
                    <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                    <i class="bi bi-calendar-week-fill text-success"></i> Từ 10/03/2026<br>
                    <div class="mt-2 small d-flex gap-3 flex-wrap">
                        <div><i class="bi bi-alarm-fill text-success"></i> 3N2Đ</div>
                        <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 15 chỗ</span>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <del class="text-muted small">3.990.000 đ</del><br>
                        <span class="fs-5 fw-bold text-danger">1.290.000 đ</span>
                    </div>
                    <button type="button"
                            onclick="window.location.href='tour-detail.php?id=canh-dong-muoi-bac-lieu'"
                            class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>
            <!-- Card 8: biển Khai Long -->
            <!-- Card 8: Bãi biển Khai Long -->
<div class="col-lg-3 col-md-6">
    <a href="tour-detail.php?id=bai-bien-khai-long" class="card-link text-decoration-none text-dark">
        <div class="card flash-card border-0 shadow position-relative overflow-hidden rounded-4">
            <img src="anhsale/8.png" class="card-img-top" alt="Bãi biển Khai Long" style="height: 220px; object-fit: cover;">
            <div class="position-absolute top-0 end-0 m-2">
                <i class="fas fa-heart text-white bg-dark bg-opacity-50 p-2 rounded-circle fs-5"></i>
            </div>
            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-60 text-white p-2 text-center">
                <div class="d-flex align-items-center justify-content-center gap-2">
                    <i class="fas fa-bolt text-warning"></i>
                    <span class="countdown text-danger fw-bold" data-end-time="2027-04-25T23:59:59">Đang tính...</span>
                </div>
            </div>
            <div class="card-body bg-white">
                <h6 class="card-title fw-bold">Bãi biển Khai Long - Nét đẹp hoang sơ hùng vĩ cực nam tổ quốc</h6>
                <div class="mt-2 small">
                    <i class="bi bi-aspect-ratio-fill text-success"></i> KHL2026008<br>
                    <i class="bi bi-geo-alt-fill text-success"></i> Khởi hành: TP. Hồ Chí Minh<br>
                    <i class="bi bi-calendar-week-fill text-success"></i> Từ 15/04/2026<br>
                    <div class="mt-2 small d-flex gap-3 flex-wrap">
                        <div><i class="bi bi-alarm-fill text-success"></i> 3N2Đ</div>
                        <span class="bi bi-people-fill text-danger tour-people badge-extra-space fw-bold">Còn 10 chỗ</span>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div>
                        <del class="text-muted small">5.990.000 đ</del><br>
                        <span class="fs-5 fw-bold text-danger">5.290.000 đ</span>
                    </div>
                    <button type="button"
                            onclick="window.location.href='tour-detail.php?id=bai-bien-khai-long'"
                            class="btn btn-outline-danger btn-sm px-4 open-detail">
                        Đặt ngay
                    </button>
                </div>
            </div>
        </div>
    </a>
</div>
<div class="text-center" style="margin-top: 50px; margin-bottom: 10px;">
            <a href="#" class="fancy-btn">Xem tất cả</a>
        </div>
</section>
      
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  
  
     <!-- IIIPlaceholder cho phần Điểm đến yêu thích -->
    <div id="favorite-destinations-container"></div>
<section class="why-choose-thtravel py-5" aria-labelledby="why-title">
    <style>
        .why-choose-thtravel{--why-green:#16845b;--why-ink:#17352c;--why-muted:#687a73;background:linear-gradient(180deg,#f4faf6 0%,#fff 100%)}
        .why-choose-thtravel .why-shell{max-width:1120px;margin:auto}
        .why-choose-thtravel .why-eyebrow{color:var(--why-green);font-size:.78rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase}
        .why-choose-thtravel .section-title{max-width:700px;margin:8px auto 12px;color:var(--why-ink);font-size:clamp(2rem,4vw,3rem);font-weight:800;letter-spacing:-.04em;text-align:center}
        .why-choose-thtravel .why-intro{max-width:650px;margin:0 auto;color:var(--why-muted);text-align:center;line-height:1.75}
        .why-choose-thtravel .camau-gallery{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:14px;margin:30px auto 8px;max-width:1000px}
        .why-choose-thtravel .camau-photo{position:relative;min-height:155px;overflow:hidden;border-radius:17px;background:#dcebe2;box-shadow:0 8px 22px rgba(24,63,44,.09)}
        .why-choose-thtravel .camau-photo img{width:100%;height:175px;object-fit:cover;display:block;transition:transform .45s ease}
        .why-choose-thtravel .camau-photo:hover img{transform:scale(1.05)}
        .why-choose-thtravel .camau-photo::after{content:"";position:absolute;inset:35% 0 0;background:linear-gradient(transparent,rgba(9,34,25,.72))}
        .why-choose-thtravel .camau-photo figcaption{position:absolute;z-index:1;bottom:13px;left:14px;color:#fff;font-size:.9rem;font-weight:750}
        .why-choose-thtravel .tabs{display:grid!important;grid-template-columns:repeat(4,minmax(0,1fr));gap:10px!important;margin:34px auto 18px;max-width:1000px}
        .why-choose-thtravel .tab-btn{display:flex;align-items:center;gap:10px;min-height:58px;padding:12px 14px;border:1px solid #e1ebe5;border-radius:14px;background:#fff;color:#42574d;font-size:.9rem;font-weight:700;text-align:left;transition:all .2s ease}
        .why-choose-thtravel .tab-btn .why-tab-icon{display:grid;place-items:center;width:34px;height:34px;flex:0 0 34px;border-radius:10px;background:#edf7f1;color:var(--why-green)}
        .why-choose-thtravel .tab-btn:hover,.why-choose-thtravel .tab-btn.active{border-color:var(--why-green);background:var(--why-green);color:#fff;box-shadow:0 8px 20px rgba(22,132,91,.16);transform:translateY(-1px)}
        .why-choose-thtravel .tab-btn:hover .why-tab-icon,.why-choose-thtravel .tab-btn.active .why-tab-icon{background:rgba(255,255,255,.16);color:#fff}
        .why-choose-thtravel .tab-content{max-width:1000px;margin:auto;padding:clamp(22px,4vw,42px);border:1px solid #e6eee8;border-radius:24px;background:#fff;box-shadow:0 18px 50px rgba(24,63,44,.07)}
        .why-choose-thtravel .tab-panel{display:none;animation:whyFade .28s ease}
        .why-choose-thtravel .tab-panel.active{display:block}
        .why-choose-thtravel .why-panel-grid{display:grid;grid-template-columns:minmax(0,1.4fr) minmax(220px,.8fr);gap:32px;align-items:center}
        .why-choose-thtravel .why-panel-icon{display:grid;place-items:center;width:58px;height:58px;margin-bottom:18px;border-radius:18px;background:#eaf6ef;color:var(--why-green);font-size:1.5rem}
        .why-choose-thtravel .tab-panel h3{margin:0 0 12px;color:var(--why-ink);font-size:clamp(1.35rem,2.5vw,1.8rem);font-weight:800;letter-spacing:-.025em}
        .why-choose-thtravel .tab-panel p{margin:0;color:var(--why-muted);line-height:1.8}
        .why-choose-thtravel .why-points{display:grid;gap:12px;padding:20px;border-radius:18px;background:#f5faf6}
        .why-choose-thtravel .why-point{display:flex;align-items:flex-start;gap:11px;color:#354a40;font-size:.93rem;line-height:1.55}
        .why-choose-thtravel .why-point i{margin-top:3px;color:var(--why-green)}
        @keyframes whyFade{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}
        @media(max-width:767.98px){.why-choose-thtravel .camau-gallery{grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.why-choose-thtravel .camau-photo img{height:145px}.why-choose-thtravel .tabs{grid-template-columns:repeat(2,minmax(0,1fr))}.why-choose-thtravel .tab-btn{font-size:.82rem;padding:9px;gap:7px}.why-choose-thtravel .tab-btn .why-tab-icon{width:30px;height:30px;flex-basis:30px}.why-choose-thtravel .why-panel-grid{grid-template-columns:1fr;gap:22px}}
        @media(max-width:380px){.why-choose-thtravel .tabs{grid-template-columns:1fr}}
        @media(prefers-reduced-motion:reduce){.why-choose-thtravel *, .why-choose-thtravel *::before,.why-choose-thtravel *::after{animation-duration:.01ms!important;transition-duration:.01ms!important}}
    </style>
    <div class="container why-shell">
        <div class="text-center">
            <div class="why-eyebrow">Hành trình an tâm, trải nghiệm trọn vẹn</div>
            <h2 id="why-title" class="section-title">Vì sao du khách chọn <span style="color:#16845b">THTravel</span>?</h2>
            <p class="why-intro">Từ rừng tràm U Minh Hạ đến Đất Mũi nơi cuối trời Tổ quốc, THTravel đưa bạn chạm vào vẻ đẹp mộc mạc, hào sảng và giàu sức sống của Cà Mau — với hành trình được chăm chút từ lúc khởi hành đến khi trở về.</p>
        </div>
        <div class="camau-gallery" aria-label="Khám phá cảnh đẹp Cà Mau">
            <figure class="camau-photo mb-0"><img src="assets/camau/u-minh-ha.jpg" alt="Rừng tràm và dòng kênh xanh ở U Minh Hạ" loading="lazy"><figcaption>Rừng U Minh Hạ</figcaption></figure>
            <figure class="camau-photo mb-0"><img src="assets/camau/dat-mui.jpg" alt="Thiên nhiên vùng Đất Mũi Cà Mau" loading="lazy"><figcaption>Đất Mũi Cà Mau</figcaption></figure>
            <figure class="camau-photo mb-0"><img src="assets/camau/camau-xanh.jpg" alt="Không gian xanh miền đất cực Nam" loading="lazy"><figcaption>Miền xanh cực Nam</figcaption></figure>
            <figure class="camau-photo mb-0"><img src="assets/camau/dien-gio.jpg" alt="Cánh đồng điện gió bên biển miền Tây" loading="lazy"><figcaption>Gió biển phương Nam</figcaption></figure>
        </div>
        <div class="tabs" role="tablist" aria-label="Lợi ích khi chọn THTravel">
            <button class="tab-btn active" id="why-tab-1" role="tab" aria-selected="true" aria-controls="tab-1" data-tab="1"><span class="why-tab-icon"><i class="fas fa-map-marked-alt"></i></span>Tour đa dạng</button>
            <button class="tab-btn" id="why-tab-2" role="tab" aria-selected="false" aria-controls="tab-2" data-tab="2"><span class="why-tab-icon"><i class="fas fa-tags"></i></span>Giá minh bạch</button>
            <button class="tab-btn" id="why-tab-3" role="tab" aria-selected="false" aria-controls="tab-3" data-tab="3"><span class="why-tab-icon"><i class="fas fa-route"></i></span>Lịch trình tối ưu</button>
            <button class="tab-btn" id="why-tab-4" role="tab" aria-selected="false" aria-controls="tab-4" data-tab="4"><span class="why-tab-icon"><i class="fas fa-headset"></i></span>Hỗ trợ tận tâm</button>
            <button class="tab-btn" id="why-tab-5" role="tab" aria-selected="false" aria-controls="tab-5" data-tab="5"><span class="why-tab-icon"><i class="fas fa-star"></i></span>Chất lượng chuẩn</button>
            <button class="tab-btn" id="why-tab-6" role="tab" aria-selected="false" aria-controls="tab-6" data-tab="6"><span class="why-tab-icon"><i class="fas fa-gift"></i></span>Ưu đãi hấp dẫn</button>
            <button class="tab-btn" id="why-tab-7" role="tab" aria-selected="false" aria-controls="tab-7" data-tab="7"><span class="why-tab-icon"><i class="fas fa-shield-alt"></i></span>An toàn trên hết</button>
            <button class="tab-btn" id="why-tab-8" role="tab" aria-selected="false" aria-controls="tab-8" data-tab="8"><span class="why-tab-icon"><i class="fas fa-comments"></i></span>Khách hàng tin chọn</button>
        </div>
       
    </div>
   
</section>
<!-- PHẦN LIÊN HỆ - ĐẸP MẮT -->
<section id = "lienhe" class="contact-section py-5 bg-light" style="background: #f0f8ff;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5">
                    <h2 class="display-5 fw-bold text-success">LIÊN HỆ VỚI THTRAVEL</h2>
                    <p class="lead text-muted">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7. Hãy gửi yêu cầu để nhận tư vấn miễn phí!</p>
                </div>
                <div class="row g-5">
                    <!-- Cột trái: Thông tin liên hệ + Map (tùy chọn) -->
                    <div class="col-lg-5">
                        <div class="contact-info bg-white p-4 rounded-4 shadow h-100">
                            <h4 class="fw-bold text-success mb-4">Thông tin liên hệ</h4>
                            <ul class="list-unstyled contact-list">
                                <li class="mb-4">
                                    <i class="fas fa-map-marker-alt text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Địa chỉ:</strong><br>
                                        123 Đường Nguyễn Văn Cừ, Quận Ninh Kiều, Cần Thơ
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <i class="fas fa-phone-alt text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Hotline / Zalo:</strong><br>
                                        0909 123 456 (24/7)
                                    </div>
                                </li>
                                <li class="mb-4">
                                    <i class="fas fa-envelope text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Email:</strong><br>
                                        info@thtravel.vn
                                    </div>
                                </li>
                                <li>
                                    <i class="fas fa-clock text-success fs-4 me-3"></i>
                                    <div>
                                        <strong>Giờ làm việc:</strong><br>
                                        8:00 - 21:00 (Hàng ngày)
                                    </div>
                                </li>
                            </ul>
                            <!-- Social icons -->
                            <div class="mt-4">
                                <h6 class="fw-bold mb-3">Kết nối ngay:</h6>
                                <div class="d-flex gap-3">
                                    <a href="#" class="footer-social" style="background: #1877F2;"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#" class="footer-social" style="background: linear-gradient(45deg, #f09433, #e6683c, #dc2743, #cc2366, #bc1888);"><i class="fab fa-instagram"></i></a>
                                    <a href="#" class="footer-social" style="background: #000;"><i class="fab fa-tiktok"></i></a>
                                    <a href="#" class="footer-social" style="background: #FF0000;"><i class="fab fa-youtube"></i></a>
                                    <a href="#" class="footer-social" style="background: #0068FF;"><span style="font-weight: bold; font-size: 1.4rem;">Z</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Cột phải: Form liên hệ -->
                    <div class="col-lg-7">
                        <div class="contact-form bg-white p-4 p-lg-5 rounded-4 shadow">
                            <form id="contactForm" novalidate>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" required placeholder="Nhập họ tên của bạn">
                                        <div class="invalid-feedback">Vui lòng nhập họ tên.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="tel" class="form-control form-control-lg" id="phone" name="phone" required placeholder="Ví dụ: 0909123456">
                                        <div class="invalid-feedback">Vui lòng nhập số điện thoại hợp lệ.</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control form-control-lg" id="email" name="email" required placeholder="email@thtravel.vn">
                                        <div class="invalid-feedback">Vui lòng nhập email hợp lệ.</div>
                                    </div>
                                    <div class="col-12">
                                        <label for="message" class="form-label fw-bold">Nội dung yêu cầu <span class="text-danger">*</span></label>
                                        <textarea class="form-control form-control-lg" id="message" name="message" rows="5" required placeholder="Bạn cần tư vấn tour nào? (Cà Mau, Đất Mũi, Bạc Liêu...)"></textarea>
                                        <div class="invalid-feedback">Vui lòng nhập nội dung yêu cầu.</div>
                                    </div>
                                    <!-- Nút gửi -->
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-lg px-5 py-3 rounded-pill fw-bold" id="submitBtn">
                                            <i class="fas fa-paper-plane me-2"></i> GỬI YÊU CẦU
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <!-- Thông báo thành công / lỗi -->
                            <div id="formMessage" class="mt-4 alert d-none" role="alert"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
          
            btn.classList.add('active');
            document.getElementById(`tab-${btn.dataset.tab}`).classList.add('active');
        });
    });
</script>
<!-- VII. BLOG / TIN TỨC DU LỊCH NGẮN -->
<section class="blog-section py-5 bg-white">
    <div class="container">
        <div class="text-center mb-5">
            <h2 id="tintuc" class="display-5 fw-bold text-success">Tin tức & Blog du lịch</h2>
            <p class="lead text-muted">Cập nhật kinh nghiệm, mẹo hay và những điểm đến hot nhất từ THTRAVEL</p>
        </div>
        <div class="row g-4">
            <!-- Bài 1 -->
            <div class="col-lg-3 col-md-6">
                <div class="blog-card position-relative overflow-hidden rounded-4 shadow-sm h-100 transition-all">
                    <div class="blog-img position-relative">
                        <img src="https://vemekong.com/wp-content/uploads/2022/06/ca-mau-cape-national-park-mekong-delta-vietnam-54a-1024x768.jpg"
                             class="img-fluid w-100" alt="Rừng ngập mặn Năm Căn"
                             style="height: 220px; object-fit: cover;">
                        <div class="blog-overlay position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-end p-3">
                            <span class="badge bg-success text-white px-3 py-2">Mẹo du lịch</span>
                        </div>
                    </div>
                    <div class="blog-content p-4 bg-white">
                        <small class="text-muted d-block mb-2"><i class="far fa-calendar-alt me-2"></i>08/02/2026</small>
                        <h5 class="fw-bold mb-3 blog-title">Khám phá Rừng ngập mặn Năm Căn – Lá phổi xanh cực Nam</h5>
                        <p class="text-muted small mb-3 line-clamp-3">
                            Rừng ngập mặn Năm Căn là nơi lý tưởng để trải nghiệm hệ sinh thái độc đáo, chèo thuyền khám phá kênh rạch và ngắm chim di cư...
                        </p>
                        <a href="blog-detail.html?id=nam-can" class="btn btn-outline-success btn-sm stretched-link">
                            Đọc thêm <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bài 2 -->
            <div class="col-lg-3 col-md-6">
                <div class="blog-card position-relative overflow-hidden rounded-4 shadow-sm h-100 transition-all">
                    <div class="blog-img position-relative">
                        <img src="https://vemekong.com/wp-content/uploads/2022/06/bac-lieu-wind-farm-9a.jpg"
                             class="img-fluid w-100" alt="Cánh đồng điện gió Bạc Liêu"
                             style="height: 220px; object-fit: cover;">
                        <div class="blog-overlay position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-end p-3">
                            <span class="badge bg-primary text-white px-3 py-2">Check-in hot</span>
                        </div>
                    </div>
                    <div class="blog-content p-4 bg-white">
                        <small class="text-muted d-block mb-2"><i class="far fa-calendar-alt me-2"></i>05/02/2026</small>
                        <h5 class="fw-bold mb-3 blog-title">Cánh đồng điện gió Bạc Liêu – Bình minh và hoàng hôn đẹp mê hồn</h5>
                        <p class="text-muted small mb-3 line-clamp-3">
                            Với hàng trăm tua-bin khổng lồ giữa biển, đây là điểm check-in mới nổi tại miền Tây, đặc biệt đẹp vào lúc bình minh...
                        </p>
                        <a href="blog-detail.html?id=bac-lieu-wind" class="btn btn-outline-success btn-sm stretched-link">
                            Đọc thêm <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bài 3 -->
            <div class="col-lg-3 col-md-6">
                <div class="blog-card position-relative overflow-hidden rounded-4 shadow-sm h-100 transition-all">
                    <div class="blog-img position-relative">
                        <img src="https://vemekong.com/wp-content/uploads/2022/06/u-minh-ha-forest-national-park-ca-mau-vietnam-38a-1024x576.jpg"
                             class="img-fluid w-100" alt="Vườn quốc gia U Minh Hạ"
                             style="height: 220px; object-fit: cover;">
                        <div class="blog-overlay position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-end p-3">
                            <span class="badge bg-warning text-dark px-3 py-2">Khám phá thiên nhiên</span>
                        </div>
                    </div>
                    <div class="blog-content p-4 bg-white">
                        <small class="text-muted d-block mb-2"><i class="far fa-calendar-alt me-2"></i>01/02/2026</small>
                        <h5 class="fw-bold mb-3 blog-title">Vườn quốc gia U Minh Hạ – Hòa mình vào rừng tràm bạt ngàn</h5>
                        <p class="text-muted small mb-3 line-clamp-3">
                            Khu bảo tồn sinh quyển với hệ động thực vật phong phú, trải nghiệm đi xuồng, ngắm ong mật và thưởng thức mật ong rừng...
                        </p>
                        <a href="blog-detail.html?id=u-minh-ha" class="btn btn-outline-success btn-sm stretched-link">
                            Đọc thêm <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Bài 4 -->
            <div class="col-lg-3 col-md-6">
                <div class="blog-card position-relative overflow-hidden rounded-4 shadow-sm h-100 transition-all">
                    <div class="blog-img position-relative">
                        <img src="anhsale/muicamau2.png"
                             class="img-fluid w-100" alt="Bãi biển Khai Long"
                             style="height: 220px; object-fit: cover;">
                        <div class="blog-overlay position-absolute top-0 start-0 end-0 bottom-0 d-flex align-items-end p-3">
                            <span class="badge bg-info text-white px-3 py-2">Biển đảo</span>
                        </div>
                    </div>
                    <div class="blog-content p-4 bg-white">
                        <small class="text-muted d-block mb-2"><i class="far fa-calendar-alt me-2"></i>25/01/2026</small>
                        <h5 class="fw-bold mb-3 blog-title">Bãi biển Khai Long – Nét đẹp hoang sơ cực Nam Tổ quốc</h5>
                        <p class="text-muted small mb-3 line-clamp-3">
                            Bãi biển dài, nước trong, cầu gỗ vươn ra biển – nơi lý tưởng để ngắm hoàng hôn và tận hưởng không gian yên bình...
                        </p>
                        <a href="blog-detail.html?id=khai-long" class="btn btn-outline-success btn-sm stretched-link">
                            Đọc thêm <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center" style="margin-top: 50px; margin-bottom: 10px;">
            <a href="#" class="fancy-btn">Xem tất cả</a>
        </div>
    </div>
</section>
    <!-- Footer -->
<footer class="footer text-white py-5" style="background: #0d1a26;"> <!-- Màu nền tối, xanh đen đẹp, dễ tùy chỉnh -->
    <div class="container">
        <div class="row g-4">
            <!-- Cột 1: Thông tin công ty / thương hiệu -->
            <div class="col-lg-3 col-md-6 mb-4">
                <a class="navbar-brand fw-bold fs-4 text-success d-flex align-items-center mb-3" href="#">
                    <i class="fas fa-plane me-2"></i> THTRAVEL
                </a>
                <p class="mb-3 fst-italic text-white-75">
                    Khám phá Cà Mau – Trọn vẹn miền đất cuối trời
                </p>
                <ul class="list-unstyled footer-list small">
                    <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-success"></i> 123 Đường Nguyễn Văn Cừ, Quận Ninh Kiều, Cần Thơ</li>
                    <li class="mb-2"><i class="fas fa-phone-alt me-2 text-success"></i> Hotline/Zalo: 0909 123 456</li>
                    <li class="mb-2"><i class="fas fa-envelope me-2 text-success"></i> Email: info@goodtrip.vn</li>
                    <li><i class="fas fa-clock me-2 text-success"></i> Giờ làm việc: 8:00 - 21:00 (Hàng ngày)</li>
                </ul>
            </div>
            <!-- Cột 2: Menu liên kết nhanh -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="mb-4 text-uppercase fw-bold text-success">Liên kết nhanh</h6>
                <ul class="footer-list">
                    <li><a href="#" class="text-white-75">Trang chủ</a></li>
                    <li><a href="#" class="text-white-75">Tour trong nước</a></li>
                    <li><a href="#" class="text-white-75">Tour Cà Mau</a></li>
                    <li><a href="#" class="text-white-75">Điểm du lịch nổi bật</a></li>
                    <li><a href="#" class="text-white-75">Giới thiệu</a></li>
                    <li><a href="#" class="text-white-75">Liên hệ</a></li>
                
                </ul>
            </div>
            <!-- Cột 3: Chính sách & pháp lý -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="mb-4 text-uppercase fw-bold text-success">Chính sách & Pháp lý</h6>
                <ul class="footer-list">
                    <li><a href="#" class="text-white-75">Điều khoản sử dụng</a></li>
                    <li><a href="#" class="text-white-75">Chính sách đặt tour</a></li>
                    <li><a href="#" class="text-white-75">Chính sách hủy & hoàn tiền</a></li>
                    <li><a href="#" class="text-white-75">Chính sách bảo mật thông tin</a></li>
                    <li><a href="#" class="text-white-75">Hình thức thanh toán</a></li>
                </ul>
            </div>
            <!-- Cột 4: Kết nối mạng xã hội -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="mb-4 text-uppercase fw-bold text-success">Kết nối với chúng tôi</h6>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#" class="footer-social" style="background: #E60023;" target="_blank" rel="noopener noreferrer" title="Pinterest - Ý tưởng du lịch">
        <i class="fab fa-pinterest-p"></i>
    </a>
                    <a href="#" class="footer-social" style="background: linear-gradient(45deg, #f09433 0%, #e6683c 25%, #dc2743 50%, #cc2366 75%, #bc1888 100%);">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="footer-social" style="background: #000000;">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="#" class="footer-social" style="background: #FF0000;">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="footer-social" style="background: #0068FF;" target="_blank" rel="noopener noreferrer" title="Zalo OA - Chat & Đặt tour">
        <span style="font-weight: bold; font-size: 1.4rem;">Z</span>
    </a>
  
    <!-- Thêm: Messenger (xanh lá dương) -->
    <a href="#" class="footer-social" style="background: #5865F2;" target="_blank" rel="noopener noreferrer" title="Discord - Cộng đồng THTRAVEL">
        <i class="fab fa-discord"></i>
    </a>
                </div>
            </div>
            <!-- Cột 5: Chứng nhận & thanh toán -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="mb-4 text-uppercase fw-bold text-success">Chứng nhận & Cam kết</h6>
                <div class="mb-3">
                    <h6 class="small text-uppercase mb-2 text-white-75">Thanh toán an toàn</h6>
                    <div class="d-flex gap-2 flex-wrap">
                        <i class="fab fa-cc-visa fs-3" style="color: #1A1F71;"></i>
                        <i class="fab fa-cc-mastercard fs-3" style="color: #EB001B;"></i>
                        <i class="fas fa-wallet fs-3" style="color: #E60023;" title="MoMo"></i>
                        <i class="fas fa-wallet fs-3" style="color: #00A859;" title="ZaloPay"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <h6 class="small text-uppercase mb-2 text-white-75">Chứng nhận</h6>
                    <p class="small text-white-75">Đăng ký Bộ Công Thương</p>
                    <!-- Nếu có logo chứng nhận, thêm img ở đây -->
                </div>
                <div>
                    <h6 class="small text-uppercase mb-2 text-white-75">Cam kết</h6>
                    <ul class="list-unstyled footer-list small text-white-75">
                        <li><i class="fas fa-check-circle me-2 text-success"></i> Giá tốt nhất</li>
                        <li><i class="fas fa-check-circle me-2 text-success"></i> Không phí ẩn</li>
                        <li><i class="fas fa-check-circle me-2 text-success"></i> Hỗ trợ 24/7</li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="border-secondary my-4">
        <div class="text-center small text-white-50">
            &copy; 2026 THTRAVEL.| PHÁT TRIỂN BỞI NHÓM 1. | PHÁT HÀNH THEO GIẤY PHÉP MIT.
        </div>
    </div>
</footer>
  
    <script>
    // Load phần Điểm đến yêu thích từ file riêng
    document.addEventListener('DOMContentLoaded', function() {
        fetch('sections/favorite-destinations.html')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Không tìm thấy file favorite-destinations.html');
                }
                return response.text();
            })
            .then(html => {
                const container = document.getElementById('favorite-destinations-container');
                container.innerHTML = html;
                // Khởi tạo lại Bootstrap tabs sau khi nội dung được load động
                const tabContainer = container.querySelector('.tab-content');
                if (tabContainer && typeof bootstrap !== 'undefined') {
                    // Tìm tab active và khởi tạo
                    const activeTab = container.querySelector('.nav-link.active');
                    if (activeTab) {
                        new bootstrap.Tab(activeTab);
                    }
                }
            })
            .catch(error => {
                console.error('Lỗi khi load phần Điểm đến yêu thích:', error);
                document.getElementById('favorite-destinations-container').innerHTML =
                    '<div class="alert alert-danger text-center">Không tải được phần Điểm đến yêu thích. Vui lòng kiểm tra file.</div>';
            });
    });
</script>
<script>
  
document.addEventListener('DOMContentLoaded', function () {
    fetch('sections/promo-tet.html')
        .then(res => {
            if (!res.ok) {
                throw new Error('Không tìm thấy promo-tet.html');
            }
            return res.text();
        })
        .then(html => {
            document.getElementById('promo-tet-container').innerHTML = html;
        })
        .catch(err => {
            console.error(err);
            document.getElementById('promo-tet-container').innerHTML =
                '<div class="alert alert-danger text-center">Không tải được Banner Tết</div>';
        });
});
</script>
<script>
    // Biến trạng thái
    let effectsEnabled = true;
    let soundEnabled = false; // muted ban đầu
    let brightnessNormal = true; // mặc định bình thường
    let snowInstance = null;
    let fireworksInstance = null;
    const music = document.getElementById('festiveMusic');
    document.addEventListener('DOMContentLoaded', function() {
        // Kích hoạt hiệu ứng ngay
        if (typeof christmasOverlaySnow !== 'undefined') {
            snowInstance = christmasOverlaySnow;
            snowInstance.enable({ snowflakeCount: 120, zIndex: 999 });
        }
        if (typeof FireworksOverlay !== 'undefined') {
            fireworksInstance = new FireworksOverlay({
                particleCount: 90,
                interval: 700,
                zIndex: 1000
            });
            fireworksInstance.startAnimation();
        }
        // Autoplay muted nhạc
        if (music) {
            music.volume = 0.3;
            music.play().catch(err => console.log('Autoplay blocked:', err));
        }
        // Unmute khi user tương tác lần đầu
        const unmuteOnInteract = function() {
            if (music && soundEnabled) {
                music.muted = false;
                music.play();
            }
            document.removeEventListener('click', unmuteOnInteract);
            document.removeEventListener('touchstart', unmuteOnInteract);
        };
        document.addEventListener('click', unmuteOnInteract);
        document.addEventListener('touchstart', unmuteOnInteract);
        // Toggle menu ☰
        const toggleBtn = document.getElementById('toggleFestiveBtn');
        const festiveMenu = document.getElementById('festiveMenu');
        if (toggleBtn && festiveMenu) {
            toggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                festiveMenu.style.display = festiveMenu.style.display === 'none' ? 'block' : 'none';
            });
        }
        document.addEventListener('click', function(e) {
            if (!toggleBtn.contains(e.target) && !festiveMenu.contains(e.target)) {
                festiveMenu.style.display = 'none';
            }
        });
        // Toggle hiệu ứng
        document.getElementById('toggleEffectsBtn')?.addEventListener('click', function() {
            effectsEnabled = !effectsEnabled;
            document.getElementById('effectsStatus').textContent = effectsEnabled ? 'BẬT' : 'TẮT';
            if (effectsEnabled) {
                snowInstance?.enable();
                fireworksInstance?.startAnimation();
            } else {
                snowInstance?.disable();
                fireworksInstance?.stopAnimation();
            }
        });
        // Toggle âm thanh
        document.getElementById('toggleSoundBtn')?.addEventListener('click', function() {
            soundEnabled = !soundEnabled;
            document.getElementById('soundStatus').textContent = soundEnabled ? 'BẬT' : 'TẮT';
            if (music) {
                if (soundEnabled) {
                    music.muted = false;
                    music.play().catch(() => {});
                } else {
                    music.pause();
                }
            }
        });
        // Toggle độ sáng (mới!)
       // Toggle độ sáng (dark mode thật)
// Toggle độ sáng (dark mode)
document.getElementById('toggleBrightnessBtn')?.addEventListener('click', function() {
    brightnessNormal = !brightnessNormal;
    const status = document.getElementById('brightnessStatus');
    const icon = this.querySelector('i'); // icon fa-sun hoặc fa-moon
  
    if (brightnessNormal) {
        document.body.classList.remove('dark-mode');
        status.textContent = 'BÌNH THƯỜNG';
        icon.classList.remove('fa-moon');
        icon.classList.add('fa-sun');
    } else {
        document.body.classList.add('dark-mode');
        status.textContent = 'TỐI';
        icon.classList.remove('fa-sun');
        icon.classList.add('fa-moon');
    }
});
      
    });
</script>
<script>
// Countdown cho flash sale
document.addEventListener('DOMContentLoaded', function () {
    function updateCountdown() {
        document.querySelectorAll('.countdown').forEach(el => {
            const endTimeStr = el.getAttribute('data-end-time');
            if (!endTimeStr) return;
            const endTime = new Date(endTimeStr).getTime();
            const now = new Date().getTime();
            const distance = endTime - now;
            if (distance <= 0) {
                el.textContent = 'HẾT HẠN!';
                el.classList.add('text-muted');
                return;
            }
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            let display = '';
            if (days > 0) {
                display = `${days} ngày ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            } else {
                display = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
            el.textContent = display;
        });
    }
    // Cập nhật mỗi giây
    updateCountdown();
    setInterval(updateCountdown, 1000);
});
</script>
<script>
// Kiểm tra đăng nhập
let user = null;
const savedUser = localStorage.getItem('thtravel_user');
if (savedUser) {
    try {
        user = JSON.parse(savedUser);
    } catch (e) {
        console.error("Lỗi parse user:", e);
        localStorage.removeItem('thtravel_user');
    }
}
document.addEventListener('DOMContentLoaded', function() {
    const accountBtn = document.getElementById('accountBtn');
    const dropdownMenu = document.getElementById('accountDropdown');
    if (!accountBtn || !dropdownMenu) return;
    if (user) {
        // Đã đăng nhập: thay nội dung nút + dropdown
        accountBtn.innerHTML = `<i class="fas fa-user me-2"></i>Xin chào, ${user.name} ▼`;
        dropdownMenu.innerHTML = `
            <li><a class="dropdown-item" href="profile.html"><i class="fas fa-user-circle me-2"></i>Hồ sơ cá nhân</a></li>
            <li><a class="dropdown-item" href="orders.php"><i class="fas fa-receipt me-2"></i>Đơn hàng của tôi</a></li>
            <li><a class="dropdown-item" href="#"><i class="fas fa-heart me-2"></i>Yêu thích</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item text-danger" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
        `;
        // Khởi tạo lại dropdown của Bootstrap sau khi thay đổi nội dung
        const dropdownInstance = new bootstrap.Dropdown(accountBtn);
        dropdownInstance.update(); // Đảm bảo dropdown nhận diện lại
        // Xử lý đăng xuất
        document.getElementById('logoutBtn')?.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('thtravel_user');
            localStorage.removeItem('thtravel_orders');
            location.reload();
        });
    } else {
        // Chưa đăng nhập: chuyển hướng đến login khi click
        accountBtn.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = "login.php";
        });
        accountBtn.removeAttribute('data-bs-toggle'); // Bỏ dropdown để không hiện menu rỗng
    }
});
</script>
<script>
// Lấy form và button
const contactForm = document.getElementById('contactForm');
const submitBtn = document.getElementById('submitBtn');

contactForm.addEventListener('submit', function(e) {
    e.preventDefault();

    // Kiểm tra validation HTML5
    if (!contactForm.checkValidity()) {
        e.stopPropagation();
        contactForm.classList.add('was-validated');
        return;
    }

    // Vô hiệu hóa nút + loading
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> ĐANG GỬI...';

    // Giả lập gửi (thay bằng fetch thật nếu có backend)
    setTimeout(() => {
        // Hiện popup thành công đẹp lung linh
        Swal.fire({
            title: 'Thành công!',
            html: `
                <div style="color: #155724; font-size: 1.1rem;">
                    <strong>Đặt chỗ thành công!</strong><br><br>
                    Cảm ơn bạn đã tin tưởng THTravel!<br>
                    Chúng tôi sẽ liên hệ xác nhận trong vòng <strong>5-10 phút</strong><br>
                    qua điện thoại hoặc Zalo.
                </div>
            `,
            icon: 'success',                // icon checkmark mặc định của SweetAlert2
            iconColor: '#28a745',           // xanh lá giống ảnh
            confirmButtonText: 'Đóng',      // hoặc 'OK' nếu muốn
            confirmButtonColor: '#28a745',  // nút xanh
            background: '#d4edda',          // nền xanh nhạt
            customClass: {
                popup: 'animated fadeInUp faster', // animation mượt
                title: 'text-success fw-bold',
                confirmButton: 'btn btn-success px-5 py-2 rounded-pill'
            },
            showCloseButton: true,          // có nút × ở góc
            allowOutsideClick: false,       // không click ngoài để đóng (tùy chọn)
            timer: 8000,                    // tự đóng sau 8 giây
            timerProgressBar: true
        });

        // Reset form và nút
        contactForm.reset();
        contactForm.classList.remove('was-validated');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i> GỬI YÊU CẦU';

    }, 1200); // delay giả lập 1.2s
});
</script>

</section>
</section>
</section>
</body>
</html>