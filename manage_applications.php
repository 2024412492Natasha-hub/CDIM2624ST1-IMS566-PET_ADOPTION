<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] == 'adopter') {
    header("Location: dashboard.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role'];

if (isset($_GET['action']) && isset($_GET['app_id'])) {
    $action = $_GET['action']; 
    $app_id = intval($_GET['app_id']);
    
    $new_status = ($action == 'approve') ? 'Approved' : 'Rejected';

    $app_info_query = "SELECT aa.*, p.pet_name, p.user_id as pet_owner_id FROM adoption_applications aa 
                       JOIN pets p ON aa.pet_id = p.pet_id 
                       WHERE aa.application_id = $app_id";
    $app_info_res = $conn->query($app_info_query);

    if ($app_info_res && $app_info_res->num_rows > 0) {
        $app_data = $app_info_res->fetch_assoc();
        
        if ($user_role == 'admin' || $app_data['pet_owner_id'] == $user_id) {
            $update_sql = "UPDATE adoption_applications SET status = '$new_status' WHERE application_id = $app_id";
            
            if ($conn->query($update_sql)) {
                if ($new_status == 'Approved') {
                    $conn->query("UPDATE pets SET status = 'Adopted' WHERE pet_id = " . $app_data['pet_id']);
                } else {
                    $conn->query("UPDATE pets SET status = 'Available' WHERE pet_id = " . $app_data['pet_id']);
                }

                // =================================================================
                // SITUASI 2: ENGLISH NOTIFICATION + CORRECT REDIRECT LINK
                // =================================================================
                $receiver_adopter_id = $app_data['adopter_id'];
                $nama_pet = $app_data['pet_name'];
                
                if ($new_status == 'Approved') {
                    $msg_noti = "Congratulations! Your application to adopt $nama_pet has been APPROVED.";
                } else {
                    $msg_noti = "We regret to inform you that your application to adopt $nama_pet has been REJECTED.";
                }
                
                // Diperbetulkan pautan ke fail senarai permohonan adopter
                $link_noti = "my_applications.php"; 
                
                $ins_noti = "INSERT INTO notifications (user_id, message, link, is_read) 
                             VALUES ($receiver_adopter_id, '$msg_noti', '$link_noti', 0)";
                $conn->query($ins_noti);
                // =================================================================

                echo "<script>alert('Application status updated and notification sent successfully!'); window.location.href='manage_applications.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Unauthorized action.'); window.location.href='manage_applications.php';</script>";
            exit();
        }
    }
}

if ($user_role == 'admin') {
    $query = "SELECT aa.*, p.pet_name, p.photo, u.name as adopter_name, u.email as adopter_email 
              FROM adoption_applications aa
              JOIN pets p ON aa.pet_id = p.pet_id
              JOIN users u ON aa.adopter_id = u.user_id
              ORDER BY aa.application_date DESC";
} else {
    $query = "SELECT aa.*, p.pet_name, p.photo, u.name as adopter_name, u.email as adopter_email 
              FROM adoption_applications aa
              JOIN pets p ON aa.pet_id = p.pet_id
              JOIN users u ON aa.adopter_id = u.user_id
              WHERE p.user_id = $user_id
              ORDER BY aa.application_date DESC";
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Applications | PawLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcf8f2; }
        .pet-mini-img { width: 50px; height: 50px; object-fit: cover; border-radius: 5px; }
    </style>
</head>
<body>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <h4 class="mb-0"><i class="fa-solid fa-file-invoice me-2 text-primary"></i>Adoption Applications Management</h4>
        <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <div class="card p-4 shadow-sm bg-white">
        <table class="table table-hover table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>Pet Name</th>
                    <th>Applicant Name (Adopter)</th>
                    <th>Applied Date</th>
                    <th>Applicant Notes</th>
                    <th>Current Status</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if (!empty($row['photo']) && file_exists("uploads/" . $row['photo'])): ?>
                                    <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" class="pet-mini-img" alt="Pet">
                                <?php else: ?>
                                    <span class="badge bg-secondary">None</span>
                                <?php endif; ?>
                            </td>
                            <td><strong><?php echo htmlspecialchars($row['pet_name']); ?></strong></td>
                            <td>
                                <?php echo htmlspecialchars($row['adopter_name']); ?><br>
                                <small class="text-muted"><?php echo htmlspecialchars($row['adopter_email']); ?></small>
                            </td>
                            <td><?php echo date('d-m-Y', strtotime($row['application_date'])); ?></td>
                            <td><small><?php echo nl2br(htmlspecialchars($row['notes'])); ?></small></td>
                            <td>
                                <?php 
                                if ($row['status'] == 'Pending') $badge_class = 'bg-warning text-dark';
                                elseif ($row['status'] == 'Approved') $badge_class = 'bg-success';
                                else $badge_class = 'bg-danger';
                                ?>
                                <span class="badge <?php echo $badge_class; ?> text-capitalize"><?php echo $row['status']; ?></span>
                            </td>
                            <td class="text-center">
                                <a href="application_letter.php?application_id=<?php echo $row['application_id']; ?>" class="btn btn-outline-danger btn-sm me-1">
                                    <i class="fa-solid fa-file-pdf"></i> Letter
                                </a>
                                <?php if ($row['status'] == 'Pending'): ?>
                                    <a href="manage_applications.php?action=approve&app_id=<?php echo $row['application_id']; ?>" 
                                       class="btn btn-success btn-sm me-1" onclick="return confirm('Approve this adoption application?')">
                                        <i class="fa fa-check"></i> Approve
                                    </a>
                                    <a href="manage_applications.php?action=reject&app_id=<?php echo $row['application_id']; ?>" 
                                       class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to reject this application?')">
                                        <i class="fa fa-times"></i> Reject
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted"><small>Processed</small></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted p-4">No adoption applications received yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
