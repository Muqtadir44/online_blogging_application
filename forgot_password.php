<?php

require 'require/general_library.php';

$obj = new general();
$obj->header();
$obj->navbar();

if (isset($_GET['msg'])) {
  ?>
    <div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
        <div class="toast-container p-3 top-0 start-50 translate-middle-x" id="toastPlacement">
            <div class="toast show">
                <div class="toast-body">
                    <button type="button" class="btn-close me-2 m-auto float-end" data-bs-dismiss="toast" aria-label="Close"></button>
                    <strong class="<?php echo $_GET['color'] ?>"><?php echo $_GET['msg'] ?></strong><br>
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
          $obj->set_action("forgot_password_process.php");
          $obj->set_method("POST");
          $obj->forgot_password();
        ?>
        <div class="col-3"></div>
    </div>
</div>

<div class="fixed-bottom">
<?php
$obj->footer();
?>
</div>