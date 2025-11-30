<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer/Exception.php';
require __DIR__ . '/../PHPMailer/PHPMailer.php';
require __DIR__ . '/../PHPMailer/SMTP.php';
require_once __DIR__ . '/../settings/db_class.php';

function get_system_setting($key) {
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

function send_invoice_email($customer_email, $customer_name, $invoice_data) {
    error_log("send_invoice_email: Called for $customer_email");
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 2; // Enable verbose debug output
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer Debug: $str");
        };
        
        $host = get_system_setting('smtp_host');
        error_log("send_invoice_email: SMTP Host is $host");
        
        $mail->isSMTP();
        $mail->Host       = get_system_setting('smtp_host');
        $mail->SMTPAuth   = true;
        $mail->Username   = get_system_setting('smtp_username');
        $mail->Password   = str_replace(' ', '', get_system_setting('smtp_password'));
        $encryption = get_system_setting('smtp_encryption');
        $mail->SMTPSecure = $encryption === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = get_system_setting('smtp_port');

        // Recipients
        $mail->setFrom(get_system_setting('from_email'), get_system_setting('from_name'));
        $mail->addAddress($customer_email, $customer_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = "Your Invoice #" . $invoice_data['invoice_no'] . " - Payment Confirmed";
        
        // Generate email body with invoice details
        $mail->Body = generate_invoice_email_body($customer_name, $invoice_data);
        $mail->AltBody = generate_invoice_plain_text($customer_name, $invoice_data);

        $mail->send();
        error_log("send_invoice_email: Mail sent successfully");
        return true;
    } catch (Exception $e) {
        error_log("Invoice Email Error: {$mail->ErrorInfo}");
        // Fallback to native mail()
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . get_system_setting('from_name') . ' <' . get_system_setting('from_email') . '>' . "\r\n";
        
        $subject = "Your Invoice #" . $invoice_data['invoice_no'] . " - Payment Confirmed";
        $body = generate_invoice_email_body($customer_name, $invoice_data);
        
        if(mail($customer_email, $subject, $body, $headers)){
            error_log("send_invoice_email: Sent via native mail() fallback");
            return true;
        }
        return false;
    }
}

function send_general_email($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0; // Disable verbose debug output
        $mail->Debugoutput = function($str, $level) {
            error_log("PHPMailer Debug: $str");
        };

        $mail->isSMTP();
        $mail->Host       = get_system_setting('smtp_host');
        $mail->SMTPAuth   = true;
        $mail->Username   = get_system_setting('smtp_username');
        $mail->Password   = str_replace(' ', '', get_system_setting('smtp_password'));
        $encryption = get_system_setting('smtp_encryption');
        $mail->SMTPSecure = $encryption === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = get_system_setting('smtp_port');

        // Recipients
        $mail->setFrom(get_system_setting('from_email'), get_system_setting('from_name'));
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = nl2br($body);
        $mail->AltBody = strip_tags($body);

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("General Email Error: {$mail->ErrorInfo}");
        // Fallback to native mail()
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: ' . get_system_setting('from_name') . ' <' . get_system_setting('from_email') . '>' . "\r\n";
        
        if(mail($to, $subject, $body, $headers)){
             error_log("send_general_email: Sent via native mail() fallback");
             return true;
        }
        return false;
    }
}

function generate_invoice_email_body($customer_name, $invoice_data) {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #4CAF50; color: white; padding: 20px; text-align: center; }
            .content { background: #f9f9f9; padding: 20px; }
            .invoice-details { background: white; padding: 15px; border-radius: 5px; margin: 15px 0; }
            .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; }
            .button { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
            th { background: #f5f5f5; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>Payment Confirmed!</h1>
                <p>Thank you for your purchase</p>
            </div>
            
            <div class="content">
                <p>Dear ' . htmlspecialchars($customer_name) . ',</p>
                
                <p>Your payment has been successfully processed. Here are your invoice details:</p>
                
                <div class="invoice-details">
                    <h3>Invoice #' . htmlspecialchars($invoice_data['invoice_no']) . '</h3>
                    
                    <table>
                        <tr>
                            <th>Description</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <td>' . htmlspecialchars($invoice_data['item_name']) . '</td>
                            <td>$' . number_format($invoice_data['amount'], 2) . '</td>
                        </tr>
                        ' . (!empty($invoice_data['tax']) ? '
                        <tr>
                            <td>Tax</td>
                            <td>$' . number_format($invoice_data['tax'], 2) . '</td>
                        </tr>' : '') . '
                        ' . (!empty($invoice_data['discount']) ? '
                        <tr>
                            <td>Discount</td>
                            <td>-$' . number_format($invoice_data['discount'], 2) . '</td>
                        </tr>' : '') . '
                        <tr style="font-weight: bold;">
                            <td>Total Amount</td>
                            <td>$' . number_format($invoice_data['total_amount'], 2) . '</td>
                        </tr>
                    </table>
                    
                    <p><strong>Payment Date:</strong> ' . $invoice_data['payment_date'] . '</p>
                    <p><strong>Payment Method:</strong> ' . htmlspecialchars($invoice_data['payment_method']) . '</p>
                    ' . (!empty($invoice_data['transaction_id']) ? '
                    <p><strong>Transaction ID:</strong> ' . htmlspecialchars($invoice_data['transaction_id']) . '</p>' : '') . '
                </div>
                
                <p>You can download your invoice from your account dashboard or <a href="' . $invoice_data['invoice_link'] . '">click here to download now</a>.</p>
                
                <p>If you have any questions about your purchase, please contact our support team.</p>
                
                <p style="text-align: center;">
                    <a href="' . $invoice_data['dashboard_link'] . '" class="button">View in Dashboard</a>
                </p>
            </div>
            
            <div class="footer">
                <p>&copy; ' . date('Y') . ' AfriConnect. All rights reserved.</p>
                <p>This is an automated email, please do not reply directly to this message.</p>
            </div>
        </div>
    </body>
    </html>
    ';
}

function generate_invoice_plain_text($customer_name, $invoice_data) {
    return "
PAYMENT CONFIRMED

Dear $customer_name,

Your payment has been successfully processed. Here are your invoice details:

Invoice #: {$invoice_data['invoice_no']}
Item: {$invoice_data['item_name']}
Amount: $" . number_format($invoice_data['amount'], 2) . 
(!empty($invoice_data['tax']) ? "\nTax: $" . number_format($invoice_data['tax'], 2) : "") . 
(!empty($invoice_data['discount']) ? "\nDiscount: -$" . number_format($invoice_data['discount'], 2) : "") . "
Total: $" . number_format($invoice_data['total_amount'], 2) . "
Payment Date: {$invoice_data['payment_date']}
Payment Method: {$invoice_data['payment_method']}" . 
(!empty($invoice_data['transaction_id']) ? "\nTransaction ID: {$invoice_data['transaction_id']}" : "") . "

Download your invoice: {$invoice_data['invoice_link']}
View in dashboard: {$invoice_data['dashboard_link']}

Thank you for your purchase!
AfriConnect Team
";
}
?>