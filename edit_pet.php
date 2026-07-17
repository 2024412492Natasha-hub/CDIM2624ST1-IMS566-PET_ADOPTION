<?php
include 'config.php';
session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'adopter') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];


if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$pet_id = intval($_GET['id']);


$query = "SELECT * FROM pets WHERE pet_id = $pet_id";
$result = $conn->query($query);

if (!$result || $result->num_rows == 0) {
    echo "Animal records not found.";
    exit();
}

$pet = $result->fetch_assoc();


if ($user_role != 'admin' && $pet['user_id'] != $user_id) {
    echo "<script>alert('You do not have permission to modify this record.'); window.location.href='dashboard.php';</script>";
    exit();
}

$error = "";
$success = "";
$age_number = "";
$age_unit = "Years";

if (preg_match('/^\s*(\d+)\s*(month|months|year|years)\s*$/i', (string)$pet['age'], $age_parts)) {
    $age_number = $age_parts[1];
    $age_unit = stripos($age_parts[2], 'month') === 0 ? 'Months' : 'Years';
} elseif (preg_match('/^\s*(\d+)\s*$/', (string)$pet['age'], $age_parts)) {
    $age_number = $age_parts[1];
    $age_unit = "Years";
}

// Update data
if (isset($_POST['update_pet'])) {
    $pet_name = mysqli_real_escape_string($conn, $_POST['pet_name']);
    $species = mysqli_real_escape_string($conn, $_POST['species']);
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $age_number = max(0, intval($_POST['age_number']));
    $age_unit = in_array($_POST['age_unit'], ['Months', 'Years']) ? $_POST['age_unit'] : 'Years';
    $age = mysqli_real_escape_string($conn, $age_number . ' ' . $age_unit);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    $photo_name = $pet['photo']; 

    if (!empty($_FILES['photo']['name'])) {
        $target_dir = "uploads/";
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $photo_name = time() . "_" . uniqid() . "." . $file_extension;
        $target_file = $target_dir . $photo_name;

        
        if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $error = "Failed to upload new image.";
        }
    }

    if (empty($error)) {
        
        $update_sql = "UPDATE pets SET 
                        pet_name = '$pet_name', 
                        species = '$species', 
                        breed = '$breed', 
                        age = '$age', 
                        gender = '$gender', 
                        location = '$location', 
                        status = '$status', 
                        photo = '$photo_name' 
                       WHERE pet_id = $pet_id";

        if ($conn->query($update_sql)) {
            echo "<script>alert('Animal information successfully updated!'); window.location.href='dashboard.php';</script>";
            exit();
        } else {
            $error = "Failed to update the database: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pet | FurEver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcf8f2; }
        .form-card { border-radius: 15px; border: 1px solid #f3e1c3; }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="card form-card shadow-sm p-4 mx-auto" style="max-width: 700px; background-color: #ffffff;">
        <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
            <h3 class="text-secondary"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Update Pet Information</h3>
            <a href="dashboard.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left"></i> Cancel</a>
        </div>

        <?php if(!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Pet Name</label>
                    <input type="text" name="pet_name" class="form-control" value="<?php echo htmlspecialchars($pet['pet_name']); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Species</label>
                    <select name="species" class="form-select" required>
                        <option value="cat" <?php if($pet['species'] == 'cat') echo 'selected'; ?>>Cat</option>
                        <option value="dog" <?php if($pet['species'] == 'dog') echo 'selected'; ?>>Dog</option>
                        <option value="rabbit" <?php if($pet['species'] == 'rabbit') echo 'selected'; ?>>Rabbit</option>
                        <option value="bird" <?php if($pet['species'] == 'bird') echo 'selected'; ?>>Bird</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Breed</label>
                    <input type="text" name="breed" class="form-control" value="<?php echo htmlspecialchars($pet['breed']); ?>" placeholder="Example: Persian, Mixed">
                </div>

                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Age</label>
                    <input type="number" name="age_number" class="form-control" min="0" value="<?php echo htmlspecialchars($age_number); ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">Age Unit</label>
                    <select name="age_unit" class="form-select" required>
                        <option value="Months" <?php if($age_unit == 'Months') echo 'selected'; ?>>Months</option>
                        <option value="Years" <?php if($age_unit == 'Years') echo 'selected'; ?>>Years</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="Male" <?php if($pet['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                        <option value="Female" <?php if($pet['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Location</label>
                    <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($pet['location']); ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Availability Status</label>
                    <select name="status" class="form-select" required>
                        <option value="Available" <?php if($pet['status'] == 'Available') echo 'selected'; ?>>Available for Adoption</option>
                        <option value="Pending" <?php if($pet['status'] == 'Pending') echo 'selected'; ?>>Under Consideration</option>
                        <option value="Adopted" <?php if($pet['status'] == 'Adopted') echo 'selected'; ?>>Already Adopted</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Change Image (Leave blank if no change)</label>
                    <input type="file" name="photo" class="form-control" accept="image/*">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label d-block fw-bold">Existing Image:</label>
                <?php if (!empty($pet['photo']) && file_exists("uploads/" . $pet['photo'])): ?>
                    <img src="uploads/<?php echo $pet['photo']; ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px;" class="border shadow-sm">
                <?php else: ?>
                    <span class="text-muted small">No image uploaded previously.</span>
                <?php endif; ?>
            </div>

            <button type="submit" name="update_pet" class="btn btn-primary w-100 fw-bold py-2"><i class="fa fa-save me-2"></i>Save Changes</button>
        </form>
    </div>
</div>
</body>
</html>
