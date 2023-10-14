<?php

class general{

	public $action;
	public $method = "GET";

	public function set_action($action){
		$this->action = $action;		
	}

	public function get_action(){
		return $this->action;			
	}

	public function set_method($method){
		$this->method = $method;			
	}

	public function get_method(){
		return $this->method;			
	}

	public function header(){
		session_start();
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
		    <meta charset="UTF-8">
		    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		    <title>Blogger</title>
		    <link rel="icon" href="images/favicon.png" type="image/x-icon">
		    <link rel="stylesheet" href="bootstrap/dist/css/bootstrap.min.css">
		    <link rel="stylesheet" href="fontawesome/css/all.min.css">
		    <link rel="stylesheet" href="css/style.css">
			<link rel="stylesheet" href="animate_css/animate.min.css">
			<link rel="stylesheet" href="select2/dist/css/select2.min.css">
		</head>
		<body>
		<?php
	}

	public function footer(){
		?>
		<div>
		  <p style="margin-top:210px"></p>
		  <div class="container-fluid bg-light">
		  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 border-top">
			  <div class="col-md-4 d-flex align-items-center">
				  <a href="index.php" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
					  <img src="images/logo.png" width="30" height="100%" alt="">
					</a>
					<span class="mb-3 mb-md-0 text_color">&copy; 2023 Company, Inc</span>
				</div>
				
				<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
					<li class="ms-3"><a href="#"><i class="fa-brands fa-instagram icon_color"></i></a></li>
					<li class="ms-3"><a href="#"><i class="fa-brands fa-linkedin icon_color"></i></a></li>
					<li class="ms-3"><a href="#"><i class="fa-brands fa-facebook icon_color"></i></a></li>
				</ul>
			</footer>
		</div> 
		</div>
		</body>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script type="text/javascript">
			// $(document).ready(function () {
			//     $('.js-example-basic-multiple').select2({
			//         placeholder: 'Choose Theme Settings',
			//         allowClear: true,
			//         closeOnSelect: false // Allow multiple selections to stay open
			//     });
			// });
		</script>
		<script type="text/javascript" src="js/ajax.js"></script>
		<script src="bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<script src="select2/dist/js/select2.min.js"></script>
		</html>
		<?php
	}

	public function navbar(){
		?>
		<nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="index.php"><img src="images/logo.png" width="40" height="100%" alt=""></a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarScroll">
		      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
		        <li class="nav-item">
		          <a class="nav-link text_color" aria-current="page" href="<?php echo isset($_GET['page'])?"index.php":"#home" ?>">Home</a>
		        </li>
		        <?php  if (!isset($_GET['page'])) {
		        ?>
		        <li class="nav-item">
		          <a class="nav-link text_color" href="#about_us">About Us</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link text_color" href="#features">Features</a>
		        </li>
		        <li class="nav-item">
		          <a class="nav-link text_color" href="#contact_us">Contact Us</a>
		        </li>
		        <?php
		        } ?>
		        <li class="nav-item">
		          <a class="nav-link text_color" href="blog.php?page=blog">Blog</a>
		        </li>
		    </ul>
			<?php
			if (isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				// echo "<pre>";
				// print_r($user);
				// echo "<pre>";
				?>
				<div class="dropdown me-5">
					<a href="#" class="d-flex align-items-center text_color text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
						<img src="<?php echo $user['profile_picture'] ?>" alt="" width="32" height="32" class="rounded-circle me-2">
						<strong><?php echo $user['first_name']." ".$user['last_name'] ?></strong>
					</a>
					<ul class="dropdown-menu dropdown-menu-light text-small shadow">
						<?php
						if ($_SESSION['user']['role_id'] == 1) {
							?>
						<li><a class="dropdown-item" href="dashboard/dashboard.php"><i class="fa-solid fa-briefcase"></i> Dashboard</a></li>
							<?php							
						}
							?>
						<li><a class="dropdown-item dash-btn" href="settings.php?page=settings"><i class="fa-solid fa-gear"></i> Settings</a></li>
						<li><hr class="dropdown-divider"></li>
						<li><a class="dropdown-item text-danger" href="logout.php"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sign out</a></li>
					</ul>
    			</div>
				<?php
			}else{
				?>				
				<form class="d-flex">
					<a href="login.php?page=login" class="btn btn-primary">Sign In <i class="fa-solid fa-right-to-bracket"></i></a>
					<a href="register.php?page=register" class="btn btn-info mx-2">Sign Up <i class="fa-solid fa-user-plus"></i></a>
				</form>
				<?php
			}
			?>
		    </div>
		  </div>
		</nav>
		<?php
	}


	/*-->>>>>>>>>> FORM's Starts <<<<<<<<<--*/

	public function sign_up(){
		?>
		<div class="col-sm col-md col-lg col-xl">
			<form action="<?php echo $this->get_action() ?>" method="<?php echo $this->get_method() ?>" enctype="multipart/form-data">
            <!-- <img class="mb-4" src="images/logo.png" alt="" width="72" height="57"> -->
				  <h1 class="h3 mb-3 fw-bold fs-1 text_color">Sign Up</h1>	
				<div class="row">
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">First Name</label>
						<input type="text" id="first_name" class="form-control" name="first_name" placeholder="eg. Ahmed">
						<p class="form-label text-danger" id="first_name_msg" ><?php echo isset($_GET['first_name_msg'])?"{$_GET['first_name_msg']}":""?></p>
					  </div>
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">Last Name</label>			
						<input type="text" id="last_name" class="form-control" name="last_name" placeholder="eg. Khan">
						<p class="form-label text-danger" id="last_name_msg"><?php echo isset($_GET['last_name_msg'])?"{$_GET['last_name_msg']}":""?></p>
					  </div>
				</div>
				<div class="row mt-2">
					  <div class="col-sm-6 col-md-6 col-lg-6">
						<label class="form-label">Email</label>
						<input type="email" onblur="email_check()" id="email" class="form-control" name="email" placeholder="example@gmail.com">
						<p class="form-label text-danger" id="email_msg"><?php echo isset($_GET['email_msg'])?"{$_GET['email_msg']}":""?></p>
					  </div>
					  <div class="col-sm-6 col-md-6 col-lg-6">
						<label class="form-label">Password</label>
						<input type="password" id="password" class="form-control" name="password" placeholder="Password">
						<p class="form-label text-danger" id="password_msg"><?php echo isset($_GET['password_msg'])?"{$_GET['password_msg']}":""?></p>
					  </div>
				</div>
				<div class="row mt-2">
					  <div class="col-sm-6 col-md-6 col-lg-6">
						<label class="form-label">Gender</label><br>
						<input type="radio" id="gender_male" name="gender" value="Male"> Male
						<input type="radio" id="gender_female" name="gender" value="Female"> Female
						<p class="form-label text-danger" id="gender_msg"><?php echo isset($_GET['gender_msg'])?"{$_GET['gender_msg']}":""?></p>
					  </div>
					  <div class="col-sm-6 col-md-6 col-lg-6">
						<label class="form-label">Date of Birth</label>
						<input type="date" id="date_of_birth" class="form-control" name="date_of_birth" placeholder="DD-MM-YYYY">
						<p class="form-label text-danger" id="date_of_birth_msg"><?php echo isset($_GET['dob_msg'])?"{$_GET['dob_msg']}":""?></p>
					  </div>
				</div>	  			
				  <div class="row mt-2">
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">Profile Picture</label>
						<input type="file" id="profile_picture" name="profile_picture" class="form-control">
						<p class="form-label text-danger" id="profile_picture_msg"><?php echo isset($_GET['profile_picture_msg'])?"{$_GET['profile_picture_msg']}":""?></p>
					  </div>	
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">Address</label>
						<input type="text" id="address" class="form-control" name="address" placeholder="eg. Jamshoro Pakistan">
						<p class="form-label text-danger" id="address_msg"><?php echo isset($_GET['address_msg'])?"{$_GET['address_msg']}":""?></p>
					  </div>	
				  </div>
				  <div class="row mt-5">
					  <input type="submit" id="register_btn" class="btn btn-primary" onclick="return register_form()" name="register" value="Sign Up">
				  </div>
			</form>
		</div>
		<?php
	}

	public function sign_in(){
		?>
		<div class="col-6">
		    <main class="form-signin w-100 m-auto">
		      <form action="<?php echo $this->get_action() ?>" method="<?php echo $this->get_method() ?>">
		        <img class="mb-4" src="images/logo.png" alt="" width="72" height="57">
		        <p class="display-5 text-center text-color">Welcome Back</p>            
		        <div class="form-floating">
		          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="ali123@example.com">
		          <label for="floatingInput">Email address</label>
		        </div>
		        <div class="form-floating mt-2">
		          <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password">
		          <label for="floatingPassword">Password</label>
		        </div>
		        <input type="submit" class="btn btn-primary w-100 py-2 mt-2" name="login" value="Sign In">
		        <a href="forgot_password.php?page=forgot_password" class="text_color mt-2 float-end text-decoration-none"> Forgot Password ?</a>
		      </form>
		    </main>
		</div>
		<?php
	}

	public function forgot_password(){
		?>
		<div class="col-6">
		    <main class="form-signin w-100 m-auto">
		      <form action="<?php echo $this->get_action() ?>" method="<?php echo $this->get_method() ?>">
		        <img class="mb-4" src="images/logo.png" alt="" width="72" height="57">
		        <p class="display-5 text-center text-color">Recover Password</p>            
		        <div class="form-floating">
		          <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com">
		          <label for="floatingInput">Email address</label>
		        </div>
		        <input class="btn btn-primary w-100 py-2 mt-2" name="forgot_password" type="submit" value="Send">
		      </form>
		    </main>
		</div>
		<?php
	}

	public function feedback_form(){
		?>
		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
			<?php 
			if (!isset($_SESSION['user'])) {
				?>
				<div class="row">
					
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">Full Name</label>
						<input id="full_name" type="text" class="form-control" name="full_name">
						<p id="full_name_msg" class="form-label text-danger"></p>
					  </div>
					  <div class="col-sm-6 col-md-6 col-lg-6">
						  <label class="form-label">Email</label>			
						<input id="email" type="email" class="form-control" name="email">
						<p id="email_msg" class="form-label text-danger"></p>
					  </div>
				</div>
				<?php
			}
			?>
			<div class="row mt-3">
		        <div class="mb-3">
		          <label  class="form-label">Message</label>
		          <textarea class="form-control" id="message" rows="3" name="feedback"></textarea>
				  <p id="message_msg" class="form-label text-danger"></p>
				</div>
			</div>
		      <div class="row">
		        <div class="col">
		          <button onclick="return feedback('<?php echo isset($_SESSION['user'])?$_SESSION['user']['user_id']:'' ?>')" class="btn btn-primary" type=button>Send Message</button>
		        </div>
		      </div>
		</div>
		<?php
	}

	/*-->>>>>>>>>> FORM's Ends <<<<<<<<<--*/



	/*-->>>>>>>>>> DASHBOARD <<<<<<<<<--*/

	public function dashboard_header(){
		session_start();
		
		if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 2) {
			header("location:../index.php");
			
		}elseif(!$_SESSION['user']){
			$msg = "Login First";
			header("location:../login.php?page=login&msg=$msg");
		}
		$user = $_SESSION['user'];

		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<title></title>
			<link rel="icon" href="../images/favicon.png" type="image/x-icon">
			<link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.min.css">
			<link rel="stylesheet" href="../fontawesome/css/all.min.css">
			<link rel="stylesheet" href="../css/style.css">	
			<link href="../css/dashboard.css" rel="stylesheet">
			<link rel="stylesheet" href="../select2/dist/css/select2.min.css">
			<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
			<link rel="stylesheet" type="text/css" href="../data_table/jquery.dataTables.min.css">
			<script type="text/javascript" src="../data_table/jquery-3.7.0.js"></script>
			<script type="text/javascript" src="../data_table/jquery.dataTables.min.js" defer></script>
		</head>
		<body>
		<?php
	}

	public function dashboard_navbar(){
		?>
		<header class="navbar sticky-top bg-body-tertiary flex-md-nowrap p-0 shadow">
			<a onclick="dashboard()" class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text_color" href="#"><i class="fa-solid fa-briefcase"></i> Dashboard</a>
			<ul class="navbar-nav flex-row d-md-none">
				<li class="nav-item text-nowrap">
				<button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
					<i class="fa-solid fa-bars text_color"></i>
				</button>
				</li>
			</ul>
			<div id="navbarSearch" class="navbar-search w-100 collapse">
				<input class="form-control w-100 rounded-0 border-0" type="text" placeholder="Search" aria-label="Search">
			</div>
		</header>
		<?php
	}

	public function dashboard_footer(){
		?>
		<div>
		  <p style="margin-top:105px"></p>
		</div> 
		<div class="container-fluid fixed-bottom bg-light">
			<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
				<div class="col-md-4 d-flex align-items-center">
				<a href="../index.php" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
					<img src="../images/logo.png" width="30" height="100%" alt="">
				</a>
				<span class="mb-3 mb-md-0 text_color">&copy; 2023 Company, Inc</span>
				</div>
				<ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
				<li class="ms-3"><a href="#"><i class="fa-brands fa-instagram icon_color"></i></a></li>
				<li class="ms-3"><a href="#"><i class="fa-brands fa-linkedin icon_color"></i></a></li>
				<li class="ms-3"><a href="#"><i class="fa-brands fa-facebook icon_color"></i></a></li>
				</ul>
			</footer>
		</div>
		</body>
		<script src="../js/dashboard.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> -->
		<script src="../select2/dist/js/select2.min.js"></script>

		</html>
		<?php
	}

	public function dashboard_sidebar(){
		?>
		<div class="sidebar border border-right col-sm-3 col-md-3 col-lg-2 p-0 bg-body-tertiary">
			<div class="offcanvas-md offcanvas-end bg-body-tertiary" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
			<div class="offcanvas-header">
			<h5 class="offcanvas-title" id="sidebarMenuLabel"><img src="../images/logo.png" width="25" height="100%" alt=""></h5>
			<button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
			</div>
			<div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
			<ul class="nav flex-column">
				<li class="nav-item">
				<a class="nav-link d-flex align-items-center gap-2 sidebar-text " aria-current="page" href="../index.php">
				<i class="fa-solid fa-house"></i> Home
				</a>
				</li>
				<li class="nav-item">
				<a class="nav-link d-flex align-items-center gap-2 sidebar-text" aria-current="page" href="../blog.php?page=blog">
				<i class="fa-solid fa-book"></i> Blog
				</a>
				</li>
				
			</ul>
			<hr class="my-3">

			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
				<span>Records</span>
			</h6>
			<ul class="nav flex-column mb-auto">
				
				<li class="nav-item">
				<a onclick="total_blogs()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-book"></i> Blog's
				</a>
				</li>
				<li class="nav-item">
				<a onclick="total_posts()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-file-pen"></i> Post's
				</a>
				</li>
				<li class="nav-item">
				<a onclick="total_categories()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-list-ul"></i> Categories 
				</a>
				</li>
				<!--<li class="nav-item">
				<a onclick="total_followers()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-plus"></i> Follower's 
				</a>
				</li> -->
				<li class="nav-item">
				<a onclick="total_feedbacks()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-regular fa-message"></i> Feedback's
				</a>
				</li>
			</ul>

			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
				<span>Create</span>
			</h6>
			<ul class="nav flex-column mb-auto">
				
				<li class="nav-item">
				<a onclick="create_blog()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-circle-plus"></i> Create Blog 
				</a>
				</li>
				<li class="nav-item">
				<a onclick="create_post()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-circle-plus"></i> Create Post 
				</a>
				</li>
				<li class="nav-item">
				<a onclick="create_categories()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-circle-plus"></i> Create Categories 
				</a>
				</li>
			</ul>


			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
				<span>User's</span>
			</h6>
			<ul class="nav flex-column mb-auto">
				<li class="nav-item">
				<a onclick="add_user()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-user-plus"></i> Add user 
				</a>
				</li>
				<li class="nav-item">
				<a onclick="all_users()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-users"></i> All user's  
				</a>
				</li>
				<li class="nav-item">
				<a onclick="rejected_users()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn text-danger">
				<i class="fa-solid fa-users-slash"></i> Rejected User's  
				</a>
				</li>
			</ul>
			<h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-body-secondary text-uppercase">
				<span>Discussions</span>
			</h6>
			<ul class="nav flex-column mb-auto">
				<li class="nav-item">
				<a onclick="comments()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-comments"></i> Comments
				</a>
				</li>
			</ul>
			<hr class="my-3">
			<ul class="nav flex-column mb-auto">
				<li class="nav-item">
				<a onclick="settings()" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn">
				<i class="fa-solid fa-gear"></i> Settings 
				</a>
				</li>
				<li class="nav-item">
				<a href="../logout.php" class="nav-link d-flex align-items-center gap-2 sidebar-text dash-btn text-bg-danger">
				<i class="fa-solid fa-arrow-right-from-bracket"></i> Sign out 
				</a>
				</li>
			</ul>
			</div>
			</div>
    	</div>
		<?php
	}

}

?>