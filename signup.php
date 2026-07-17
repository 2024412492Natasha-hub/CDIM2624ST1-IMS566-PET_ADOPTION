<?php
include 'config.php';
session_start();

$error = "";
$success = "";

// Registration process
if (isset($_POST['signup'])) {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone_no = mysqli_real_escape_string($conn, $_POST['phone_no']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);
    $role     = mysqli_real_escape_string($conn, $_POST['role']); 

    // Check email
    $check_email = "SELECT * FROM users WHERE email='$email'";
    $run_check = $conn->query($check_email);

    if ($run_check && $run_check->num_rows > 0) {
        $error = "This email is already in use! Please use another email.";
    } else {
        
        $insert_query = "INSERT INTO users (name, email, password, phone_no, address, role) 
                         VALUES ('$name', '$email', '$password', '$phone_no', '$address', '$role')";
        
        if ($conn->query($insert_query)) {
            $success = "Account successfully registered! Please log in.";
        } else {
            $error = "Failed to register account: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Pet Adoption System</title>

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
        .signup-card {
            border: none;
            background: rgba(255, 255, 255, 0.45);
            border-radius: 20px;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            color: #333;
        }
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
        .form-control, .form-select {
            border-left: none;
        }
        .form-control:focus, .form-select:focus {
            box-shadow: none;
            border-color: #ced4da;
        }
        .login-link {
            color: #954535;
            text-decoration: none;
            font-weight: bold;
        }
        .login-link:hover {
            text-decoration: underline;
            color: #7b3326;
        }
    </style>
</head>

<body id="vanta-bg">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card signup-card p-4 mx-2">
                <div class="card-body">
                    
                    <div class="text-center mb-4">
                        <div class="brand" style="font-size: 38px; line-height: 1.1;">
                            <h1 class="fw-bold mb-0" style="font-size: inherit;">Join Us ฅ՞•ﻌ•՞ฅ</h1>
                        </div>
                        <div class="description mt-1">
                            <p class="text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Create Your Account Today</p>
                        </div>
                    </div>

                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fa-solid fa-circle-exclamation me-2"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($success)): ?>
                        <div class="alert alert-success" role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label text-secondary small fw-bold">Full Name</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-user"></i></span>
                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter your full name" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label text-secondary small fw-bold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-envelope"></i></span>
                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label text-secondary small fw-bold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone_no" class="form-label text-secondary small fw-bold">Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="phone_no" class="form-control" id="phone_no" placeholder="e.g. 0123456789" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label text-secondary small fw-bold">Address</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-location-dot"></i></span>
                                <textarea name="address" class="form-control" id="address" rows="2" placeholder="Enter your complete address" required></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label text-secondary small fw-bold">Account Type (Role)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white text-muted"><i class="fa-solid fa-user-tag"></i></span>
                                <select name="role" class="form-select" id="role" required>
                                    <option value="" selected disabled>Select your role...</option>
                                    <option value="adopter">Adopter (Pet Seeker)</option>
                                    <option value="admin">Admin (System Manager)</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" name="signup" class="btn btn-custom py-2 fw-bold">Sign Up</button>
                        </div>

                        <div class="text-center mt-3 small">
                            <span class="text-muted">Already have an account?</span> 
                            <a href="login.php" class="login-link ms-1">Log In Here</a>
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
