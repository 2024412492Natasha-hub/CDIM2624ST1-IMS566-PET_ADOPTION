<?php
function h($value) {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function application_number($application_id) {
    return 'APP' . str_pad((string)$application_id, 4, '0', STR_PAD_LEFT);
}

function render_application_letter_html($data, $show_button = false, $show_edit = false) {
    $applicationNo = application_number($data['application_id']);
    $status = $data['status'] ?: 'Pending';
    $applicationDate = !empty($data['application_date']) ? date('Y-m-d', strtotime($data['application_date'])) : '';
    $dob = !empty($data['date_of_birth']) ? date('Y-m-d', strtotime($data['date_of_birth'])) : '';
    $species = !empty($data['species']) ? ucfirst((string)$data['species']) : '';
    $petLabel = trim($species . ' - ' . ($data['pet_name'] ?? ''), ' -');

    ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pet Adoption Application <?php echo h($applicationNo); ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 12mm 12mm 10mm 12mm;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #ffffff;
            color: #111;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 9px;
            line-height: 1.15;
        }
        .toolbar {
            max-width: 176mm;
            margin: 20px auto 0;
            text-align: right;
        }
        .btn {
            display: inline-block;
            padding: 9px 13px;
            border-radius: 6px;
            background: #8b1f1f;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }
        .btn-secondary { background: #6c757d; margin-right: 8px; }
        .page {
            width: 100%;
            margin: 0 auto;
            padding: 0;
            background: #fff;
            border: 0;
        }
        .doc-title {
            text-align: center;
            margin: 0 0 10px;
        }
        .doc-title h1 {
            font-size: 18px;
            margin: 0 0 5px;
            letter-spacing: 0;
            line-height: 1;
        }
        .doc-meta {
            font-size: 10px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 7px;
            page-break-inside: avoid;
        }
        th {
            background: #eeeeee;
            text-align: left;
            padding: 5px 5px;
            border: 1px solid #cfcfcf;
            font-size: 9px;
            font-weight: bold;
        }
        td {
            border: 1px solid #cfcfcf;
            padding: 5px;
            vertical-align: top;
            min-height: 20px;
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-word;
        }
        td.label {
            width: 29%;
            font-weight: normal;
            background: #ffffff;
        }
        @media print {
            body { background: #fff; }
            .toolbar { display: none; }
            .page { margin: 0; border: 0; width: 100%; }
        }
        @media screen {
            body {
                background: #f6f3ee;
                padding: 18px 0 28px;
            }
            .page {
                width: 176mm;
                padding: 12px;
                background: #fff;
                box-shadow: 0 8px 24px rgba(0,0,0,0.08);
            }
        }
    </style>
</head>
<body>
<?php if ($show_button): ?>
    <div class="toolbar">
        <a class="btn btn-secondary" href="javascript:history.back()">Back</a>
        <?php if ($show_edit): ?>
            <a class="btn btn-secondary" href="edit_application.php?application_id=<?php echo (int)$data['application_id']; ?>">Edit Application</a>
        <?php endif; ?>
        <a class="btn" href="generate_pdf.php?application_id=<?php echo (int)$data['application_id']; ?>">Download PDF</a>
    </div>
<?php endif; ?>

<div class="page">
    <div class="doc-title">
        <h1>&#9633; PET ADOPTION APPLICATION</h1>
        <div class="doc-meta">Application ID : <?php echo h($applicationNo); ?></div>
        <div class="doc-meta">Status : <?php echo h($status); ?></div>
    </div>

    <table>
        <tr><th colspan="2">Applicant Information</th></tr>
        <tr><td class="label">Full Name</td><td><?php echo h($data['adopter_name']); ?></td></tr>
        <tr><td class="label">Application Date</td><td><?php echo h($applicationDate); ?></td></tr>
        <tr><td class="label">IC / Passport</td><td><?php echo h($data['ic_passport']); ?></td></tr>
        <tr><td class="label">Date of Birth</td><td><?php echo h($dob); ?></td></tr>
        <tr><td class="label">Phone</td><td><?php echo h($data['phone_no']); ?></td></tr>
        <tr><td class="label">Email</td><td><?php echo h($data['email']); ?></td></tr>
        <tr><td class="label">Address</td><td><?php echo nl2br(h($data['address'])); ?></td></tr>
        <tr><td class="label">Occupation</td><td><?php echo h($data['occupation']); ?></td></tr>
        <tr><td class="label">Gender</td><td><?php echo h($data['gender']); ?></td></tr>
    </table>

    <table>
        <tr><th colspan="2">Living Arrangement</th></tr>
        <tr><td class="label">Home Type</td><td><?php echo h($data['home_type']); ?></td></tr>
        <tr><td class="label">Ownership</td><td><?php echo h($data['ownership']); ?></td></tr>
        <tr><td class="label">Household Members</td><td><?php echo h($data['household_members']); ?></td></tr>
        <tr><td class="label">Other Pets</td><td><?php echo h($data['other_pets']); ?></td></tr>
    </table>

    <table>
        <tr><th colspan="2">Adoption Details</th></tr>
        <tr><td class="label">Pet</td><td><?php echo h($petLabel); ?></td></tr>
        <tr><td class="label">Managed By</td><td><?php echo h($data['shelter_name']); ?></td></tr>
        <tr><td class="label">Adopted Before</td><td><?php echo h($data['adopted_before']); ?></td></tr>
        <tr><td class="label">Reason for Adoption</td><td><?php echo nl2br(h($data['notes'])); ?></td></tr>
        <tr><td class="label">Pet Care Experience</td><td><?php echo h($data['pet_care_experience']); ?></td></tr>
    </table>

    <table>
        <tr><th colspan="2">Emergency Contact</th></tr>
        <tr><td class="label">Name</td><td><?php echo h($data['emergency_name']); ?></td></tr>
        <tr><td class="label">Phone</td><td><?php echo h($data['emergency_phone']); ?></td></tr>
        <tr><td class="label">Relationship</td><td><?php echo h($data['emergency_relationship']); ?></td></tr>
    </table>
</div>
</body>
</html>
<?php
    return ob_get_clean();
}
?>
