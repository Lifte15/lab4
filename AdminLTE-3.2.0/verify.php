<?php
// Start the session
session_start();
// Include the database connection 
include "db_conn.php";

// Check if email, verification code, and user's input are set in the POST data
if (isset($_POST['user_otp']) && isset($_POST['email'])) {
    // Validate email, verification code, and user's input from the POST data
    $user_otp = validate($_POST['user_otp']);
    $email = validate($_POST['email']);

    // Select user with provided email and verification code
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            // Check if the user is not already verified and the user's input matches the verification code
            $v_code = $row['verification_code'];

            if ($row['is_verified'] == 0 && $user_otp === $v_code) {
                // Update the user's verification status to verified
                $update = "UPDATE user SET is_verified = '1' WHERE email = '$email'";
                if (mysqli_query($conn, $update)) {
                    // Redirect to the login form
                    header("Location: login-v2.php?success=Email verification successful.&eemail=" . urlencode($email));
                    exit();
                } else {
                    // Redirect to the success form with error message
                    header("Location: otp-v2.php?error=Unable to update verification status");
                    exit();
                }
            } else {
                // Redirect to the success form with error message
                header("Location: otp-v2.php?error=Invalid OTP.&eemail=" . urlencode($email));
                exit();
            }
        } else {
            // Redirect to the success form with error message
            header("Location: otp-v2.php?error=User not found");
            exit();
        }
    } else {
        // Redirect to the success form with error message
        header("Location: otp-v2.php?error=Database query failed");
        exit();
    }
} else {
    // Redirect to the success form
    header("Location: otp-v2.php");
    exit();
}

// Function to validate user input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
