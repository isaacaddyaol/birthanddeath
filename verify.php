<?php
include('dbcon.php');
$certNo = isset($_GET['certNo']) ? $_GET['certNo'] : '';
if (!$certNo) {
    echo "No certificate number provided.";
    exit;
}
$query = $con->query("SELECT * FROM tblbirth WHERE certNo = '$certNo'");
if ($row = $query->fetch_assoc()) {
    echo "<h2>Birth Certificate Verification</h2>";
    echo "<b>Certificate Number:</b> " . htmlspecialchars($row['certNo']) . "<br>";
    echo "<b>Name:</b> " . htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) . "<br>";
    echo "<b>Date of Birth:</b> " . htmlspecialchars($row['dateOfBirth']) . "<br>";
    // ... add more fields as needed
} else {
    echo "Certificate not found or invalid.";
}
?>
