<?php
include 'config.php';
session_start();

// User login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


if (isset($_GET['action']) && $_GET['action'] == 'mark_all_read') {
    $conn->query("UPDATE notifications SET is_read = 1 WHERE user_id = $user_id");
    header("Location: notifications.php");
    exit();
}

if (isset($_GET['read_id'])) {
    $read_id = intval($_GET['read_id']);
    $conn->query("UPDATE notifications SET is_read = 1 WHERE notification_id = $read_id AND user_id = $user_id");
    
    if (isset($_GET['redirect_url']) && !empty($_GET['redirect_url'])) {
        header("Location: " . $_GET['redirect_url']);
    } else {
        header("Location: notifications.php");
    }
    exit();
}

$query = "SELECT * FROM notifications WHERE user_id = $user_id ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Pet Adoption</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fcf8f2;
        }
        .noti-item {
            border-left: 5px solid #6c757d;
            transition: background-color 0.2s;
        }
        .noti-unread {
            background-color: #fff4db !important; 
            border-left: 5px solid #ffc107;
        }
        .noti-item:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4 shadow-sm mx-auto" style="max-width: 800px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-secondary"><i class="fa fa-bell text-warning me-2"></i>Your Notifications</h3>
            <div>
                <a href="notifications.php?action=mark_all_read" class="btn btn-outline-secondary btn-sm me-2">Mark All as Read</a>
                <a href="dashboard.php" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back to Dashboard</a>
            </div>
        </div>

        <div class="list-group">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    
                    <a href="notifications.php?read_id=<?php echo $row['notification_id']; ?>&redirect_url=<?php echo urlencode($row['link']); ?>" 
                       class="list-group-item list-group-item-action noti-item <?php echo $row['is_read'] == 0 ? 'noti-unread' : ''; ?> p-3 mb-2 rounded shadow-sm">
                        
                        <div class="d-flex w-100 justify-content-between align-items-center">
                            <h6 class="mb-1 text-dark">
                                <?php if($row['is_read'] == 0): ?>
                                    <i class="fa-solid fa-circle text-warning me-2" style="font-size: 10px;"></i>
                                <?php endif; ?>
                                <?php echo htmlspecialchars($row['message']); ?>
                            </h6>
                            <small class="text-muted">
                                <i class="fa-regular fa-clock me-1"></i><?php echo date('M j, g:i a', strtotime($row['created_at'])); ?>
                            </small>
                        </div>
                        
                        <?php if(!empty($row['link'])): ?>
                            <small class="text-primary d-block mt-2"><i class="fa fa-link me-1"></i> Click to view application details</small>
                        <?php endif; ?>
                    </a>

                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center p-5 bg-light rounded">
                    <i class="fa fa-bell-slash text-muted fa-3x mb-3"></i>
                    <p class="text-muted mb-0">No notifications available at this time.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>