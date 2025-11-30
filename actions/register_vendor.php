<?php
require("../controllers/vendor_controller.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $full_name = $data['full_name'] ?? '';
    $email = $data['email'] ?? '';
    $phone = $data['phone'] ?? '';
    $password = $data['password'] ?? '';
    $address = $data['address'] ?? '';
    $business_name = $data['business_name'] ?? '';
    $business_type = $data['business_type'] ?? '';
    $registration_number = $data['registration_number'] ?? '';
    $mobile_money_account = $data['mobile_money_account'] ?? '';

    $result = add_vendor_ctr($full_name, $email, $phone, $password, $address, $business_name, $business_type, $registration_number, $mobile_money_account);

    if ($result == "success") {
        echo json_encode(['status' => 'success']);
    } elseif ($result == "duplicate") {
        echo json_encode(['status' => 'duplicate']);
    } else {
        echo json_encode(['status' => 'error']);
    }
} else {
    echo json_encode(['status' => 'invalid']);
}
?>