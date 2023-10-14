<?php 
session_start();
require  'require/database_settings.php';
require  'require/database_class.php';
$obj =  new database($hostname,$username,$password,$database);

if (isset($_POST['login'])) {

extract($_POST);
$result  = $obj->login($email,$password);
if ($result->num_rows > 0) {
	$row = mysqli_fetch_assoc($result);
	if ($row['state'] == 'Approved') {
		
		if ($row['status'] == "Active") {
			if ($row['role_id'] == 1) {
				$_SESSION['user'] = $row;
				header('location:dashboard/dashboard.php');
			}else{
				$_SESSION['user'] = $row;
				header("location:index.php");
			}
			// echo "<pre>";
			// print_r($row);
			// echo "</pre>";
		}else{
			$msg="Sorry! Your Account is Inactive please contact Admin";
			header("location:login.php?page=login&msg=$msg&contact");
		}
	}else{
		$msg = "Your Account is not Approved yet by Admin<br> You will receive an email after getting approved - Please Have Patience";
		header("location:login.php?page=login&msg=$msg");
	}


	}
	else{
		$msg = "Invalid Email or Password";
		header("location:login.php?page=login&msg=$msg");
	}

}

 ?>