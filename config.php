<?php
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "pet_adoption";

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Sambungan gagal: " . $conn->connect_error);
}
?>