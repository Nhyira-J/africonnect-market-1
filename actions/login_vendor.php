<?php
require("../controllers/vendor_controller.php");
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$login = $data['login'] ?? '';
$password = $data['password'] ?? '';

$result = login_vendor_ctr($login, $password);

if (is_array($result)) {
    echo json_encode(['status' => 'success', 'user' => $result]);
} elseif ($result === 'invalid_password') {
    echo json_encode(['status' => 'invalid_password']);
} elseif ($result === 'user_not_found') {
    echo json_encode(['status' => 'user_not_found']);
} else {
    echo json_encode(['status' => 'error']);
}

?>

