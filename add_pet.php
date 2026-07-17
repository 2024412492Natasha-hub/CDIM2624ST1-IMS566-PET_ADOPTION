<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'adopter') {
    header("Location: dashboard.php");
    exit();
}

if (isset($_POST['add_pet'])) {
    $user_id = $_SESSION['user_id'];
    $pet_name = mysqli_real_escape_string($conn, $_POST['pet_name']);
    $species = $_POST['species'];
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $age_number = max(0, intval($_POST['age_number']));
    $age_unit = in_array($_POST['age_unit'], ['Months', 'Years']) ? $_POST['age_unit'] : 'Years';
    $age = $age_number . ' ' . $age_unit;
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    
    // --- UPLOAD IMAGE ---
    $photo_name = $_FILES['photo']['name'];
    $photo_tmp = $_FILES['photo']['tmp_name'];
    $upload_folder = "uploads/"; 

    
    if (!is_dir($upload_folder)) {
        mkdir($upload_folder, 0777, true);
    }

    // Change image name
    $unique_photo_name = time() . "_" . $photo_name;
    $target_file = $upload_folder . $unique_photo_name;

    // Move file
    if (move_uploaded_file($photo_tmp, $target_file)) {
        $photo_db_value = $unique_photo_name; 
    } else {
        $photo_db_value = NULL; 
    }
    

    //Insert data
    $query = "INSERT INTO pets (user_id, pet_name, species, breed, age, gender, size, description, location, photo, status) 
              VALUES ('$user_id', '$pet_name', '$species', '$breed', '$age', '$gender', '$size', '$description', '$location', '$photo_db_value', 'Available')";
    
    if ($conn->query($query)) {
        header("Location: dashboard.php");
    } else {
        $error = "Gagal menambah data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <title>Add new pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 mx-auto shadow-sm" style="max-width: 600px;">
        <h3>Add new pet</h3>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Pet Name</label>
                <input type="text" name="pet_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Species</label>
                <select name="species" class="form-control" required>
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="rabbit">Rabbit</option>
                    <option value="bird">Bird</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Breed</label>
                <input type="text" name="breed" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Age</label>
                    <input type="number" name="age_number" class="form-control" min="0" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Age Unit</label>
                    <select name="age_unit" class="form-control" required>
                        <option value="Months">Months</option>
                        <option value="Years">Years</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
                <div class="col-md-2 mb-3">
                    <label>Size</label>
                    <select name="size" class="form-control">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3">
                <label>Pet Image</label>
                <input type="file" name="photo" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" class="form-control">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
            <button type="submit" name="add_pet" class="btn btn-success w-100">Save Information</button>
            <a href="dashboard.php" class="btn btn-secondary w-100 mt-2">Back</a>
        </form>
    </div>
</div>
</body>
</html>
