<?php
// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Construct email message
$to = "malikzain909192@gmail.com"; // Change to your email address
$subject = "New Message from $name";
$body = "Name: $name\nEmail: $email\nMessage: $message";
$headers = "From: $email";

// Send email
$mailSent = mail($to, $subject, $body, $headers);

if ($mailSent) {
    echo "Email sent successfully!";
} else {
    echo "Error: Email sending failed.";
}
?>
