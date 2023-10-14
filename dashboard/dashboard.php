<?php 
require '../require/general_library.php';

$obj = new general();
$obj->dashboard_header();

$obj->dashboard_navbar();

if (isset($_GET['msg'])) {
	// echo $_GET['email'];
	$email = $_GET['email'];
	// echo $email;
	?>
	<div aria-live="polite" aria-atomic="true" class="bg-body-secondary position-relative bd-example-toasts rounded-3 mt-5">
		<div class="toast-container p-3 top-50 end-0 translate-middle-y mt-5" id="toastPlacement">
			<div class="toast show">
			<div class="toast-header">
				<img src="../images/logo.png" class=" me-2 img-fluid"  width="32" height="32" alt="...">
				<strong class="me-auto">Blogger</strong>
				<button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
			</div>
			<div class="toast-body">
			<strong class="primary"><?php echo $_GET['msg'] ?></strong><br>
				Email has sended to the user<br><br>
				<button onclick="download_file('<?php echo $email ?>')" class=" btn btn-primary float-end btn-sm mx-2">Download PDF</button>
				<!-- <button onclick="generate_file('<?php echo $email ?>')" class=" btn btn-info float-end btn-sm">Generate PDF</button> -->
				<br><br>
			</div>
			</div>
		</div>
	</div>
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


<div class="container-fluid">
	<!-- <div id="state_msg"></div> -->
  <div class="row">    
<?php
$obj->dashboard_sidebar();
?>
    <!-- Main Content Area Start's -->
    <div id="main_content_area" class="col-md-9 mx-auto" style="margin-bottom: 50px;">
    </div>
      <!--Main Content Area End's-->
  </div>
</div>

<?php
$obj->dashboard_footer();
?>