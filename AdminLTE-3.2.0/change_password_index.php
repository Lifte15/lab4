<?php
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
    // Retrieve the user_id from the session
    $user_id = $_SESSION['user_id'];

    // Check if the form is submitted using POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are provided
        if (isset($_POST['cupass']) && isset($_POST['npass']) && isset($_POST['copass'])) {
            // Sanitize and validate the input
            $cupass = validate($_POST['cupass']);
            $npass = validate($_POST['npass']);
            $copass = validate($_POST['copass']);
            $terms = isset($_POST['terms']);

        if (empty($cupass)) {
            header("Location: profile.php?errorpa=Current Password is required");
            exit();
        }
        // Check the username if empty
        else if (empty($npass)) {
            header("Location: profile.php?errorpa=New Password is required");
            exit();
        } 
        // Check the firstname if empty
        else if (empty($copass)) {
            header("Location: profile.php?errorpa=Confirm Password is required");
            exit();
        }
        // If terms checkbox is not checked
  //      else if (!$terms) {
  //          header("Location: profile.php?errorpa=Please agree to the terms and conditions");
  //          exit();
  //      }
        // Check the lastname if empty
        else {
            // Check if new password and confirm password match
            if ($npass !== $copass) {
                header("Location: profile.php?errorpa=New password and confirm password do not match");
                exit();
            }

            // Query to fetch the user's current password from the database
            $sql = "SELECT password FROM user WHERE user_id = '$user_id'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Fetch the password from the query result
                $row = mysqli_fetch_assoc($result);
                $hashed_password = $row['password'];

                // Verify if the entered current password matches the stored hashed password
                if (password_verify($cupass, $hashed_password)) {
                    // Hash the new password
                    $hashed_npassword = password_hash($npass, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $sql_update = "UPDATE user SET password='$hashed_npassword' WHERE user_id='$user_id'";
                    if (mysqli_query($conn, $sql_update)) {
                        // Password updated successfully
                        header("Location: login-v2.php?success=Password updated successfully<br> Please Login gain");
                        exit();
                    } else {
                        // Error updating password
                        header("Location: profile.php?errorpa=Failed to update password");
                        exit();
                    }
                } else {
                    // Current password is incorrect
                    header("Location: profile.php?errorpa=Incorrect current password");
                    exit();
                }
            } else {
                // Error occurred while fetching user data from the database
                header("Location: profile.php?errorpa=Database error");
                exit();
            }
        }
    } else {
        // Redirect back to the change password page if form is not submitted via POST method
        header("Location: profile.php");
        exit();
    }
}
?>
