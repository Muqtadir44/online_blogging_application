<?php
require 'require/general_library.php';

$obj = new general();

$obj->header();
$obj->navbar();

if (isset($_SESSION['user'])) {
  header("location:index.php");
}
if (!isset($_GET['page'])) {
  header("location: index.php");
}

if (isset($_GET['msg'])) {
  ?>
  <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3">
    <div class="toast-container p-3 top-0 start-50 translate-middle-x" id="toastPlacement">
      <div class="toast show">
      <div class="toast-body">
      <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
      <strong class="text-danger"><?php echo $_GET['msg'] ?></strong>
      <?php
      if (isset($_GET['contact'])) {
        ?>
        <!-- Button trigger modal -->
        <br>
        <span class="primary fw-bold">you can send request here</span>
        <button type="button" class="btn primary " data-bs-toggle="modal" data-bs-target="#exampleModal">
          <i class="fa-solid fa-circle-info"></i>
        </button>
        <?php
      }
      ?>
      </div>
      </div>
    </div>
	</div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Activation Request</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
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
          <div class="alert alert-info" role="alert">
            Enter Your Account Email and we will send request to Admin
          </div>
          <div id="request_msg"></div>
          <div>
              <main class="form-signin w-100 m-auto">            
                  <div class="form-floating">
                    <input type="email" onblur="email_check_request()" name="email" id="email" class="form-control" id="floatingInput" placeholder="">
                    <label for="floatingInput">Email address</label>
                  </div>
                  <button type="button" onclick="return activation_request()" id="send_request" class="btn btn-primary w-100 py-2 mt-2">Send Request</button>
              </main>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-3"></div>
        <?php
          $obj->set_action('login_process.php');
          $obj->set_method('POST');
          $obj->sign_in();
        ?>
        <div class="col-3"></div>
    </div>
</div>
<?php

$obj->footer(); 
?>
