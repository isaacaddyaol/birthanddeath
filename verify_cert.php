<?php
include('dbcon.php');
$type = isset($_GET['type']) ? strtolower($_GET['type']) : '';
$certNo = isset($_GET['certNo']) ? $_GET['certNo'] : '';

function safe($str) {
    return htmlspecialchars($str ?? '');
}

if (!$type || !$certNo) {
    echo "<h2>Certificate Verification</h2><div style='color:red;'>Invalid or missing parameters.</div>";
    exit;
}

if ($type === 'birth') {
    $query = $con->query("SELECT * FROM tblbirth WHERE certNo = '$certNo'");
    if ($row = $query->fetch_assoc()) {
        echo "<h2>Birth Certificate Verification</h2>";
        echo "<b>Certificate Number:</b> " . safe($row['certNo']) . "<br>";
        echo "<b>Name:</b> " . safe($row['firstName'] . ' ' . $row['lastName']) . "<br>";
        echo "<b>Date of Birth:</b> " . safe($row['dateOfBirth']) . "<br>";
        echo "<b>Gender:</b> " . safe($row['gender']) . "<br>";
        echo "<b>Place of Birth:</b> " . safe($row['birthPlace']) . "<br>";
        echo "<b>Father's Name:</b> " . safe($row['fathersName']) . "<br>";
        echo "<b>Mother's Name:</b> " . safe($row['mothersName']) . "<br>";
        echo "<b>Registration Centre:</b> " . safe($row['regCentre']) . "<br>";
        echo "<b>Date Registered:</b> " . safe($row['dateReg']) . "<br>";
        echo "<div style='color:green; margin-top:10px;'><b>Status:</b> VALID</div>";
    } else {
        echo "<h2>Birth Certificate Verification</h2><div style='color:red;'>Certificate not found or invalid.</div>";
    }
} elseif ($type === 'death') {
    $query = $con->query("SELECT * FROM tbldeath WHERE certNo = '$certNo'");
    if ($row = $query->fetch_assoc()) {
        echo "<h2>Death Certificate Verification</h2>";
        echo "<b>Certificate Number:</b> " . safe($row['certNo']) . "<br>";
        echo "<b>Name:</b> " . safe($row['firstName'] . ' ' . $row['lastName']) . "<br>";
        echo "<b>Date of Death:</b> " . safe($row['dateOfDeath']) . "<br>";
        echo "<b>Gender:</b> " . safe($row['gender']) . "<br>";
        echo "<b>Place of Death:</b> " . safe($row['placeOfDeath']) . "<br>";
        echo "<b>Age at Death:</b> " . safe($row['ageAtDeath']) . "<br>";
        echo "<b>Registration Centre:</b> " . safe($row['regCentre']) . "<br>";
        echo "<b>Date Registered:</b> " . safe($row['dateReg']) . "<br>";
        echo "<div style='color:green; margin-top:10px;'><b>Status:</b> VALID</div>";
    } else {
        echo "<h2>Death Certificate Verification</h2><div style='color:red;'>Certificate not found or invalid.</div>";
    }
} else {
    echo "<h2>Certificate Verification</h2><div style='color:red;'>Invalid certificate type.</div>";
} 