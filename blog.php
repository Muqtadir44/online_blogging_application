<?php

require 'require/general_library.php';
require 'require/database_class.php';
require 'require/database_settings.php';
$db  = new database($hostname,$username,$password,$database);
$obj = new general();
$obj->header();
$obj->navbar();

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

if (!isset($_GET['page'])) {
  header("location: index.php");
}
?>

<!--Cover start-->
<div class="py-5 text-center container-fluid bg-body-secondary">
    <div class="row py-lg-5">
      <div class="col-lg-6 col-md-8 mx-auto">
        <h1 class="fw-light display-2 text_color">Blog's</h1>
        <p class="lead text-body-secondary">So, here's to embarking on a journey of discovery together.</p>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] == 1) {
          ?>
          <p>
            <a href="dashboard/dashboard.php" class="btn btn-primary my-2 px-5">Create Blog</a>
          </p>
          <?php
        } ?>
      </div>
    </div>
    <div class="row">
      <div class="col-sm col-md col-lg col-xl col-xxl"></div>
      <div class="col-sm col-md col-lg col-xl col-xxl">
        <div class="my-1 d-flex">
            <div class="input-group mx-2">
                <input onkeyup="return search_blogs()" type="text" id="blog_search" class="form-control" required placeholder="Search Blogs">
                <button onclick="return" type="button" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>
                </button>     
            </div>
        </div>
      </div>
      <div class="col-sm col-md col-lg col-xl col-xxl"></div>
    </div>
</div>
<hr class="featurette-divider">
<!--Cover Ends-->

<?php
$result = $db->blogs_count();
if ($result->num_rows > 0) {
   $row = mysqli_fetch_assoc($result);
   $total_blogs = $row['total_blogs'];
}
$per_page    = 3;
$total_links = (ceil($total_blogs/$per_page));

 if (isset($_REQUEST['paggination'])) {
  $paggination = $_REQUEST['paggination'];
  $start       = ($paggination*$per_page);
 }else{
   $paggination = 0;
   $start       = 0;
 }
?>

<!--Blogs Start-->
<div class="container">
  
  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3" id="searching_blog">
    <?php
     $result = $db->all_blogs($start,$per_page);
     if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          ?>
            <div class="col">
              <div class="card shadow-sm animate__animated animate__zoomIn">
                <img src="<?php echo $row['blog_background_image'] ?>" class="image-fluid rounded-top" alt="">
                <div class="card-body">
                  <h4 class="primary theme_settings"><?php echo $row['blog_title'] ?>
                    <span class="float-end fs-6 primary fw-light">
                      <?php
                        $total_posts = $db->total_blog_posts($row['blog_id']);
                        if ($total_posts->num_rows > 0) {
                          $total_blog_posts = mysqli_fetch_assoc($total_posts);
                          ?>
                          <i class="fa-regular fa-file-lines"></i> <?php echo $total_blog_posts['total_blog_posts']; ?>
                          <?php
                        }else{
                          ?>
                          <i class="fa-regular fa-file-lines"></i> <?php echo "0"; ?>
                          <?php
                        }
                      ?>
                    </span>
                    <span class="float-end fs-6 primary fw-light mx-2">
                      <?php
                        $total_followers = $db->total_blog_followers($row['blog_id']);
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
                      <a href="blog_page.php?page=blog_page&blog_id=<?php echo $row['blog_id'] ?>" class="btn btn-sm btn-primary">Read Blog <i class="fa-solid fa-book"></i> </a>
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
     }
    ?>
  </div>
  <div class="row mt-5">
        <div class="col">
          <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

              <?php
                if ($paggination>0) { ?>
                  <li class="page-item">
                    <a href="blog.php?page=blog&paggination=<?php echo $paggination-1 ?>" class="page-link">Previous</a>
                  </li>
              <?php
               }
                for ($i=1; $i <=$total_links ; $i++) { 
                  if ($paggination == $i-1) { ?>
                    <li class="page-item"><a class="page-link" href="blog.php?page=blog&paggination=<?php echo $i-1 ?>"><?php echo $i; ?></a></li>
                  <?php }else{ ?>
                    <li class="page-item"><a class="page-link" href="blog.php?page=blog&paggination=<?php echo $i-1 ?>"><?php echo $i; ?></a></li>
                  <?php } 
                }
                if ($paggination<$total_links-1) { ?>
                    <li class="page-item">
                      <a class="page-link" href="blog.php?page=blog&paggination=<?php echo $paggination+1 ?>">Next</a>
                    </li>
                <?php }
              ?>
            </ul>
          </nav>
        </div>
      </div>
</div>
<!--Blogs Ends-->

<?php $obj->footer(); ?>
