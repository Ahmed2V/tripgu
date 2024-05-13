<?php
include 'MyData.php';
$username = "username";
$password = "password";

// Create connection
$conn = new mysqli( $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from the request body
    $email = filterRequest("email");

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(array("error" => "Invalid email format"));
        exit();
    }

    // Check if the email exists in the database
    $sql = "SELECT * FROM signup WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = md5(uniqid(rand(), true));

        // Update the user's record with the token
        $sql = "UPDATE signup SET reset_token='$token' WHERE email='$email'";
        if ($conn->query($sql) === TRUE) {
            // Send the reset link to the user's email
            $reset_link = "https://tripgu.com/reset_password.php?token=$token";
            // Send email code here

            echo json_encode(array("message" => "Password reset link sent successfully"));
        } else {
            echo json_encode(array("error" => "Error updating record: " . $conn->error));
        }
    } else {
        echo json_encode(array("error" => "Email address not found"));
    }
} else {
    echo json_encode(array("error" => "Invalid request method"));
}

// Close the database connection
$conn->close();
?>
