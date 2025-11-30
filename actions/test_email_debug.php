<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../settings/db_class.php';

function get_setting($key) {
    $db = new db_connection();
    $conn = $db->db_conn();
    $key = mysqli_real_escape_string($conn, $key);
    $sql = "SELECT setting_value FROM system_settings WHERE setting_key = '$key'";
    $result = mysqli_query($conn, $sql);
    if($row = mysqli_fetch_assoc($result)){
        return $row['setting_value'];
    }
    return null;
}

$mail = new PHPMailer(true);

echo "Host: " . get_setting('smtp_host') . "<br>";
echo "Port: " . get_setting('smtp_port') . "<br>";
echo "Username: " . get_setting('smtp_username') . "<br>";

try {
    // Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
    $mail->isSMTP();
    $mail->Host       = get_setting('smtp_host');
    $mail->SMTPAuth   = true;
    $mail->Username   = get_setting('smtp_username');
    $mail->Password   = str_replace(' ', '', get_setting('smtp_password'));
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Recipients
    $mail->setFrom(get_setting('from_email'), get_setting('from_name'));
    $mail->addAddress('henryowusu023@gmail.com');

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Debug Test Email';
    $mail->Body    = 'This is a debug test email.';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
