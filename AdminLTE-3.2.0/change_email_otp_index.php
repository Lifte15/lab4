<?php
// Start the PHP session
session_start();
// Include the database connection file
include "db_conn.php";

// Function to sanitize and validate user input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Retrieve the user_id and otp from the session
$user_id = $_SESSION['user_id'];
$otp = $_SESSION['otp'];
// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and store user input in variables
    $user_otp = validate($_POST['nuser_otp']);
    $password = validate($_POST['password']);

    // Check if the OTP is empty
    if (empty($otp)) {
        header("Location: profile.php?errorem=OTP is required");
        exit();
    }

    // Check if the OTP matches the one stored in the session
    if ($user_otp == $otp) {
        // Check if the current password is empty
        if (empty($password)) {
            header("Location: profile.php?errorem=Password is required");
            exit();
        }

        // Verify the current password
        $sql = "SELECT password FROM user WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            // Fetch the password from the query result
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];
            // Verify if the entered current password matches the stored hashed password
            if (!password_verify($password, $hashed_password)) {
                header("Location: profile.php?errorem=Incorrect password");
                exit();
            }
        }

        // Retrieve the new email address from the session
        $new_email = $_SESSION['new_email'];

        // Update the database with the new email address
        $update_email_sql = "UPDATE user SET email='$new_email', verification_code='' WHERE user_id='$user_id'";
        if (mysqli_query($conn, $update_email_sql)) {
            // Email address updated successfully, unset session variables
            unset($_SESSION['email']);
            unset($_SESSION['otp']);
            header("Location: login-v2.php?success=Email Address updated successfully<br> Please Login again");
            exit();
        } else {
            // Failed to update email address, redirect back with an error message
            header("Location: profile.php?errorem=Failed to update email address");
            exit();
        }
    } else {
        header("Location: profile.php?errorem=OTP does not match");
        exit();
    }
} else {
    // Redirect back if form is not submitted via POST method
    header("Location: profile.php");
    exit();
}
?>
