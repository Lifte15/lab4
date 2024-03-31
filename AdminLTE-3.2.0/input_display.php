<?php
session_start();
// Include the database connection file
include "db_conn.php";

$user_id = $_SESSION['user_id'];

// Display user information from the user table
$fnames = $lnames = $emails = '*';
$p_nums = $birthdays = $genders = $addresss = '*';

$userSql = "SELECT first_name, lastname, email FROM user WHERE user_id = '$user_id'";
$userResult = mysqli_query($conn, $userSql);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userRow = mysqli_fetch_assoc($userResult);
    $fnames = !empty($userRow['first_name']) ? $userRow['first_name'] : '*';
    $lnames = !empty($userRow['lastname']) ? $userRow['lastname'] : '*';
    $emails = !empty($userRow['email']) ? $userRow['email'] : '*';
}

// Fetch and display user profile information
$profileSql = "SELECT phone_number, gender, b_day, b_month, b_year, province, city, brgy, region, zip_code FROM user_profile WHERE user_id = '$user_id'";
$profileResult = mysqli_query($conn, $profileSql);

if ($profileResult && mysqli_num_rows($profileResult) > 0) {
    $profileRow = mysqli_fetch_assoc($profileResult);
    $p_nums = !empty($profileRow['p_number']) ? $profileRow['p_number'] : '*';
    $genders = !empty($profileRow['gender']) ? $profileRow['gender'] : '*';

    $b_days = !empty($profileRow['b_day']) ? $profileRow['b_day'] : '*';
    $b_months = !empty($profileRow['b_month']) ? $profileRow['b_month'] : '*';
    $b_years = !empty($profileRow['b_year']) ? $profileRow['b_year'] : '*';

    $birthdays = !empty($b_days) && !empty($b_months) && !empty($b_years) ? "$b_day $b_month $b_year" : '*';

    $provinces = !empty($profileRow['province']) ? $profileRow['province'] : '*';
    $citys = !empty($profileRow['city']) ? $profileRow['city'] : '*';
    $brgys = !empty($profileRow['brgy']) ? $profileRow['brgy'] : '*';
    $regions = !empty($profileRow['region']) ? $profileRow['region'] : '*';
    $zip_codes = !empty($profileRow['zip_code']) ? $profileRow['zip_code'] : '*';

    $addresss = "$provinces, $citys, $brgys, $regions, $zip_codes";
}
?>
