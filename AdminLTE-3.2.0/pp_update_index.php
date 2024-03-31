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
    // Check if the password field is submitted
    if (isset($_POST['password'])) {
        // Sanitize and validate the password input
        $password = validate($_POST['password']);
        $terms = isset($_POST['terms']);

        if (!isset($_FILES['pp']['name']) || empty($_FILES['pp']['name'])) {
            // Redirect to profile page with an error message
            header("Location: profile.php?errorpp=Profile Picture is required");
            exit();
            
        } else if (empty($password)) {
            // Redirect to profile page with an error message
            header("Location: profile.php?errorpp=Password is required");
            exit();

        }else if (!$terms) {
            header("Location: profile.php?errorpp=Please agree to the terms and conditions");
            exit();
        } else  {

        // Query to fetch the user's current password from the database
        $sql = "SELECT password FROM user WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Fetch the password from the query result
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['password'];

            // Verify if the entered password matches the stored hashed password
            if (password_verify($password, $hashed_password)) {
                // Password is correct, proceed with profile picture update
                if (isset($_FILES['pp']['name'])) {
                    // Process profile picture upload
                    $img_name = $_FILES['pp']['name'];
                    $size = $_FILES['pp']['size'];
                    $tmp_name = $_FILES['pp']['tmp_name'];
                    $error = $_FILES['pp']['error'];

                    if ($error === 0){
                        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
                        $img_ex_to_lc = strtolower($img_ex);

                        $allowed_exs = array('jpg', 'jpeg', 'png');
                        if (in_array($img_ex_to_lc, $allowed_exs)) {
                            $new_img_name = uniqid($user_id, true).'.'.$img_ex_to_lc;
                            
                            // Define the destination folder
                            $uploadDirectory = 'upload/';

                            // Create the destination folder if it doesn't exist
                            if (!is_dir($uploadDirectory)) {
                                mkdir($uploadDirectory, 0755, true); // Recursive directory creation
                            }

                            // Check if the file was uploaded successfully
                            if (move_uploaded_file($tmp_name, $uploadDirectory . $new_img_name)) {
                                // Proceed with database insertion
                                $sql_update = "UPDATE user 
                                    SET pp='$new_img_name'
                                    WHERE user_id='$user_id'";

                                if (mysqli_query($conn, $sql_update)) {
                                    // If update is successful, redirect to the profile page
                                    header("Location: login-v2.php?success=Profile Picture updated successfully<br> Please Login again");
                                    exit();
                                } else {
                                    // If update fails, redirect to the profile page with an error message
                                    header("Location: profile.php?errorpp=Failed to update profile picture");
                                    exit();
                                }
                            } else {
                                // Handle the case where file upload fails
                                header("Location: profile.php?errorpp=Failed to move uploaded file");
                                exit();
                            }
                        } else {
                            header("Location: profile.php?errorpp=You can't upload files of this type");
                            exit();
                        }
                    } else {
                        header("Location: profile.php?errorpp=Unknown error occurred");
                        exit();
                    }
                } else {
                    // Redirect to profile page if profile picture is not provided
                    header("Location: profile.php?errorpp=Profile Picture is required");
                    exit();
                }
            } else {
                // Password is incorrect, redirect back to the form with an error message
                header("Location: profile.php?errorpp=Incorrect password");
                exit();
            }
        } else {
            // Error occurred while fetching user data from the database
            header("Location: profile.php?errorpp=Database error");
            exit();
        }
    }
    } else {
        // Redirect back to the form if password field is not provided
        header("Location: profile.php");
        exit();
    }
} else {
    // Redirect back to the profile page if form is not submitted via POST method
    header("Location: profile.php");
    exit();
}
?>
