<?php
// Start the PHP session
session_start();
// Include the database connection file
include "db_conn.php";
// Import the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to send email verification
function generateVerificationCode() {
    // Generate a random verification code
    return mt_rand(1000000, 9999999);
}

// Function to send email verification
function sendMail($email, $v_code) 
{
    // Include the required PHPMailer files
    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
        $mail->isSMTP();                                            
        $mail->Host       = 'smtp.gmail.com';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'brianbognotipt101@gmail.com';                     
        $mail->Password   = 'dzgs vwfb zvli zuji';                               
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            
        $mail->Port       = 587;                                    
    
        //Recipients
        $mail->setFrom('brianbognotipt101@gmail.com', 'IPT101lab_4');
        $mail->addAddress($email);     

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'Email Verification';
        $mail->Body    = "<h1>You have been Registered!</h1> 
                        <h5>Verify your email address to Login with the below code:</h5>
                        <br/><br/>
                        <h2>$v_code</h2>";
    
        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        // If an exception occurs, return false
        return false;
    }

}

// Function to sanitize and validate user input
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Check if the form is submitted using post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and store user input in variables
    $email = validate($_POST['email']);
    $uname = validate($_POST['uname']);
    $fname = validate($_POST['fname']);
    $mname = validate($_POST['mname']);
    $lname = validate($_POST['lname']);
    $status = validate($_POST['status']);
    $password = validate($_POST['password']);
    $cpassword = validate($_POST['cpassword']);
    $terms = isset($_POST['terms']);

    // Check the email if empty
    if (empty($email)) {
        header("Location: register-v2.php?error=Email is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // Check the username if empty
    else if (empty($uname)) {
        header("Location: register-v2.php?error=User Name is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    } 
    // Check the firstname if empty
    else if (empty($fname)) {
        header("Location: register-v2.php?error=First Name is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // Check the lastname if empty
    else if (empty($lname)) {
        header("Location: register-v2.php?error=Last Name is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // Check the status if empty
    else if (empty($status)) {
        header("Location: register-v2.php?error=Status is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // Check the password if empty
    else if (empty($password)) {
        header("Location: register-v2.php?error=Password is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // Check the second paswword if empty
    else if (empty($cpassword)) {
        header("Location: register-v2.php?error=Second password is required.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // If terms checkbox is not checked
    else if (!$terms) {
        header("Location: register-v2.php?error=Please agree to the terms and conditions.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
        exit();
    }
    // If all are provided
    else {

        // Handle file upload
if (isset($_FILES['pp']['name'])) {
    $img_name = $_FILES['pp']['name'];
    $size = $_FILES['pp']['size'];
    $tmp_name = $_FILES['pp']['tmp_name'];
    $error = $_FILES['pp']['error'];

    if ($error === 0){
        $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
        $img_ex_to_lc = strtolower($img_ex);

        $allowed_exs = array('jpg', 'jpeg', 'png');
        if (in_array($img_ex_to_lc, $allowed_exs)) {
            $new_img_name = uniqid($uname, true).'.'.$img_ex_to_lc;
            
            // Define the destination folder
            $uploadDirectory = 'upload/';

            // Create the destination folder if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true); // Recursive directory creation
            }

            // Check if the file was uploaded successfully
            if (move_uploaded_file($tmp_name, $uploadDirectory . $new_img_name)) {
                // Proceed with database insertion
            } else {
                // Handle the case where file upload fails
                header("Location: register-v2.php?error=Failed to move uploaded file");
                exit();
            }
        } else {
            header("Location: register-v2.php?error=You can't upload files of this type");
            exit();
        }
    } else {
        header("Location: register-v2.php?error=unknown error occurred");
        exit();
    }
}
        // Check if the email already exists
        $check_email_sql = "SELECT * FROM user WHERE email='$email'";
        $resulte = mysqli_query($conn, $check_email_sql);
        if (mysqli_num_rows($resulte) > 0) {

            $user_data = mysqli_fetch_assoc($resulte);
            // Keep the existing values for username, name, email, and password
            $euname = $user_data['uname'];
            $efname = $user_data['fname'];
            $emname = $user_data['mname'];
            $elname = $user_data['mname'];
            $eemail = $user_data['email'];
            header("Location: register-v2.php?error=Email already exists.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname));
            exit();
        }


        // Check the passwords if matches
        if ($password !== $cpassword) {
            header("Location: register-v2.php?error=Password don't match.&euname=" . urlencode($uname) . "&efname=" . urlencode($fname) . "&emname=" . urlencode($mname) . "&elname=" . urlencode($lname) . "&eemail=" . urlencode($email));
            exit();
        }
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Generate a verification code
        $v_code = generateVerificationCode();
        // SQL query to insert user data into the database
        $sql = "INSERT INTO user (first_name, middle_name, lastname, email, password, verification_code, is_verified, status, username, pp) 
                VALUES ('$fname', '$mname', '$lname', '$email', '$hashed_password', '$v_code', '0', '$status', '$uname', '$new_img_name')";

        // Execute the SQL query
        if (mysqli_query($conn, $sql)) {
            // Send verification email
            if (sendMail($email, $v_code)) {
                // If registration and email sending are successful, redirect to verify.php
                $_SESSION["email"] = $email;
                $_SESSION["uname"] = $uname;
                header("Location: otp-v2.php?success=Registration successful.&eemail=" . urlencode($email));
                exit();
            } else {
                // If sending email fails, redirect to registration form with error message
                header("Location: register-v2.php?error=Failed to send verification email. Please try again.");
                exit();
            }
        } else {
            // If registration fails, redirect to registration form with error message
            header("Location: register-v2.php?error=Registration failed. Please try again.");
            exit();
        }
    }
} else {
    header("Location: register-v2.php");
    exit();
}
?>
