<?php
date_default_timezone_set('Asia/Karachi');
require 'require/database_settings.php';
require 'require/database_class.php';

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

if (isset($_POST['action']) && $_POST['action'] == 'email_check') {
	extract($_POST);
	$result = $obj->email_check($email);
	if ($result->num_rows > 0) {
		echo "email matched";
	}
}

elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_profile'){

	extract($_REQUEST);
	$original_name = substr($profile_picture_name,9);
	if($_FILES['profile_picture']['name'] != ""){
		extract($_FILES['profile_picture']);
		$name = $original_name;
		// echo $name;
		$folder = "pictures";
		$path   = $folder.'/'.$name;
		// die();
		if(!is_dir($folder)){
			if(!mkdir($folder)){
				echo "Could Not Created $folder Folder";
				die;
			}
		}

		$file_uploaded = move_uploaded_file($tmp_name,$path);
		if ($file_uploaded) {
			$result = $obj->update_profile($user_id,$first_name,$last_name,$gender,$address,$path);
			if($result){
				echo "<p class='primary text-center'>Profile Updated Successfully!</p>";
			}else{
				echo "<p class='text-danger text-center'>Couldn't Updated Profile</p>";
			}
		}
	}else{
		$path   = $profile_picture_name;
		$result = $obj->update_profile($user_id,$first_name,$last_name,$gender,$address,$path);
		if($result){
			echo "<p class='primary text-center'>Profile Updated Successfully!</p>";
		}else{
			echo "<p class='text-danger text-center'>Couldn't Updated Profile</p>"; 
		}
	}
}

elseif(isset($_POST['action']) && $_POST['action'] == 'change_password'){
	extract($_POST);
	$result = $obj->change_password($user_id,$new_password);
	if($result){
	echo "<p class='primary text-center'>Password Changed Successfully!</p>";
	}else{
	echo "<p class='text-danger text-center'>Couldn't Change Password</p>";
	}
}

elseif(isset($_POST['action']) && $_POST['action'] == 'password_check'){
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	extract($_POST);
	$result = $obj->password_check($user_id,$old_password);
	if($result->num_rows > 0){
		echo "Ok";
	}else{
		echo "stop";
	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'feedback_user') {
	extract($_POST);
	$result = $obj->feedback_user($user_id,$message);
	if ($result) {
		?>
			<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
			<div class="toast-container p-3 top-50 end-0 translate-middle-y mt-5" id="toastPlacement">
				<div class="toast show">
				<div class="toast-header">
					<img src="images/logo.png" class=" me-2 img-fluid"  width="32" height="32" alt="...">
					<strong class="me-auto">Blogger</strong>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">
				<strong class="primary">Thank You for your Feedback</strong><br>
				</div>
				</div>
			</div>
			</div>
		<?php
		$result = $obj->sending_email_to_admins();
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				extract($row);
				$mail->addAddress($email);
				    $mail->Subject = "Hello Admin ".$first_name." ".$last_name." New Feedback..";
				    $mail->msgHTML("<h1 >New Feedback</h1>
				    <p>Your just received a new feedback to get it out on your dashboard.</p>
				    <br>
				    <p>Best regards - <strong>Blogger</strong></p>
				    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
				    $mail->send();
			}
		}

	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'feedback_visitor') {
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	extract($_POST);
	$result = $obj->feedback_visitor($full_name,$email,$message);
	if ($result) {
		?>
			<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
			<div class="toast-container p-3 top-50 end-0 translate-middle-y mt-5" id="toastPlacement">
				<div class="toast show">
				<div class="toast-header">
					<img src="images/logo.png" class=" me-2 img-fluid"  width="32" height="32" alt="...">
					<strong class="me-auto">Blogger</strong>
					<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
				</div>
				<div class="toast-body">
				<strong class="primary">Thank You for your Feedback</strong><br>
				</div>
				</div>
			</div>
			</div>
		<?php
		$result = $obj->sending_email_to_admins();
		if ($result->num_rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				extract($row);
				$mail->addAddress($email);
				    $mail->Subject = "Hello Admin ".$first_name." ".$last_name." New Feedback..";
				    $mail->msgHTML("<h1 >New Feedback</h1>
				    <p>Your just received a new feedback to get it out on your dashboard.</p>
				    <br>
				    <p>Best regards - <strong>Blogger</strong></p>
				    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
				    $mail-> send();
			}
		}
	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'follow_status') {

	extract($_POST);

	$follower_record = $obj->user_record($user_id);
	$follower_record = mysqli_fetch_assoc($follower_record);

	$blog_author     = $obj->blog_author($blog_author_id,$blog_id);
	$blog_author     = mysqli_fetch_assoc($blog_author);

	$result = $obj->follow_status($user_id,$blog_id,$status);
	if ($result) {
		if ($status == 'Follow') {
			$mail->addAddress($blog_author['email']);
			    $mail->Subject = "Hello Admin ".$blog_author['first_name']." ".$blog_author['last_name']."";
			    $mail->msgHTML("<h1>Followed your ". $blog_author['blog_title'] ."</h1>
			    <p>".$follower_record['first_name']." ".$follower_record['last_name']." Followed Your Blog</p>
			    <br>
			    <p>Best regards - <strong>Blogger</strong></p>
			    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
			    $mail-> send();
			    echo "follow";
		}else{
			$mail->addAddress($blog_author['email']);
			    $mail->Subject = "Hello Admin ".$blog_author['first_name']." ".$blog_author['last_name']."";
			    $mail->msgHTML("<h1>Followed your ". $blog_author['blog_title'] ."</h1>
			    <p>".$follower_record['first_name']."".$follower_record['last_name']." Unfollowed Your Blog</p>
			    <br>
			    <p>Best regards - <strong>Blogger</strong></p>
			    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
			     $mail-> send();
			     echo "unfollow";
		}
	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'new_follower') {

	extract($_POST);
	$follower_record = $obj->user_record($user_id);
	$follower_record = mysqli_fetch_assoc($follower_record);

	$blog_author     = $obj->blog_author($blog_author_id,$blog_id);
	$blog_author     = mysqli_fetch_assoc($blog_author);

	$result = $obj->new_follower($user_id,$blog_id);
	if ($result) {
		$mail->addAddress($blog_author['email']);
		    $mail->Subject = "Hello Admin ".$blog_author['first_name']." ".$blog_author['last_name']."";
		    $mail->msgHTML("<h1>New Followed your ". $blog_author['blog_title'] ."</h1>
		    <p>".$follower_record['first_name']." ".$follower_record['last_name']." Followed Your Blog</p>
		    <br>
		    <p>Best regards - <strong>Blogger</strong></p>
		    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
		    $mail-> send();
	}
}


elseif (isset($_POST['action']) && $_POST['action'] == 'commenting') {
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	extract($_POST);
	if ($user_id == $author_id) {
		$result = $obj->author_commenting($author_id,$post_id,$comment);
		if ($result) {
			?>
			<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
				<div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
					<div class="toast show">
						<div class="toast-body">
							<button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
							<strong class="primary">Comment Added</strong><br>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
	}
	else{
		$result = $obj->commenting($user_id,$post_id,$comment);
		if ($result) {
			?>
			<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
				<div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
					<div class="toast show">
						<div class="toast-body">
							<button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
							<strong class="primary">Comment Added</strong><br>
							<p class="primary">Your comment will be visible after the approval of post author</p>
						</div>
					</div>
				</div>
			</div>
			<?php
		}	
	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'search_blogs') {
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	extract($_POST);
	$result = $obj->search_blogs($search);
	if ($result->num_rows > 0) {
		while($row = mysqli_fetch_assoc($result)){
			// echo "<pre>";
			// print_r($blog);
			// echo "<pre>";
			?>
			<div class="col">
              <div class="card shadow-sm">
                <img src="<?php echo $row['blog_background_image'] ?>" class="image-fluid rounded-top" alt="">
                <div class="card-body">
                  <!-- <h4 class="primary theme_settings"><?php echo $row['blog_title'] ?></h4> -->
                  <h4 class="primary theme_settings"><?php echo $row['blog_title'] ?>
                    <span class="float-end fs-6 primary">
                      <?php
                        $total_posts = $obj->total_blog_posts($row['blog_id']);
                        if ($total_posts->num_rows > 0) {
                          $total_blog_posts = mysqli_fetch_assoc($total_posts);
                          ?>
                          <i class="fa-solid fa-file-pen"></i> <?php echo $total_blog_posts['total_blog_posts']; ?>
                          <?php
                        }else{
                          ?>
                          <i class="fa-solid fa-file-pen"></i> <?php echo "0"; ?>
                          <?php
                        }
                      ?>
                    </span>
                    <span class="float-end fs-6 primary mx-2">
                      <?php
                        $total_followers = $obj->total_blog_followers($row['blog_id']);
                        if ($total_followers->num_rows > 0) {
                          $total_blog_followers = mysqli_fetch_assoc($total_followers);
                          ?>
                          <i class="fa-solid fa-plus"></i> <?php echo $total_blog_followers['total_followers']; ?>
                          <?php
                        }else{
                          ?>
                          <i class="fa-solid fa-plus"></i> <?php echo "0"; ?>
                          <?php
                        }
                      ?>
                    </span>
                  </h4>
                  <small class="text_color"><?php echo substr($row['blog_summary'],0,30)."...." ?></small><br>
                  <small class="text_color"><em>Author: <?php echo $row['first_name']." ".$row['last_name'] ?></em></small>
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="blog_page.php?page=blog_page&blog_id=<?php echo $row['blog_id'] ?>" class="btn btn-sm btn-primary"><i class="fa-solid fa-book"></i> Read Blog</a>
                    </div>
                    <small class="text-body-secondary">
                      <?php 
                      $date = date_create($row['created_at']);
                      echo date_format($date,"d M - Y"); ?>                                   
                   </small>
                  </div>
                </div>
              </div>
            </div>
			<?php
		}
	}else{
		?>
		<div class="col"></div>
		<div class="col">
			<div class="alert alert-warning text-center text-danger" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> No Blog Found</div>
		</div>
		<div class="col"></div>
		<?php
	}
}

elseif (isset($_POST['action']) && $_POST['action'] == 'search_posts') {
	extract($_POST);
	$result = $obj->search_posts($search,$blog_id);
	if ($result->num_rows > 0) {
		while ($blog_posts = mysqli_fetch_assoc($result)) {
			?>
			<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 my-2">
				<div class="card shadow-sm">
					<img src="<?php echo $blog_posts['featured_image'] ?>" class="img-fluid" alt="">
					<div class="card-body">
					<h4 class="text_color theme_settings"><?php echo $blog_posts['post_title'] ?></h4>
					<p class="card-text"><?php echo substr($blog_posts['post_summary'],0,30)."...." ?></p>
					<div class="d-flex justify-content-between align-items-center">
						<div class="btn-group">
						<a href="post.php?page=post&post_id=<?php echo $blog_posts['post_id'] ?>" class="btn btn-sm btn-primary">Read Post</a>
						</div>
						<small class="text-body-secondary">
							<?php $date = date_create($blog_posts['created_at']);
									echo date_format($date,"d M-Y"); ?>			
						</small>
					</div>
					</div>
				</div>					
			</div>
			<?php
		}
	}else{
		?>
		<div class="col"></div>
		<div class="col">
			<div class="alert alert-warning text-center text-danger" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> No Post Found</div>
		</div>
		<div class="col"></div>
		<?php
	}
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'theme_settings') {
	$user_id  = $_REQUEST['user_id'];
	$settings = $_POST;

	foreach ($settings as $key => $value) {

		if ($value != "") {
			$result = $obj->manage_theme_setting($user_id,$key);

			if ($result->num_rows > 0) {
			$row              = mysqli_fetch_assoc($result);
			$removing_setting = $obj->remove_theme_setting($user_id,$row['setting_key']);

				if ($removing_setting) {
				$result = $obj->theme_settings($user_id,$key,$value);
				}	
			}
			else{
			$result = $obj->theme_settings($user_id,$key,$value);			
			}
		}

	}
	
	if ($result) {
		?>
		<p class="primary text-center">Settings Applied</p>
		<?php
	} else {
		?>
		<p class="text-danger text-center">Coudln't apply settings</p>
		<?php
	}
}


elseif (isset($_POST['action']) && $_POST['action'] == 'activation_request') {
	// echo "<pre>";
	// print_r($_POST);
	// echo "</pre>";
	extract($_POST);
	$result = $obj->requesting_user($email);
	if ($result->num_rows > 0) {
		$user   = mysqli_fetch_assoc($result);
		$admins_record = $obj->all_admins();
		if ($admins_record->num_rows > 0) {
			while ($admins = mysqli_fetch_assoc($admins_record)) {
				$mail->addAddress($admins['email']);
				    $mail->Subject = "Hello Admin ".$admins['first_name']." ".$admins['last_name']." Account Activation Request";
				    $mail->msgHTML("<h1>Account Activation Request</h1>
				    <p>".$user['first_name']." ".$user['last_name']." is Requesting for Activation</p>
				    <br>
				    <p>Best regards - <strong>Blogger</strong></p>
				    <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
				    $mail-> send();
			}
			echo "<p class='primary'>Activation Request Sent</p>";
		}
	}
}
?>