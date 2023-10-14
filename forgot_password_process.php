<?php
require 'require/database_class.php';
require 'require/database_settings.php';
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

$obj = new database($hostname,$username,$password,$database);

if (isset($_POST['forgot_password'])) {
    extract($_POST);
    $result = $obj->forgot_password($email);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        // print_r($row);
        extract($row);
        $result = $obj->changing_password($user_id);
        if ($result) {
            $result = $obj->user_record($user_id);
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                extract($row);
                $mail->addAddress($email);
                    $mail->Subject = "Hello ! ".$row['first_name']." ".$row['last_name']." your New Password";
                    $mail->msgHTML("<h1>Hey!</h1>
                    <p>As you have forgot your password - Hopefully we got have recovered with a new password</p>
                    <p>Your Login Credentials:</p>
                    <ul>
                    <li><strong>Email: </strong>".$email."</li>
                    <li><strong>Password: </strong>".$password."</li>
                    </ul>
                    <br>
                    <p> You are now a valued member of our Blogger community.</p>
                    <p>Best regards - <strong>Blogger</strong></p>
                    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
                    if ($mail->send()) {
                        $msg = "Email Sended Successfully! Please Check your email - for new login credentails";
                        header("location:forgot_password.php?page=forgot_password&msg=$msg&color=primary");
                    }else{
                        $msg = "Please Check your email - for new login credentails";
                        header("location:forgot_password.php?page=forgot_password&msg=$msg&color=text-danger");
                    }
            }
        }
        
    }else{
       $msg = "Email Not Found";
       header("location:forgot_password.php?page=forgot_password&msg=$msg&color=text-danger");
    } 

}
?>