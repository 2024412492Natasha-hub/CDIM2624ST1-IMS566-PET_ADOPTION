<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services | FurEver Home</title>
    
    <!--BOOTSTRAP & FONTS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!--AOS ANIMATION CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Concert+One&family=Fuzzy+Bubbles:wght@400;700&family=Luckiest+Guy&family=Nerko+One&family=Single+Day&family=Spicy+Rice&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #FAF5F5;
        }

        .services-title {
            font-family: "Nerko One", cursive;
            color: #351F1A;
            font-size: 60px;
            margin-bottom: 80px;
        }

        .services-bg-img {
            height: 380px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
        }
        .services-container {
            margin-top: -120px; 
            position: relative;
            z-index: 2;
        }
        .service-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 25px 30px 25px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
            position: relative;
            border: none;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        .service-icon-box {
            width: 60px;
            height: 60px;
            background-color: #5A4A4C; 
            color: #ffffff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 5px 15px rgba(15, 33, 49, 0.2);
        }
        .btn-more {
            color: #0f2131;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-decoration: none;
            border-bottom: 2px solid #0f2131;
            padding-bottom: 2px;
            transition: color 0.2s ease;
        }
        .btn-more:hover {
            color: #ffb7c3;
            border-bottom-color: #ffb7c3;
        }
        nav.navbar-custom {
            background-color: #3D2C2E; 
            border-bottom: 1px solid #d1d5db;
        }
        .navbar-nav-dark .nav-link {
            color: white !important; 
            font-size: 1.1rem;
            font-weight: 600; 
        }
        .navbar-nav-dark .nav-link i {
            color: white !important;
        }
        .navbar-nav-dark .nav-link.active {
            border-bottom: 3px solid #0f2131;
            padding-bottom: 5px;
        }


        .footer-custom { 
            background-color: #FADADD !important; 
            color: black; 
            flex-shrink: 0;
            margin-top: 100px;
        }

        .footer-custom .border-secondary {
            border-color: rgba(255, 255, 255, 0.15) !important;
        }

    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="home.php" style="color: white !important;">
            <span class="brand-name">FurEver Home</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 navbar-nav-dark text-center">                    
                <li class="nav-item"><a class="nav-link" href="home.php#about-us">About Us</a></li>
                <li class="nav-item"><a class="nav-link active" href="service.php">Services</a></li>
            </ul>
            <div class="d-flex align-items-center">
                <a href="login.php" class="btn btn-light btn-sm" style="color: #0f2131; font-weight: 600;">Log In</a>
            </div>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<section class="py-5">
    <div class="container py-4">
        
        <div class="text-center mb-4" data-aos="fade-up">
            <h2 class="fw-bold services-title">Our Services</h2>
        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12">
                <div class="services-bg-img">
                    <img src="uploads/petshelter.jpg" alt="Our Services Banner" class="w-100 h-100 object-fit-cover" style="filter: brightness(0.9);">
                </div>
            </div>
        </div>

<div class="container services-container">
<div class="row g-4 justify-content-center">
    
    <!-- Card 1: Pet Adoption -->
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card service-card">
            <div class="service-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-paw-fill" viewBox="0 0 16 16">
                    <path d="M1 8a3 3 0 1 1 6 0A3 3 0 0 1 1 8m7-5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m4 2.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m2.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M13 13c0 .733-.456 1.367-1.11 1.622l-.76.304a.25.25 0 0 1-.184-.008L9.2 14.244c-.21-.105-.44-.162-.673-.166A2.6 2.6 0 0 0 6 16c-.522 0-1.016-.17-1.423-.485l-.46-.346a.25.25 0 0 1-.06-.312l.62-1.09c.124-.218.175-.47.146-.72A2.4 2.4 0 0 0 2.5 11c0-.987.58-1.834 1.418-2.205l.865-.384a.25.25 0 0 1 .256.035c.346.274.774.454 1.24.514 1.077.138 2.146-.252 2.766-1.052l.433-.56c.108-.14.288-.19.45-.115l.89.412C12.106 8.204 13 9.497 13 11z"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-3 mt-2" style="color: #0f2131; font-size: 1.25rem;">Pet Adoption</h4>
            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Find your perfect companion. Browse through our shelter pets, submit your application, and start your journey toward giving a pet a forever home.
            </p>
        </div>
    </div>

    <!-- Card 2: Fostering Program -->
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card service-card">
            <div class="service-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-house-heart-fill" viewBox="0 0 16 16">
                    <path d="M7.293 1.5a1 1 0 0 1 1.414 0L14 6.707A1 1 0 0 1 13.293 8.5H13v6a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-6h-.293A1 1 0 0 1 2 6.707zM8 6.207a1.5 1.5 0 0 0-2 2.235c.646.647 1.62 1.523 2 1.865.38-.342 1.354-1.218 2-1.865a1.5 1.5 0 0 0-2-2.235"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-3 mt-2" style="color: #0f2131; font-size: 1.25rem;">Fostering Program</h4>
            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Not ready for permanent adoption? Provide a temporary loving home for animals recovering from medical treatment or awaiting adoption.
            </p>
        </div>
    </div>

    <!-- Card 3: Medical Care -->
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card service-card">
            <div class="service-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-heart-pulse-fill" viewBox="0 0 16 16">
                    <path d="M1.475 9c.085.5.227.98.417 1.432l3.632-3.632a.5.5 0 0 1 .704 0l2.086 2.086 4.022-4.022a.5.5 0 0 1 .708 0l2.544 2.544c.26-.53.424-1.12.449-1.751C15.93 3.654 13.08 1 9.5 1 7.23 1 5.253 2.126 4.092 3.84c-.332-.309-.724-.56-1.156-.736C2.42 2.093.57 3.834.053 6.182c-.035.158-.053.32-.053.483 0 1.074.522 2.023 1.475 2.335M8.5 9.707L6.207 7.414 2.455 11.166C3.59 12.898 5.61 14 8 14c2.257 0 4.225-1.042 5.5-2.668L10.207 8.05zM12 5a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-3 mt-2" style="color: #0f2131; font-size: 1.25rem;">Medical Care</h4>
            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Every pet deserves a healthy start. We ensure all animals are fully vaccinated, dewormed, health-checked, and spayed/neutered before adoption.
            </p>
        </div>
    </div>

    <!-- Card 4: Volunteer Programe -->
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
        <div class="card service-card">
            <div class="service-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-3 mt-2" style="color: #0f2131; font-size: 1.25rem;">Volunteer Program</h4>
            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Make a direct impact on our animals. Join our volunteer team to assist with daily feeding, shelter maintenance, socializations, and events.
            </p>
        </div>
    </div>

    <!-- Card 5: Donation & Support -->
    <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
        <div class="card service-card">
            <div class="service-icon-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-gift-fill" viewBox="0 0 16 16">
                    <path d="M3 2.5a.5.5 0 0 1 .5-.5L4 2h8l.5.5a.5.5 0 0 1-.5.5H3.5a.5.5 0 0 1-.5-.5M2 3.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H2.5a.5.5 0 0 1-.5-.5zm0 2.5h5v10H2.5a.5.5 0 0 1-.5-.5V6.5zm6 10h4.5a.5.5 0 0 0 .5-.5V6.5H8z"/>
                </svg>
            </div>
            <h4 class="fw-bold mb-3 mt-2" style="color: #0f2131; font-size: 1.25rem;">Donations & Support</h4>
            <p class="text-muted mb-4" style="font-size: 0.95rem; line-height: 1.6;">
                Help us sustain our operations. Financial donations and material supplies go directly toward medical bills, kibbles, and improving shelter facilities.
            </p>
        </div>
    </div>

</div></div>
    </div>
</section>

<!-- FOOTER -->
<footer class="text-center text-lg-start footer-custom text-black-50 py-4">
    <div class="container text-center text-md-start">
        <div class="row mt-2">
            <div class="col-md-5 mx-auto mb-3">
                <h6 class="text-uppercase fw-bold text-black mb-2">FurEver Home</h6>
                <p class="small mb-0" style="font-size: 0.95rem; line-height: 1.6; text-align: justify;">
                    A dedicated digital platform connecting rescued and shelter animals with compassionate families. 
                    We streamline the adoption process to help you find the perfect pet and give them a second chance at life.
                </p>            
            </div>

            <div class="col-md-4 mx-auto mb-3 text-md-end">
                <h6 class="text-uppercase fw-bold text-black mb-2">Course Information</h6>
                <p class="small mb-1"><i class="fa-solid fa-code me-2"></i> IMS566 - Advanced Web Design</p>
                <p class="small mb-1"><i class="fa-solid fa-graduation-cap me-2"></i> Faculty of Information Management</p>
                <p class="small mb-0"><i class="fa-solid fa-calendar me-2"></i> Semester May 2026</p>
            </div>
        </div>
    </div>

    <div class="text-center p-3 border-top border-secondary mt-3 small text-black-50">
        © 2026 FurEver Home. All Rights Reserved. <span class="text-black fw-semibold">FurEver Home Animal Adoption Management System</span>
    </div>
</footer>


<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 850,
        once: true,
        offset: 120
    });
</script>

</body>
</html>