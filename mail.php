
<?php
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Function to sanitize form data
    function sanitizeData($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Retrieve and sanitize form data
    $name = sanitizeData($_POST["contact-name"]);
    $phone = sanitizeData($_POST["contact-phone"]);
    $email = sanitizeData($_POST["contact-email"]);
    $subject = sanitizeData($_POST["subject"]);
    $message = sanitizeData($_POST["contact-message"]);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array('code' => false, 'err' => 'Invalid email address.'));
        exit;
    }

    // Perform any additional validation or processing with the form data
    // For example, you might want to check if required fields are not empty, etc.

    // Send email
    $to = "mh7325003@gmai.com"; // Replace with your email address
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\nMessage: $message";

    // Use the mail() function to send the email
    $mailSuccess = mail($to, $subject, $body);

    if ($mailSuccess) {
        echo json_encode(array('code' => true, 'success' => 'Form data received successfully. Email sent!'));
    } else {
        echo json_encode(array('code' => false, 'err' => 'Form data received, but there was an issue sending the email.'));
    }
} else {
    echo json_encode(array('code' => false, 'err' => 'Invalid request method.'));
}
?>

