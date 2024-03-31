<?php
session_start();
// Include the database connection file
include "db_conn.php";

// Function to sanitize and validate user_profile input
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
    // Validate and store user_profile input in variables
    $p_num = validate($_POST['p_num']);
    $gender = validate($_POST['gender']);
    $birthday = validate($_POST['birthday']);
    $province = validate($_POST['province']);
    $city = validate($_POST['city']);
    $brgy = validate($_POST['brgy']);
    $region = validate($_POST['region']);
    $zip_code = validate($_POST['zip_code']);
    $terms = isset($_POST['terms']);

    if (empty($p_num)) {
        header("Location: profile.php?errorpi=Phone Number is required");
        exit();
    }
    // Check the lastname if empty
    else if (empty($gender)) {
        header("Location: profile.php?errorpi=Gender is required");
        exit();
    }
    // Check the status if empty
    else if (empty($province)) {
        header("Location: profile.php?errorpi=Province is required");
        exit();
    }
    // Check the password if empty
    else if (empty($city)) {
        header("Location: profile.php?errorpi=City is required");
        exit();
    }
    else if (empty($brgy)) {
        header("Location: profile.php?errorpi=Barangay is required");
        exit();
    }
    // Check the status if empty
    else if (empty($region)) {
        header("Location: profile.php?errorpi=Region is required");
        exit();
    }
    // Check the password if empty
    else if (empty($zip_code)) {
        header("Location: profile.php?errorpi=Zip Code is required");
        exit();
    }
    // If terms checkbox is not checked
    else if (!$terms) {
        header("Location: profile.php?errorpi=Please agree to the terms and conditions");
        exit();
    }
    // If all are provided
    else {
    

        // SQL query to update user_profile data in the database
        $sql_profile = "UPDATE user_profile 
                        SET phone_number='$p_num', gender='$gender', birthday='$birthday', 
                            province='$province', city='$city', barangay='$brgy', region='$region', zip_code='$zip_code'
                        WHERE user_id='$user_id'";

        if (mysqli_query($conn, $sql_profile)) {
            header("Location: login-v2.php?success=User Update successfully<br> Please Login again");
            exit();
        } else {
        // If update fails, redirect to the user section on the profile
        header("Location: profile.php");
        exit();
    }
}
} else {
    header("Location: profile.php");
    exit();
}
?>
