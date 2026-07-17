<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'adopter') {
    header("Location: dashboard.php");
    exit();
}

if (!isset($_GET['application_id'])) {
    header("Location: my_applications.php");
    exit();
}

$application_id = intval($_GET['application_id']);
$adopter_id = intval($_SESSION['user_id']);

$query = "SELECT aa.*, p.pet_name, p.species, p.breed, p.photo, p.user_id AS shelter_id, u.name AS shelter_name
          FROM adoption_applications aa
          JOIN pets p ON aa.pet_id = p.pet_id
          JOIN users u ON p.user_id = u.user_id
          WHERE aa.application_id = $application_id AND aa.adopter_id = $adopter_id
          LIMIT 1";

$result = $conn->query($query);
if (!$result || $result->num_rows === 0) {
    echo "Application not found.";
    exit();
}

$application = $result->fetch_assoc();
$error = "";

if (isset($_POST['update_application'])) {
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $ic_passport = mysqli_real_escape_string($conn, $_POST['ic_passport']);
    $date_of_birth = !empty($_POST['date_of_birth']) ? "'" . mysqli_real_escape_string($conn, $_POST['date_of_birth']) . "'" : "NULL";
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

    $update_sql = "UPDATE adoption_applications SET
                    notes = '$notes',
                    ic_passport = '$ic_passport',
                    date_of_birth = $date_of_birth,
                    occupation = '$occupation',
                    gender = '$gender',
                    home_type = '$home_type',
                    ownership = '$ownership',
                    household_members = $household_members,
                    other_pets = '$other_pets',
                    adopted_before = '$adopted_before',
                    pet_care_experience = '$pet_care_experience',
                    emergency_name = '$emergency_name',
                    emergency_phone = '$emergency_phone',
                    emergency_relationship = '$emergency_relationship'
                   WHERE application_id = $application_id AND adopter_id = $adopter_id";

    if ($conn->query($update_sql)) {
        $message = mysqli_real_escape_string($conn, $_SESSION['name'] . " updated the adoption application for " . $application['pet_name'] . ".");
        $link = "application_letter.php?application_id=" . $application_id;
        $conn->query("INSERT INTO notifications (user_id, message, link, is_read) VALUES (" . intval($application['shelter_id']) . ", '$message', '$link', 0)");

        echo "<script>alert('Application updated successfully.'); window.location.href='application_letter.php?application_id=$application_id';</script>";
        exit();
    }

    $error = "Failed to update application: " . $conn->error;
}

function selected($current, $value) {
    return ((string)$current === (string)$value) ? 'selected' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Adoption Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcf8f2; color: #4a2825; }
        .form-card { max-width: 780px; border: 0; border-radius: 14px; }
        .section-title { color: #691d17; font-weight: 800; font-size: 1rem; }
        .pet-chip { background: #f7ede2; border: 1px solid #eddcd2; border-radius: 10px; }
        .btn-theme { background: #8b1f1f; color: #fff; font-weight: 700; }
        .btn-theme:hover { background: #6f1818; color: #fff; }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="card form-card shadow-sm mx-auto p-4">
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h3 class="mb-0"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Edit Adoption Application</h3>
            <a href="my_applications.php" class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="pet-chip p-3 mb-4">
            <strong><?php echo htmlspecialchars($application['pet_name']); ?></strong>
            <span class="text-muted text-capitalize"> | <?php echo htmlspecialchars($application['species']); ?> (<?php echo htmlspecialchars($application['breed']); ?>)</span>
            <br><small>Managed by: <?php echo htmlspecialchars($application['shelter_name']); ?></small>
        </div>

        <form method="POST">
            <h5 class="section-title mb-3">Applicant Information</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">IC / Passport</label>
                    <input type="text" name="ic_passport" class="form-control" value="<?php echo htmlspecialchars($application['ic_passport']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?php echo htmlspecialchars($application['date_of_birth']); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Occupation</label>
                    <input type="text" name="occupation" class="form-control" value="<?php echo htmlspecialchars($application['occupation']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Gender</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select gender</option>
                        <option value="Male" <?php echo selected($application['gender'], 'Male'); ?>>Male</option>
                        <option value="Female" <?php echo selected($application['gender'], 'Female'); ?>>Female</option>
                    </select>
                </div>
            </div>

            <h5 class="section-title mb-3">Living Arrangement</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Home Type</label>
                    <input type="text" name="home_type" class="form-control" value="<?php echo htmlspecialchars($application['home_type']); ?>" placeholder="House, Apartment, Condo" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Ownership</label>
                    <input type="text" name="ownership" class="form-control" value="<?php echo htmlspecialchars($application['ownership']); ?>" placeholder="Own House, Rent" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Household Members</label>
                    <input type="number" name="household_members" class="form-control" min="1" value="<?php echo htmlspecialchars($application['household_members']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Other Pets</label>
                    <input type="text" name="other_pets" class="form-control" value="<?php echo htmlspecialchars($application['other_pets']); ?>" placeholder="No, or describe pets" required>
                </div>
            </div>

            <h5 class="section-title mb-3">Adoption Details</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Adopted Before</label>
                    <select name="adopted_before" class="form-select" required>
                        <option value="">Select answer</option>
                        <option value="Yes" <?php echo selected($application['adopted_before'], 'Yes'); ?>>Yes</option>
                        <option value="No" <?php echo selected($application['adopted_before'], 'No'); ?>>No</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Pet Care Experience</label>
                    <input type="text" name="pet_care_experience" class="form-control" value="<?php echo htmlspecialchars($application['pet_care_experience']); ?>" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Reason for Adoption</label>
                    <textarea name="notes" class="form-control" rows="3" required><?php echo htmlspecialchars($application['notes']); ?></textarea>
                </div>
            </div>

            <h5 class="section-title mb-3">Emergency Contact</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold">Name</label>
                    <input type="text" name="emergency_name" class="form-control" value="<?php echo htmlspecialchars($application['emergency_name']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Phone</label>
                    <input type="text" name="emergency_phone" class="form-control" value="<?php echo htmlspecialchars($application['emergency_phone']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">Relationship</label>
                    <input type="text" name="emergency_relationship" class="form-control" value="<?php echo htmlspecialchars($application['emergency_relationship']); ?>" required>
                </div>
            </div>

            <div class="row g-2">
                <div class="col-md-8">
                    <button type="submit" name="update_application" class="btn btn-theme w-100 py-2">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Save Application
                    </button>
                </div>
                <div class="col-md-4">
                    <a href="application_letter.php?application_id=<?php echo $application_id; ?>" class="btn btn-secondary w-100 py-2">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>
</body>
</html>
