<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'adopter') {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_GET['pet_id'])) {
    header("Location: dashboard.php");
    exit();
}

$pet_id = intval($_GET['pet_id']);
$adopter_id = $_SESSION['user_id'];

// Mengambil data pet dan maklumat shelter
$pet_query = "SELECT pets.*, users.name as shelter_name FROM pets JOIN users ON pets.user_id = users.user_id WHERE pets.pet_id = $pet_id";
$pet_result = $conn->query($pet_query);

if ($pet_result->num_rows == 0) {
    echo "Pet not found.";
    exit();
}

$pet = $pet_result->fetch_assoc();

if (isset($_POST['submit_application'])) {
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $ic_passport = mysqli_real_escape_string($conn, $_POST['ic_passport']);
    $date_of_birth = !empty($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $home_type = mysqli_real_escape_string($conn, $_POST['home_type']);
    $ownership = mysqli_real_escape_string($conn, $_POST['ownership']);
    $household_members = intval($_POST['household_members']);
    $other_pets = mysqli_real_escape_string($conn, $_POST['other_pets']);
    $adopted_before = mysqli_real_escape_string($conn, $_POST['adopted_before']);
    $pet_care_experience = mysqli_real_escape_string($conn, $_POST['pet_care_experience']);
    $emergency_name = mysqli_real_escape_string($conn, $_POST['emergency_name']);
    $emergency_phone = mysqli_real_escape_string($conn, $_POST['emergency_phone']);
    $emergency_relationship = mysqli_real_escape_string($conn, $_POST['emergency_relationship']);
    $application_date = date('Y-m-d');
    $status = 'Pending'; 

    $stmt = $conn->prepare("INSERT INTO adoption_applications (pet_id, adopter_id, application_date, status, notes, ic_passport, date_of_birth, occupation, gender, home_type, ownership, household_members, other_pets, adopted_before, pet_care_experience, emergency_name, emergency_phone, emergency_relationship) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssssssssissssss", $pet_id, $adopter_id, $application_date, $status, $notes, $ic_passport, $date_of_birth, $occupation, $gender, $home_type, $ownership, $household_members, $other_pets, $adopted_before, $pet_care_experience, $emergency_name, $emergency_phone, $emergency_relationship);

    if ($stmt->execute()) {
        $conn->query("UPDATE pets SET status = 'Pending' WHERE pet_id = $pet_id");
        
        $shelter_id = $pet['user_id']; 
        $nama_adopter = $_SESSION['name']; 
        $nama_haiwan = $pet['pet_name']; 
        
        $message = "$nama_adopter has submitted an application to adopt $nama_haiwan.";
        $link = "manage_applications.php"; 
        
        $sql_noti = "INSERT INTO notifications (user_id, message, link, is_read) VALUES ($shelter_id, '$message', '$link', 0)";
        $conn->query($sql_noti);
        
        echo "<script>alert('Your adoption application has been submitted successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        $error = "Failed to submit application: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Application - <?php echo htmlspecialchars($pet['pet_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Menggunakan tema warna pastel FurEver Home */
        body {
            background-color: #fcf8f2; /* Warna krim lembut */
            color: #4a2825; /* Warna coklat gelap untuk teks */
        }
        .card {
            border: none;
            border-radius: 15px;
            background-color: #ffffff;
        }
        .text-theme-title {
            color: #691d17; /* Warna tajuk coklat pekat */
            font-weight: 700;
        }
        .detail-box {
            background-color: #f7ede2; /* Warna background detail pet */
            border-radius: 12px;
            border: 1px solid #eddcd2;
        }
        .btn-theme-submit {
            background-color: #c97a70; /* Warna butang submit pastel-coklat */
            color: white;
            border: none;
            font-weight: 600;
            padding: 10px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .btn-theme-submit:hover {
            background-color: #b5665c;
            color: white;
        }
        .btn-theme-cancel {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
        }
        .badge-custom {
            background-color: #eddcd2;
            color: #4a2825;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container mt-5 mb-5">
    <div class="card p-4 mx-auto shadow" style="max-width: 760px;">
        <h3 class="mb-4 text-center text-theme-title">Adoption Application Form</h3>
        
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <div class="detail-box p-3 mb-4 d-flex align-items-start">
            <?php if (!empty($pet['photo']) && file_exists("uploads/" . $pet['photo'])): ?>
                <img src="uploads/<?php echo htmlspecialchars($pet['photo']); ?>" style="width: 120px; height: 120px; object-fit: cover; border-radius: 10px;" class="me-3 shadow-sm">
            <?php else: ?>
                <div class="me-3 bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; border-radius: 10px;">No Image</div>
            <?php endif; ?>
            
            <div class="w-100">
                <h4 class="mb-1 text-theme-title"><?php echo htmlspecialchars($pet['pet_name']); ?></h4>
                <p class="text-muted mb-2" style="font-size: 0.9rem;">Managed by: <strong><?php echo htmlspecialchars($pet['shelter_name']); ?></strong></p>
                
                <div class="row g-2">
                    <div class="col-6">
                        <span class="badge badge-custom p-2 w-100 text-start">🐾 Species: <?php echo ucfirst(htmlspecialchars($pet['species'])); ?></span>
                    </div>
                    <div class="col-6">
                        <span class="badge badge-custom p-2 w-100 text-start">🎂 Age: <?php echo htmlspecialchars($pet['age']); ?></span>
                    </div>
                    <div class="col-6">
                        <span class="badge badge-custom p-2 w-100 text-start">📍 Location: <?php echo htmlspecialchars($pet['location']); ?></span>
                    </div>
                    <div class="col-6">
                        <span class="badge badge-custom p-2 w-100 text-start">📌 Status: <?php echo ucfirst(htmlspecialchars($pet['status'])); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST">
            <h5 class="text-theme-title mb-3">Applicant Information</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><strong>IC / Passport</strong></label>
                    <input type="text" name="ic_passport" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Date of Birth</strong></label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Occupation</strong></label>
                    <input type="text" name="occupation" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Gender</strong></label>
                    <select name="gender" class="form-control" required>
                        <option value="">Select gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </div>
            </div>

            <h5 class="text-theme-title mb-3">Living Arrangement</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><strong>Home Type</strong></label>
                    <input type="text" name="home_type" class="form-control" placeholder="House, Apartment, Condo" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Ownership</strong></label>
                    <input type="text" name="ownership" class="form-control" placeholder="Own House, Rent" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Household Members</strong></label>
                    <input type="number" name="household_members" class="form-control" min="1" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Other Pets</strong></label>
                    <input type="text" name="other_pets" class="form-control" placeholder="No, or describe pets" required>
                </div>
            </div>

            <h5 class="text-theme-title mb-3">Adoption Details</h5>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><strong>Adopted Before</strong></label>
                    <select name="adopted_before" class="form-control" required>
                        <option value="">Select answer</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><strong>Pet Care Experience</strong></label>
                    <input type="text" name="pet_care_experience" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label"><strong>Notes / Reason for Adoption</strong></label>
                <textarea name="notes" class="form-control" rows="4" placeholder="Tell the shelter a bit about yourself, your experience with pets, or why you want to adopt this pet..." style="border-radius: 8px;" required></textarea>
                <div class="form-text text-muted">This note will be thoroughly reviewed by the shelter management.</div>
            </div>

            <h5 class="text-theme-title mb-3">Emergency Contact</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label"><strong>Name</strong></label>
                    <input type="text" name="emergency_name" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Phone</strong></label>
                    <input type="text" name="emergency_phone" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label"><strong>Relationship</strong></label>
                    <input type="text" name="emergency_relationship" class="form-control" required>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-8">
                    <button type="submit" name="submit_application" class="btn btn-theme-submit w-100">Submit Application</button>
                </div>
                <div class="col-md-4">
                    <a href="dashboard.php" class="btn btn-theme-cancel w-100">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
