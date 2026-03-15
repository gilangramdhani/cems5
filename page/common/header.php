<?php
if (!DEFINED('FILE_ACCESS') or FILE_ACCESS !== TRUE) {
	exit("Sorry, you're doing something that is not normal! \r\n Please do normally.");
}
/* if ($_SESSION['status'] == 'double') {
	header('Location: double');
} */
if (!isset($_SESSION['id'])) {
	header('Location: login');
}
if (isset($_SESSION['id'])) {
	$user_id = $_SESSION['id'];
	$userQuery = mysqli_query($con, "select * from user where user_id = '$user_id'");
	$userData = mysqli_fetch_array($userQuery, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html class="not-loading" lang="en" data-textdirection="ltr">
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
		// Deteksi apakah sedang di folder /cems5/ (biasanya di XAMPP) atau di root / (Docker)
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
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/pickers/pickadate/pickadate.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/extensions/toastr.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/charts/apexcharts.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/tables/datatable/datatables.min.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/ui/prism.min.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/bootstrap-extended.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/colors.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/components.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/themes/dark-layout.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/themes/semi-dark-layout.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/plugins/extensions/toastr.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/core/menu/menu-types/vertical-menu.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/css/forms/select/select2.min.css">
		<link rel="stylesheet" type="text/css" href="app-assets/vendors/fullcalendar/main.min.css">
		<!--
		<link rel="stylesheet" type="text/css" href="app-assets/css/pages/app-todo.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/pages/dashboard-analytics.css">
		<link rel="stylesheet" type="text/css" href="app-assets/css/pages/card-analytics.css">
		-->
		<link rel="stylesheet" type="text/css" href="assets/css/style.css">
		<style>
		.tooltip-inner {
			max-width: 600px;
			text-align: left;
		}
		.fc-daygrid-day-frame {
			height : 100px;
		}
		.fc-event-title-container, .fc-daygrid-event {
			text-align: center;
			margin-top : -10px;
			padding: 10px 0;
			background-color: #fff;
			background-image: url('assets/cloud.jpg');
			background-repeat: no-repeat;
			background-position: center center;
		}
		.fc-event-title {
			font-size: 24px;
			color: #000;			
		}
		</style>
	</head>
	<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns navbar-sticky fixed-footer todo-application" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns" data-layout="semi-dark-layout">
		<div class="content-overlay"></div>
		<div class="header-navbar-shadow"></div>
		<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
			<div class="navbar-wrapper">
				<div class="navbar-container content">
					<div class="navbar-collapse" id="navbar-mobile">
						<div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
							<ul class="nav navbar-nav">
								<li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon feather icon-menu"></i></a></li>
							</ul>
							<!--
							<ul class="nav navbar-nav bookmark-icons">
								<li class="nav-item d-none d-lg-block"><a class="nav-link" href="todo" data-toggle="tooltip" data-placement="top" title="Todo"><i class="ficon feather icon-check-square"></i></a></li>
								<li class="nav-item d-none d-lg-block"><a class="nav-link" href="#" data-toggle="tooltip" data-placement="top" title="Chat"><i class="ficon feather icon-message-square"></i></a></li>
							</ul>
							-->
						</div>
						<ul class="nav navbar-nav float-right">
							<li class="nav-item d-none d-lg-block">
								<a class="nav-link nav-link-expand"><i class="ficon feather icon-maximize"></i></a>
							</li>
							<li class="dropdown dropdown-notification nav-item">
								<a id="notif_count" class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i></a>
								<ul id="notif_list" class="dropdown-menu dropdown-menu-media dropdown-menu-right">
									<li class="dropdown-menu-header">
										<div class="dropdown-header m-0 p-2">
											<span class="white"><strong>Notifications</strong></span>
										</div>
									</li>
									<li id="notif_data" class="scrollable-container media-list">
									</li>
									<li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center" href="notif/all_notif">Read all notifications</a></li>
								</ul>
							</li>
							<li class="dropdown dropdown-user nav-item">
								<a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
									<div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600"><?php echo $userData['user_full']; ?></span><span class="user-status"><?php echo $userData['user_role']; ?></span></div><span><img class="round" src="app-assets/images/profile/user.jpg" alt="avatar" height="40" width="40"></span>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="myprofile"><i class="feather icon-user"></i> My Profile</a>
<?php
if ($userData['user_role'] <> 'Operator') {
?>
									<a class="dropdown-item" href="setting"><i class="feather icon-settings"></i> Settings</a>
<?php
}
?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="logout"><i class="feather icon-power"></i> Logout</a>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</nav>
		<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
			<div class="navbar-header">
				<ul class="nav navbar-nav flex-row">
					<li class="nav-item mr-auto"><a class="navbar-brand" href="./">
							<div class="brand-logo"></div>
							<h2 class="brand-text mb-0">CEMS</h2>
						</a></li>
					<li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary" data-ticon="icon-disc"></i></a></li>
				</ul>
			</div>
			<div class="shadow-bottom"></div>
			<?php include sidebar; ?>
		</div>
<?php
}
?>
