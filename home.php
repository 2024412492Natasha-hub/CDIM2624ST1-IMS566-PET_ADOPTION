<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurEver Home</title>

    <!--BOOTSTRAP & FONTS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!--AOS ANIMATION CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!--GOOGLE FONTS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Concert+One&family=Fuzzy+Bubbles:wght@400;700&family=Luckiest+Guy&family=Nerko+One&family=Single+Day&family=Spicy+Rice&display=swap" rel="stylesheet">
    
    <!--CSS STYLE-->    
    <style>
        body {
            background-color: #FAF5F5; 
            color: #1a202c;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .hero-title {
            font-size: 4.3rem;
            font-weight: 400;
            color: #351F1A;
            font-family: "Nerko One", cursive;
            font-style: normal;
        }
        
        /* --- NAVBAR CSS --- */
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
            color: #0f2131 !important;
        }

        .navbar-nav-dark .nav-link.active {
            border-bottom: 3px solid #0f2131;
            padding-bottom: 5px;
        }

        .btn-custom {
            background-color: #0f2131;
            color: #ffffff;
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            transition: background-color 0.3s ease;
        }
        .btn-custom:hover {
            background-color: #1a354e;
            color: #ffffff;
        }
        
        /* --- STATISTIC PAGE CSS --- */
        .stats-section {
            background-color: #F1DDCF; 
            padding: 80px 0;
        }

        .stats-title {
            color: #3D2C2E;
            font-family: "Nerko One", cursive;    
            font-weight: 500;
            font: size 2.7em;
        }

        .stats-desc {
            color: #5A4A4C;
            max-width: 700px;
            margin: 0 auto 50px auto;
            font-family: 'Fuzzy Bubbles', sans-serif; 
            font-weight: 600; 
            text-align: center;
            margin-top: 20px;
        }

        .stat-number-large {
            font-size: 3.5rem;
            font-weight: 800;
            color: #94483B; 
            line-height: 1;
        }

        .stat-label-large {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #5A4A4C;
            font-weight: 600;
        }   

        .stat-card {
            border-radius: 4px; 
            padding: 40px 20px;
            text-align: center;
            border: none;
            height: 100%;
        }

        .stat-card-dark {
            background-color: #3D2C2E;
            color: #FAF5F5;
        }
        
        .stat-card-dark .stat-num {
            color: #FAF5F5;
            font-size: 3rem;
            font-weight: 700;
        }
        
        .stat-card-dark .stat-title-sub {
            color: #E8D5D6;
            font-weight: 600;
        }
        
        .stat-card-dark .stat-text {
            color: #D6C2C3;
            font-size: 0.9rem;
        }

        .stat-card-light {
            background-color: #FAF2F0;
            color: #3D2C2E;
        }

        .stat-card-light .stat-num {
            color: #3D2C2E;
            font-size: 3rem;
            font-weight: 700;
        }

        .stat-card-light .stat-title-sub {
            color: #3D2C2E;
            font-weight: 600;
        }

        .stat-card-light .stat-text {
            color: #5A4A4C;
            font-size: 0.9rem;
        }

        /* --- LOGIN INVITATION CSS --- */
        .cta-section {
            background-color: #FAF5F5; 
            padding: 60px 0 100px 0;
        }

        .cta-card {
            background-color: #E8D5D6; 
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(61, 44, 46, 0.05);
            border: none;
        }

        .cta-title {
            color: #3D2C2E;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 15px;
        }

        .cta-text {
            color: #5A4A4C;
            font-size: 1.05rem;
            max-width: 650px;
            margin: 0 auto 30px auto;
            line-height: 1.6;
        }

        .btn-cta-signin {
            background-color: #3D2C2E; 
            color: #FAF5F5 !important;
            font-weight: 600;
            padding: 14px 40px;
            border-radius: 50px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 5px 15px rgba(61, 44, 46, 0.2);
        }

        .btn-cta-signin:hover {
            background-color: #FAF5F5;
            color: #3D2C2E !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(61, 44, 46, 0.25);
        }

        /* --- CSS FOOTER --- */
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

<div class="wrapper">

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
                    <li class="nav-item"><a class="nav-link" href="#about-us">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="service.php">Services</a></li>
                </ul>
                <div class="d-flex align-items-center">
                    <a href="login.php" class="btn btn-light btn-sm">Log In</a>
                </div>
            </div>
        </div>
    </nav>
        
        
    <!-- CONTENT -->

    <!-- Header -->
    <header class="py-5" style="background-color: #f6e5e1; box-shadow: 0 15px 30px rgba(255, 230, 234, 0.8); position: relative; z-index: 1; margin-top: -1px;">
        <div class="container text-center">
            <div class="row justify-content-center" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-lg-8">
                    <h1 class="hero-title mb-3">Meet Your Buddies</h1>
                    <p class="text-muted px-md-5 mb-0" style="font-size: 1.1rem; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600; color: #333333 !important;">
                        Open your heart and home to a pet in need. Experience the unconditional love of a 
                        shelter animal that has been lovingly prepared for their journey to a new forever home.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <!-- SECTION: IMAGE GALLERY -->
    <section class="py-5" style="overflow: hidden;">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-right" data-aos-duration="1000">
                    <img src="uploads/dog.jpeg" alt="Dogs" class="img-fluid w-100 object-fit-cover" style="height: 450px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                </div>
                <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                    <img src="uploads/cats.jpeg" alt="Cats" class="img-fluid w-100 object-fit-cover" style="height: 450px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                </div>
            </div>
        </div>
    </section>
    
    <!-- SECTION: WHY ADOPT FROM US -->
    <section class= "container-fluid" py-5 style="background-color: #F0D8D1; font-family: 'Segoe UI', sans-serif; overflow: hidden;">
        <div class="container py-4 text-center">
            
            <div class="row mb-5" data-aos="fade-up" data-aos-duration="800">
                <div class="col-12">
                    <h2 class="fw-bold" style="color: #351F1A; font-family: 'Nerko One', cursive; font-size: 3rem; letter-spacing: -0.5px;">
                        Why Adopt From Us?
                    </h2>
                </div>
            </div>

            <div class="row g-5 justify-content-center">
              
                <!-- 1. Save a Life -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">Save a Life</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        Give a deserving animal a second chance at a happy life and a warm, loving home.
                    </p>
                </div>

                <!-- 2. Fully Vet-Checked -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">Fully Vet-Checked</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        All our adoptable pets are vaccinated, dewormed, and health-checked before going home.
                    </p>
                </div>

                <!-- 3. The Perfect Match -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">The Perfect Match</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        We help guide you to find a pet that perfectly matches your lifestyle and family dynamic.
                    </p>
                </div>

                <!-- 4. Stop Puppy Mills -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">Stop Puppy Mills</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        By adopting, you take a stand against commercial breeding facilities and illegal mills.
                    </p>
                </div>

                <!-- 5. Post-Adopt Support -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">Post-Adopt Support</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        Our shelter team is always here to provide advice and tips for your pet's transition.
                    </p>
                </div>

                <!-- 6. Community First -->
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <h4 class="fw-bold mb-3" style="color: #0f2131; font-size: 1.3rem;">Community First</h4>
                    <p class="text-muted mx-auto" style="max-width: 280px; font-size: 1.3rem; line-height: 1.6; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                        Every successful adoption helps us free up space to rescue more stray animals.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: ABOUT OUR SHELTER -->
    <section class="py-5" style="font-family: 'Segoe UI', sans-serif; overflow: hidden;" id="about-us">
        <div class="container py-4">
            <div class="row align-items-center g-5">
              
                <div class="col-md-6" data-aos="zoom-in" data-aos-duration="1000">
                    <img src="uploads/catlover.jpeg" alt="About Our Family" class="img-fluid w-100 object-fit-cover" style="max-height: 600px; border-radius: 4px;">
                </div>

                <div class="col-md-6" data-aos="fade-left" data-aos-duration="1000">
                    <div class="ps-lg-4">
                        <h2 class="fw-bold mb-4" style="color: #351F1A; font-family: 'Nerko One', cursive; font-size: 3rem; letter-spacing: -0.5px;">
                            About Our Shelter
                        </h2>
                        <p class="text-muted" style="font-size: 1.3rem; line-height: 1.7; text-align: justify; font-family: 'Fuzzy Bubbles', sans-serif; font-weight: 600;">
                            We are dedicated to rescuing, rehabilitating, and rehoming animals in need. Our mission is to connect loving families with pets who deserve a second chance at life. By adopting instead of buying, you are saving a life and making space for another animal to be rescued. Every pet in our shelter is vaccinated, health-checked, and ready to bring unconditional love to their forever home.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION: STATISTICS -->
    <section class="stats-section">
    <div class="container">
        
        <div class="text-center mb-5" style="padding-top: 10px; padding-bottom: 30px;" data-aos="fade-up" data-aos-duration="800">
            <h2 class="stats-title display-4 fw-bold">Our Journey in Saving Lives</h2>
            <p class="stats-desc fs-5">
                Every number represents a story of hope, healing, and a second chance. Thanks to our passionate community, donors, and volunteers, we continue to bridge the gap between rescued animals and loving homes.
            </p>
        </div>

        

        <div class="row align-items-center mb-5 g-5">
            <div class="col-lg-5">
                <h3 class="fw-bold mb-3" style="color: #3D2C2E; line-height: 1.4;">
                    We've helped connect over 1,500 pets with their forever families!
                </h3>
                <p class="text-muted" style="font-size: 0.95rem;">
                    Through efficient adoption drives, rigorous health screenings, and community awareness, we aim to reduce stray populations and secure a safe environment for every furry friend.
                </p>
            </div>
            
            <div class="col-lg-7" data-aos="fade-left" data-aos-duration="800">
                <div class="row g-4 text-center text-lg-start">
                    <div class="col-6">
                        <div class="stat-number-large">92%</div>
                        <div class="stat-label-large">Success Adoption Rate</div>
                    </div>
                    <div class="col-6">
                        <div class="stat-number-large">500+</div>
                        <div class="stat-label-large">Active Volunteers</div>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="stat-number-large">24/7</div>
                        <div class="stat-label-large">Emergency Care Response</div>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="stat-number-large">10k+</div>
                        <div class="stat-label-large">Kilos of Kibbles Donated</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4" data-aos="fade-up" data-aos-duration="800">
            
            <div class="col-md-3 col-sm-6">
                <div class="card stat-card stat-card-dark">
                    <div class="stat-num">1.2k</div>
                    <div class="stat-title-sub mb-2">Happy Tails</div>
                    <p class="stat-text mb-0">Dogs and cats successfully adopted into warm, loving households.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card stat-card stat-card-light">
                    <div class="stat-num">80+</div>
                    <div class="stat-title-sub mb-2">Foster Parents</div>
                    <p class="stat-text mb-0">Temporary homes provided for animals during medical recoveries.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card stat-card stat-card-dark">
                    <div class="stat-num">100%</div>
                    <div class="stat-title-sub mb-2">Vaccinated Pets</div>
                    <p class="stat-text mb-0">All pets are fully neutered, vaccinated, and microchipped.</p>
                </div>
            </div>

            <div class="col-md-3 col-sm-6">
                <div class="card stat-card stat-card-light">
                    <div class="stat-num">5</div>
                    <div class="stat-title-sub mb-2">Shelter Partners</div>
                    <p class="stat-text mb-0">Collaborating with local clinics and rescue teams statewide.</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- SECTION: LOGIN INVITATION -->
<section class="cta-section" data-aos="fade-up">
    <div class="container">
        <div class="cta-card">
            <h2 class="cta-title">Ready to Find Your Furry Companion?</h2>
            
            <p class="cta-text">
                Create an account or sign in today to streamline your adoption process, apply for fostering, or get personalized updates on pets waiting for a forever home.
            </p>
            
            <a href="login.php" class="btn-cta-signin">
                <i class="fa-solid fa-right-to-bracket me-2"></i> Sign In to FurEver Home
            </a>
        </div>
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
</div> 

<!-- BOOTSTRAP, CHART, & AOS ANIMATION SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- AOS JS LIBRARY -->
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