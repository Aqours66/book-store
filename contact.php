<?php
include 'header.php';
?>
<?php
require 'vendor/autoload.php'; // Include PHPMailer autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize PHPMailer
$mail = new PHPMailer(true);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject']; // Retrieve subject from form data
    $message = $_POST['message'];

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ongweian1234@gmail.com'; // SMTP username
        $mail->Password = 'dlsv fate ufge xmst';   // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        //Recipients
        $mail->setFrom($email, $name);
        $mail->addAddress('ongweian1234@gmail.com', 'Ong Wei An'); // Add a recipient

        //Content
        $mail->isHTML(false);
        $mail->Subject = $subject; // Set email subject from form input
        $mail->Body = "Name: $name\nEmail: $email\nSubject: $subject\nMessage: $message";

        $mail->send();
        $successMessage = 'Message has been sent successfully.';
    } catch (Exception $e) {
        $errorMessage = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="contact.css">
</head>

<body>
    <div class="container">
        <h2 class="text-center">Contact Us</h2>

        <!-- Display success message -->
        <?php if (!empty($successMessage)) : ?>
            <div class="success-message"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <!-- Display error message -->
        <?php if (!empty($errorMessage)) : ?>
            <div class="error-message"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form class="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required><br>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required><br>

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" placeholder="Subject" required><br>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" placeholder="Your Message" required></textarea><br>

            <input type="submit" value="Send Message">
        </form>
    </div>
</body>

</html>