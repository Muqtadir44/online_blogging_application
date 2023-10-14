<?php

require 'require/general_library.php';
require 'require/database_class.php';
require 'require/database_settings.php';

$db  = new database($hostname,$username,$password,$database);
$obj = new general();
$obj->header();
$obj->navbar();

if (isset($_GET['blog_id']) && $_GET['blog_id'] != "") {
	extract($_GET);
	$result = $db->blog_record($blog_id);
	if (!$result->num_rows > 0) {
		header("location:blog.php?page=blog");
	}
	$blog_page = $db->blog_page($blog_id);
 	$blog_page =	mysqli_fetch_assoc($blog_page);
}
else{
	header("location:blog.php?page=blog");
}
?>


<?php
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

<!--loading spinner-->
<div id="spinner-modal" class="custom-modal">
  <div class="custom-modal-dialog">
    <div class="custom-modal-content">
      <div class="custom-modal-body text-center">
        <div class="custom-spinner spinner-border text-info" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
        <p class="text-info">Loading...</p>
      </div>
    </div>
  </div>
</div>
<!--loading spinner end-->

<!--Cover Starts-->
<div class="container-fluid">
	<div class="row">
		<div class="col px-0">
			<img src="<?php echo $blog_page['blog_background_image'] ?>" class="img-fluid" alt="">
		</div>
	</div>
	<div class="row shadow border-top">
		<div class="col">
			<p class="primary fs-3 theme_settings"><?php echo $blog_page['blog_title'] ?> <span class="fs-6 text_color"><em>(By: <?php echo $blog_page['first_name']." ".$blog_page['last_name']  ?>)</em></span>
            </p>
		</div>
		<div class="col">
			<?php
			if (isset($_SESSION['user'])) {
				$blog_author = $db->blog_author($_SESSION['user']['user_id'],$blog_page['blog_id']);
				if (!$blog_author->num_rows > 0) {
					$follow_status = $db->follower_check($_SESSION['user']['user_id'],$blog_page['blog_id']);
					if ($follow_status->num_rows > 0) {
						$follow_status = mysqli_fetch_assoc($follow_status);
						if ($follow_status['follow_status'] == 'Follow') {
							?>
							<button id="follow_btn" onclick="follow_status('<?php echo $_SESSION['user']['user_id']?>','<?php echo $blog_page['blog_id'] ?>','<?php echo $follow_status['follow_status'] ?>','<?php echo $blog_page['user_id']?>')" type="button" class="btn btn-danger float-end mt-2">Unfollow <i class="fa-solid fa-plus"></i></button>
							<?php
						}else{
							?>
							<button id="follow_btn" onclick="follow_status('<?php echo $_SESSION['user']['user_id']?>','<?php echo $blog_page['blog_id'] ?>','<?php echo $follow_status['follow_status'] ?>','<?php echo $blog_page['user_id']?>')" type="button" class="btn btn-info float-end mt-2">Follow <i class="fa-solid fa-plus"></i></button>
							<?php
						}
					}else{
						?>
						<button onclick="new_follower('<?php echo $_SESSION['user']['user_id']?>','<?php echo $blog_page['blog_id'] ?>','<?php echo $blog_page['user_id']?>')" type="button" class="btn btn-info float-end mt-2">Follow <i class="fa-solid fa-plus"></i></button>
						<?php
					}				
				}
		}else{
			?>
			<a href="login.php?page=login&msg=Please Login First" class="btn btn-info float-end mt-2">Follow <i class="fa-solid fa-plus"></i></a>
			<?php
		}
		?>
		</div>
	</div>

	<div class="row mt-1">
		<div class="col">
			<p class="fs-6 float-end text-secondary">
				Blog Published on <?php $date = date_create($blog_page['created_at']);
                echo date_format($date,"d M-Y"); ?>		
            </p>
		</div>
	</div>
</div>
<div id="following_msg"></div>
<!--Cover Ends-->

<!-- Search Bar starts -->
<div class="container mt-5">
	<div class="row mb-5">
		<div class="col-sm col-md col-lg col-xl col-xxl"></div>
		<div class="col-sm col-md col-lg col-xl col-xxl">
			<div class="my-1 d-flex">
				<div class="input-group mx-2">
					<input onkeyup="search_posts('<?php echo $blog_page['blog_id'] ?>')" type="text" id="post_search" class="form-control" required placeholder="Search posts">
					<button onclick="return" type="submit" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass"></i>
					</button>     
				</div>
			</div>
		</div>
		<div class="col-sm col-md col-lg col-xl col-xxl"></div>
	</div>
</div>
<!-- Search Bar ends -->

<div class="container-fluid mt-5">
	<div class="row">
		<!--Blog Posts Starts-->
		<div class="col-sm-9 col-md-9 col-lg-9 col-xl-9">
			<?php
			$result = $db->post_paggination($blog_page['blog_id']);
			if ($result->num_rows > 0) {
			   $row = mysqli_fetch_assoc($result);
			   
			   $total_posts = $row['total_posts'];
			}
			$per_page = $blog_page['post_per_page'];
			$total_links = ceil(ceil($total_posts/$per_page));
			 if (isset($_REQUEST['paggination'])) {
			  $paggination = $_REQUEST['paggination'];
			  $start = ($paggination*$per_page);
			 }else{
			   $paggination = 0;
			   $start = 0;
			 }
			?>
			<div class="row" id="searching_post">
				<?php
				$result = $db->blog_page_post($blog_page['blog_id'],$start,$per_page);
					if ($result->num_rows > 0){
						
						while ($blog_posts = mysqli_fetch_assoc($result)) {
							?>
							<div class="col-sm-4 col-md-4 col-lg-4 col-xl-4 my-2 animate__animated animate__zoomIn animate__delay-1s">
								<div class="card shadow-sm">
									<img src="<?php echo $blog_posts['featured_image'] ?>" class="img-fluid rounded-top" alt="">
								  <div class="card-body">
								  	<h4 class="primary theme_settings"> <?php echo $blog_posts['post_title'] ?></h4>
								    <p class="card-text"><?php echo substr($blog_posts['post_summary'],0,30)."...."  ?></p>
								    <!-- <p class="card-text"><?php echo $blog_posts['post_summary']  ?></p> -->
								    <div class="d-flex justify-content-between align-items-center">
								      <div class="btn-group">
								        <a href="post.php?page=post&post_id=<?php echo $blog_posts['post_id'] ?>" class="btn btn-sm btn-primary"> Read Post <i class="fa-regular fa-file-lines"></i></a>
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
						?>
						<div class="row mt-5">
							<div class="col">
								<nav aria-label="Page navigation example">
								  <ul class="pagination justify-content-center">
						
									<?php
									  if ($paggination>0) { ?>
										<li class="page-item">
										  <a href="blog_page.php?page=blog_page&blog_id=<?php echo $blog_page['blog_id']?>&paggination=<?php echo $paggination-1 ?>" class="page-link">Previous</a>
										</li>
									<?php
									 }
									  for ($i=1; $i <=$total_links ; $i++) { 
										if ($paggination == $i-1) { ?>
										  <li class="page-item"><a class="page-link" href="blog_page.php?page=blog_page&blog_id=<?php echo $blog_page['blog_id']?>&paggination=<?php echo $i-1 ?>"><?php echo $i; ?></a></li>
										<?php }else{ ?>
										  <li class="page-item"><a class="page-link" href="blog_page.php?page=blog_page&blog_id=<?php echo $blog_page['blog_id']?>&paggination=<?php echo $i-1 ?>"><?php echo $i; ?></a></li>
										<?php } 
									  }
									  if ($paggination<$total_links-1) { ?>
										  <li class="page-item">
											<a class="page-link" href="blog_page.php?page=blog_page&blog_id=<?php echo $blog_page['blog_id']?>&paggination=<?php echo $paggination+1 ?>">Next</a>
										  </li>
									  <?php }
									?>
								  </ul>
								</nav>
							</div>
						</div>
						<?php
					}else{
						?>
						<div class="col"></div>
						<div class="col">
							<div class="alert alert-warning text-center text-danger" role="alert"><i class='fa fa-exclamation'></i> Author Has not Posted yet</div>
						</div>
						<div class="col"></div>
						<?php
					}
				?>
			</div>
		</div>
		<!--Blog Posts Ends-->

		<!--Related Author Blogs Starts-->
		<div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 border-start" style="position: relative;">
			<div style="position: sticky; top:80px;">
				<p class="text_color fs-5 fw-lighter"><em>More By <?php echo $blog_page['first_name']." ".$blog_page['last_name'] ?></em></p>
				 <ul class="list-unstyled" style="height:350px; overflow:auto;">
                  <?php
                  // echo "<pre>";
                  // print_r($blog_page);
                  // echo "</pre>";
                  $result = $db->related_blogs($blog_page['user_id'],$blog_page['blog_id']);
                  if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <li>
                          <a href="blog_page.php?page=blog_page&blog_id=<?php echo $row['blog_id'] ?>" class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="#">
                            <img src="<?php echo $row['blog_background_image'] ?>" class="img-fluid" width = "96" height="96" alt="">
                            <div class="col-lg-8">
                              <h6 class="mb-0 primary theme_settings"><?php echo $row['blog_title'] ?></h6>
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
		<!--Related Author Blogs Ends-->
	</div>
</div>


<?php

$obj->footer();
?>

