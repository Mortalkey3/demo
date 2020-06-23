<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin E-Order dan E-Retur</title>
	<meta charset="UTF-8">
	<?php echo $style;?>
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(<?php echo base_url(); ?>assets/images/bg.jpg);">
					<span class="login100-form-title-1">
						ADMIN
					</span>
				</div>

				<form class="login100-form validate-form" action="<?php echo base_url();?>Admin/login" method="post">
					<div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
						<span class="label-input100">Username</span>
						<input class="input100" type="text" name="username" placeholder="Enter username" id="username">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Enter password" id="password">
						<span class="focus-input100"></span>
					</div>
					<div class="flex-sb-m w-full p-b-30 row">
							<div class="col-sm-8 col-md-6 col-lg-8">
								<?php if($this->session->flashdata('error'))
									{
										echo "<p class='text-center' style='color:#ff0000;'>". $this->session->flashdata('error')."</p>";
									} ?>
							</div>


							<div class="col-sm-4 col-md-6 col-lg-4">
								<button type="submit" class="btn btn-info btn-block" name="signin">
									Login
								</button>
							</div>
						</div>

				</form>
			</div>
		</div>
	</div>


</body>

<?php echo $script?>
</html>
