<?php

// date_default_timezone_set("Asia/Karachi");

require 'require/general_library.php';
require 'require/database_class.php';
require 'require/database_settings.php';

$db  = new database($hostname,$username,$password,$database);
$obj = new general();

$obj->header();
$obj->navbar();


if (isset($_GET['post_id']) && $_GET['post_id'] != "") {
    extract($_GET);
    $result = $db->post($post_id);
    if (!$result->num_rows > 0) {
        header("location:blog.php?page=blog");
    }
    $result = $db->blog_post($post_id);
    $post   = mysqli_fetch_assoc($result);
}else{
    header("location:blog.php?page=blog");

}
// echo "<pre>";
// print_r($post);
// echo "</pre>";
if (isset($_SESSION['user'])) {
    ?>
        <?php
        $result = $db->user_theme_settings($_SESSION['user']['user_id']);
        if ($result->num_rows > 0) {
            ?>
            <style type="text/css">
            .theme_settings{
                <?php
                while($theme_settings = mysqli_fetch_assoc($result)){
                    echo $theme_settings['setting_key'].':'.$theme_settings['setting_value'].';';
                }
                ?>  
            }
            </style>
            <?php   
        }
        ?>
    <?php
}
?>

<!--Cover Starts-->
<div class="container">
	<div class="row border-bottom">
		<div class="col px-0">
            <img src="<?php echo $post['featured_image'] ?>" class="img-fluid" alt="">
            <p class="primary fw-bold fs-3 theme_settings"><?php echo $post['post_title'] ?></p>
			<p class="text_color fs-5 theme_settings">Blog - <?php echo $post['blog_title'] ?> <span class="fs-6"><em>(Author: <?php echo $post['first_name']." ".$post['last_name'] ?> )</em></span></p>
		</div>
	</div>
    <div class="row">
        <div class="col">
            <p class="float-end px-2 text-secondary">
                <?php $date = date_create($post['created_at']);
                echo date_format($date,"d M-Y"); ?>
            </p>
        </div>
    </div>
</div>
<!--Cover Ends-->

<!--Attachment Starts-->
<div class="container">
    <div class="row">
        <div class="col"></div>
        <div class="col">
            <?php
            if (isset($_SESSION['user'])) {
                $result = $db->blog_post_attachment($post_id);
                if ($result->num_rows > 0) {
                    ?>
                    <button class="btn float-end btn-info my-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="fa-solid fa-paperclip"></i>
                        </button>
                    <p class="d-flex gap-2 m-4">
                    </p>
                    <div class="collapse" id="collapseExample">
                    <div id="box" class="card card-body">
                        <?php
                        while ($attachment = mysqli_fetch_assoc($result)) {
                            ?>
                            <a class="text-decoration-none primary" id="icon" download="<?php echo $attachment['post_attachment_path'] ?>" href="<?php echo $attachment['post_attachment_path']?>"><?php echo $attachment['post_attachment_title'] ?></a>
                            <?php
                        }
                        ?>
                    <?php
                }
                ?>
                </div>
                </div>  
                <?php              
            }else{
                ?>
                <a href="login.php?page=login&msg=Please Login First" class="btn float-end btn-info my-2">
                    <i class="fa-solid fa-paperclip"></i>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</div>
<!--Attachment Ends-->


<!--Post Content Start-->
<div class="container">
    <div class="row">
        <div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <p>
                <em>
                    <strong>Post Summary: </strong><?php echo $post['post_summary'] ?>
                </em>
            </p>
            <p>
               <strong>Description: </strong> <?php echo $post['post_description'] ?>
            </p>
        </div>
        <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 border-start" style="position: relative;">
        <div style="position: sticky; top:10px;">
				<p class="text_color fs-5 fw-lighter"><em>Related Posts</em></p>
				 <ul class="list-unstyled" style="height:350px; overflow:auto;">
                  <?php
                //   echo "<pre>";
                //   print_r($post);
                //   echo "</pre>";
                  $result = $db->related_posts($post['blog_id'] ,$post['post_id']);
                  if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <li>
                          <a href="post.php?page=post&post_id=<?php echo $row['post_id'] ?>" class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top">
                            <img src="<?php echo $row['featured_image'] ?>" class="img-fluid" width = "96" height="96" alt="">
                            <div class="col-lg-8">
                              <h6 class="mb-0 primary theme_settings"><?php echo $row['post_title'] ?></h6>
                              <small class="text_color"><em><?php echo $row['first_name']." ".$row['last_name'] ?></em></small>
                              <br>
                              <small class="text-body-secondary float-end">
                                <?php
                              $date = date_create($row['created_at']);
                              echo date_format($date,"d M-Y");
                              ?>
                              </small>
                            </div>
                          </a>
                        </li>
                      <?php
                    }
                  }else{
                  	?>
                  	<li class="primary"><em>This is the only Blog by this author</em></li>
                  	<?php
                  }

                  ?>
                </ul>
			</div>
        </div>
    </div>
</div>
<!--Post Content Ends-->
<hr>
<!-- Commenting Section Start-->
<div class="container mt-4">
    <div class="row">
        <div class="col">
            <p class="fs-4 text_color">Comments</p>
        </div>
    </div>
    <?php
    if ($post['comments_status'] == 'Enable') {
    ?>
    <div class="row">
        <div class="col-sm my-1 d-flex">
            <img src="<?php echo isset($_SESSION['user'])?$_SESSION['user']['profile_picture']:"dummy_img.jpg" ?>" alt="User Image" class="rounded-circle" width="50" height="50">
            <div class="input-group mx-2">
                <input type="text" id="comment" class="form-control" aria-describedby="inputGroupPrepend" required placeholder="Write a Comment">
                <?php 
                if (isset($_SESSION['user'])) {
                    ?>
                    <button onclick="return commenting('<?php echo $_SESSION['user']['user_id'] ?>','<?php echo $post['post_id'] ?>','<?php echo $post['user_id'] ?>')" type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i></button>
                    <?php
                }else{
                    ?>
                    <a class="btn btn-primary p-3" href="login.php?page=login&msg=Please Login First"><i class="fa-solid fa-paper-plane"></i></a>
                    <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm">
                <div id="commenting_msg"></div>
        </div>
    </div>
    <?php
    } else {
    ?>
    <div class="row">
        <div class="col">
            <p class="lead text-center">Comments are <span class="text-danger">disabled</span> for now on this post</p>
        </div>
    </div>
    <?php
    }
    ?>
</div>
<!--Commenting Section Ends-->

<!--All Comments Starts-->
<div class="container mt-5">
    <?php
    $all_comments = $db->all_comments($post['post_id']);
    if($all_comments->num_rows > 0){
        ?>
        <ul class="list-unstyled">
        <?php
        while($comments = mysqli_fetch_assoc($all_comments)){
            // echo "<pre>";
            // print_r($comments);
            // echo "</pre>";
            ?>
            <li>
              <div class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none">
                <img src="<?php echo $comments['profile_picture'] ?>" class="rounded-circle" width = "50" height="50" alt="">
                <div class="col-lg-8">
                  <h6 class="mb-0 primary"><?php echo $comments['first_name']." ".$comments['last_name'] ?></h6>
                  <small><?php echo $comments['comment'] ?></small>
                  <small class="text-body-secondary float-end">
                    <?php

                    $date = date_create($comments['created_at']);
                    // echo $comments['created_at'];
                    // print_r($date);
                    echo date_format($date,"d M-Y");
                    ?>
                  </small>
                </div>
              </div>
            </li>    
            <?php
        }
    }else{
        if ($post['comments_status'] == 'Enable') {
            ?>
            <div class="row">
                <div class="col">
                    <p class="text-center lead">Be the first <span class="primary">one</span> to comment</p>
                </div>
            </div>
            <?php   
        }
    }
    ?>
</div>
<!--All Comments Ends-->

<?php
$obj->footer();
?>