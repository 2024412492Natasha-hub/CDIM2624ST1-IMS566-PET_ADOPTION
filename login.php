<?php
include 'config.php';
session_start();

$error = "";

// Proses log masuk apabila borang dihantar
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Semak pengguna melalui email dahulu, kemudian sahkan kata laluan.
    // Ini menyokong password lama plain text dan password baru yang di-hash.
    $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $stored_password = $user['password'];
        $password_ok = password_verify($password, $stored_password) || hash_equals($stored_password, $password);

        if ($password_ok) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            header("Location: dashboard.php");
            exit();
        }
    }

    $error = "E-mel atau kata laluan salah!";
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk | Pet Adoption System</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&family=Yesteryear&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=Chango&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }
        /* Kesan Glassmorphism Lutsinar */
        .login-card {
            border: none;
            background: rgba(255, 255, 255, 0.45);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            color: #333;
        }
        /* Warna butang utama */
        .btn-custom {
            background-color: #954535;
            color: white;
            border-radius: 8px;
            transition: background-color 0.2s;
        }
        .btn-custom:hover {
            background-color: #7b3326;
            color: white;
        }
        /* Gaya tulisan tajuk utama */
        .brand {
            font-family: "Chango", sans-serif;
            font-weight: 300;
            font-style: normal;
            color: #800020;
            letter-spacing: 2px;
        }
        .input-group-text {
            border-right: none;
        }
        .form-control {
            border-left: none;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .signup-link {
            color: #954535;
            text-decoration: none;
            font-weight: bold;
        }
        .signup-link:hover {
            text-decoration: underline;
            color: #7b3326;
        }
    </style>
</head>

<body id="vanta-bg">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card login-card p-4 mx-2">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <div class="brand" style="font-size: 50px; line-height: 1.1;">
                            <h1 class="fw-bold mb-0" style="font-size: inherit;">FurEver Home ฅ՞•ﻌ•՞ฅ</h1>
                        </div>
                        <div class="description mt-1">
                            <p class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Animal Adoption Management System</p>
                        </div>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div id="errorAlert" class="alert alert-danger" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary small fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label text-secondary small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" name="login" class="btn btn-custom py-2 fw-bold">Log In</button>
                        </div>

                        <div class="text-center mt-3 small">
                            <span class="text-muted">Don't have an account?</span> 
                            <a href="signup.php" class="signup-link ms-1">Sign Up Here</a>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanta@latest/dist/vanta.fog.min.js"></script>
<script>
    // Membina semula latar hiasan kabus eksklusif
    VANTA.FOG({
        el: "#vanta-bg",
        mouseControls: true,
        touchControls: true,
        gyroControls: false,
        minHeight: 200.00,
        minWidth: 200.00,
        highlightColor: 0xe3cbb3,
        midtoneColor: 0xca9a71,
        lowlightColor: 0xdfc29d,
        baseColor: 0xfcf8f2
    });
</script>
</body>
</html>
