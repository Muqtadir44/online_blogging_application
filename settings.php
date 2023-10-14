<?php 
require 'require/general_library.php';
require 'require/database_class.php';
require 'require/database_settings.php';
$db  = new database($hostname,$username,$password,$database);
$obj = new general();
$obj->header();
if (!isset($_SESSION['user'])) {
	header("location:index.php");
}

$obj->navbar();
 ?>
<div class="container">
    <?php
    $user_id = $_SESSION['user']['user_id'];
    $result  = $db->user_profile($user_id);
    if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Profile</h1>
        </div>
    </div>
    <div id="settings_msg"></div>
    <div class="row m-2 p-3 shadow rounded"> 
         <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#change_profile" ><i class="fa-solid fa-pen"></i></button>
            <div class="modal fade" id="change_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-address-card"></i> Update Profile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="update_profile_msg"></div>
                        <form id="update_profile_form" entype="multipart/form-data">

                            <div class="mb-3 row">
                                <label class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-9">
                            <input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $row['first_name'] ?>">
                            <p id="first_name_msg" class="text-danger"></p>
                            </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">Last Name</label>
                                <div class="col-sm-9">
                                <input type="text" id="last_name" class="form-control" name="last_name"  value="<?php echo $row['last_name'] ?>">
                                <p id="last_name_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">Gender</label>
                                <div class="col-sm-9">
                                    <input type="radio" id="gender_male" name="gender" value="Male" <?php echo $row['gender'] == 'Male'?'checked':''?>> Male
                                    <input type="radio" id="gender_female" name="gender" value="Female" <?php echo $row['gender'] == 'Female'?'checked':''?>> Female
                                    <p id="gender_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">Date of Birth</label>
                                <div class="col-sm-9">
                                    <input type="date" id="date_of_birth" class="form-control" name="date_of_birth" value="<?php echo $row['date_of_birth'] ?>" placeholder="DD-MM-YYYY">
                                    <p id="date_of_birth_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" id="address" class="form-control" name="address" value="<?php echo $row['address'] ?>" placeholder="eg. Jamshoro">
                                    <p id="address_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">Picture</label>
                                <div class="col-sm-9">
                                    <input type="file" id="profile_picture" class="form-control" name="profile_picture" >
                                    <p id="profile_picture_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                               <div class="col-sm">
                                    <input type="hidden" name="profile_picture_name" value="<?php echo $row['profile_picture'] ?>">
                                    <button type="button" class="btn btn-info w-100" id="change_profile_btn" onclick="return update_profile('<?php echo $row['user_id'] ?>')">Update Profile</button>
                                </div>
                            </div>
                        </form>  
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <h1 class="text_color"><?php echo $row['first_name']." ".$row['last_name'] ?> <span class="badge <?php echo $row['role_type'] == 'Admin'?'bg-warning':'bg-info' ?> fs-6"><?php echo $row['role_type'] ?></span> </h1>
            <hr>
            
            <p class="text_color"><?php echo $row['gender'] == 'Male'?"<i class='fa-solid fa-mars'></i>":"<i class='fa-solid fa-venus'></i>" ?> <?php echo $row['gender'] ?> <span class="ms-3"><i class="fa-solid fa-cake-candles"></i> <?php echo $row['date_of_birth'] ?></span>
                <button class="btn" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-caret-down"></i>
                </button>
            </p>
            <p class="d-inline-flex gap-1">
                
            </p>
            <div class="collapse" id="collapseExample">
            <div class="card card-body">
            <span class="ms-3"><i class="fa-solid fa-envelope"></i> <?php echo $row['email'] ?></span>
            <span class="ms-3"><i class="fa-solid fa-location-arrow"></i> <?php echo $row['address'] ?></span>
            </div>
            </div>
        </div>
        <div class="col-sm-2 col-md-2 col-lg-2">
            <img class="img-fluid rounded-circle" src="<?php echo $row['profile_picture']?>" alt="">
        </div>
        <?php
        }
        ?>
    </div>


    <div class="row m-2 mt-3">
        <div class="col-sm-6 col-md-6 m-1 shadow rounded p-3">
            <p class="fs-4">Settings</p>
            <ul class="lead fs-6 list-unstyled">
                <a class="text-decoration-none dash-btn sidebar-text"  data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <li><i class="fa-solid fa-lock "></i> Change Password</li>
                </a>
                <a class="text-decoration-none dash-btn sidebar-text"  data-bs-toggle="modal" data-bs-target="#theme_settings">
                    <li><i class="fa-solid fa-brush"></i> Theme Settings</li>
                </a>
            </ul>
            <div class="modal fade" id="theme_settings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-brush"></i> Theme Settings</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-info" role="alert">
                             <i class="fa-solid fa-circle-info"></i> These settings will take effect on Post's and blog's Titles
                            </div>
                            <div id="theme_setting_msg"></div>
                            <form action="process.php" method="POST" id="theme_settings_form">
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Title Color</label>
                                    <div class="col-sm-9">
                                        <input type="color" name="color" class="form-control" id="post_title_color">
                                        <p id="font-size_msg" class="text-danger"></p>          
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Font-size</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="font-size" name="font-size" style="width: 100%;">
                                            <option value="">--Choose Setting--</option>
                                            <option value="14px">14px</option>
                                            <option value="16px">16px</option>
                                            <option value="18px">18px</option>
                                            <option value="24px">24px</option>
                                        </select>
                                        <p id="font-size_msg" class="text-danger"></p>                 
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Font-Style</label>
                                    <div class="col-sm-9">
                                        <select class="form-select" id="settings_key" name="font-weight"  style="width: 100%;">
                                            <option value="">--Choose Setting--</option>
                                            <option value="800">Bold</option>
                                            <option value="400">Regular</option>
                                            <option value="200">Light</option>
                                        </select>
                                        <p id="font_style_msg" class="text-danger"></p>                 
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                   <div class="col-sm">
                                        <button type="button" class="btn btn-info w-100" onclick="return theme_settings('<?php echo $row['user_id'] ?>')" id="theme_settings_btn">Apply Settings</button>
                                   </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">      
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
            </div>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel"><i class="fa-solid fa-lock "></i> Change Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="change_password_msg"></div>      
                            <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label">Old Password</label>
                            <div class="col-sm-9">
                            <input type="password" onblur="password_check('<?php echo $row['user_id'] ?>')" name="old_password" id="old_password" class="form-control">
                            <p id="old_password_msg" class="text-danger"></p>
                            </div>
                            </div>
                            <div class="mb-3 row">
                                <label  class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                <input type="password" id="new_password" class="form-control">
                                <p id="new_password_msg" class="text-danger"></p>
                                </div>
                            </div>
                            <div class="mb-3 row">
                               <div class="col-sm">
                                    <button type="button" class="btn btn-info w-100" id="change_password_btn" onclick="return change_password('<?php echo $row['user_id'] ?>')">Change Password</button>
                               </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
        <?php 
        if ($row['role_id'] == 1) {
            ?>
             <div class="col-sm col-md m-1 shadow rounded p-3">
            <p class="text-center fs-5 fw-bold primary">Blogs <i class="fa-solid fa-book"></i></p>
            <h1 class="fw-bold display-1 text-center primary">
                <?php 
                    $result = $db->admin_total_blogs($row['user_id']);
                    $total  = mysqli_fetch_assoc($result);
                    echo $total['total_blogs'];
                ?>
             </h1>
        </div>
        <div class="col-sm col-md m-1 shadow rounded p-3">
            <p class="text-center fs-5 fw-bold primary">Posts <i class="fa-solid fa-file-pen"></i></p>
            <h1 class="fw-bold display-1 text-center primary">
            <?php 
                    $result = $db->admin_total_posts($row['user_id']);
                    $total  = mysqli_fetch_assoc($result);
                    echo $total['total_posts'];
                ?>
            </h1>
        </div>
            <?php
        }
        ?>
       
    </div>
    <?php
    ?>
</div>


<?php
$obj->footer();
?>