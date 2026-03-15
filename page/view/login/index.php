<?php
ob_start();
session_start();
if (isset($_SESSION['id'])) {
	header('Location: ./');
}
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="author" content="">
		<title>CEMS</title>
		<?php
		$request_uri = $_SERVER['REQUEST_URI'];
		if (strpos($request_uri, '/cems5/') !== false) {
			$base_path = '/cems5/';
		} else {
			$base_path = '/';
		}
		?>
		<base href="<?php echo $base_path; ?>" />
		<link rel="apple-touch-icon" href="app-assets/images/ico/apple-icon-120.png">
		<link rel="shortcut icon" type="image/x-icon" href="app-assets/images/ico/favicon.ico">
		<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/vendors.min.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/toastr.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/core/colors/palette-gradient.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/toastr.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/pages/authentication.css">
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	</head>
	<body class="vertical-layout vertical-menu-modern semi-dark-layout 1-column  navbar-floating footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column" data-layout="semi-dark-layout">
		<div class="app-content content">
			<div class="content-overlay"></div>
			<div class="header-navbar-shadow"></div>
			<div class="content-wrapper">
				<div class="content-header row">
				</div>
				<div class="content-body">
					<section class="row flexbox-container">
						<div class="col-xl-7 col-10 d-flex justify-content-center">
							<div class="card bg-authentication rounded-0 mb-0 w-100">
								<div class="row m-0">
									<div class="col-lg-6 d-lg-block d-none text-center align-self-center px-1 py-0">
										<img src="app-assets/images/pages/lock-screen.png" alt="branding logo">
									</div>
									<div class="col-lg-6 col-12 p-0">
										<div class="card rounded-0 mb-0 px-2 pb-2">
											<div class="card-header pb-1">
												<div class="card-title">
													<h4 class="mb-0">CEMS GATEWAY</h4>
												</div>
											</div>
											<p class="px-2">Welcome back, please login to your account.</p>
											<div class="card-content">
												<div class="card-body pt-1">
													<form id="login_form" method="post">
														<fieldset class="form-label-group position-relative has-icon-left">
															<input id="user_email" type="email" class="form-control" placeholder="Email" autocomplete="off" required>
															<div class="form-control-position">
																<i class="feather icon-mail"></i>
															</div>
															<label for="user_email">Email</label>
														</fieldset>
														<fieldset class="form-label-group position-relative has-icon-left">
															<input id="user_pass" type="password" class="form-control" placeholder="Password" required>
															<div class="form-control-position">
																<i class="feather icon-lock"></i>
															</div>
															<label for="user_pass">Password</label>
														</fieldset>
														<button id="login_btn" type="button" class="btn btn-primary float-right">Login</button>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
		<script src="app-assets/vendors/js/vendors.min.js"></script>
		<script src="app-assets/vendors/js/extensions/toastr.min.js"></script>
		<script src="app-assets/js/core/app-menu.js"></script>
		<script src="app-assets/js/core/app.js"></script>
		<script src="app-assets/js/scripts/components.js"></script>
		<script src="page/view/login/script.js"></script>
	</body>
</html>