<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../PHPMailer-master/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);

    try {
        $subject = $_POST['subject'] ?? '';
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        // Server settings
        $mail->SMTPDebug = 2;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'jjbright0402l@gmail.com'; // Your Gmail address
        $mail->Password = ''; // Your 16-char App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('jjbright0402l@gmail.com', 'Jasper James');
        $mail->addAddress('espielreo635@gmail.com');
        $mail->addReplyTo('espielreo635@gmail.com', 'espiel');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $subject";
        $mail->Body = "You have received a new message from the contact form.<br><br>".
                     "Name: $name<br>".
                     "Email: $email<br>".
                     "Message:<br>$message";

        $mail->send();
        header("Location: ../views/thank_you.php");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>