<?php
include 'config.php';
session_start();
require_once 'letter_template.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['application_id'])) {
    header("Location: dashboard.php");
    exit();
}

$autoload = __DIR__ . '/vendor/autoload.php';
if (!file_exists($autoload)) {
    die("PDF library is not installed. Run: composer install");
}

require_once $autoload;

use Dompdf\Dompdf;
use Dompdf\Options;

$application_id = intval($_GET['application_id']);
$user_id = intval($_SESSION['user_id']);
$role = $_SESSION['role'];

$query = "SELECT aa.*, 
                 p.pet_name, p.species, p.breed, p.user_id AS pet_owner_id,
                 adopter.name AS adopter_name, adopter.email, adopter.phone_no, adopter.address,
                 shelter.name AS shelter_name
          FROM adoption_applications aa
          JOIN pets p ON aa.pet_id = p.pet_id
          JOIN users adopter ON aa.adopter_id = adopter.user_id
          JOIN users shelter ON p.user_id = shelter.user_id
          WHERE aa.application_id = $application_id
          LIMIT 1";

$result = $conn->query($query);
if (!$result || $result->num_rows === 0) {
    echo "Application not found.";
    exit();
}

$data = $result->fetch_assoc();
$can_view = ($role === 'admin') || ($role === 'adopter' && intval($data['adopter_id']) === $user_id) || ($role !== 'adopter' && intval($data['pet_owner_id']) === $user_id);

if (!$can_view) {
    echo "Unauthorized access.";
    exit();
}

$options = new Options();
$options->set('isRemoteEnabled', false);
$options->set('defaultFont', 'DejaVu Sans');

$dompdf = new Dompdf($options);
$dompdf->loadHtml(render_application_letter_html($data, false));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$safeName = preg_replace('/[^A-Za-z0-9_-]+/', '_', $data['adopter_name']);
$filename = 'Letter_' . trim($safeName, '_') . '_' . date('Y-m-d') . '.pdf';

$dompdf->stream($filename, ['Attachment' => true]);
exit();
?>
