<?php
require 'require/general_library.php';
require 'require/database_settings.php';
require 'require/database_class.php';
$db = new database($hostname,$username,$password,$database);

$obj = new general();

$obj->header();
$obj->navbar();
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
<!--Home Start-->
<div id="home" class="container">
    <div class="row">
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6 p-5 mt-5">
            <h1 class="animate__animated animate__bounce text_color display-1 fw-bold">Blogger.</h1>
            <p class="animate__animated animate__fadeIn lead text_color">Echoes of Insight: Unveiling Stories, Exploring Ideas</p>
            <a href="blog.php?page=blog" class="animate__animated animate__fadeIn btn btn-primary-blogger m-2">Read Blogs <i class="fa-solid fa-book"></i></a>
            <a href="<?php echo isset($_SESSION['user'])?"dashboard/dashboard.php":"login.php?page=login&msg=Please Login First"?>" class="animate__animated animate__fadeIn btn btn-info-blogger m-2">Create Blogs <i class="fa-solid fa-circle-plus"></i></a>
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 col-xxl-6">
            <img src="images/home_cover.jpg" class="animate__animated animate__slideInDown img-fluid " alt="" height="100%">
        </div>
    </div>
</div>
<!--Home Ends-->


<!--Our Recents Starts-->
<div class="container">
      <div class="row">
        <div class="row">
          <h1 class="text_color fw-bold">Our Recents</h1>
        </div>
      </div>
      <div class="row p-5">
        <!--Recent Blog-->
        <div class="col-sm-9 col-md-9 col-lg-9">
          <div class="row">
          <div id="myCarousel" class="carousel slide mb-6" data-bs-ride="carousel">
            <div class="carousel-inner">
              <?php
              $result = $db->recent_blogs();
              if ($result->num_rows > 0) {
                $counter = 0;
                while ($blogs = mysqli_fetch_assoc($result)) {
                  $counter++
                  ?>
                  <div class="carousel-item <?php echo $counter == 1?'active':'' ?>">
                    <img src="<?php echo $blogs['blog_background_image'] ?>" class="img-fluid rounded shadow" alt="">  
                  <div class="container">
                      <div class="carousel-caption text-start">
                        <h1 class="text-light"><?php echo $blogs['blog_title'] ?></h1>
                        <p class="opacity-75 text-light"><?php echo $blogs['blog_summary'] ?></p>
                        <p><a class="btn btn-primary" href="blog_page.php?page=blog_page&blog_id=<?php echo $blogs['blog_id'] ?>">Read Blog</a></p>
                      </div>
                    </div>
                  </div>
                  <?php
                }
              }
              ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
          </div>
        </div>
        <!--Recent Blog Ends-->
    
        <!--Recent Posts Starts-->
        <div class="col-sm-3 col-md-3 col-lg-3">
          <div>
                <h4 class="text_color">Some Recent posts</h4>
                <ul class="list-unstyled" style="height: 500px; overflow-y:auto; overflow-x:auto">
                  <?php
                  $result = $db->recent_posts();
                  if ($result->num_rows > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                        <li>
                          <a href="post.php?page=post&post_id=<?php echo $row['post_id'] ?>" class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="#">
                            <img src="<?php echo $row['featured_image'] ?>" class="img-fluid rounded" width = "96" height="96" alt="">
                            <div class="col-lg-8">
                              <h6 class="mb-0 primary theme_settings"><?php echo $row['post_title'] ?></h6>
                              <small class="text-body-secondary">
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
                  }
                  ?>
                </ul>
              </div>
        </div>
        <!--Recent Posts Ends-->
      </div>
      <hr class="featurette-divider">
</div>
<!--Our Recents Ends-->


<!--About Us Starts-->
<div id="about_us" class="container mt-2 mb-5">
  <div class="row mt-5">
    <div class="col"><h1 class="text-center text_color display-2">About Us</h1></div>
  </div>
  <div class="row mt-5">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
      <img src="images/about_us.jpg" class="img-fluid" alt="" height="100%">
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
      <!-- <h1 class="text_color display-2 text-center">About Us</h1> -->
      <p class="lead text_color text-center">
        Welcome to our online blogging website, where we provide a platform for individuals to express their thoughts, insights, and opinions on a wide range of topics.
        As a user-centric platform, our primary goal is to foster a community of like-minded individuals who are passionate about sharing their knowledge and experiences with a wider audience.
        Our website is designed to be user-friendly, with a clean and intuitive interface that allows users to easily navigate through different categories and find content that is of interest to them. 
        We provide a diverse range of topics for our users to choose from, including technology, lifestyle, health, education, and much more.   
        In addition to providing a platform for individuals to express their thoughts, our blog also serves as a valuable source of information and knowledge. 
        Through our curated content and expert contributors, we strive to provide informative and engaging articles that offer valuable insights and perspectives on various subjects.
      </p>
    </div>
  </div>
  <hr class="featurette-divider">
</div>
<!--About Us Ends-->


<!--Features Start-->
<div id="features" class="container mt-5">
  <div class="row mt-5">
    <div class="col"><h1  class="text-center text_color display-2">Our Features</h1></div>
  </div>
  <div class="row featurette">
        <div class="col-md-7 mt-5 p-5">
          <h2 class="featurette-heading fw-normal lh-1">All Blog Features <span class="text-body-secondary">It’ll blow your mind.</span></h2> 
          <div class="accordion" id="accordionExample">
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                 Create Blog's
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis quaerat tempora fugiat atque esse, consequuntur amet nesciunt velit quae ducimus repudiandae ut ratione animi! Fugit repellat a reiciendis in suscipit.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                 Create Post's
                </button>
              </h2>
              <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis quaerat tempora fugiat atque esse, consequuntur amet nesciunt velit quae ducimus repudiandae ut ratione animi! Fugit repellat a reiciendis in suscipit.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                  Follow Blog's
                </button>
              </h2>
              <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis quaerat tempora fugiat atque esse, consequuntur amet nesciunt velit quae ducimus repudiandae ut ratione animi! Fugit repellat a reiciendis in suscipit.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-5">
          <img src="images/features.jpg" class="img-fluid" alt="">
        </div>
  </div>
  <hr class="featurette-divider">
</div>
<!--Features Ends-->


<!--Contact Us Starts-->
<div id="contact_us" class="container mt-5">
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
  <div id="contact_us_msg"></div>
  <div class="row">
    <div class="col">
      <h1 class="text-center text_color display-2">Contact Us</h1>
    </div>
  </div>
	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
    <img src="images/contact_us.jpg" class="img-fluid" style="height: 80%;" alt="">
		</div>
    <?php
    $obj->set_action("feedback_process.php");
    $obj->set_method("POST");
    $obj->feedback_form();
    ?>
	</div>
</div>
<!--Contact Us Ends-->


<!--Back to Top-->
<div class="container">
  <div class="row">
    <div class="col"><a  href="#home" class="btn btn-primary rounded-circle float-end"><i class="fa-solid fa-arrow-up"></i></a>
    </div>
  </div>
</div>


<?php $obj->footer(); ?>