<?php
require_once 'locations.php';

header('Content-Type: application/json');

$type = $_GET['type'] ?? '';
$region = $_GET['region'] ?? '';
$district = $_GET['district'] ?? '';

switch ($type) {
    case 'districts':
        if (!empty($region)) {
            echo json_encode(getDistricts($region));
        } else {
            echo json_encode([]);
        }
        break;
        
    case 'towns':
        if (!empty($region) && !empty($district)) {
            echo json_encode(getTowns($region, $district));
        } else {
            echo json_encode([]);
        }
        break;
        
    default:
        echo json_encode([]);
        break;
}
?> 