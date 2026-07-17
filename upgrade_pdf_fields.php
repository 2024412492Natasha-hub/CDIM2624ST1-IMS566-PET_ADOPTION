<?php
require_once 'config.php';

$columns = [
    "ic_passport VARCHAR(50) DEFAULT NULL",
    "date_of_birth DATE DEFAULT NULL",
    "occupation VARCHAR(100) DEFAULT NULL",
    "gender ENUM('Male','Female') DEFAULT NULL",
    "home_type VARCHAR(100) DEFAULT NULL",
    "ownership VARCHAR(100) DEFAULT NULL",
    "household_members INT(11) DEFAULT NULL",
    "other_pets VARCHAR(255) DEFAULT NULL",
    "adopted_before ENUM('Yes','No') DEFAULT NULL",
    "pet_care_experience TEXT DEFAULT NULL",
    "emergency_name VARCHAR(255) DEFAULT NULL",
    "emergency_phone VARCHAR(30) DEFAULT NULL",
    "emergency_relationship VARCHAR(100) DEFAULT NULL"
];

foreach ($columns as $definition) {
    $column = strtok($definition, ' ');
    $check = $conn->query("SHOW COLUMNS FROM adoption_applications LIKE '$column'");
    if ($check && $check->num_rows === 0) {
        if (!$conn->query("ALTER TABLE adoption_applications ADD COLUMN $definition")) {
            die("Failed adding $column: " . $conn->error);
        }
    }
}

$conn->query("UPDATE adoption_applications SET status = 'Pending' WHERE status = 'pending'");
$conn->query("UPDATE adoption_applications SET status = 'Approved' WHERE status = 'approved'");
$conn->query("UPDATE adoption_applications SET status = 'Rejected' WHERE status = 'rejected'");
$conn->query("UPDATE pets SET status = 'Available' WHERE status = 'available'");
$conn->query("UPDATE pets SET status = 'Adopted' WHERE status = 'adopted'");
$conn->query("UPDATE pets SET status = 'Pending' WHERE status = 'pending'");
$conn->query("UPDATE pets SET gender = 'Male' WHERE gender = 'male'");
$conn->query("UPDATE pets SET gender = 'Female' WHERE gender = 'female'");
$conn->query("UPDATE pets SET size = 'Small' WHERE size = 'small'");
$conn->query("UPDATE pets SET size = 'Medium' WHERE size = 'medium'");
$conn->query("UPDATE pets SET size = 'Large' WHERE size = 'large'");

echo "Database upgrade completed.";
?>
