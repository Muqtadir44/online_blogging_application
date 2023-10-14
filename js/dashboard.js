dashboard();

function showSpinner() {
    var spinnerModal = document.getElementById('spinner-modal');
    spinnerModal.style.display = 'block';
  }
  
function hideSpinner() {
    var spinnerModal = document.getElementById('spinner-modal');
    spinnerModal.style.display = 'none';
}

function dashboard(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            setTimeout(user_request,100);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=dashboard');
}

function user_request(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            document.getElementById('user_request').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=user_request');
}

function total_blogs(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );

        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=total_blogs');
}

function total_posts(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=total_posts');
}

function total_categories(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=total_categories');
}

function total_followers(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=total_followers');
}

function total_feedbacks(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=total_feedbacks');
}

function create_blog(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=create_blog');
}

function create_post(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready(function () {
                $('.js-example-basic-multiple').select2({
                    placeholder: 'Choose Your Categories',
                    allowClear: true,
                    closeOnSelect: true // Allow multiple selections to stay open
                });
            });

            $(document).ready(function (){
                // alert("working");
                $("#add_more").click(function(e){
                    e.preventDefault();
                    $("#attachment_row").prepend(`<div class="row mb-3" id="attachment_row">
                    <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment title</label> -->
                    <div class="col-sm-7 my-2">
                        <input type="text" class="form-control" name="attachment_title[]" placeholder="Attachment Title">
                        <!-- <p class="form-label">msg</p> -->
                    </div>
                    <div class="col-sm-4 my-2">
                        <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment</label> -->
                        <input type="file" name="attachment_file[]" class="form-control" placeholder="Attachment File">
                        <!-- <p class="form-label">msg</p> -->
                    </div>
                    <div class="col-sm-1 my-auto">
                        <button class="float-end btn text-danger remove_row"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>
                </div>`);
                });
                $(document).on('click','.remove_row', function(e){
                    e.preventDefault();
                    let attachment_row = $(this).parent().parent();
                    $(attachment_row).remove();
                });
            });
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=create_post');
}

function create_categories(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=create_categories');
}

function add_user(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=add_user');
}

function all_users(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=all_users');
}

function rejected_users(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=rejected_users');
}

function comments(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
             $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=comments');
}

function settings(){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=settings');
}

function approve_user(id){
    showSpinner();
    var user_id = id;
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            hideSpinner();
            // console.log(obj.responseText);
            document.getElementById('state_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                dashboard();
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=approve_user&user_id='+user_id);
}

function reject_user(id){
    showSpinner();
    var user_id = id;
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            hideSpinner();
            // console.log(obj.responseText);
            document.getElementById('state_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                dashboard();
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=reject_user&user_id='+user_id);
}

function dashboard_adduser(){
    // document.getElementById("loading-spinner").style.display = "inline-block";
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
    var role_id         = document.getElementById('role_id').value;
	
	var profile_picture = document.getElementById('profile_picture').files[0];
	var max_size = 1024 * 1024;

	if (!profile_picture) {
		flag = false;
	    document.getElementById("profile_picture_msg").innerHTML   = "Please Enter your profile picture";
	}else{
	    document.getElementById("profile_picture_msg").innerHTML   = "";
		if (!file_extensions.test(profile_picture.name)) {
			$flag = false;
            
			document.getElementById("profile_picture_msg").innerHTML   = "file type should be jpg/jpeg/png only";
		}
		if (profile_picture.size > max_size) {
			$flag = false;
			document.getElementById("profile_picture_msg").innerHTML   = "max file size 1MB only";
		}
	}

	if (gender_element[0].checked) {
		gender = gender_element[0].value;
	}
	else if(gender_element[1].checked){
		gender = gender_element[1].value;
	}
	
    if (role_id == '') {
        flag = false;
        document.getElementById('role_id_msg').innerHTML   = 'Please choose the role'; 	
    }else{
        document.getElementById('role_id_msg').innerHTML   = ''; 	
    }


	if (first_name == "") {
	    flag = false;
	    document.getElementById("first_name_msg").style.color = 'red';
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
	    document.getElementById("last_name_msg").style.color = 'red';
	    document.getElementById("last_name_msg").innerHTML   = "Please Enter Last Name";
	}else{
		document.getElementById("last_name_msg").innerHTML   = "";

	     if (alpha_pattern.test(last_name) == false) {
	     	flag = false;
	    document.getElementById("last_name_msg").innerHTML = "Last name eg. Khan";
	     }  
	}


	if (email == "") {
		flag = false;
		document.getElementById('email_msg').style.color = 'red';
		document.getElementById('email_msg').innerHTML   = 'Please enter your email';
	}else{
		document.getElementById('email_msg').innerHTML   = '';
		if (email_pattern.test(email) == false) {
			flag = false;
			document.getElementById('email_msg').innerHTML = 'eg. ali123@gmail.com';
		}
	}

	if (password == '') {
		flag = false;
		document.getElementById('password_msg').style.color = 'red';
		document.getElementById('password_msg').innerHTML   = 'Please enter your password';
	}else{
		document.getElementById('password_msg').innerHTML   = '';
		if (password_pattern.test(password) == false){
			flag = false;
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
		document.getElementById('date_of_birth_msg').innerHTML   = 'Please give your date of birth'; 	
	}else{
		document.getElementById('date_of_birth_msg').innerHTML   = ''; 	
	}

	if (address == '') {
		flag = false;
		document.getElementById('address_msg').style.color = 'red';
		document.getElementById('address_msg').innerHTML   = 'Please enter your address'; 
	}else{
		document.getElementById('address_msg').innerHTML   = '';

		if (address_pattern.test(address) == false) {
			flag = false;
			document.getElementById('address_msg').innerHTML = 'eg. Jamshoro Pakistan';
		}
	}

	if (flag) {
        showSpinner();  
        var adduser_form = document.getElementById('adduser_form');
        var form_data    = new FormData(adduser_form);
        console.log(form_data);
        var obj;
        if (window.ActiveXObject) {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }else{
            obj = new XMLHttpRequest();
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                hideSpinner();
                // document.getElementById("loading-spinner").style.display = "none";
                document.getElementById('add_user_msg').innerHTML = obj.responseText;
                setTimeout(function() {
                    add_user();
                }, 2000);
            }
        }
        obj.open("POST","process.php?action=dashboard_adduser",true);
        obj.send(form_data);

	}else{
		return false;
	}
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
				document.getElementById('add_user').style.color = 'red';
				document.getElementById('add_user').disabled = true;
				document.getElementById('email_msg').innerHTML   = 'Email already exist';
			}else{
				document.getElementById('add_user').disabled = false;
				document.getElementById('add_user').style.color = 'white';
				document.getElementById('email_msg').innerHTML   = '';
			}
		}
	}
	obj.open("POST","process.php");
	obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
	obj.send('action=email_check&email='+email);
}

function download_file(obj){
	var email = obj;
	window.location.href = "../pdf_file.php?action=download_file&email="+email;
}

function update_user(id){
    var user_id = id;
    // console.log(user_id);
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            // all_users();
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
    obj.send("action=update_user&user_id="+user_id);
}

function updating_user(id){
    var flag = true;
    var user_id = id;

    var adduser_form = document.getElementById('updating_user_form');
    var form_data    = new FormData(adduser_form);
    // console.log(form_data.getAll);
    var first_name       = form_data.get('first_name');
    var last_name        = form_data.get('last_name');
    var gender           = form_data.get('gender');
    var date_of_birth    = form_data.get('date_of_birth');
    var address          = form_data.get('address');
    var role_id          = form_data.get('role_id');
    var profile_picture  = form_data.get('profile_picture');
    
    var image_size       = profile_picture.size;
    var image_name       = profile_picture.name;
    var image_type       = profile_picture.type;
    // console.log(image_name);


    var file_extensions  = /(.jpg|.jpeg|.png)$/;
    var max_size = 1024 * 1024;

    if (first_name == "") {
        flag = false;
        document.getElementById('first_name_msg').innerHTML = "required"; 
    }else{
         document.getElementById('first_name_msg').innerHTML = ""; 
    }

    if (last_name == "") {
        document.getElementById('last_name_msg').innerHTML = "required";
    }else{
        document.getElementById('last_name_msg').innerHTML = ""; 
    }

    if (gender == "") {
        document.getElementById('gender_msg').innerHTML = "required";
    } else {
        document.getElementById('gender_msg').innerHTML = "";
    }
    if (date_of_birth == "") {
        document.getElementById('date_of_birth_msg').innerHTML = "required";
    } else {
        document.getElementById('date_of_birth_msg').innerHTML = "";
    }
   
    if (address == "") {
        document.getElementById('address_msg').innerHTML = "required";
    } else {
        document.getElementById('address_msg').innerHTML = "";
    }

    if (role_id == "") {
        document.getElementById('role_id_msg').innerHTML = "required";
    } else {
        document.getElementById('role_id_msg').innerHTML = "";
    }

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
            document.getElementById('updating_user_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                all_users();
            }, 2000);
        }
    }
    obj.open("POST","process.php?action=updating_user&user_id="+user_id,true);
    obj.send(form_data);
   }else{
    return false;
   }
    
}

function delete_user(id){
    // alert(id);
    var user_id = id;
    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            document.getElementById('update_msg').innerHTML = obj.responseText;
            setTimeout(rejected_users,1000);
        }
    }
    var response = confirm("Are You Sure?");
    // console.log(response);
    if (response) {
        obj.open("POST","process.php");
        obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
        obj.send("action=delete_user&user_id="+user_id);
    }
}

function update_status(id,status){
    showSpinner();
    var status = status;
    if (status == 'Active') {
         status = 'Inactive';
    }else{
        status = 'Active';
    }
    console.log(status);
    // console.log(status);
    var user_id = id;
    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            hideSpinner();
            document.getElementById('update_msg').innerHTML = obj.responseText;
            setTimeout(all_users,2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader("content-type","application/x-www-form-urlencoded");
    obj.send("action=update_status&user_id="+user_id+"&status="+status);
}

function creating_blog(){
    var flag      = true;
    var blog_form = document.getElementById('create_blog_form');
    var form_data = new FormData(blog_form);
    
    var blog_title       = form_data.get('blog_title');
    var blog_summary     = form_data.get('blog_summary');
    var post_per_page    = form_data.get('post_per_page');

    var background_image = form_data.get('background_image');
    var image_size       = background_image.size;
    var image_name       = background_image.name;
    var image_type       = background_image.type;


    var file_extensions  = /(.jpg|.jpeg|.png)$/;
    var max_size = 1024 * 1024;

    if (!blog_title) {
        flag = false;
        document.getElementById('blog_title_msg').innerHTML = "Please enter your blog title";
    }else{
        document.getElementById('blog_title_msg').innerHTML = "";
    }

    if (!blog_summary) {
        flag = false;
        document.getElementById('blog_summary_msg').innerHTML = "Please enter a summary of your blog";
    }else{
        document.getElementById('blog_summary_msg').innerHTML = "";
    }

    if (!Number(post_per_page)) {
        flag = false;
        document.getElementById('post_per_page_msg').innerHTML = "Enter the number for posts you want see on your blog";
    }else{
        document.getElementById('post_per_page_msg').innerHTML = "";
        if (post_per_page == 3 || post_per_page == 6 || post_per_page == 9) {
            flag = true;
            }else{
            flag = false;
            document.getElementById('post_per_page_msg').innerHTML = "post per page can only be either 3, 6 or 9 only working";                
            }
    }


    if (image_name == "") {
        flag = false;
        document.getElementById("background_image_msg").innerHTML   = "Please give the background image";
    }else{
        document.getElementById("background_image_msg").innerHTML   = "";
        if (!file_extensions.test(image_name)) {
            flag = false;
            document.getElementById("background_image_msg").innerHTML   = "file type should be jpg/jpeg/png only";
        }
        if (image_size > max_size) {
            flag = false;
            document.getElementById("background_image_msg").innerHTML   = "max file size 1MB only";
        }
    }


    if (flag == true) {
        console.log(form_data);
        var obj;
        if (window.ActiveXObject) {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }else{
            obj = new XMLHttpRequest();
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                console.log(obj.responseText);
                document.getElementById('create_blog_msg').innerHTML = obj.responseText;
                setTimeout(create_blog,2000);
            }
        }
        obj.open("POST","process.php?action=creating_blog",true);
        obj.send(form_data);

    }else{
        return false;
    }
}

function blog_status(blog_id,status){
    var blog_id = blog_id;
    var status  = status;
    
    if (status == 'Active') {
        status = 'Inactive';
    }else{
       status = 'Active';
    }
    console.log(status);
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('blog_status_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                total_blogs();
            }, 2000);
        }
    }
    obj.open('POST','process.php');
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=blog_status&blog_id='+blog_id+'&status='+status);
}

function delete_blog(blog_id){
    var blog_id = blog_id;
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('blog_status_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                total_blogs();
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=delete_blog&blog_id="+blog_id);
}

function update_blog(blog_id,user_id){
    var blog_id = blog_id;
    var user_id = user_id;
    // alert("update blog");
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=update_blog_form&blog_id="+blog_id+"&user_id="+user_id);
}

function updating_blog(blog_id){
    var flag = true;
    var blog_id = blog_id;
    var blog_form = document.getElementById('updating_blog_form');
    var form_data = new FormData(blog_form);
    var blog_title      = form_data.get('blog_title');
    var blog_summary    = form_data.get('blog_summary');
    var post_per_page   = form_data.get('post_per_page');
    var background_image = form_data.get('background_image');

    var image_size       = background_image.size;
    var image_name       = background_image.name;
    var image_type       = background_image.type;
    // console.log(image_name);


    var file_extensions  = /(.jpg|.jpeg|.png)$/;
    var max_size = 1024 * 1024;

    if (blog_title == "") {
        flag = false;
        document.getElementById('blog_title_msg').innerHTML = 'required';
    }else{
        document.getElementById('blog_title_msg').innerHTML = '';
    }

    if (blog_summary == "") {
        flag = false;
        document.getElementById('blog_summary_msg').innerHTML = 'required';
    }else{
        document.getElementById('blog_summary_msg').innerHTML = '';
    }

    if (post_per_page == "") {
        flag = false;
        document.getElementById('post_per_page_msg').innerHTML = 'required';
    }else{
        document.getElementById('post_per_page_msg').innerHTML = '';
        if (post_per_page == 3 || post_per_page == 6 || post_per_page == 9) {
            flag = true;
            }else{
            flag = false;
            document.getElementById('post_per_page_msg').innerHTML = "post per page can only be either 3, 6 or 9 only working";                
            }
    }

    if (image_name != "") {
        if (!file_extensions.test(image_name)) {
            flag = false;
            document.getElementById("background_image_msg").innerHTML   = "file type should be jpg/jpeg/png only";        
        }else{
            document.getElementById("background_image_msg").innerHTML   = "";
            if (image_size > max_size) {
                flag = false;
                document.getElementById("background_image_msg").innerHTML   = "max file size 1MB only";
            }        
        }
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
                document.getElementById('updating_blog_msg').innerHTML = obj.responseText;
                setTimeout(function() {
                    total_blogs();
                }, 2000);
            }
        }
        obj.open("POST","process.php?action=updating_blog&blog_id="+blog_id);
        obj.send(form_data);
    }else{
        return false;
    }
}

function creating_category(){
    flag = true;
    var category_title       = document.getElementById('category_title').value;
    var category_description = document.getElementById('category_description').value;
    console.log(category_title);
    console.log(category_description);

    if (category_title == "") {
        flag = false;
        document.getElementById('category_title_msg').innerHTML = "requried";
    } else {
        document.getElementById('category_title_msg').innerHTML = "";
    }

    if (category_description == "") {
        flag = false;
        document.getElementById('category_description_msg').innerHTML = "requried";
    } else {
        document.getElementById('category_description_msg').innerHTML = "";
    }

    if (flag){
        var obj;
        if (window.XMLHttpRequest) {
            obj = new XMLHttpRequest();
        }else{
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                document.getElementById('category_msg').innerHTML = obj.responseText;
                setTimeout(create_categories,2000);
    
            }
        }
        obj.open("POST","process.php");
        obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
        obj.send("action=creating_category&category_title="+category_title+"&category_description="+category_description);
    }else{
        return false;
    }
}

function category_status(category_id,status){
    var category_id = category_id;
    var status  = status;
    
    if (status == 'Active') {
        status = 'Inactive';
    }else{
       status = 'Active';
    }
    // console.log(status);
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('category_status_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                total_categories();
            }, 2000);
        }
    }
    obj.open('POST','process.php');
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=category_status&category_id='+category_id+'&status='+status);
}

function delete_category(category_id){
    var category_id = category_id;
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('category_status_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                total_categories();
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=delete_category&category_id="+category_id);
}

function update_category(category_id){
    var category_id = category_id;
    // alert("update category");
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
        }
    }
    obj.open('POST',"process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=update_category_form&category_id="+category_id);
}

function updating_category(category_id){
    var category_title       = document.getElementById('category_title').value;
    var category_description = document.getElementById('category_description').value;
    var category_id          = category_id;
    var flag                 = true;

    if (category_title == "") {
        document.getElementById('category_title_msg').innerHTML = 'required';
    } else {
        document.getElementById('category_title_msg').innerHTML = '';
    }

    if (category_description == "") {
        document.getElementById('category_description_msg').innerHTML = 'required';
    } else {
        document.getElementById('category_description_msg').innerHTML = '';
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
                console.log(obj.responseText);
                document.getElementById('updating_category_msg').innerHTML = obj.responseText;
                 setTimeout(function() {
                    total_categories();
                }, 2000);
            }
        }
        obj.open("POST",'process.php');
        obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
        obj.send('action=updating_category&category_id='+category_id+"&category_title="+category_title+"&category_description="+category_description);

    }else {
        return false;
    }
}

/*-----  POST Start ------*/
function creating_post(){
    var flag = true;
    var form_data = new FormData(document.getElementById('create_post_form'));
    console.log(form_data);

    var post_title       = form_data.get('post_title');
    var blog_id          = form_data.get('blog_id');
    var post_summary     = form_data.get('post_summary');
    var post_description = form_data.get('post_description');
    var featured_image   = form_data.get('featured_image');
    var attachment_title = form_data.get('attachment_title');
    var attachment_file  = form_data.get('attachment_file');
    var comments         = form_data.get('comments');

    console.log(post_title);
    console.log(blog_id);
    console.log(post_summary);
    console.log(post_description);
    console.log(featured_image);
    console.log(attachment_title);
    console.log(attachment_file);

    var image_size       = featured_image.size;
    var image_name       = featured_image.name;
    var image_type       = featured_image.type;

    var comments_radio   = document.querySelectorAll("input[type='radio']");
    var comments         = null;
    var comments_enable  = document.getElementById('comments_enable');
    var comments_disable = document.getElementById('comments_disable');

    if (comments_radio[0].checked) {
        comments = comments_radio[0].value;
    }
    else if(comments_radio[1].checked){
        comments = comments_radio[1].value;
    }


    var file_extensions  = /(.jpg|.jpeg|.png)$/;
    var max_size         = 1024 * 1024;


    var category_id = document.getElementById('category_id').value;
    console.log(category_id);

    if (category_id  == "") {
        flag = false;
        document.getElementById('post_categories_msg').innerHTML = "required atleast one";
    } else {
        document.getElementById('post_categories_msg').innerHTML = "";
    }

    if (post_title == "") {
        flag = false;
        document.getElementById('post_title_msg').innerHTML = "required";
    }else{
        document.getElementById('post_title_msg').innerHTML = "";
    }

    if (blog_id == "") {
        flag = false;
        document.getElementById('blog_title_msg').innerHTML = "required"; 
    } else {
        document.getElementById('blog_title_msg').innerHTML = ""; 
    }

    if (post_summary == "") {
        flag = false;
        document.getElementById('post_summary_msg').innerHTML = "required";
    } else {
        document.getElementById('post_summary_msg').innerHTML = "";
    }

    if (post_description == "") {
        flag = false;
        document.getElementById('post_description_msg').innerHTML = "required";
    } else {
        document.getElementById('post_description_msg').innerHTML = "";
    }

    if (image_name == "") {
        flag = false;
        document.getElementById("featured_image_msg").innerHTML   = "Please give the Featured image";
    }else{
        document.getElementById("featured_image_msg").innerHTML   = "";
        if (!file_extensions.test(image_name)) {
            flag = false;
            document.getElementById("featured_image_msg").innerHTML   = "file type should be jpg/jpeg/png only";
        }
        if (image_size > max_size) {
            flag = false;
            document.getElementById("featured_image_msg").innerHTML   = "max file size 1MB only";
        }
    }

    if (!comments) {
    flag = false;
    document.getElementById("post_comments_msg").innerHTML   = "required";
    }else{
    document.getElementById("post_comments_msg").innerHTML   = "";
    }



    if (flag) {
        showSpinner();
        var obj;
        if (window.ActiveXObject) {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        } else {
            obj = new XMLHttpRequest();
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                hideSpinner();
                console.log(obj.responseText);
                document.getElementById('creating_post_msg').innerHTML = obj.responseText;
                setTimeout(function() {
                    create_post();
                }, 2000);
            }
        }
        obj.open('POST','process.php?action=creating_post');
        obj.send(form_data);
    }else{
        return false;
    }
}

function post_status(post_id,status){
    var post_id = post_id;
    var status  = status;
    
    if (status == 'Active') {
        status = 'Inactive';
    }else{
       status = 'Active';
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
            document.getElementById('post_status_msg').innerHTML = obj.responseText;
            setTimeout(function() {
                total_posts();
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=post_status&post_id="+post_id+"&status="+status);
}

function update_post(post_id){
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
            $(document).ready( function () {
                $('#attachments').DataTable();
            } );
            $(document).ready(function () {
                $('.js-example-basic-multiple').select2({
                    placeholder: 'Choose Your Categories',
                    allowClear: true,
                    closeOnSelect: true // Allow multiple selections to stay open
                });
            });

            $(document).ready(function (){
                // alert("working");
                $("#add_more").click(function(e){
                    e.preventDefault();
                    $("#attachment_row").prepend(`<div class="row mb-3" id="attachment_row">
                    <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment title</label> -->
                    <div class="col-sm-7 my-2">
                        <input type="text" class="form-control" name="attachment_title[]" placeholder="Attachment Title">
                        <!-- <p class="form-label">msg</p> -->
                    </div>
                    <div class="col-sm-4 my-2">
                        <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment</label> -->
                        <input type="file" name="attachment_file[]" class="form-control" placeholder="Attachment File">
                        <!-- <p class="form-label">msg</p> -->
                    </div>
                    <div class="col-sm-1 my-auto">
                        <button class="float-end btn text-danger remove_row"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>
                </div>`);
                });
                $(document).on('click','.remove_row', function(e){
                    e.preventDefault();
                    let attachment_row = $(this).parent().parent();
                    $(attachment_row).remove();
                });
            });
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=update_post&post_id="+post_id);
}

function updating_post(post_id){
    var updating_post_form = document.getElementById('update_post_form');
    var form_data = new FormData(updating_post_form);
    console.log(form_data);
    var post_title = form_data.get('post_title');
    console.log(post_title);
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            console.log(obj.responseText);
            document.getElementById('updating_post_msg').innerHTML = obj.responseText;
            setTimeout(() => {
                total_posts();
            }, 2000);
        }
    }
    obj.open("POST","process.php?action=updating_post&post_id="+post_id);
    obj.send(form_data);
}

function posts_categories(post_id){
   var post_id = post_id;
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready(function () {
                $('.js-example-basic-multiple').select2({
                    placeholder: 'Choose Your Categories',
                    allowClear: true,
                    closeOnSelect: true // Allow multiple selections to stay open
                });
            });
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=posts_categories&post_id="+post_id);
}

function add_post_categories(post_id){
    var flag = true;
    // alert(post_id);
    var form_data = new FormData(document.getElementById('category_form'));
    console.log(form_data);

    var category_id = form_data.get('category_id[]');
    console.log(category_id);

    if (category_id == null) {
        flag = false;
        document.getElementById('add_more_categories_msg').innerHTML = 'give atleast one category';
    } else {
        document.getElementById('add_more_categories_msg').innerHTML = '';
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
                console.log(obj.responseText);
                document.getElementById('post_categories_msg').innerHTML = obj.responseText;
                setTimeout(() => {
                    posts_categories(post_id);
                }, 2000);
            }
        }
        obj.open("POST","process.php?action=add_post_categories&post_id="+post_id);
        obj.send(form_data);
    } else {
        return false;        
    }
}

function post_category_status(category_id,post_id,status){
    var status = status;
    var category_id = category_id;
    var post_id = post_id;
    if (status == 'Active') {
        status = 'Inactive';
    }else{
       status = 'Active';
    }

    console.log(status);

    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('post_categories_msg').innerHTML = obj.responseText;
            setTimeout(() => {
                posts_categories(post_id);
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send('action=post_category_status&post_id='+post_id+'&category_id='+category_id+'&status='+status);
    
}


function posts_attachments(post_id){
    // alert(post_id);
    var post_id = post_id;

    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;

            $(document).ready(function (){
                // alert("working");
                $("#add_more").click(function(e){
                    e.preventDefault();
                    $("#attachment_row").prepend(`<div class="row mb-3" id="attachment_row">
                    <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment title</label> -->
                    <div class="col-sm-7 my-2">
                        <input type="text" class="form-control" name="attachment_title[]" placeholder="Attachment Title" required>
                        <!-- <p class="form-label">msg</p> -->
                    </div>
                    <div class="col-sm-4 my-2">
                        <!-- <label for="inputPassword3" class="col-sm-2 col-form-label">Attachment</label> -->
                        <input type="file" name="attachment_file[]" class="form-control" placeholder="Attachment File" required>
                        <!-- <p class="form-label">msg</p> -->
                    </div>

                    <div class="col-sm-1 my-auto">
                        <button class="float-end btn text-danger remove_row"><i class="fa-solid fa-circle-xmark"></i></button>
                    </div>
                     <p id="add_more_attachment_msg" class="text-danger"></p>
                </div>`);
                });
                $(document).on('click','.remove_row', function(e){
                    e.preventDefault();
                    let attachment_row = $(this).parent().parent();
                    $(attachment_row).remove();
                });
            });

             $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=posts_attachments&post_id="+post_id);
}

function add_post_attachments(post_id){
    flag = true;

    var attachments_form = document.getElementById('attachemnts_form');
    var form_data        = new FormData(attachemnts_form);
    // console.log(form_data);
    // alert(post_id);
    var attachment_title = form_data.get('attachment_title[]');
    var attachment_file = form_data.get('attachment_file[]');
    // console.log(attachment_title);
    // console.log(attachment_file);

    if (attachment_title == "" || attachment_file.name == "") {
        flag = false;
        document.getElementById('add_more_attachment_msg').innerHTML = "required";
    } else {
        document.getElementById('add_more_attachment_msg').innerHTML = "";
    }

    if (flag) {
        console.log("working");
        var obj;
        if (window.ActiveXObject) {
            obj = new ActiveXObject('Microsoft.XMLHTTP');
        } else {
            obj = new XMLHttpRequest();
        }
        obj.onreadystatechange = function(){
            if (obj.status == 200 && obj.readyState == 4) {
                // console.log(obj.responseText);
                document.getElementById('post_attachemnts_msg').innerHTML = obj.responseText;
                setTimeout(() => {
                    posts_attachments(post_id);
                }, 2000);
            }
        }
        obj.open("POST","process.php?action=add_post_attachments&post_id="+post_id);
        obj.send(form_data);
    } else {
        return false;
    }
}

function attachments_status(attachment_id,status,post_id){
    // alert(attachment_id);
    if (status == 'Active') {
        var status = 'Inactive';
    } else {
        var status = 'Active';
    }

    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('post_attachemnts_msg').innerHTML = obj.responseText;
            setTimeout(() => {
                posts_attachments(post_id);
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=attachments_status&attachment_id="+attachment_id+"&status="+status);
}
/*-----  POST End  ------*/

/*-----  Profile Settings Starts  ------*/

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
                document.getElementById('change_password_msg').innerHTML = obj.responseText;
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
                document.getElementById('first_name').value = "";
                document.getElementById('last_name').value = "";
                document.getElementById('date_of_birth').value = "";
                document.getElementById('address').value = "";
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
    console.log(old_password);
    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            console.log(obj.responseText);
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
/*-----  Profile Settings  ends------*/

/*-----  Comments  start------*/
function show_comments(post_id){
    // alert(post_id);
    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            // console.log(obj.responseText);
            document.getElementById('main_content_area').innerHTML = obj.responseText;
            $(document).ready( function () {
                $('#example').DataTable();
            } );
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=show_comments&post_id="+post_id);
}

function update_comment_status(post_comment_id,status,post_id){
    console.log(post_comment_id);
    console.log(status);

    if (status == 'Active') {
        status = 'Inactive';
    } else {
        status = 'Active';
    }
    console.log(status);

    var obj;
    if (window.ActiveXObject) {
        obj = new ActiveXObject('Microsoft.XMLHTTP');
    } else {
        obj = new XMLHttpRequest();
    }
    obj.onreadystatechange = function(){
        if (obj.status == 200 && obj.readyState == 4) {
            console.log(obj.responseText);
            document.getElementById('post_comments_msg').innerHTML = obj.responseText;
             setTimeout(function(){
                show_comments(post_id);
            }, 2000);
        }
    }
    obj.open("POST","process.php");
    obj.setRequestHeader('content-type','application/x-www-form-urlencoded');
    obj.send("action=post_comment_status&post_comment_id="+post_comment_id+"&status="+status);
}
/*-----  Comments  ends------*/
