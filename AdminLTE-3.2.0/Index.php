<?php
// Start the session to manage user data
session_start();
// Include the database connection file
include "db_conn.php";

// Check if the username and password are provided
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Function to validate user input
    function validate($data){
        $data = trim($data);        // Remove whitespace from the beginning and end of the input
        $data = stripslashes($data);   // Remove backslashes (\) from the input
        $data = htmlspecialchars($data);   // Convert special characters to HTML entities
        return $data;
    }
    // Validate the provided username and password
    $email = validate($_POST['email']);
    $pass = validate($_POST['password']);


    // Check if the username is empty
    if (empty($email)) {
        header("Location: login-v2.php?error=Email is required");
        exit();
    }
    // Check if the password is empty
    else if (empty($pass)) {
        header("Location: login-v2.php?error=Password is required.&eemail=" . urlencode($email));
        exit();
    }
    // If both username and password are provided
    else {
        // SQL query to select user data based on the provided username and password
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        // Check if the query returned exactly one row (user found)
        if (mysqli_num_rows($result) === 1) {
            // Get the user data as an associative array
            $row = mysqli_fetch_assoc($result);
            // Check if the provided password matches the hashed password in the database
            if (password_verify($pass, $row['password'])) {
            // Check if the user's email is verified
                if($row['is_verified'] === '1')
                {
                    $sql2 = "SELECT * FROM user_profile WHERE user_id='". $row['user_id'] ."'";
                    $result2 = mysqli_query($conn, $sql2);

                    if ($row2 = mysqli_fetch_assoc($result2)) {
                    // Store user data in the session
                    $_SESSION["email"] = $row['email'];
                    $_SESSION["lastname"] = $row['lastname'];
                    $_SESSION["middle_name"] = $row['middle_name'];
                    $_SESSION["first_name"] = $row['first_name'];
                    $_SESSION["user_id"] = $row['user_id'];
                    $_SESSION["username"] = $row['username'];
                    $_SESSION["status"] = $row['status'];
                    $_SESSION["pp"] = $row['pp'];

                    $_SESSION["phone_number"] = $row2['phone_number'];
                    $_SESSION["gender"] = $row2['gender'];
                    $_SESSION["birthday"] = $row2['birthday'];
                    $_SESSION["province"] = $row2['province'];
                    $_SESSION["city"] = $row2['city'];
                    $_SESSION["barangay"] = $row2['barangay'];
                    $_SESSION["region"] = $row2['region'];
                    $_SESSION["zip_code"] = $row2['zip_code'];
                    // Redirect to the home page
                    header("Location: index2.php");
                    exit();

                    } else {
                        header("Location: login-v2.php?error=not found");
                        exit();
                    }
                } else {
                    // Redirect with an error message if the password is incorrect
                    header("Location: otp-v2.php?error=Check your Email to get the OTP.&eemail=" . urlencode($email));
                    exit();
                }
            }
            else {
                // Redirect with an error message if the email is not verified
                header("Location: login-v2.php?error=Incorrect Password.&eemail=" . urlencode($email));
                exit();
            }
        } else {
            // Redirect with an error message if the username or password is incorrect
            header("Location: login-v2.php?error=Incorrect Email or password");
            exit();
        }
    }
} else {
    // Redirect if the username or password is not provided
    header("Location: login-v2.php");
    exit();
}
?>
