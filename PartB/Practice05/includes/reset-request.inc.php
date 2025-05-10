<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// First we check if the form was submitted.
if (isset($_POST['reset-request-submit'])) {

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $url = "http://localhost/CISC3003-ProjectAssignment-IndividualWork-DC226696/PartB/Practice05/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);
    $expires = date("U") + 1800;

    require 'dbh.inc.php';

    $userEmail = $_POST["email"];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    // Here we then insert the info we have regarding the token into the database. This means that we have something we can use to check if it is the correct user that tries to change their password.
    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "There was an error!";
        exit();
    } else {
        // Here we also hash the token to make it unreadable, in case a hacker accessess our database.
        $hashedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hashedToken, $expires);
        mysqli_stmt_execute($stmt);
    }

    // Here we close the statement and connection.
    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->Debugoutput = function ($str, $level) {
            echo "Debug: $str<br>";
        };
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'opchitc@gmail.com';
        $mail->Password = 'yyfymzkmnmvagwta';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('opchitc@gmail.com', 'Password Reset');
        $mail->addAddress($userEmail);

        $mail->isHTML(true);
        $mail->Subject = 'Reset your password';
        $mail->Body = '<p>We received a password reset request. The link to reset your password is below. ';
        $mail->Body .= 'If you did not make this request, you can ignore this email</p>';
        $mail->Body .= '<p>Here is your password reset link: </br>';
        $mail->Body .= '<a href="' . $url . '">' . $url . '</a></p>';

        echo "Sending Email...<br>";
        $mail->send();
        echo "Email Sent Successfully! <br>";
        echo "Redirecting...<br>";
        header("Location: ../reset-password.php?reset=success");
        exit();
    } catch (Exception $e) {
        echo "<h2>Send Email Error</h2>";
        echo "<pre>";
        echo "Error: " . $e->getMessage() . "\n";
        echo "Message: " . $mail->ErrorInfo . "\n";
        echo "</pre>";
        die();
    }
} else {
    header("Location: ../signup.php");
    exit();
}
