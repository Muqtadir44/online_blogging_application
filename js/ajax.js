function showSpinner() {
    var spinnerModal = document.getElementById('spinner-modal');
    spinnerModal.style.display = 'block';
}
  
function hideSpinner() {
    var spinnerModal = document.getElementById('spinner-modal');
    spinnerModal.style.display = 'none';
}

function email_check(){
	var email = document.getElementById('email').value;
	console.log(email);

	var obj;
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			// console.log(obj.responseText);
			if (obj.responseText == 'email matched') {
				// console.log("working");
				document.getElementById('register_btn').style.color = 'red';
				document.getElementById('register_btn').disabled    = true;
				document.getElementById('email_msg').innerHTML      = 'Email already exist';
			}else{
				document.getElementById('register_btn').disabled    = false;
				document.getElementById('register_btn').style.color = 'white';
				document.getElementById('email_msg').innerHTML      = '';
			}
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send('action=email_check&email='+email);
}

function download_file(obj){
	var email = obj;
	window.location.href = "pdf_file.php?action=download_file&email="+email;
}

function generate_file(obj){
	var email = obj;
	var obj = new XMLHttpRequest();
	if (obj.responseText) {
		
	}
	obj.open("GET","pdf_file.php?action=generate_file&email="+email);
	obj.send();
}

function change_password(user_id){
    flag = true;
    var password_pattern = /^[A-Z]{1}\w{7,}$/;
    // alert(user_id);
    var old_password = document.getElementById('old_password').value;
    var new_password = document.getElementById('new_password').value;


    if (old_password == "") {
        flag = false;
        document.getElementById('old_password_msg').innerHTML = "required";
    }else{
        document.getElementById('old_password_msg').innerHTML = "";
    }

    if (new_password == '') {
		flag = false;
		document.getElementById('new_password_msg').innerHTML   = 'Please enter your password';
	}else{
		document.getElementById('new_password_msg').innerHTML   = '';
		if (password_pattern.test(new_password) == false){
			flag = false;
			document.getElementById('new_password_msg').innerHTML = 'altest 8 characters one uppercase character';
		}
	}

    if (flag) {
        var obj;
        if (window.XMLHttpRequest) {
            obj = new XMLHttpRequest();
        } else {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
				setTimeout(() => {
					document.getElementById('change_password_msg').innerHTML = obj.responseText;
				}, 3000);
            }
        }
        obj.open("POST","process.php");
        obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
        obj.send("action=change_password&user_id="+user_id+"&new_password="+new_password);   
    } else {
        return false;
    }
}

function update_profile(user_id){
    // alert(user_id);
    var flag = true;
    var update_profile_form = document.getElementById('update_profile_form');
    var form_data    = new FormData(update_profile_form);
    console.log(form_data);

	var alpha_pattern    = /^[A-Z]{1}[a-z]{2,}$/;
	var address_pattern  = /^[A-Z]{1}\w{5,}/;
	var file_extensions  = /(.jpg|.jpeg|.png)$/;
	
	
	var first_name      = document.getElementById('first_name').value;
	var last_name       = document.getElementById('last_name').value;
	var date_of_birth   = document.getElementById('date_of_birth').value;
	var address         = document.getElementById('address').value;
	
	var gender_element  = document.querySelectorAll("input[type='radio']");
	var gender          = null;
	var gender_male     = document.getElementById('gender_male');
	var gender_female   = document.getElementById('gender_female');
	
    var profile_picture  = form_data.get('profile_picture');
    var image_size       = profile_picture.size;
    var image_name       = profile_picture.name;
    var image_type       = profile_picture.type;

	var max_size = 1024 * 1024;

    if (image_name != "") {
        if (!file_extensions.test(image_name)) {
            flag = false;
            document.getElementById("profile_picture_msg").innerHTML   = "file type should be jpg/jpeg/png only";        
        }else{
            document.getElementById("profile_picture_msg").innerHTML   = "";
            if (image_size > max_size) {
                flag = false;
                document.getElementById("profile_picture_msg").innerHTML   = "max file size 1MB only";
            }        
        }
    }

	if (gender_element[0].checked) {
		gender = gender_element[0].value;
	}
	else if(gender_element[1].checked){
		gender = gender_element[1].value;
	}
	
	if (first_name == "") {
	    flag = false;
	    document.getElementById("first_name_msg").innerHTML   = "Please Enter First Name";
	}else{
		document.getElementById("first_name_msg").innerHTML   = "";

	     if (alpha_pattern.test(first_name) == false) {
	     	flag = false;
	    document.getElementById("first_name_msg").innerHTML = "First name eg. Ali";
	     }  
	}

	if (last_name == "") {
	    flag = false;
	    document.getElementById("last_name_msg").innerHTML   = "Please Enter Last Name";
	}else{
		document.getElementById("last_name_msg").innerHTML   = "";

	     if (alpha_pattern.test(last_name) == false) {
	     	flag = false;
	    document.getElementById("last_name_msg").innerHTML = "Last name eg. Khan";
	     }  
	}

	if (!gender) {
	flag = false;
	document.getElementById("gender_msg").innerHTML   = "Please choose your gender";
	}else{
	document.getElementById("gender_msg").innerHTML   = "";
	}

	if (date_of_birth == '') {
		flag = false;
		document.getElementById('date_of_birth_msg').innerHTML   = 'Please give your date of birth'; 	
	}else{
		document.getElementById('date_of_birth_msg').innerHTML   = ''; 	
	}

	if (address == '') {
		flag = false;
		document.getElementById('address_msg').innerHTML   = 'Please enter your address'; 
	}else{
		document.getElementById('address_msg').innerHTML   = '';

		if (address_pattern.test(address) == false) {
			flag = false;
			document.getElementById('address_msg').innerHTML = 'eg. Jamshoro Pakistan';
		}
	}

	if (flag) {
        var obj;
        if (window.ActiveXObject) {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }else{
            obj = new XMLHttpRequest();
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                // console.log(obj.responseText);
					document.getElementById('update_profile_msg').innerHTML = obj.responseText;
					window.location.href="settings.php?page=settings";
				setTimeout(() => {
					document.getElementById('update_profile_msg').innerHTML = "";
				}, 3000);
                document.getElementById('first_name').value    = "";
                document.getElementById('last_name').value     = "";
                document.getElementById('date_of_birth').value = "";
                document.getElementById('address').value       = "";
            }
        }
        obj.open("POST","process.php?action=update_profile&user_id="+user_id,true);
        obj.send(form_data);

	}else{
		return false;
	}
}

function password_check(user_id){
    // alert(user_id);
    var old_password = document.getElementById('old_password').value;
    // console.log(old_password);
    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            if (obj.responseText == 'stop') {
                document.getElementById('change_password_btn').disabled = true;
                document.getElementById('old_password_msg').innerHTML = "Old password didn't match";
                // console.log("stop button");
            } else {
                document.getElementById('change_password_btn').disabled = false;
                document.getElementById('old_password_msg').innerHTML = "";
            }
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=password_check&user_id="+user_id+"&old_password="+old_password);
}

function feedback(user_id) {
	var flag = true; 

	if (user_id != "") {
		var message   = document.getElementById('message').value;

		// console.log(user_id);
		if (message == "") {
			flag = false;
		 return	document.getElementById('message_msg').innerHTML = "Please Share your Message";
		}else{
			document.getElementById('message_msg').innerHTML = "";
		}
		var obj;
		showSpinner();
		if (window.ActiveXObject) {
			obj = new ActiveXObject('Microsoft.XMLHTTP');
		} else {
			obj = new XMLHttpRequest();
		}
		obj.onreadystatechange = function() {
			if (obj.status == 200 && obj.readyState == 4) {
				hideSpinner();
				// console.log(obj.responseText);
				document.getElementById('contact_us_msg').innerHTML = obj.responseText;
				document.getElementById('message').value   = "";
			}
		}
		obj.open("POST","process.php");
		obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
		obj.send('action=feedback_user&user_id='+user_id+'&message='+message);

	}else{
		var full_name = document.getElementById('full_name').value;
		var email     = document.getElementById('email').value;
		var message   = document.getElementById('message').value;
		if (full_name == "") {
			flag = false;
			document.getElementById('full_name_msg').innerHTML = "Please give your Full name";
		}else{
			document.getElementById('full_name_msg').innerHTML = "";
		}
	
		if (email == "") {
			flag = false;
			document.getElementById('email_msg').innerHTML = "Please give your Email";
		}else{
			document.getElementById('email_msg').innerHTML = "";
		}
	
		if (message == "") {
			flag = false;
			document.getElementById('message_msg').innerHTML = "Please Share your Message";
		}else{
			document.getElementById('message_msg').innerHTML = "";
		}

		if (flag) {	
			showSpinner();		
			var obj;
			if (window.ActiveXObject) {
				obj = new ActiveXObject('Microsoft.XMLHTTP');
			} else {
				obj = new XMLHttpRequest();
			}
			obj.onreadystatechange = function() {
				if (obj.status == 200 && obj.readyState == 4) {
					hideSpinner();
					// console.log(obj.responseText);
					document.getElementById('contact_us_msg').innerHTML = obj.responseText;
					document.getElementById('full_name').value = "";
					document.getElementById('email').value 	   = "";
					document.getElementById('message').value   = "";
	
				}
			}
			obj.open("POST","process.php");
			obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
			obj.send('action=feedback_visitor&full_name='+full_name+'&email='+email+'&message='+message);
		}else{
			return false;
		}
	}
}

function follow_status(user_id,blog_id,status,blog_author_id){
	// alert(status);
	// console.log(status);
	if (status == 'Follow') {
		status = 'Unfollow';
	} else {
		status = 'Follow';
	}
	// console.log(status);
	// console.log(user_id,blog_id);
	// console.log(blog_author_id);

	var obj;
	showSpinner();
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			hideSpinner();
			console.log(obj.responseText);
			if (obj.responseText == 'follow') {
				// console.log('user has followed');
			// document.getElementById('following_msg').innerHTML = `<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
			//     	<div class="toast-container p-3 top-50 end-0 translate-middle-y mt-5" id="toastPlacement">
			//     		<div class="toast show">
			//     		<div class="toast-header">
			//     			<img src="images/logo.png" class=" me-2 img-fluid"  width="32" height="32" alt="...">
			//     			<strong class="me-auto">Blogger</strong>
			//     			<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			//     		</div>
			//     		<div class="toast-body">
			//     		<strong class="primary">You are now following this Blog</strong><br>
			//     		<p class="primary">You will be notified via Email on every new post on this blog</p>
			//     		</div>
			//     		</div>
			//     	</div>
			//     	</div>`;
			    	setTimeout(window.location.href='blog_page.php?page=blog_page&blog_id='+blog_id,2000);
			} else {
				// console.log('user has Unfollowed');
				// document.getElementById('following_msg').innerHTML = `<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
			 //    	<div class="toast-container p-3 top-50 end-0 translate-middle-y mt-5" id="toastPlacement">
			 //    		<div class="toast show">
			 //    		<div class="toast-header">
			 //    			<img src="images/logo.png" class=" me-2 img-fluid"  width="32" height="32" alt="...">
			 //    			<strong class="me-auto">Blogger</strong>
			 //    			<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			 //    		</div>
			 //    		<div class="toast-body">
			 //    		<strong class="text-danger">Blogged Unfollowed</strong><br>
			 //    		<p class="text-danger">You will not be notified via Email on every new post on this blog</p>
			 //    		</div>
			 //    		</div>
			 //    	</div>
			 //    	</div>`;
			    	setTimeout(window.location.href='blog_page.php?page=blog_page&blog_id='+blog_id,2000);
			}
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send('action=follow_status&user_id='+user_id+'&blog_id='+blog_id+'&status='+status+'&blog_author_id='+blog_author_id);
}

function new_follower(user_id,blog_id,blog_author_id){
	// alert('working');
	showSpinner();
	var obj;
	if (window.ActiveXObject) {
		obj = new  ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			hideSpinner();
			console.log(obj.responseText);
			setTimeout(window.location.href='blog_page.php?page=blog_page&blog_id='+blog_id,2000);	
		}
	}
	obj.open('POST','Process.php');
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send("action=new_follower&user_id="+user_id+"&blog_id="+blog_id+"&blog_author_id="+blog_author_id);
}

function commenting(user_id,post_id,author_id){
	// alert(author_id);
	var flag    = true;
	var comment = document.getElementById('comment').value;

	if (comment == "") {
		flag = false;
		document.getElementById('comment').style.borderColor = 'red';
	} else {
		document.getElementById('comment').style.borderColor = 'green';
	}

	if (flag) {
		var obj;
		if (window.ActiveXObject) {
			obj = new ActiveXObject('Microsoft.XMLHTTP');
		} else {
			obj = new XMLHttpRequest();
		}
		obj.onreadystatechange = function(){
			if (obj.status == 200 && obj.readyState == 4) {
				// console.log(obj.responseText);
				document.getElementById('commenting_msg').innerHTML = obj.responseText;
				document.getElementById('comment').value = "";
			}
		}
		obj.open("POST","process.php");
		obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
		obj.send('action=commenting&user_id='+user_id+'&comment='+comment+'&post_id='+post_id+'&author_id='+author_id);
	} else {
		return false;
	}
}

function search_blogs(){
	// alert("working");
	var search = document.getElementById('blog_search').value;
	// console.log(search);
	if (search == "") {
		window.location.href ="blog.php?page=blog";
		// return;
	}
	var obj;
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			console.log(obj.responseText);
			document.getElementById('searching_blog').innerHTML = obj.responseText;
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send("action=search_blogs&search="+search);
}

function search_posts(blog_id){
	// alert("working");
	// console.log(blog_id);
	var search = document.getElementById('post_search').value;
	// console.log(search);
	if (search == "") {
		window.location.href = "";
	}
	var obj;
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			console.log(obj.responseText);
			document.getElementById('searching_post').innerHTML = obj.responseText;
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send("action=search_posts&search="+search+"&blog_id="+blog_id);
}

function theme_settings(user_id){
	// alert(user_id);
	var user_id = user_id;
	console.log(user_id);
	var theme_settings_form = document.getElementById('theme_settings_form');
	var form_data           = new FormData(theme_settings_form);
	console.log(form_data);
	var obj;
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			console.log(obj.responseText);
			document.getElementById('theme_setting_msg').innerHTML = obj.responseText;
			setTimeout(() => {
			document.getElementById('theme_setting_msg').innerHTML = "";
			}, 3000);
		}
	}
	obj.open('POST','process.php?action=theme_settings&user_id='+user_id);
	obj.send(form_data);
}

function activation_request(){
	var email = document.getElementById('email').value;
	if (email == "") {
		return;
	}
	var obj;
	showSpinner();
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			hideSpinner();
			console.log(obj.responseText);
			document.getElementById('request_msg').innerHTML = obj.responseText;
			document.getElementById('email').value = '';
		}
	}
	obj.open('POST',"process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send('action=activation_request&email='+email);

}

function email_check_request(){
	var email = document.getElementById('email').value;
	var obj;
	if (window.ActiveXObject) {
		obj = new ActiveXObject('Microsoft.XMLHTTP');
	} else {
		obj = new XMLHttpRequest();
	}
	obj.onreadystatechange = function(){
		if (obj.status == 200 && obj.readyState == 4) {
			// console.log(obj.responseText);
			if (obj.responseText != 'email matched') {
				// console.log("working");
				document.getElementById('send_request').style.color = 'red';
				document.getElementById('send_request').disabled    = true;
				document.getElementById('send_request').innerHTML   = 'Email not found';
				document.getElementById('email').style.borderColor  = 'red';
			}else{
				document.getElementById('send_request').disabled    = false;
				document.getElementById('send_request').style.color = 'white';
				document.getElementById('email').style.borderColor  = 'green';
				document.getElementById('send_request').innerHTML   = 'Send Request';
			}
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send('action=email_check&email='+email);
}