<?php
// Start the PHP session
session_start();
// Include the database connection file
include "db_conn.php";
// Import the PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to generate a 7-digit OTP code
function generateOTP() {
    return mt_rand(1000000, 9999999);
}

// Function to send email verification
function sendMail($email, $otp) 
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
        $mail->Subject = 'New Email Verification';
        $mail->Body    = "<h1>Your Email has been Changed!</h1> 
                        <h5>Verify your new email address to change your current email address with the below code:</h5>
                        <br/><br/>
                        <h2>$otp</h2>";
    
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

// Retrieve the user_id from the session
$user_id = $_SESSION['user_id'];

// Check if the form is submitted using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and store user input in variables
    $email = validate($_POST['nemail']);

    // Check if the email is empty
    if (empty($email)) {
        header("Location: profile.php?errorem=New email is required");
        exit();
    } else {
        // Check if the email already exists
        $check_email_sql = "SELECT * FROM user WHERE email='$email'";
        $resulte = mysqli_query($conn, $check_email_sql);
        if (mysqli_num_rows($resulte) > 0) {
            $user_data = mysqli_fetch_assoc($resulte);
            // Keep the existing values for email
            $eemail = $user_data['email'];
            header("Location: profile.php?errorem=Email already exists");
            exit();
        }

        // Generate a 7-digit OTP
        $otp = generateOTP();

        // Store the OTP in session
        $_SESSION['otp'] = $otp;
        
        // Store the new email address in session
        $_SESSION['new_email'] = $email;

        // Send the OTP to the user's email
        if (sendMail($email, $otp)) {
            // Email sent successfully, proceed with the rest of the process
            // Redirect the user to a page where they enter the OTP
            header("Location: profile.php?successem=Verification Code is send in your new Email Address.&email=" . urlencode($email));
            exit();
        } else {
            // Failed to send email, redirect back with an error message
            header("Location: profile.php?errorem=Failed to send verification email");
            exit();
        }
    }
} else {
    // Redirect back to the registration form if form is not submitted via POST method
    header("Location: profile.php");
    exit();
}
?>
