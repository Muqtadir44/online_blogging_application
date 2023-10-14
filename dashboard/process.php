<?php
session_start();
require '../require/database_settings.php';
require '../require/database_class.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
require '../PHPMailer/src/Exception.php';
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

if (isset($_POST['action']) && $_POST['action'] == 'dashboard') {
    $result = $obj->posts_statistics();
    if ($result->num_rows > 0) {
        $post = mysqli_fetch_assoc($result);
    }
    $result = $obj->blogs_statistics();
    if ($result->num_rows > 0) {
        $blog = mysqli_fetch_assoc($result);
    }
    $result = $obj->users_statistics();
    if ($result->num_rows > 0) {
        $users = mysqli_fetch_assoc($result);
    }
    $result = $obj->categories_statistics();
    if ($result->num_rows > 0) {
        $categories = mysqli_fetch_assoc($result);
    }
    $result = $obj->feedback_statistics();
    if ($result->num_rows > 0) {
        $feedback = mysqli_fetch_assoc($result);
    }
    ?>
    <div id="state_msg"></div>
    <div class="row mt-5 ">
          <div class="col-sm col-md col-lg col-xl my-2">
            <div id="total_posts" class="shadow rounded">
              <p class="text-center fs-5 fw-bold primary">Posts <i class="fa-solid fa-file-pen"></i></p>
              <h1 class="fw-bold display-1 text-center primary"><?php echo $post['post_statistics']?></h1>
            </div>
          </div>
          <div class="col-sm col-md col-lg col-xl my-2">
            <div id="total_posts" class="shadow rounded">
              <p class="text-center fs-5 fw-bold primary">Blogs <i class="fa-solid fa-book"></i></p>
              <h1 class="fw-bold display-1 text-center primary"><?php echo $blog['blog_statistics']?></h1>
            </div>
          </div>
          <div class="col-sm col-md col-lg col-xl my-2">
            <div id="total_posts" class="shadow rounded">
              <p class="text-center fs-5 fw-bold primary">Users <i class="fa-solid fa-users"></i></p>
              <h1 class="fw-bold display-1 text-center primary"><?php echo $users['users_statistics']?></h1>
            </div>
          </div>
          <div class="col-sm col-md col-lg col-xl my-2">
            <div id="total_posts" class="shadow rounded">
              <p class="text-center fs-5 fw-bold primary">Categories <i class="fa-solid fa-list-ul"></i></p>
              <h1 class="fw-bold display-1 text-center primary"><?php echo $categories['categories_statistics']?></h1>
            </div>
          </div>
          <div class="col-sm col-md col-lg col-xl my-2">
            <div id="total_posts" class="shadow rounded">
              <p class="text-center fs-5 fw-bold primary">Feedbacks <i class="fa-regular fa-message"></i></p>
              <h1 class="fw-bold display-1 text-center primary"><?php echo $feedback['feedback_statistics']?></h1>
            </div>
          </div>
        </div>

        <div class="row p-3 shadow rounded m-2">
            <p class="text_color fs-4">User Requests</p>
            <div class="col-sm table-responsive " id="user_request"></div>
        </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'user_request') {

            $result = $obj->user_request();
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">email</th>
                            <th class="text-center">gender</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Request</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>  
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td class="text-danger"><i class="fa-regular fa-circle-xmark"></i></td>
                            <td><?php echo $row['state']; ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                    <button onclick="approve_user('<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-primary">Approve</button>
                                    <button onclick="reject_user('<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-danger">Reject</button>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Pending user's Requests</p>
                <?php
            }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'approve_user') {
    extract($_POST);
    $result = $obj->approve_user($user_id);
    if ($result) {
        $user   = $obj->user_record($user_id);
        if ($user->num_rows > 0) {
            $row = mysqli_fetch_assoc($user);
            extract($row);
            $mail->addAddress($email);
            $mail->Subject = "Congraluation's ".$first_name." ".$last_name." Account Approved";
            $mail->msgHTML("<h1 >Congratulations!</h1>
            <p>Your Account has been Approved and now you can login.</p>
            <h2>Welcome to Blogger</h2>
            <p>Your login credentials are:</p>
            <ul>
            <li><strong>Email: </strong>".$email."</li>
            <li><strong>Password: </strong>".$password."</li>
            </ul>
            <br>
            <p> You are now a valued member of our Blogger community.</p>
            <p>Best regards - <strong>Blogger</strong></p>
            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
            if($mail->send()){
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">User Approved Email Sended to user</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
            }else{
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="primary"> User Approved<span class="text-danger">Couldn't send email</span></strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php 
            }
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'reject_user') {
    extract($_POST);
    $result = $obj->reject_user($user_id);
    if ($result) {
        $user    = $obj->user_record($user_id);
        if ($user->num_rows > 0) {
            $row = mysqli_fetch_assoc($user);
            extract($row);
            $mail->addAddress($email);
            $mail->Subject = "Sorry".$first_name." ".$last_name."";
            $mail->msgHTML("
            <p>Your Account has been Rejected Sorry.</p>
            <p>Better Luck Next Time</p>
            <p>Best regards - <strong>Blogger</strong></p>
            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
            
            if($mail->send()){
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="text-danger">User Rejected Email Sended to user</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php                
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="text-danger">User Rejected <span class="text-danger">Couldn't send email</span></strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'total_blogs') {
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Blogs</h1>
        </div>
    </div>
    <div id="blog_status_msg"></div>
    <div class="row mt-5 p-1">
       <div class="col-sm table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result  = $obj->blogs();
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Blog Title</th>
                            <th class="text-center">Blog Summary</th>
                            <th class="text-center">Post Per Page</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Change Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td><?php echo $row['blog_title']; ?></td>  
                            <td><?php echo $row['blog_summary']; ?></td>
                            <td><?php echo $row['post_per_page']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <?php if($_SESSION['user']['user_id'] == $row['user_id']) {
                                ?>
                            <td><button onclick="blog_status('<?php echo $row['blog_id'] ?>','<?php echo $row['status'] ?>')" class="btn btn-sm <?php echo $row['status'] == 'Active'?"btn-danger":"btn-info"?> "><?php echo $row['status'] == 'Active'?"Inactive":"Active" ?></button></td>
                            <?php }else{
                                ?><td></td><?php
                            }
                            ?>
                            <td>
                                <?php
                                $date = date_create($row['created_at']);
                                echo date_format($date,"d M-Y"); ?>
                            </td>
                            <?php if($_SESSION['user']['user_id'] == $row['user_id']) {
                                ?>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                        <button onclick="update_blog('<?php echo $row['blog_id'] ?>','<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></button>
                                        <!-- <button onclick="delete_blog('<?php echo $row['blog_id'] ?>')" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button> -->
                                    </div>
                                </td>
                                <?php
                            }else{
                                ?>
                                <td></td>
                                <?php
                            } ?>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Blogs Found</p>
                <?php
            }?>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'update_blog_form') {

    extract($_POST);
    $result = $obj->blog_record($blog_id);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <div id="updating_blog_msg"></div>
        <button onclick="total_blogs()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center text_color">Update Blog</h1>
            </div>
        </div>
        <div class="row p-5">
            <div class="col">
            <form id="updating_blog_form" action="process.php" method="POST" enctype="multipart/form-data">
                <div class="row mb-3">
                    <label  class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                    <input type="text" name="blog_title" class="form-control" value="<?php echo $row['blog_title'] ?>" id="blog_title">
                    <p class="form-label text-danger" id="blog_title_msg"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Blog Summary</label>
                    <div class="col-sm-10">
                    <input type="text" name="blog_summary" class="form-control" value="<?php echo $row['blog_summary'] ?>" id="blog_summary">
                    <p class="form-label text-danger" id="blog_summary_msg"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label  class="col-sm-2 col-form-label">Post Per Page</label>
                    <div class="col-sm-10">
                   <input type="number" name="post_per_page" class="form-control" value="<?php echo $row['post_per_page']?>" id="post_per_page">
                    <p class="form-label text-danger" id="post_per_page_msg"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Background Image
                    <img src="../<?php echo $row['blog_background_image'] ?>" class="img-fluid" width="32" height="32" alt="">
                    </label>
                    <div class="col-sm-10">
                            <input type="file" name="background_image" class="form-control">
                            <p class="form-label text-danger" id="background_image_msg"></p>
                        </div>	
                </div>
                <button onclick="return updating_blog('<?php echo $row['blog_id'] ?>')" type="button" class="btn btn-primary w-100">Update Blog</button>
                <!-- <input type="submit" class="btn btn-primary w-100" name="create_blog" value="Create Blog"> -->
            </form>
            </div>
        </div>
        <?php
        
    }
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'updating_blog') {
    // echo "<pre>";
    // print_r($_REQUEST);
    // print_r($_FILES);
    // echo "</pre>";
    extract($_REQUEST);
    $result      = $obj->blog_record($blog_id);
    $blog_record = mysqli_fetch_assoc($result);

    $image = $blog_record['blog_background_image'];
    $name  = substr($image, 12);
    // echo $name;
    // die();
    if ($_FILES['background_image']['name'] != "") {
        extract($_FILES['background_image']);
        $result      = $obj->blog_record($blog_id);
        $blog_record = mysqli_fetch_assoc($result);

        $image = $blog_record['blog_background_image'];
        $name  = substr($image, 12);
        // echo $name;
        // echo $name;
        // echo $first_name;
        $file_name = $name;

        // echo  $tmp_name;
        $folder = "../blog_images";
        $path   = $folder.'/'.$file_name;

        if(!is_dir($folder)){
            if(!mkdir($folder)){
                echo "Could Not Created $folder Folder";
                die;
            }
        }

        $file_uploaded = move_uploaded_file($tmp_name,$path);
        $folder = "blog_images";
        $path   = $folder.'/'.$file_name;
        if ($file_uploaded) {
            $result = $obj->udpating_blog_with_image($blog_id,$blog_title,$blog_summary,$post_per_page,$path);
            // echo $result;

            if ($result) {
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Blog Updated</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="text-danger">couldn't update Blog</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    else{
        $result = $obj->updating_blog($blog_id,$blog_title,$blog_summary,$post_per_page);
        if ($result) {
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="primary">Blog Updated</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="text-danger">couldn't update Blog</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'blog_status') {
    extract($_POST);
    $result = $obj->blog_status($blog_id,$status);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Blog is Active Now":"Blog is Inactive Now" ?></strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'delete_blog') {
    extract($_POST);
    $result = $obj->delete_blog($blog_id);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Blog Deleted</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'total_posts') {
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Posts</h1>
        </div>
    </div>
    <div id="post_status_msg"></div>
    <div class="row mt-5 p-1">
       <div class="col-sm col-md col-lg table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result = $obj->show_posts($user_id);
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Post Title</th>
                            <th class="text-center">Blog Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Change Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){
                            ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td><?php echo $row['post_title']; ?></td>
                            <td><?php echo $row['blog_title']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td class="text-center">
                                <button onclick="post_status('<?php echo $row['post_id'] ?>','<?php echo $row['status'] ?>')" class="btn btn-sm <?php echo $row['status'] == 'Active'?"btn-danger":"btn-info"?> "><?php echo $row['status'] == 'Active'?"Inactive":"Active" ?></button>
                            </td>
                            <td>
                                <?php
                                $date = date_create($row['created_at']);
                                echo date_format($date,"d M-Y"); ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                    <button onclick="update_post('<?php echo $row['post_id'] ?>','<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></button>
                                    <button onclick="posts_categories('<?php echo $row['post_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-list-ul"></i></button>
                                    <button onclick="posts_attachments('<?php echo $row['post_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-paperclip"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Posts Found</p>
                <?php
            }?>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'posts_categories') {
    extract($_POST);
    ?>
    <div id="post_categories_msg"></div>
    <button onclick="total_posts()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center text_color">Post Categories</h1>
        </div>
    </div>
    <div class="row mb-3 mt-5">
        <div class="col">
            <form id="category_form" action="process.php" method="POST">
                <label class="col-sm-2 col-form-label">Add More Categories</label>
                <select id="category_id" class="js-example-basic-multiple" name="category_id[]" multiple="multiple" style="width: 100%;">
                <?php
                    $result = $obj->add_more_categories($post_id);
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_title'] ?></option>
                            <?php
                        }
                    }
                else{
                    ?>
                    <option value="" disable>No Category Found</option>
                    <?php
                }
                ?>
                </select>
                <p id="add_more_categories_msg" class="text-danger"></p>
                <div class="d-flex justify-content-center mt-3">
                    <button onclick="return add_post_categories('<?php echo $post_id ?>')" type="button" class="btn btn-primary">Add Category</button>              
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-sm col-md col-lg">
            <?php
            $result = $obj->posts_categories($post_id);
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Post Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td><?php echo $row['category_title']; ?></td>  
                            <td><?php echo $row['post_title']; ?></td>
                            <td class="<?php echo $row['post_category_status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['post_category_status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td class="text-center">
                                <button onclick="post_category_status('<?php echo $row['category_id'] ?>','<?php echo $row['post_id'] ?>','<?php echo $row['post_category_status'] ?>')" class="btn btn-sm <?php echo $row['post_category_status'] == 'Active'?"btn-danger":"btn-info"?> "><?php echo $row['post_category_status'] == 'Active'?"Inactive":"Active" ?></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
    <?php
}

elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_post_categories'){
    extract($_REQUEST);
    foreach ($category_id as $key => $id) {
        $result = $obj->creating_post_category($id,$post_id);
    }
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Category Added</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="text-danger">couldn't add category</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'post_category_status') {
    extract($_POST);
    $result = $obj->post_category_status($post_id,$category_id,$status);
    if ($result) {
     ?>
     <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
         <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
             <div class="toast show">
                 <div class="toast-body">
                     <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                     <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Post Category is Active Now":"Post Category is Inactive Now" ?></strong><br>
                 </div>
             </div>
         </div>
     </div>
     <?php   
    }   
}

elseif (isset($_POST['action']) && $_POST['action'] == 'posts_attachments') {
    extract($_POST);
    ?>
    <div id="post_attachemnts_msg"></div>
    <button onclick="total_posts()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center text_color">Post Attachments</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-sm">
            <p>Add More Attachments</p>
        </div>
    </div>
    <form id="attachemnts_form" action="process.php" method="POST" enctype="multipart/form-data">
        <div class="row mb-3" id="attachment_row">
            <div class="col-sm-7 my-2">
                <input type="text" class="form-control" name="attachment_title[]" placeholder="Attachment Title" required>
                <p id="attachment_title_msg" class="text-danger"></p>
            </div>
            <div class="col-sm-4 my-2">
                <input type="file" name="attachment_file[]" class="form-control" placeholder="Attachment File" required>
                <p id="attachment_file_msg" class="text-danger"></p>
            </div>
            <div class="col-sm-1 my-auto">
                <button class="float-end btn primary" id="add_more"><i class="fa-solid fa-circle-plus"></i></button>
            </div>
        </div>
        <p id="add_more_attachment_msg" class="text-danger"></p>
        <div class="d-flex justify-content-center mt-3">
            <button onclick="return add_post_attachments('<?php echo $post_id ?>')" type="button" class="btn btn-primary">Add Attachments</button>              
        </div>
    </form>
    <div class="row mt-5 p-1">
       <div class="col-sm col-md col-lg table-responsive p-2 shadow rounded">
            <?php
            $result = $obj->posts_attachments($post_id);
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Attachment Title</th>
                            <th class="text-center">Post Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Change Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){
                            ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td><?php echo $row['post_attachment_title']; ?></td>
                            <td><?php echo $row['post_title']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td class="text-center">
                                <button onclick="attachments_status('<?php echo $row['attachment_id'] ?>','<?php echo $row['status'] ?>','<?php echo $row['post_id'] ?>')" class="btn btn-sm <?php echo $row['status'] == 'Active'?"btn-danger":"btn-info"?> "><?php echo $row['status'] == 'Active'?"Inactive":"Active" ?></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Posts Found</p>
                <?php
            }?>
        </div>
    </div>
    <?php
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_post_attachments') {
    extract($_REQUEST);
    $attachment  = $_FILES['attachment_file'];
    $folder      = "../attachments";
    
    if (!is_dir($folder)) {
        if (!mkdir($folder)) {
            echo "can't create this $folder folder";
            die();
        }
    }
    $count = 0;
    foreach($attachment['name'] as $key => $files){
        $file_name     = rand()."_".$attachment['name'][$key];
        $tmp_name      = $attachment['tmp_name'][$key];
    
        $folder        = "../attachments";
        $path          = $folder."/".$file_name;
        $flag          = move_uploaded_file($tmp_name,$path);
        $folder        = "attachments";
        $path          = $folder."/".$file_name;
        
        if ($flag) {
            $result = $obj->creating_post_attachments($post_id,$attachment_title[0],$path);
            if ($result) {
                $count++;
                $attachment_title[0]++;
            }
        }else{
           echo "can't create attachments";
        }
    }
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Attachment Added Successfully!</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="text-danger">Couldn't Add Attachment</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } 
}

elseif (isset($_POST['action']) && $_POST['action'] == 'attachments_status') {
    extract($_POST);
    $result = $obj->post_attachment_status($attachment_id,$status);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Post Attachment is Active Now":"Post Attachment is Inactive Now" ?></strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'post_status') {
    extract($_POST);
    $result = $obj->post_status($post_id,$status);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Post is Active Now":"Post is Inactive Now" ?></strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'update_post') {

    extract($_POST);
    $result = $obj->update_post_blog($post_id);
    if ($result->num_rows > 0) {
        $post = mysqli_fetch_assoc($result);
           ?>
           <div id="updating_post_msg"></div>
            <button onclick="total_posts()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
           <div class="row mt-5">
               <div class="col">
                   <h1 class="text-center text_color">Update Post</h1>
               </div>
           </div>
           <div class="row p-5">
               <div class="col">
               <form action="process.php" method="POST" id="update_post_form" enctype="multipart/form-data">
                   <div class="row mb-3">
                       <label class="col-sm-2 col-form-label">Post Title</label>
                       <div class="col-sm-10">
                       <input type="text" class="form-control" name="post_title" value="<?php echo $post['post_title'] ?>">
                       <p id="post_title_msg" class="text-danger"></p>
                       </div>
                   </div>
                   <div class="row mb-3">
                       <label for="inputEmail3" class="col-sm-2 col-form-label">Blog Title</label>
                       <div class="col-sm-10">
                           <select class="form-select" name="blog_id" aria-label="Default select example">
                               <option value="">-- Select Blog --</option>
                               <?php
                               $result = $obj->admin_blogs($_SESSION['user']['user_id']);
                               if ($result->num_rows > 0) {
                                   while ($row = mysqli_fetch_assoc($result)) {
                                       ?>
                                       <option value="<?php echo $row['blog_id']?>" <?php echo $post['blog_id'] ==  $row['blog_id']?"Selected":""?> ><?php echo $row['blog_title'] ?></option>
                                       <?php
                                   }
                               }else{
                                   ?>
                                   <option value="" class="text-danger" disabled>Create Blog First</option>
                                   <?php   
                               }
                               ?>
                           </select>
                           <p id="blog_title_msg" class="text-danger"></p>
                       </div>
                   </div>
                     
                   <div class="row mb-3">
                       <label class="col-sm-2 col-form-label">Summary</label>
                       <div class="col-sm-10">
                       <input type="text" class="form-control" name="post_summary" value="<?php echo $post['post_summary']  ?>">
                       <p id="post_summary_msg" class="text-danger"></p>
                       </div>
                   </div>
                   <div class="row mb-3">
                       <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Description</label>
                       <div class="col-sm-10">
                       <textarea class="form-control" name="post_description" id="exampleFormControlTextarea1" rows="3"><?php echo $post['post_description'] ?></textarea>
                       <p id="post_description_msg" class="text-danger"></p>
                       </div>
                </div>
                   <div class="row mb-3">

                       <label for="inputPassword3" class="col-sm-2 col-form-label">Featured Image
                        <img src="../<?php echo $post['featured_image'] ?>" class="img-fluid" width="32" height="32" alt=""></label>
                       <div class="col-sm-10">
                    <input type="file" name="featured_image" class="form-control">
                       <p id="featured_image_msg" class="text-danger"></p>
                    </div>  
                   </div>
                   
                   <div class="row mb-3">
                       <label for="inputPassword3" class="col-sm-2 col-form-label">Comments</label>
                       <div class="col-sm-10">
                           <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                               <input id="commments_enable" type="radio" class="btn-check" name="comments" value="enable" autocomplete="off" <?php echo $post['comments_status'] == 'Enable'?"Checked":"" ?> >
                               <label class="btn btn-outline-primary" for="commments_enable">Enable</label>
                               <input id="commments_disable" type="radio" class="btn-check" name="comments" value="disable" autocomplete="off" <?php echo $post['comments_status'] == 'Disable'?"Checked":"" ?> >
                               <label class="btn btn-outline-danger" for="commments_disable">Disable</label>
                           </div>
                           <p id="post_comments_msg" class="text-danger"></p>
                       </div>
                   </div>
                   <button type="button"  onclick="return updating_post('<?php echo $post['post_id'] ?>')" class="btn btn-primary w-100">Update Post</button>
               </form>
               </div>
           </div>
           <?php
    }
}

elseif(isset($_REQUEST['action']) && $_REQUEST['action'] == 'updating_post') {
    extract($_REQUEST);

    $result      = $obj->post($post_id);
    $post_record = mysqli_fetch_assoc($result);
    $image       = $post_record['featured_image'];
    $name        = substr($image, 12);
    if ($_FILES['featured_image']['name'] != "") {
        extract($_FILES['featured_image']);
        $result      = $obj->post($post_id);
        $post_record = mysqli_fetch_assoc($result);
        $image       = $post_record['featured_image'];
        $name        = substr($image, 12);
        $file_name   = $name;
        $folder      = "../post_images";
        $path        = $folder.'/'.$file_name;
        if(!is_dir($folder)){
            if(!mkdir($folder)){
                die;
            }
        }
        $file_uploaded = move_uploaded_file($tmp_name,$path);
        $folder        = "post_images";
        $path          = $folder.'/'.$file_name;
        if ($file_uploaded) {
            $result = $obj->updating_post_with_image($blog_id,$post_id,$post_title,htmlspecialchars($post_summary),htmlspecialchars($post_description),$path,$comments);
            if ($result) {
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Post Updated</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="text-danger">couldn't update Post</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    else{
        $result = $obj->updating_post($blog_id,$post_id,$post_title,htmlspecialchars($post_summary),htmlspecialchars($post_description),$comments);
        if ($result) {
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="primary">Post Updated</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="text-danger">couldn't update Post</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'total_categories') {
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Categories</h1>
        </div>
    </div>
    <div id="category_status_msg"></div>
    <div class="row mt-5 p-1">
       <div class="col-sm table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result = $obj->categories();
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Category Title</th>
                            <th class="text-center">Category Description</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Change Status</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td><?php echo $row['category_title']; ?></td>  
                            <td><?php echo $row['category_description']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td><button onclick="category_status('<?php echo $row['category_id'] ?>','<?php echo $row['status'] ?>')" class="btn btn-sm <?php echo $row['status'] == 'Active'?"btn-danger":"btn-info"?> "><?php echo $row['status'] == 'Active'?"Inactive":"Active" ?></button></td>
                            <td>
                                <?php
                                $date = date_create($row['created_at']);
                                echo date_format($date,"d M-Y"); ?>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                    <button onclick="update_category('<?php echo $row['category_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></button>
                                    <!-- <button onclick="delete_category('<?php echo $row['category_id'] ?>')" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-trash"></i></button> -->
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Categories Found</p>
                <?php
            }?>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'category_status') {
    extract($_POST);
    $result = $obj->category_status($category_id,$status);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Category is Active Now":"Category is Inactive Now" ?></strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'delete_category') {
    extract($_POST);
    $result = $obj->delete_category($category_id);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Category Deleted</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'total_feedbacks') {
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Feedbacks</h1>
        </div>
    </div>
    <div class="row mt-5 p-1">
       <div class="col-sm table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result = $obj->show_feedbacks();
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Feedback</th>
                            <th class="text-center">At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td><?php echo $row['full_name']; ?></td>  
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['feedback']; ?></td>
                            <td>
                                <?php
                                $date = date_create($row['created_at']);
                                echo date_format($date,"d M-Y"); ?>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Categories Found</p>
                <?php
            }?>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'create_blog') {
    ?>
    <div id="create_blog_msg"></div>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center text_color">Create Blog</h1>
        </div>
    </div>
    <div class="row p-5">
        <div class="col">
        <form id="create_blog_form" action="process.php" method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <label  class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                <input type="text" name="blog_title" class="form-control" id="blog_title">
                <p class="form-label text-danger" id="blog_title_msg"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Blog Summary</label>
                <div class="col-sm-10">
                <input type="text" name="blog_summary" class="form-control" id="blog_summary">
                <p class="form-label text-danger" id="blog_summary_msg"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label  class="col-sm-2 col-form-label">Post Per Page</label>
                <div class="col-sm-10">
                <input type="number" name="post_per_page" class="form-control" id="post_per_page">
                <p class="form-label text-danger" id="post_per_page_msg"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Background Image</label>
                <div class="col-sm-10">
						<input type="file" name="background_image" class="form-control">
						<p class="form-label text-danger" id="background_image_msg"></p>
					  </div>	
            </div>
            <button onclick="return creating_blog()" type="button" class="btn btn-primary w-100">Create Blog</button>
            <!-- <input type="submit" class="btn btn-primary w-100" name="create_blog" value="Create Blog"> -->
        </form>
        </div>
    </div>
    <?php
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'creating_blog') {
    extract($_REQUEST);
    extract($_FILES['background_image']);

    $original_file_name = $name;
    $file_name = rand()."_".$name;
    // echo  $tmp_name;
    $folder = "../blog_images";
    $path   = $folder.'/'.$file_name;

    if(!is_dir($folder)){
        if(!mkdir($folder)){
            echo "Could Not Created $folder Folder";
            die;
        }
    }

    $file_uploaded = move_uploaded_file($tmp_name,$path);
    $folder = "blog_images";
    $path   = $folder.'/'.$file_name;
    if ($file_uploaded) {
        $user_id = $_SESSION['user']['user_id'];
        // echo $user_id;
        $result  = $obj->creating_blog($user_id,$blog_title,$blog_summary,$post_per_page,$path);
        if ($result) {
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Blog Created Successfully</strong><br>
                                <p>Now you can add posts in your blog</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'create_post') {
    ?>
    <div id="creating_post_msg"></div>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center text_color">Create Post</h1>
        </div>
    </div>
    <div class="row p-5">
        <div class="col">
        <form action="process.php" method="POST" id="create_post_form" enctype="multipart/form-data">
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" name="post_title" id="inputEmail3">
                <p id="post_title_msg" class="text-danger"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Blog Title</label>
                <div class="col-sm-10">
                    <select class="form-select" name="blog_id" aria-label="Default select example">
                        <option value="">-- Select Blog --</option>
                        <?php
                        $result = $obj->admin_blogs($_SESSION['user']['user_id']);
                        if ($result->num_rows > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $row['blog_id']?>"><?php echo $row['blog_title'] ?></option>
                                <?php
                            }
                        }else{
                            ?>
                            <option value="" class="text-danger" disabled>Create Blog First</option>
                            <?php   
                        }
                        ?>
                    </select>
                    <p id="blog_title_msg" class="text-danger"></p>
                </div>
            </div>
               <div class="row mb-3">
                   <label for="inputEmail3" class="col-sm-2 col-form-label">Categories</label>
                   <div class="col-sm-10">
                       <select id="category_id" class="js-example-basic-multiple" name="category_id[]" multiple="multiple" style="width: 100%;">
                       <?php
                       $result = $obj->post_categories();
                       if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <option value="<?php echo $row['category_id'] ?>"><?php echo $row['category_title'] ?></option>                            
                            <?php
                        }
                       }else{
                        ?>
                        <option value="" disable>No Category Found</option>
                        <?php
                       }
                       ?>
                       </select>
                       <p id="post_categories_msg" class="text-danger"></p>                 
                   </div>
               </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Summary</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" name="post_summary" id="inputPassword3">
                <p id="post_summary_msg" class="text-danger"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label for="exampleFormControlTextarea1" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="post_description" id="exampleFormControlTextarea1" rows="3"></textarea>
                <p id="post_description_msg" class="text-danger"></p>
                </div>
			</div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Featured Image</label>
                <div class="col-sm-10">
				<input type="file" name="featured_image" class="form-control">
                <p id="featured_image_msg" class="text-danger"></p>
				</div>	
            </div>
            <div class="row">
                <div class="col-sm">
                    <p>Attachments</p>
                </div>
            </div>
            <div class="row mb-3" id="attachment_row">
                <div class="col-sm-7 my-2">
				    <input type="text" class="form-control" name="attachment_title[]" placeholder="Attachment Title">
                    <p id="attachment_title_msg" class="text-danger"></p>
				</div>
                <div class="col-sm-4 my-2">
				    <input type="file" name="attachment_file[]" class="form-control" placeholder="Attachment File">
                    <p id="attachment_file_msg" class="text-danger"></p>
                </div>
                <div class="col-sm-1 my-auto">
                    <button class="float-end btn primary" id="add_more"><i class="fa-solid fa-circle-plus"></i></button>
                </div>
            </div>
            <div class="row mb-3">
                <label for="inputPassword3" class="col-sm-2 col-form-label">Comments</label>
                <div class="col-sm-10">
                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                        <input id="commments_enable" type="radio" class="btn-check" name="comments" value="enable">
                        <label class="btn btn-outline-primary" for="commments_enable">Enable</label>
                        <input id="commments_disable" type="radio" class="btn-check" name="comments" value="disable">
                        <label class="btn btn-outline-danger" for="commments_disable">Disable</label>
                    </div>
                    <p id="post_comments_msg" class="text-danger"></p>
                </div>
            </div>
            <button type="button"  onclick="return creating_post()" class="btn btn-primary w-100">Create Post</button>
        </form>
        </div>
    </div>
    <?php
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'creating_post') {
    extract($_REQUEST);
    if ($_FILES['attachment_file']['name'][0] != "") {

        extract($_FILES['featured_image']);
        $file_name          = rand()."_".$name;
        $folder             = "../post_images";
        $path               = $folder.'/'.$file_name;

        if(!is_dir($folder)){
            if(!mkdir($folder)){
                echo "Could Not Created $folder Folder";
                die;
            }
        }
        $file_uploaded = move_uploaded_file($tmp_name,$path);
        $folder      = "post_images";
        $path        = $folder.'/'.$file_name;
        $result      = $obj->creating_post($blog_id,$post_title,htmlspecialchars($post_summary),htmlspecialchars($post_description),$path,$comments);
        $post_result = $obj->post_record();
        $row         = mysqli_fetch_assoc($post_result);
        $post_id     = $row['post_id'];
        if ($result) {

            $attachment  = $_FILES['attachment_file'];
            $folder = "../attachments";
     
            if (!is_dir($folder)) {
                if (!mkdir($folder)) {
                    echo "can't create this $folder folder";
                    die();
                }
            }
            // extract($attachment_title);
            $count = 0;
            foreach($attachment['name'] as $key => $files){
                $file_name     = rand()."_".$attachment['name'][$key];
                $tmp_name      = $attachment['tmp_name'][$key];
    
                $folder        = "../attachments";
                $path          = $folder."/".$file_name;
                $flag          = move_uploaded_file($tmp_name,$path);
                $folder        = "attachments";
                $path          = $folder."/".$file_name;
                
                if ($flag) {
                    $result = $obj->creating_post_attachments($post_id,$attachment_title[0],$path);
                    if ($result) {
                        $count++;
                        $attachment_title[0]++;
                    }
                }else{
                   echo "can't create attachments";
                }
            }
            if ($result) {
                foreach ($category_id as $key => $id) {
                    $result = $obj->creating_post_category($id,$post_id);
                }
                if ($result) {
                    /*...follower emailing...*/
                    $result = $obj->sending_email($blog_id);
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            extract($row);
                            $mail->addAddress($email);
                            $mail->Subject = "New Post on ".$blog_title;
                            $mail->msgHTML("<h1> Check out the New Post </h1>
                            <p> The Blog you Follow just have a New Post -- Read it out --</p>
                            <br>
                            <p> You are now a valued member of our Blogger community.</p>
                            <p>Best regards - <strong>Blogger</strong></p>
                            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
                            if ($mail->send()) {
                                ?>
                                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                                        <div class="toast show">
                                            <div class="toast-body">
                                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                                <strong class="primary">Post Created Successfully and Email sended to your Followers</strong><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }else{
                                ?>
                                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                                        <div class="toast show">
                                            <div class="toast-body">
                                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                                <strong class="primary">Post Created <span class="text-danger">Couldn't Send Email to your followers</span></strong><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    }
                }
            }else{
                echo "couldn't create category";
            }
        }else{
            echo "couldn't create post";
        }
        
    }
    else{
        extract($_FILES['featured_image']);
        $file_name          = rand()."_".$name;
        $folder             = "../post_images";
        $path               = $folder.'/'.$file_name;

        if(!is_dir($folder)){
            if(!mkdir($folder)){
                echo "Could Not Created $folder Folder";
                die;
            }
        }
        $file_uploaded = move_uploaded_file($tmp_name,$path);
        $folder      = "post_images";
        $path        = $folder.'/'.$file_name;
        $result      = $obj->creating_post($blog_id,$post_title,htmlspecialchars($post_summary),htmlspecialchars($post_description),$path,$comments);
        $post_result = $obj->post_record();
        $row         = mysqli_fetch_assoc($post_result);
        $post_id     = $row['post_id'];
        if ($result) {
            foreach ($category_id as $key => $id) {
                $result = $obj->creating_post_category($id,$post_id);
            }
            if ($result) {
                /*...follower emailing...*/
                $result = $obj->sending_email($blog_id);
                if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        extract($row);
                        $mail->addAddress($email);
                        $mail->Subject = "New Post on ".$blog_title;
                        $mail->msgHTML("<h1> Check out the New Post </h1>
                        <p> The Blog you Follow just have a New Post -- Read it out --</p>
                        <br>
                        <p> You are now a valued member of our Blogger community.</p>
                        <p>Best regards - <strong>Blogger</strong></p>
                        <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
                        if ($mail->send()) {
                            ?>
                            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                                    <div class="toast show">
                                        <div class="toast-body">
                                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                            <strong class="primary">Post Created Successfully and Email sended to your Followers</strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }else{
                            ?>
                            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                                    <div class="toast show">
                                        <div class="toast-body">
                                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                            <strong class="primary">Post Created <span class="text-danger">Couldn't Send Email to your followers</span></strong><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                }
            }
            
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'create_categories') {
    ?>
    <div id="category_msg"></div>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text-center text_color">Create Category</h1>
        </div>
    </div>
    <div class="row p-5">
        <div class="col">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="category_title">
                <p id="category_title_msg" class="text-danger"></p>
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="category_description">
                <p id="category_description_msg" class="text-danger"></p>
                </div>
            </div>
            <button onclick="return creating_category()" class="btn btn-primary w-100">Create Category</button>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'creating_category') {
    extract($_POST);
    $result = $obj->creating_category($category_title,htmlspecialchars($category_description));
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Category Created Successfully</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="text-danger">Can't create Category</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'update_category_form') {
    extract($_POST);
    $result = $obj->category_record($category_id);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        ?>
        <div id="updating_category_msg"></div>
        <button onclick="total_categories()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
        <div class="row mt-5">
            <div class="col">
                <h1 class="text-center text_color">Update Category</h1>
            </div>
        </div>
        <div class="row p-5">
            <div class="col">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Title</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="category_title" value="<?php echo $row['category_title'] ?>">
                    <p id="category_title_msg" class="text-danger"></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Description</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="category_description" value="<?php echo $row['category_description'] ?>">
                    <p id="category_description_msg" class="text-danger"></p>
                    </div>
                </div>
                <button onclick="return updating_category('<?php echo $row['category_id'] ?>')" class="btn btn-primary w-100">Update Category</button>
            </div>
        </div>
        <?php    
    }  
}

elseif (isset($_POST['action']) && $_POST['action'] == 'updating_category') {
    extract($_POST);
    $result = $obj->updating_category($category_id,$category_title,htmlspecialchars($category_description));
    if ($result){
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Category Updated</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="text-danger">Couldn't Update Category</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'add_user') {
    ?>
    <div id="add_user_msg"></div>
    <div class="row mt-5">
        <div class="col">
            <h1 class="text_color text-center">Add User</h1>
            <p id="msg" class="text-danger text-center"></p>
        </div>
    </div>
    <div class="row p-5">
        <div class="col">
        <form id="adduser_form" action="process.php" method="POST" enctype="multipart/form-data">
				<div class="row">
					  <div class="col-sm col-md col-lg col-xl">
						  <label class="form-label">First Name</label>
						<input id="first_name" type="text" class="form-control" name="first_name" placeholder="eg. Ahmed">
						<p class="form-label text-danger" id="first_name_msg"></p>
					  </div>
					  <div class="col-sm col-md col-lg col-xl">
						  <label class="form-label">Last Name</label>			
						<input id="last_name" type="text" class="form-control" name="last_name" placeholder="eg. Khan">
						<p class="form-label text-danger" id="last_name_msg"></p>
					  </div>
				</div>
				<div class="row mt-2">
					  <div class="col-sm col-md col-lg col-xl">
						<label class="form-label">Email</label>
						<input id="email" onblur="email_check()" type="email" class="form-control" name="email" placeholder="example@gmail.com">
						<p class="form-label text-danger" id="email_msg"></p>
					  </div>
					  <div class="col-sm col-md col-lg col-xl">
						<label class="form-label">Password</label>
						<input id="password" type="password" class="form-control" name="password" placeholder="Password">
						<p class="form-label text-danger" id="password_msg"></p>
					  </div>
				</div>
				<div class="row mt-2">
					  <div class="col-sm col-md col-lg col-xl">
						<label class="form-label">Gender</label><br>
						<input type="radio" name="gender" value="Male"> Male
						<input type="radio" name="gender" value="Female"> Female
						<p class="form-label text-danger" id="gender_msg"></p>
					  </div>
					  <div class="col-sm col-md col-lg col-xl">
						<label class="form-label">Date of Birth</label>
						<input id="date_of_birth" type="date" class="form-control" name="date_of_birth">
						<p class="form-label text-danger" id="date_of_birth_msg"></p>
					  </div>
				</div>	  			
				  <div class="row mt-2">
					  <div class="col-sm col-md col-lg col-xl">
						  <label class="form-label">Profile Picture</label>
						<input id="profile_picture" type="file" name="profile_picture" class="form-control">
						<p class="form-label text-danger" id="profile_picture_msg"></p>
					  </div>	
					  <div class="col-sm col-md col-lg col-xl">
						  <label class="form-label">Address</label>
						<input id="address" type="text" name="address" class="form-control" placeholder="eg. Jamshoro Pakistan">
						<p class="form-label text-danger" id="address_msg"></p>
					  </div>	
				  </div>
                    <div class="row mt-2">
                        <div class="col-sm col-md col-lg col-xl">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Role Type</label>
                            <select id="role_id" class="form-select" name="role_id" aria-label="Default select example">
                                <option value="">-- Select Role --</option>
                                <option value="1">Admin</option>
                                <option value="2">User</option>
                            </select>
						    <p class="form-label text-danger" id="role_id_msg"></p>
                        </div>
                        <div class="col-sm col-md col-lg col-xl"></div>
                    </div>
				  <div class="row mt-5">
                    <button type="button" id="add_user" onclick="return dashboard_adduser()" class="btn btn-primary">Add User</button>
					  <!-- <input id="add_user" onclick="return dashboard_adduser()" class="btn btn-primary" name="add_user" value="Add User"> -->
				  </div>
			</form>
        </div>
    </div>
    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'all_users') {
   ?>
   <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">All Users</h1>
        </div>
    </div>
   <div id="update_msg"></div>
   <div class="row mt-5 p-1">
       <div class="col-sm table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result = $obj->all_users($user_id);
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Profile</th>   
                            <th class="text-center">Full Name</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Gender</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">change Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td class="text-center"><img src="../<?php echo $row['profile_picture'] ?>" class="img-fluid rounded-circle" width="32" height="32" alt=""></td> 
                            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>  
                            <td><?php echo $row['role_type']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td class="text-center"><button onclick="update_status('<?php echo $row['user_id'] ?>','<?php echo $row['status'] ?>')" class="btn <?php echo $row['status'] == 'Active'?"btn-danger":"btn-info"?> btn-sm"><?php echo $row['status'] == 'Active'?"Inactive":"Active" ?></button></td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                    <button onclick="update_user('<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-primary"><i class="fa-solid fa-pen"></i></button>
                                    <!-- <button onclick="delete_user('<?php echo $row['user_id'] ?>')" type="button" class="btn btn-outline-danger"><i class="fa-solid fa-user-xmark"></i></button> -->
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Pending user's Requests</p>
                <?php
            }?>
        </div>
    </div>
   <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'rejected_users' ) {
    ?>
    <div class="row mt-5 p-1">
        <div class="col">
            <h1 class="text_color">Rejected Users</h1>
        </div>
    </div>
   <div id="update_msg"></div>
   <div class="row mt-5 p-1">
       <div class="col-sm table-responsive p-2 shadow rounded">
            <?php
            $user_id = $_SESSION['user']['user_id'];
            $result = $obj->rejected_users();
            if ($result->num_rows > 0) {
                $counter = 1;
                ?>
                    <table id="example" class="display text-center">
                        <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th class="text-center">Profile</th>
                            <th class="text-center">Full Name</th>
                            <th class="text-center">email</th>
                            <th class="text-center">gender</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)){ ?>
                        <tr>
                            <td class="text-center"><?php echo $counter++ ?></td>
                            <td class="text-center"><img src="../<?php echo $row['profile_picture'] ?>" class="img-fluid rounded-circle" width="32" height="32" alt=""></td>
                            <td><?php echo $row['first_name']." ".$row['last_name']; ?></td>  
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['gender']; ?></td>
                            <td class="<?php echo $row['status'] == 'Active'?'primary':'text-danger' ?>">
                                <?php 
                                echo $row['status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                 ?>    
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                                    <button onclick="delete_user('<?php echo $row['user_id'] ?>')"  type="button" class="btn btn-outline-danger"><i class="fa-solid fa-user-xmark"></i></button>
                                </div>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
                <?php
            }else{
                ?>
                <p class="lead text-danger">No Rejected User's</p>
                <?php
            }?>
        </div>
    </div>
   <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'update_user') {
    $user_id   = $_POST['user_id'];
    $result    = $obj->user_record($user_id);
    if ($result->num_rows > 0) {
        $roles     = $obj->roles(); 
        $row       = mysqli_fetch_assoc($result);
        extract($row);
        ?>
        <div id="updating_user_msg"></div>
        <!-- <div class="shadow rounded p-3 mt-5"> -->
            <button onclick="all_users()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
            <form action="process.php" method="POST" id="updating_user_form" enctype="multipart/form-data">
            <div class="row">
                    <p id="error_msg" class="text-center text-danger"></p>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-label">First Name</label>
                    <input type="text" id="first_name" class="form-control" name="first_name" value="<?php echo $first_name ?>" placeholder="eg. Ahmed">
                    <p id="first_name_msg" class="text-danger"></p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-label">Last Name</label>           
                    <input type="text" id="last_name" class="form-control" name="last_name" value="<?php echo $last_name ?>" placeholder="eg. Khan">
                    <p id="last_name_msg" class="text-danger"></p>
                    </div>
            </div>
            <div class="row mt-2">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-label">Gender</label><br>
                    <input type="radio" id="gender_male" name="gender" value="Male" <?php echo $gender == 'Male'?'checked':''?>> Male
                    <input type="radio" id="gender_female" name="gender" value="Female" <?php echo $gender == 'Female'?'checked':''?>> Female
                    <p id="gender_msg" class="text-danger"></p>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" id="date_of_birth" class="form-control" name="date_of_birth" value="<?php echo $date_of_birth ?>" placeholder="DD-MM-YYYY">
                    <p id="date_of_birth_msg" class="text-danger"></p>
                    </div>
            </div>
                <div class="row mt-2">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-label">Profile Picture</label>
                    <img src="../<?php echo $profile_picture ?>" class="img-fluid" width="32" height="32" alt="">
                    <input type="file" id="profile_picture" name="profile_picture" class="form-control">
                    <p id="profile_picture_msg" class="text-danger"></p>
                    </div>    
                    <div class="col-sm-6 col-md-6 col-lg-6">
                        <label class="form-label">Address</label>
                    <input type="text" id="address" class="form-control" name="address" value="<?php echo $address ?>" placeholder="eg. Jamshoro, Pakistan">
                    <p id="address_msg" class="text-danger"></p>
                    </div>    
                </div> 
                <div class="row mt-2">
                    <div class="col-sm-6 col-md-6 col-lg-6">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">Role Type</label>
                    <select id="role_id" class="form-select" name="role_id" aria-label="Default select example">
                        <option value="">-- Select Role --</option>
                        <?php
                        while($role_type = mysqli_fetch_assoc($roles)){
                            ?>
                            <option value="<?php echo $role_type['role_id']?>" <?php echo $role_id == $role_type['role_id'] ?'Selected':"" ?> ><?php echo $role_type['role_type'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <p id="role_id_msg" class="text-danger"></p>
                    </div>
                </div> 
                <div class="row mt-2">
                    <div class="col-sm col-md">
                        <button type="button" onclick="return updating_user('<?php echo $user_id ?>')" class="btn btn-primary w-100">Update User</button>
                    </div>
                </div>

            
            </form>
        <!-- </div> -->
        <?php
    }
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'updating_user') {
    extract($_REQUEST);
    $result = $obj->user_record($user_id);
    $row = mysqli_fetch_assoc($result);
    // print_r($row);
    $picture = $row['profile_picture'];
    // echo $picture;
    $profile_picture = substr($picture,9);
    //601693949_dummy_profile.jpg
    if ($_FILES['profile_picture']['name'] != "") {
        extract($_FILES['profile_picture']);
        // echo $name;
        // echo $first_name;
        $file_name = $profile_picture;
        // echo  $tmp_name;
        $folder = "pictures";
        $path   = "../".$folder.'/'.$file_name;

        if(!is_dir($folder)){
            if(!mkdir($folder)){
                echo "Could Not Created $folder Folder";
                die;
            }
        }

        $file_uploaded = move_uploaded_file($tmp_name,$path);
        if ($file_uploaded) {
            $path   = $folder.'/'.$file_name;
            $result = $obj->updating_user_with_picture($user_id,$role_id,$first_name,$last_name,$gender,$date_of_birth,$address,$path);
            if ($result) {
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">User Profile Updated</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="text-danger">couldn't update user</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    else{
        // echo $first_name;
        $result = $obj->updating_user($user_id,$role_id,$first_name,$last_name,$gender,$date_of_birth,$address);
        if ($result) {
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="primary">User Profile Updated</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }else{
            ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="text-danger">couldn't update user</strong><br>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'update_status') {
    extract($_POST);
    if ($status == 'Active') {
        $result = $obj->update_status($user_id,$status);
        if ($result) {
            $user = $obj->user_record($user_id);
            $row = mysqli_fetch_assoc($user);
            extract($row);
            $mail->addAddress($email);
            $mail->Subject = "Hello ! ".$first_name." ".$last_name." Account Active";
            $mail->msgHTML("<h1>Congratulations!</h1>
            <p>Your Account is Active and now you can login.</p>
            <p>Your login credentials are:</p>
            <ul>
            <li><strong>Email: </strong>".$email."</li>
            <li><strong>Password: </strong>".$password."</li>
            </ul>
            <br>
            <p> You are now a valued member of our Blogger community.</p>
            <p>Best regards - <strong>Blogger</strong></p>
            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
            if ($mail->send()) {
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Account is Active now Email has been sended to the user</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Account Active now <span class="text-danger">Couldn't Send Email</span></strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
    else{
        $result = $obj->update_status($user_id,$status);
        if ($result) {
            $user = $obj->user_record($user_id);
            $row = mysqli_fetch_assoc($user);
            extract($row);
            $mail->addAddress($email);
            $mail->Subject = "Sorry ! ".$first_name." ".$last_name." your account is Inactive now";
            $mail->msgHTML("<h1>Dear user!</h1>
            <p>Your Account is Inactive now and now you can not login.</p>
            <br>
            <p>Best regards - <strong>Blogger</strong></p>
            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");
            if ($mail->send()) {
                ?>

                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Account is Inactive now email has been sended to the user</strong><br>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                    <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                        <div class="toast show">
                            <div class="toast-body">
                                <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                <strong class="primary">Account is Inactive now Couldn't Send Email</strong><br>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'delete_user') {
    extract($_POST);
    $result = $obj->delete_user($user_id);
    if ($result) {
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">User Deleted</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }else{
        ?>
        <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
            <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                <div class="toast show">
                    <div class="toast-body">
                        <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                        <strong class="primary">Can't Deleted User</strong><br>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == 'dashboard_adduser') {
    extract($_REQUEST);
    extract($_FILES);

    extract($profile_picture);

    $original_file_name = $name;
    $file_name = rand()."_".$name;
    // echo  $tmp_name;
    $folder = "pictures";
    $path   = "../".$folder.'/'.$file_name;

    if(!is_dir($folder)){
        if(!mkdir($folder)){
            echo "Could Not Created $folder Folder";
            die;
        }
    }

    $file_uploaded = move_uploaded_file($tmp_name,$path);
    if ($file_uploaded) {
        $path   = $folder.'/'.$file_name;
        $result = $obj->dashboard_add_user($role_id,$first_name,$last_name,$email,$password,$gender,$date_of_birth,$address,$path);
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
            <p>Best regards - <strong>Blogger</strong></p>
            <p>Echoes of Insight: Unveiling Stories, Exploring Ideas</p>");

            if ($mail->send()) {
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                        <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                            <div class="toast show">
                                <div class="toast-body">
                                    <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                    <strong class="primary">User Added Successfully</strong><br>
                                    <p>Email has been sended to the user</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }else{
                ?>
                <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                        <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                            <div class="toast show">
                                <div class="toast-body">
                                    <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                                    <strong class="primary">User Added Successfully</strong><br>
                                    <p class="text-danger">Couldn't send email to user</p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
            }
        }
    }
}

elseif (isset($_POST['action']) && $_POST['action'] == 'comments') {
    ?>
    <div class="row mt-5 p-1">
         <div class="col">
             <h1 class="text_color">Comments</h1>
         </div>
     </div>
     <div id="post_status_msg"></div>
     <div class="row mt-5 p-1">
        <div class="col-sm col-md col-lg table-responsive p-2 shadow rounded">
             <?php
             $user_id = $_SESSION['user']['user_id'];
             $result = $obj->show_posts($user_id);
             if ($result->num_rows > 0) {
                 $counter = 1;
                 ?>
                     <table id="example" class="display">
                         <thead>
                         <tr>
                             <th class="text-center">S.No</th>
                             <th class="text-center">Post Title</th>
                             <th class="text-center">Blog Title</th>
                             <th class="text-center">Created At</th>
                             <th class="text-center">Comments</th>
                             <th class="text-center">Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php while($row = mysqli_fetch_assoc($result)){
                             ?>
                         <tr>
                             <td class="text-center"><?php echo $counter++ ?></td>
                             <td class="text-center"><?php echo $row['post_title']; ?></td>
                             <td class="text-center"><?php echo $row['blog_title']; ?></td>
                             <td class="text-center">
                                 <?php
                                 $date = date_create($row['created_at']);
                                 echo date_format($date,"d M-Y"); ?>
                             </td>
                             <td class="text-center">
                                <?php
                                $comments = $obj->comments_count($row['post_id']);
                                $comments = mysqli_fetch_assoc($comments);
                                echo $comments['comments_count'];
                                ?>
                             </td>
                             <td class="text-center">
                                <?php
                                if ($comments['comments_count']) {
                                    ?>
                                    <button onclick="show_comments('<?php echo $row['post_id'] ?>')" type="button" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-comments"></i></button>
                                    <?php
                                }
                                ?>
                             </td>
                         </tr>
                     <?php }?>
                     </tbody>
                 </table>
                 <?php
             }else{
                 ?>
                 <p class="lead text-danger">No Posts Found</p>
                 <?php
             }?>
         </div>
     </div>

    <?php
}

elseif (isset($_POST['action']) && $_POST['action'] == 'show_comments') {
    extract($_POST);
    // die();
    ?>
        <button onclick="comments()" class="btn btn-info mt-5"><i class="fa-solid fa-angle-left"></i></button>
        <div class="row mt-5 p-1">
             <div class="col">
                 <h1 class="text_color">Comments</h1>
             </div>
         </div>
         <div id="post_comments_msg"></div>
         <div class="row mt-5 p-1">
            <div class="col-sm col-md col-lg table-responsive p-2 shadow rounded">
                 <?php
                 $result = $obj->show_comments($post_id);
                 if ($result->num_rows > 0) {
                     $counter = 1;
                     ?>
                         <table id="example" class="display text-center">
                             <thead>
                             <tr>
                                 <th class="text-center">S.No</th>
                                 <th class="text-center">Name</th>
                                 <th class="text-center">Comment</th>
                                 <th class="text-center">On</th>
                                 <th class="text-center">Status</th>
                                 <th class="text-center">Change Status</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php while($row = mysqli_fetch_assoc($result)){
                                 ?>
                             <tr>
                                 <td class="text-center"><?php echo $counter++ ?></td>
                                 <td class="text-center"><?php echo $row['first_name']." ".$row['last_name']; ?></td>
                                 <td class="text-center"><?php echo $row['comment']; ?></td>
                                 <td class="text-center">
                                     <?php
                                     $date = date_create($row['created_at']);
                                     echo date_format($date,"d M-Y"); ?>
                                 </td>
                                 <!-- <td class="text-center"><?php echo $row['comment_status'] ?></td> -->
                                 <td class="<?php echo $row['comment_status'] == 'Active'?'primary':'text-danger' ?>">
                                     <?php 
                                     echo $row['comment_status'] == 'Active'?"<i class='fa-regular fa-circle-check'></i>":"<i class='fa-regular fa-circle-xmark'></i>"
                                      ?>    
                                 </td>
                                 <td class="text-center">
                                    <button onclick="update_comment_status('<?php echo $row['post_comment_id'] ?>','<?php echo $row['comment_status'] ?>','<?php echo $row['post_id'] ?>')" class="btn <?php echo $row['comment_status'] == 'Active'?"btn-danger":"btn-info"?> btn-sm"><?php echo $row['comment_status'] == 'Active'?"Inactive":"Active" ?></button>
                                 </td>
                             </tr>
                         <?php }?>
                         </tbody>
                     </table>
                     <?php
                 }else{
                     ?>
                     <p class="lead text-danger">No Posts Found</p>
                     <?php
                 }?>
             </div>
         </div>
    <?php    
}

elseif (isset($_POST['action']) && $_POST['action'] == 'post_comment_status') {
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    extract($_POST);
    $result = $obj->post_comments_status($post_comment_id,$status);
    if ($result) {
        ?>
            <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
                <div class="toast-container p-3 top-50 end-0 translate-middle-y" id="toastPlacement">
                    <div class="toast show">
                        <div class="toast-body">
                            <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                            <strong class="<?php echo $status == 'Active'?"primary":"text-danger"?>"><?php echo $status == 'Active'?"Comment is Active Now":"Comment is Inactive Now" ?></strong><br>
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}

/*---- settings start  ----*/
elseif (isset($_POST['action']) && $_POST['action'] == 'settings') {
    ?>
    <div class="row mt-5 p-1">
         <div class="col">
             <h1 class="text_color">Profile</h1>
         </div>
     </div>
     <div id="settings_msg"></div>
     <?php
        $user_id = $_SESSION['user']['user_id'];
        $result  = $obj->user_profile($user_id);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            // echo "<pre>";
            // print_r($row);
            // echo "</pre>";
            ?>
     <div class="row m-2 p-3 shadow rounded"> 
         <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#change_profile" ><i class="fa-solid fa-pen"></i></button>
            <div class="modal fade" id="change_profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa-solid fa-address-card"></i> Update Profile</h1>
                        <button type="button" onclick="settings()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                            <button type="button" onclick="settings()" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10 col-md-10 col-lg-10">
            <h1 class="text_color"><?php echo $row['first_name']." ".$row['last_name'] ?> <span class="badge <?php echo $row['role_type'] == 'Admin'?'bg-warning':'bg-success' ?> fs-6"><?php echo $row['role_type'] ?></span> </h1>
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
            <img class="img-fluid rounded-circle" src="../<?php echo $row['profile_picture']?>" alt="">
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
            </ul>
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
        if(isset($row['role_id']) && $row['role_id'] == 1){       
        ?>
        <div class="col-sm col-md m-1 shadow rounded p-3">
            <p class="text-center fs-5 fw-bold primary">Blogs <i class="fa-solid fa-book"></i></p>
            <h1 class="fw-bold display-1 text-center primary">
                <?php 
                    $result = $obj->admin_total_blogs($row['user_id']);
                    $total  = mysqli_fetch_assoc($result);
                    echo $total['total_blogs'];
                ?>
             </h1>
        </div>
        <div class="col-sm col-md m-1 shadow rounded p-3">
            <p class="text-center fs-5 fw-bold primary">Posts <i class="fa-solid fa-file-pen"></i></p>
            <h1 class="fw-bold display-1 text-center primary">
            <?php 
                    $result = $obj->admin_total_posts($row['user_id']);
                    $total  = mysqli_fetch_assoc($result);
                    echo $total['total_posts'];
                ?>
            </h1>
        </div>
    </div>
    <?php
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
        $path   = "../".$folder.'/'.$name;
        // die();
        if(!is_dir($folder)){
            if(!mkdir($folder)){
                echo "Could Not Created $folder Folder";
                die;
            }
        }
    
        $file_uploaded = move_uploaded_file($tmp_name,$path);
        if ($file_uploaded) {
            $path   = $folder.'/'.$name;
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
/*---- settings end  ----*/

elseif (isset($_POST['action']) && $_POST['action'] == 'email_check') {
	extract($_POST);
	$result = $obj->email_check($email);
	if ($result->num_rows > 0) {
		echo "email matched";
	}
}

?>