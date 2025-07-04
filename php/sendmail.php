<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';
require 'phpmailer/src/Exception.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $recaptchaSecret = '6LeAo2srAAAAABoRZYhoJmhtiw2iR4CNEMUJ9cEG';
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseData = json_decode($verify);

    if (!$responseData->success) {
      echo "Captcha verification failed. Please go back and try again.";
      exit;
    }
    //Analytis: https://www.google.com/recaptcha/admin/site/728474496




  $name = htmlspecialchars($_POST['name'] ?? '');
  $email = htmlspecialchars($_POST['email'] ?? '');
  $phone = htmlspecialchars($_POST['phone'] ?? '');
  $message = htmlspecialchars($_POST['message'] ?? '');

  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    //$mail->Host = 'smtp.gmail.com';
    //$mail->SMTPAuth = true;
    //$mail->Username = 'envirosh.webform@gmail.com';
    //$mail->Password = 'jpeu kvhq ezma vndx'; // Replace with generated App Password
    //$mail->SMTPSecure = 'tls';
    //$mail->Port = 587;

    //$mail->setFrom('envirosh.webform@gmail.com', 'Envirosh Contact Form');
    //$mail->addAddress('envirosh.webform@gmail.com');

    $mail->Host = 'mail.enviroshcon.com'; // Or your hosting SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'webform@enviroshcon.com';
    $mail->Password = 'WebForm123!'; // Use the actual email password
    $mail->SMTPSecure = 'tls'; // Or 'ssl' depending on your host
    $mail->Port = 587; // Use 465 for SSL, 587 for TLS

    $mail->setFrom('webform@enviroshcon.com', 'Envirosh Contact Form');
    $mail->addAddress('webform@enviroshcon.com');


    $mail->addReplyTo($email, $name);
    $mail->Subject = "New Contact Form Submission from $name";
    $mail->isHTML(true);
    $mail->Body = '
    <html>
    <head><style>
    body { font-family: Arial; background: #f7f7f7; color: #333; padding: 20px; }
    .box { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .label { font-weight: 600; margin-top: 15px; }
    .value { margin: 5px 0 20px; }
    </style></head>
    <body><div class="box">
    <h3>📩 New Submission from ENVIROSH Contact Form</h3>
    <div class="label">Name</div><div class="value">'.nl2br($name).'</div>
    <div class="label">Email</div><div class="value">'.nl2br($email).'</div>
    <div class="label">Phone</div><div class="value">'.nl2br($phone).'</div>
    <div class="label">Message</div><div class="value">'.nl2br($message).'</div>
    <p style="font-size:13px; color:gray;">This message was sent from the ENVIROSH website.</p>
    </div></body></html>';

    $mail->send();
    echo '
    <!DOCTYPE html>
    <html><head>
    <meta charset="UTF-8">
    <title>Message Sent | ENVIROSH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    </head>
    <body>
    <div class="modal fade show d-block" style="background: rgba(0, 0, 0, 0.5);">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center">
          <div class="modal-body p-5">
              <h5 class="modal-title mb-3">Message has been sent.</h5>
              <i class="fas fa-check-circle fa-3x text-success"></i>
          </div>
        </div>
      </div>
    </div>
    <script>
      setTimeout(() => { window.location.href = "../contact.html"; }, 2000);
    </script>
    </body></html>';
  } catch (Exception $e) {
    echo "Mailer Error: {$mail->ErrorInfo}";
  }
}
?>
