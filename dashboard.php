<?php
include 'config.php';
session_start();

// Pastikan pengguna telah log masuk terlebih dahulu
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function format_pet_age($age) {
    $age = trim((string)$age);
    if ($age === '') {
        return 'N/A';
    }

    if (preg_match('/^\d+$/', $age)) {
        return $age . ' Years';
    }

    return $age;
}

// Operasi DELETE jika butang padam ditekan (Hanya dibenarkan untuk Admin / Shelter)
if (isset($_GET['delete_id'])) {
    if ($_SESSION['role'] != 'adopter') {
        $delete_id = intval($_GET['delete_id']);
        $conn->query("DELETE FROM pets WHERE pet_id = $delete_id");
    }
    header("Location: dashboard.php");
    exit();
}

// Logik Tapisan (Filter by Species)
$filter_species = isset($_GET['species']) ? $_GET['species'] : '';

// Bina SQL Query berdasarkan tapisan yang dipilih
if (!empty($filter_species)) {
    // Escaping input untuk keselamatan daripada SQL Injection
    $safe_species = $conn->real_escape_string($filter_species);
    $query = "SELECT pets.*, users.name as shelter_name 
              FROM pets 
              JOIN users ON pets.user_id = users.user_id 
              WHERE pets.species = '$safe_species' 
              ORDER BY pets.created_at DESC";
} else {
    // Ambil semua data sekiranya tiada tapisan dibuat
    $query = "SELECT pets.*, users.name as shelter_name 
              FROM pets 
              JOIN users ON pets.user_id = users.user_id 
              ORDER BY pets.created_at DESC";
}

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - PawLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative:wght@400;700;900&family=Cinzel:wght@400..900&family=Diplomata&family=Roboto:ital,wght@0,100..900;1,100..900&family=Rubik+Doodle+Shadow&family=Sekuya&family=Unica+One&family=Yesteryear&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Chango&family=Luckiest+Guy&display=swap" rel="stylesheet">   
    <style>
        body {
            background-color: #fcf8f2; /* Warna latar belakang lembut tema haiwan */
        }
        
        /* Premium Hero Banner Header */
        .dashboard-header {
            background: linear-gradient(135deg, #954535 0%, #d4a373 100%);
            color: white;
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 35px;
            box-shadow: 0 10px 25px rgba(149, 69, 53, 0.15);
            position: relative;
            overflow: hidden;
        }
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .header-brand-text { 
            font-family: "Yesteryear", cursive; 
            font-size: 2.3rem; 
            opacity: 0.95; 
        }

        /* Rekabentuk Custom Grid Card mengikut contoh susunan */
        .pet-card {
            background-color: #FFE6E6; /* Latar belakang kad kekuningan lembut */
            border: 1px solid #f3e1c3;
            border-radius: 15px;
            display: flex;
            overflow: hidden;
            height: 200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }

        .title-section {
            font-family: "Cinzel", serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;            
            letter-spacing: 0.5px;
            color:#800000;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .pet-card:hover {
            transform: translateY(-5px);
        }
        .pet-img-container {
            width: 40%;
            height: 100%;
        }
        .pet-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .pet-info {
            width: 60%;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .pet-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
        }
        .star-icon {
            color: #ffc107;
            margin-right: 5px;
        }
        .pet-location {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        .pet-details {
            color: #b83b3b; /* Warna teks merah gelap untuk spesifikasi fizikal */
            font-weight: bold;
            font-size: 0.95rem;
            line-height: 1.2;
        }
        .pet-status {
            display: inline-block;
            width: fit-content;
            margin-top: 8px;
            padding: 4px 9px;
            border-radius: 999px;
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        .status-available { background: #d1e7dd; color: #0f5132; }
        .status-pending { background: #fff3cd; color: #664d03; }
        .status-adopted { background: #f8d7da; color: #842029; }
        .pet-shelter {
            color: #888;
            font-size: 0.85rem;
        }

        .text-secondary {
            color: #800000 !important;
            font-family: "Chango", sans-serif;
            font-optical-sizing: auto;
            font-weight: 400;
            font-style: normal;            
            letter-spacing: 0.5px;
        }

        /* Premium Footer Styling */
        footer {
            background-color: #800000; /* Menggunakan warna merah gelap sesuai elemen judul */
            color: #fcf8f2;
            font-size: 0.9rem;
        }
        footer a {
            color: #dfc29d;
            text-decoration: none;
            transition: color 0.2s;
        }
        footer a:hover {
            color: #ffffff;
        }
        footer .footer-title {
            font-family: "Cinzel", serif;
            font-weight: bold;
            letter-spacing: 1px;
            color: #ffffff;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .footer-brand {
            font-family: "Chango", sans-serif;
            font-size: 1.2rem;
            color: #ffffff;
        }

        /* Filter Section Styling */
        .filter-box {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <h4 class="mb-0 text-secondary">
            <i class="fa-solid fa-circle-user me-2"></i>FurEver Home</h4>
        <div>
            <?php if ($_SESSION['role'] == 'adopter'): ?>
                <a href="my_applications.php" class="btn btn-outline-secondary me-2 fw-bold">
                    <i class="fa-solid fa-folder-open me-1"></i> My Applications</a>
            <?php else: ?>
                <a href="manage_applications.php" class="btn btn-outline-secondary me-2 fw-bold">
                    <i class="fa-solid fa-list-check me-1"></i> Manage Applications</a>
            <?php endif; ?>

            <a href="notifications.php" class="btn btn-outline-primary me-2 position-relative fw-bold">
                <i class="fa fa-bell"></i> Notifications<?php
                // Query untuk mengira bilangan notifikasi terkini milik pengguna yang is_read = 0
                $count_query = "SELECT COUNT(*) as unread FROM notifications WHERE user_id = $user_id AND is_read = 0";
                $count_res = $conn->query($count_query);
                if ($count_res) {
                    $count_row = $count_res->fetch_assoc();
                    if ($count_row['unread'] > 0) {
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $count_row['unread'] . '</span>';
                    }
                }
                ?>
            </a>

            <?php if ($_SESSION['role'] != 'adopter'): ?>
                <a href="add_pet.php" class="btn btn-success me-2 fw-bold"><i class="fa fa-plus"></i> Add New Pet</a>
            <?php endif; ?>
            
            <a href="logout.php" class="btn btn-danger btn-sm fw-bold px-3 rounded-pill" onclick="return confirm('Are you sure you want to log out?')">Log Out</a>
        </div>
    </div>

    <div class="dashboard-header d-flex justify-content-between align-items-center flex-wrap">
        <div class="header-text">
            <span class="header-brand-text">Welcome back,</span>
            <h1 class="fw-bold mb-2" style="font-size: 2.3rem;"><?php echo htmlspecialchars($_SESSION['name']); ?>!</h1>
            <p class="mb-0 opacity-75 fw-light" style="max-width: 550px;">
                <?php if ($_SESSION['role'] == 'adopter'): ?>
                    Ready to find your new furry best friend today? Browse our available pet listings below and submit your application.
                <?php elseif ($_SESSION['role'] == 'shelter'): ?>
                    Welcome to your shelter workspace. Update pet statuses, list new animals, and track adoption applications dynamically.
                <?php else: ?>
                    System Administrator Dashboard. You have overall access to modify user databases, monitor logs, and manage adoptions.
                <?php endif; ?>
            </p>
        </div>
        <div class="header-icon d-none d-md-block opacity-25 me-4">
            <?php if ($_SESSION['role'] == 'adopter'): ?>
                <i class="fa-solid fa-heart-pulse fa-5x"></i>
            <?php elseif ($_SESSION['role'] == 'shelter'): ?>
                <i class="fa-solid fa-house-chimney-window fa-5x"></i>
            <?php else: ?>
                <i class="fa-solid fa-user-shield fa-5x"></i>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Bahagian Tapisan / Search Species (4 Markah Kriteria Search & Filter) -->
    <div class="filter-box mb-4">
    <form method="GET" action="dashboard.php" class="row g-3 align-items-center">
        <div class="col-md-4">
            <label for="species" class="form-label fw-bold text-secondary mb-1">
                <i class="fa-solid fa-filter me-1"></i> Filter by Pet Species
            </label>
            <select name="species" id="species" class="form-select">
                <option value="">-- All Species --</option>
                <option value="cat" <?php if ($filter_species == 'cat') echo 'selected'; ?>>Cat</option>
                <option value="dog" <?php if ($filter_species == 'dog') echo 'selected'; ?>>Dog</option>
                <option value="bird" <?php if ($filter_species == 'bird') echo 'selected'; ?>>Bird</option>
                <option value="rabbit" <?php if ($filter_species == 'rabbit') echo 'selected'; ?>>Rabbit</option>
            </select>
        </div>
        <div class="col-md-4 d-flex align-items-end pt-md-4">
            <button type="submit" class="btn btn-primary fw-bold me-2">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Search
            </button>
            <?php if (!empty($filter_species)): ?>
                <a href="dashboard.php" class="btn btn-outline-secondary fw-bold">
                    <i class="fa-solid fa-rotate-left me-1"></i> Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

    <div class="title-section mb-4">
        <h3 class="mb-4 text-secondary"><i class="fa-solid fa-paw me-2 text-primary"></i>List of Pets for Adoption</h3>
    </div>

    <div class="row">
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-6 mb-4">
                    <div class="pet-card">
                        <div class="pet-img-container">
                            <?php if (!empty($row['photo']) && file_exists("uploads/" . $row['photo'])): ?>
                                <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" class="pet-img" alt="<?php echo htmlspecialchars($row['pet_name']); ?>">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-secondary text-white">
                                    <small>No Image</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="pet-info">
                            <div>
                                <div class="pet-name">
                                    <i class="fa-solid fa-star star-icon"></i><?php echo htmlspecialchars($row['pet_name']); ?>
                                </div>
                                <div class="pet-location">
                                    For Adoption, <?php echo !empty($row['location']) ? htmlspecialchars($row['location']) : 'Shah Alam'; ?>
                                </div>
                                <div class="pet-details">
                                    <?php echo htmlspecialchars(format_pet_age($row['age'])); ?>, 
                                    <span class="text-capitalize"><?php echo htmlspecialchars($row['gender']); ?></span><br>
                                    <span class="text-capitalize"><?php echo !empty($row['breed']) ? htmlspecialchars($row['breed']) : 'Mixed Breed'; ?></span>
                                </div>
                                <?php
                                    $status_class = 'status-available';
                                    if ($row['status'] == 'Pending') $status_class = 'status-pending';
                                    if ($row['status'] == 'Adopted') $status_class = 'status-adopted';
                                ?>
                                <span class="pet-status <?php echo $status_class; ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="pet-shelter">
                                    <small><?php echo htmlspecialchars($row['shelter_name']); ?> | <?php echo date('M jS', strtotime($row['created_at'])); ?></small>
                                </div>
                                
                                <div class="action-buttons">
                                    <?php if ($_SESSION['role'] != 'adopter'): ?>
                                        <a href="edit_pet.php?id=<?php echo $row['pet_id']; ?>" class="btn btn-warning btn-sm py-1 px-2" title="Edit"><i class="fa fa-edit"></i></a>
                                        <a href="dashboard.php?delete_id=<?php echo $row['pet_id']; ?>" class="btn btn-danger btn-sm py-1 px-2" onclick="return confirm('Are you sure you want to delete this pet record permanently?')" title="Delete"><i class="fa fa-trash"></i></a>
                                    <?php else: ?>
                                        <?php if ($row['status'] == 'Available'): ?>
                                            <a href="apply_adoption.php?pet_id=<?php echo $row['pet_id']; ?>" class="btn btn-primary btn-sm py-1 px-3">Adopt</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm py-1 px-3" disabled><?php echo htmlspecialchars($row['status']); ?></button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center mt-5">
                <div class="p-5 bg-white rounded shadow-sm">
                    <i class="fa-solid fa-paw fa-3x text-muted mb-3"></i>
                    <p class="text-muted fs-5">No pets of this species found for adoption at this time.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="py-5 mt-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <div class="footer-title">
                    <span class="footer-brand">FurEver Home</span>
                </div>
                <p class="opacity-75" style="line-height: 1.6; text-align: justify;">
                    FurEver Home is a leading digital platform specializing in connecting loving pet seekers with shelters. Our mission is to empower communities to find and adopt their perfect animal companions through our structured and innovative management tools, fostering a safe and caring environment for all pets.
                </p>
            </div>

            <div class="col-md-3 offset-md-1">
                <div class="footer-title text-uppercase">Main Menu</div>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="dashboard.php"><i class="fa fa-chevron-right me-2" style="font-size: 0.75rem;"></i> Dashboard</a></li>
                    
                    <?php if ($_SESSION['role'] == 'adopter'): ?>
                        <li class="mb-2"><a href="my_applications.php"><i class="fa fa-chevron-right me-2" style="font-size: 0.75rem;"></i> My Applications</a></li>
                    <?php else: ?>
                        <li class="mb-2"><a href="manage_applications.php"><i class="fa fa-chevron-right me-2" style="font-size: 0.75rem;"></i> Manage Applications</a></li>
                        <li class="mb-2"><a href="add_pet.php"><i class="fa fa-chevron-right me-2" style="font-size: 0.75rem;"></i> Add New Pet</a></li>
                    <?php endif; ?>
                    
                    <li class="mb-2"><a href="notifications.php"><i class="fa fa-chevron-right me-2" style="font-size: 0.75rem;"></i> Notifications</a></li>
                </ul>
            </div>

            <div class="col-md-3">
                <div class="footer-title text-uppercase">Course Information</div>
                <ul class="list-unstyled opacity-75">
                    <li class="mb-2"><i class="fa-solid fa-code me-2"></i> IMS560 - Advanced Database Management System</li>
                    <li class="mb-2"><i class="fa-solid fa-graduation-cap me-2"></i> Faculty of Information Management</li>
                    <li class="mb-2"><i class="fa-solid fa-calendar-days me-2"></i> Semester May 2026</li>
                </ul>
            </div>
        </div>

        <div class="row mt-4 pt-4 border-top border-secondary text-center opacity-75">
            <div class="col-12">
                <p class="mb-0">&copy; 2026 FurEver Home. All Rights Reserved. <strong>FurEver Home Management System</strong></p>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
