<?php
session_start();
require 'require/database_settings.php';
require 'require/database_class.php';
require 'FPDF/fpdf.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->SMTPAuth = true;
$mail->Username = 'salarhere27@gmail.com';
$mail->Password = 'dgmvpxzdptbzwydb';
$mail->setFrom('salarhere27@gmail.com','Blogger');

date_default_timezone_set('Asia/Karachi');




$obj    = new database($hostname,$username,$password,$database);

if (isset($_POST['register'])) {
    // echo "<pre>";
    // print_r($_POST);
    // print_r($_FILES);
    // echo "</pre>";


    $alpha_pattern     = "/^[A-Z]{1}[a-z]{2,}$/";
	$email_pattern     = "/^[a-z]{2,}[0-9]{1,3}[@][a-z]{5,8}[.][a-z]{3}$/";
	$password_pattern  = "/^[A-Z]{1}\w{7,}$/";
	$address_pattern   = "/^[A-Z a-z]{4,}$/";
	$file_extension    = "/(png|jpg|jpeg)$/";

	extract($_POST);
	extract($_FILES);

	$flag      = true;


	if ($first_name == "") {
		$flag           = false;
		$first_name_msg = 'Please enter your first name';
	}else{
		$first_name_msg = "";
		if (!preg_match($alpha_pattern, $first_name)) {
			$flag           = false;
			$first_name_msg = 'First name eg. Ali';
		}
	}

	if ($last_name == "") {
		$flag          = false;
		$last_name_msg = "Please enter your last name"; 
	}else{
		$last_name_msg = "";
		if (!preg_match($alpha_pattern, $last_name)) {
			$flag          = false;
			$last_name_msg = "Last name eg. Khan";
		}
	}

	if ($email == "") {
		$flag = false;
		$email_msg = "Please enter your email";
	}else{
		$email_msg = "";
		if (!preg_match($email_pattern, $email)) {
			$flag = false;
			$email_msg = "eg. ali123@gmail.com";
		}
	}

	if ($password == "") {
		$flag         = false;
		$password_msg = "Please enter your password"; 
	}else{
		$password_msg = "";
		if (!preg_match($password_pattern, $password)) {
			$flag         = false;
			$password_msg = "altest 8 characters one uppercase character";
		}
	}

	if (!isset($gender)) {
		$flag       = false;
		$gender_msg = "Please choose your gender";
	}

	if ($date_of_birth == "") {
		$flag    = false;
		$dob_msg = "Please enter your date of birth";
	}

	
	if ($address == "") {
		$flag = false;
		$address_msg = "Please enter your address";
		}else{
			$address_msg = "";
			if (!preg_match($address_pattern, $address)) {
				$flag        =  false;
				$address_msg = "eg. Jamshoro Pakistan"; 
			}
		}

	$max_size = 1024 * 1024;
	if (!$profile_picture['error'] == 0) {
		$flag                = false;
		$profile_picture_msg = "Please give your profile picture";
	}else{
		$profile_picture_msg = "";
		$file_ext 			 = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
		if (!preg_match($file_extension,$file_ext)) {
			$flag 				 = false;
			$profile_picture_msg = "file type should be jpg/jpeg/png only";
		}
		if ($profile_picture['size'] > $max_size) {
			$flag  				 = false;
			$profile_picture_msg = "max file size 1MB only";
		}

	}

	if ($flag == false) {
		header("location:register.php?page=blog&first_name_msg=$first_name_msg&last_name_msg=$last_name_msg&email_msg=$email_msg&password_msg=$password_msg&gender_msg=$gender_msg&dob_msg=$dob_msg&profile_picture_msg=$profile_picture_msg&address_msg=$address_msg");
		die();
	}


	extract($profile_picture);

	$original_file_name = $name;
    $file_name = rand()."_".$name;
    // echo  $tmp_name;
    $folder = "pictures";
    $path   = $folder.'/'.$file_name;

    if(!is_dir($folder)){
        if(!mkdir($folder)){
            echo "Could Not Created $folder Folder";
            die;
        }
    }

    $file_uploaded = move_uploaded_file($tmp_name,$path);
	if ($file_uploaded) {

		$result = $obj->register_user($first_name,$last_name,$email,$password,$gender,$date_of_birth,$address,$path);
		if ($result) {
			$mail->addAddress($email);
			$mail->Subject = "Congraluation's ".$first_name." ".$last_name." Account Created Successfully";
			$mail->msgHTML("<h1 >Congratulations!</h1>
			<p>Thank you for registering on Blogger. You are now a valued member of our Blogger community.</p>
			<p>Your login credentials are:</p>
			<ul>
				<li><strong>Email: </strong>".$email."</li>
				<li><strong>Password: </strong>".$password."</li>
			</ul>
			<br>
			<p>Right Now your account is in pending state wait for your account to get Approved by Admin</p>
			<p>You Will be receving an email after getting Approved</p>
			<p>Best regards - <strong>Blogger</strong></p>
			<p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");

			if ($mail->send()) {
				$msg  = "Congratulations on a successful registration!"; 
				header("location:register.php?page=register&msg=$msg&email=$email");
			}else{
				echo "Can't Send Email";
				// $msg  = "Congratulations on a successful registration!"; 
				// header("location:register.php?page=register&msg=$msg&email=$email");
			}
		}
	}

}


?>