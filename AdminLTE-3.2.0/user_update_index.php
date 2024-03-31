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
    // Validate and store user input in variables
    $uname = validate($_POST['uname']);
    $fname = validate($_POST['fname']);
    $mname = validate($_POST['mname']);
    $lname = validate($_POST['lname']);
    $status = validate($_POST['status']);
    $terms = isset($_POST['terms']);

    if (empty($uname)) {
        header("Location: profile.php?erroruu=UserName is required");
        exit();
    }
    // Check the lastname if empty
    else if (empty($fname)) {
        header("Location: profile.php?erroruu=First Name is required");
        exit();
    }
    // Check the status if empty
    else if (empty($lname)) {
        header("Location: profile.php?erroruu=Last Name is required");
        exit();
    }
    // Check the password if empty
    else if (empty($status)) {
        header("Location: profile.php?erroruu=Status is required");
        exit();
    }
    // If terms checkbox is not checked
    else if (!$terms) {
        header("Location: profile.php?erroruu=Please agree to the terms and conditions");
        exit();
    }
    // If all are provided
    else {

    // SQL query to update user data in the database
    $sql = "UPDATE user 
            SET username='$uname', first_name='$fname', middle_name='$mname', lastname='$lname', status='$status'
            WHERE user_id='$user_id'";

    // Execute the SQL query
    if (mysqli_query($conn, $sql)) {
        // If update is successful, redirect to the login page
        header("Location: login-v2.php?success=User Update successfully<br> Please Login again");
        session_destroy();
        exit();
    } else {
        // If update fails, redirect to the user section on the profile
        header("Location: profile.php#user");
        exit();
    }
}
} else {
    // If the form is not submitted, redirect to the user section on the profile
    header("Location: profile.php#user");
    exit();
}
?>
