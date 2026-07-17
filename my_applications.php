<?php
include 'config.php';
session_start();

// Pastikan pengguna telah log masuk dan peranan mereka adalah 'adopter'
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'adopter') {
    header("Location: dashboard.php");
    exit();
}

$adopter_id = $_SESSION['user_id'];

// Mengambil senarai permohonan adopsi milik adopter ini sahaja
$query = "SELECT aa.*, p.pet_name, p.photo, p.species, p.breed, u.name as shelter_name 
          FROM adoption_applications aa
          JOIN pets p ON aa.pet_id = p.pet_id
          JOIN users u ON p.user_id = u.user_id
          WHERE aa.adopter_id = $adopter_id
          ORDER BY aa.application_date DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Adoption Applications | PawLink</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #fcf8f2; }
        .pet-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
        .card-custom { border-radius: 15px; border: none; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded shadow-sm">
        <h4 class="mb-0 text-secondary"><i class="fa-solid fa-folder-open me-2 text-primary"></i>My Adoption Applications</h4>
        <a href="dashboard.php" class="btn btn-secondary btn-sm"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
    </div>

    <div class="card p-4 shadow-sm bg-white card-custom">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Pet Photo</th>
                        <th>Pet Name</th>
                        <th>Managed By (Shelter)</th>
                        <th>Applied Date</th>
                        <th>My Notes</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php if (!empty($row['photo']) && file_exists("uploads/" . $row['photo'])): ?>
                                        <img src="uploads/<?php echo htmlspecialchars($row['photo']); ?>" class="pet-img border" alt="Pet">
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No Image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($row['pet_name']); ?></strong>
                                    <br><small class="text-muted text-capitalize"><?php echo htmlspecialchars($row['species']); ?> (<?php echo htmlspecialchars($row['breed']); ?>)</small>
                                </td>
                                <td><i class="fa-solid fa-house-chimney text-muted me-1" style="font-size: 0.85rem;"></i> <?php echo htmlspecialchars($row['shelter_name']); ?></td>
                                <td><?php echo date('F j, Y', strtotime($row['application_date'])); ?></td>
                                <td>
                                    <p class="mb-0 text-muted small" style="max-width: 250px; word-wrap: break-word;">
                                        <?php echo nl2br(htmlspecialchars($row['notes'])); ?>
                                    </p>
                                </td>
                                <td class="text-center">
                                    <?php 
                                    // Tetapan warna lencana mengikut status (Dalam Bahasa Inggeris)
                                    if ($row['status'] == 'Pending') {
                                        $badge_class = 'bg-warning text-dark';
                                        $status_text = 'Pending';
                                    } elseif ($row['status'] == 'Approved') {
                                        $badge_class = 'bg-success';
                                        $status_text = 'Approved';
                                    } else {
                                        $badge_class = 'bg-danger';
                                        $status_text = 'Rejected';
                                    }
                                    ?>
                                    <span class="badge <?php echo $badge_class; ?> px-3 py-2 text-uppercase" style="font-size: 0.75rem; letter-spacing: 0.5px;">
                                        <?php echo $status_text; ?>
                                    </span>
                                    <br>
                                    <a href="edit_application.php?application_id=<?php echo $row['application_id']; ?>" class="btn btn-outline-primary btn-sm mt-2">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <a href="application_letter.php?application_id=<?php echo $row['application_id']; ?>" class="btn btn-outline-danger btn-sm mt-2">
                                        <i class="fa-solid fa-file-pdf"></i> Download PDF
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted p-5">
                                <i class="fa-solid fa-file-circle-xmark fa-3x mb-3 text-black-50"></i>
                                <p class="mb-0">You haven't submitted any adoption applications yet.</p>
                                <a href="dashboard.php" class="btn btn-primary btn-sm mt-3">Browse Pets Available</a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
