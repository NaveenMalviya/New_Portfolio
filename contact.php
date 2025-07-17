<?php
// Set your email address here
$to = "naveensingawat@gmail.com";

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {

  // Basic validation
  $name    = strip_tags(trim($_POST["name"] ?? ''));
  $email   = filter_var(trim($_POST["email"] ?? ''), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"] ?? ''));
  $message = trim($_POST["message"] ?? '');

  if (empty($name) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Please complete the form and use a valid email address.";
    exit;
  }

  // Email content
  $email_subject = "New Contact: $subject";
  $email_content = "You have received a new message from your website contact form.\n\n";
  $email_content .= "Name: $name\n";
  $email_content .= "Email: $email\n";
  $email_content .= "Subject: $subject\n";
  $email_content .= "Message:\n$message\n";

  // Email headers
  $headers = "From: $name <$email>";

  // Send email
  if (mail($to, $email_subject, $email_content, $headers)) {
    echo "OK";
  } else {
    http_response_code(500);
    echo "Something went wrong and we couldn't send your message.";
  }

} else {
  http_response_code(403);
  echo "Invalid request method.";
}
?>
