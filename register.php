<?php 
require 'require/general_library.php';

$obj = new general();

$obj->header();
$obj->navbar();
if (isset($_SESSION['user'])) {
	header("location:index.php");
  }
 ?>

<script>
function register_form(){

	var flag;
	flag = true;

	var alpha_pattern    = /^[A-Z]{1}[a-z]{2,}$/;
	var email_pattern    = /^[a-z]{2,}[0-9]{1,3}[@][a-z]{5,8}[.][a-z]{3}$/;
	var password_pattern = /^[A-Z]{1}\w{7,}$/;
	var address_pattern  = /^[A-Z a-z]{4,}$/;
	var file_extensions  = /(.jpg|.jpeg|.png)$/;
	
	
	var first_name      = document.getElementById('first_name').value;
	var last_name       = document.getElementById('last_name').value;
	var email           = document.getElementById('email').value;
	var password        = document.getElementById('password').value;
	var date_of_birth   = document.getElementById('date_of_birth').value;
	var address         = document.getElementById('address').value;
	
	var gender_element  = document.querySelectorAll("input[type='radio']");
	var gender          = null;
	var gender_male     = document.getElementById('gender_male');
	var gender_female   = document.getElementById('gender_female');
	
	var profile_picture = document.getElementById('profile_picture').files[0];
	var max_size = 1024 * 1024;

	

	if (gender_element[0].checked) {
		gender = gender_element[0].value;
	}
	else if(gender_element[1].checked){
		gender = gender_element[1].value;
	}
	

	if (first_name == "") {
	    flag = false;
	    document.getElementById("first_name_msg").style.color = 'red';
		document.getElementById('first_name').style.borderColor = 'red';
	    document.getElementById("first_name_msg").innerHTML   = "Please Enter First Name";
	}else{
		document.getElementById("first_name_msg").innerHTML   = "";
		document.getElementById('first_name').style.borderColor = 'green';
	     if (alpha_pattern.test(first_name) == false) {
	     	flag = false;
			document.getElementById('first_name').style.borderColor = 'red';
	    	document.getElementById("first_name_msg").innerHTML = "First name eg. Ali";
	    }  
	}

	if (last_name == "") {
	    flag = false;
	    document.getElementById("last_name_msg").style.color = 'red';
		document.getElementById('last_name').style.borderColor = 'red';
	    document.getElementById("last_name_msg").innerHTML   = "Please Enter Last Name";
	}else{
		document.getElementById("last_name_msg").innerHTML   = "";
		document.getElementById('last_name').style.borderColor = 'green';
	     if (alpha_pattern.test(last_name) == false) {
	     	flag = false;
			document.getElementById('last_name').style.borderColor = 'red';
	    	document.getElementById("last_name_msg").innerHTML = "Last name eg. Khan";
	    }  
	}


	if (email == "") {
		flag = false;
		document.getElementById('email_msg').style.color = 'red';
		document.getElementById('email_msg').innerHTML   = 'Please enter your email';
		document.getElementById('email').style.borderColor = 'red';
	}else{
		document.getElementById('email_msg').innerHTML   = '';
		document.getElementById('email').style.borderColor = 'green';
		if (email_pattern.test(email) == false) {
			flag = false;
			document.getElementById('email').style.borderColor = 'red';
			document.getElementById('email_msg').innerHTML = 'eg. ali123@gmail.com';
		}
	}

	if (password == '') {
		flag = false;
		document.getElementById('password_msg').style.color = 'red';
		document.getElementById('password').style.borderColor = 'red';
		document.getElementById('password_msg').innerHTML   = 'Please enter your password';
	}else{
		document.getElementById('password_msg').innerHTML   = '';
		document.getElementById('password').style.borderColor = 'green';
		if (password_pattern.test(password) == false){
			flag = false;
			document.getElementById('password').style.borderColor = 'red';
			document.getElementById('password_msg').innerHTML = 'altest 8 characters one uppercase character';
		}
	}

	if (!gender) {

	flag = false;
	document.getElementById("gender_msg").style.color = 'red';

	document.getElementById("gender_msg").innerHTML   = "Please choose your gender";
	}else{
	document.getElementById("gender_msg").innerHTML   = "";
	}

	if (date_of_birth == '') {
		flag = false;
		document.getElementById('date_of_birth_msg').style.color = 'red';
		document.getElementById('date_of_birth').style.borderColor = 'red';
		document.getElementById('date_of_birth_msg').innerHTML   = 'Please give your date of birth'; 	
	}else{
		document.getElementById('date_of_birth').style.borderColor = 'green';
		document.getElementById('date_of_birth_msg').innerHTML   = ''; 	
	}

	if (address == '') {
		flag = false;
		document.getElementById('address_msg').style.color = 'red';
		document.getElementById('address').style.borderColor = 'red';
		document.getElementById('address_msg').innerHTML   = 'Please enter your address'; 
	}else{
		document.getElementById('address').style.borderColor = 'green';
		document.getElementById('address_msg').innerHTML   = '';

		if (address_pattern.test(address) == false) {
			flag = false;
			document.getElementById('address').style.borderColor = 'red';
			document.getElementById('address_msg').innerHTML = 'eg. Jamshoro Pakistan';
		}
	}

	if (!profile_picture) {
		flag = false;
	    document.getElementById("profile_picture_msg").innerHTML   = "Please Enter your profile picture";
		document.getElementById('profile_picture').style.borderColor = 'red';
	}else{
	    document.getElementById("profile_picture_msg").innerHTML   = "";
		document.getElementById('profile_picture').style.borderColor = 'green';
		if (!file_extensions.test(profile_picture.name)) {
			$flag = false;
			document.getElementById('profile_picture').style.borderColor = 'red';
			document.getElementById("profile_picture_msg").innerHTML   = "file type should be jpg/jpeg/png only";
		}
		if (profile_picture.size > max_size) {
			$flag = false;
			document.getElementById('profile_picture').style.borderColor = 'red';
			document.getElementById("profile_picture_msg").innerHTML   = "max file size 1MB only";
		}
	}


	if (flag) {
		return true;
	}else{
		return false;

	}
}
</script>
<?php
if (isset($_GET['msg'])) {
	// echo $_GET['email'];
	$email = $_GET['email'];
	// echo $email;
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
			<strong class="primary"><?php echo $_GET['msg'] ?></strong><br>
				Please check your email.<br><br>
				<button onclick="download_file('<?php echo $email ?>')" class=" btn btn-primary float-end btn-sm mx-2">Download PDF</button>
				<br><br>
			</div>
			</div>
		</div>
	</div>
	
	<?php
}
?>

<div class="container mt-5">
	<div class="row">
		<?php
		$obj->set_method("POST");
		$obj->set_action("register_process.php");
		$obj->sign_up();
		?>
	</div>
</div>


<?php $obj->footer(); ?>

