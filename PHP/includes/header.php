<?php 
	session_start();
	include_once ('../includes/authentication/User.php');
	include_once ('../includes/database/database_connect.php'); 
	include_once ('../includes/authentication/AccessRights.php');
	
	//redirect user to login page if not logged in
	if(basename($_SERVER['PHP_SELF']) != "login.php" && !User::loggedin()){
		header('Location: login.php');
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BSPC : <?= isset($pageTitle) ? $pageTitle : '' ?></title>
	<link rel=" shortcut icon" type="image/ico" href="../webroot/favicon.ico?v=1" />
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="../webroot/js/jquery.min.js"></script>
	<script>
		function IsJsonString(str) {
			try {
				JSON.parse(str);
			} catch (e) {
				return false;
			}
			return true;
		}
	</script>
</head>
<body>
	<div class="container">
		<div id="header">
			<div class="page-header">
				<h1>
					Bahamas Sports Physio Center
				</h1>
			</div>

			<!--Navbar-->
			<nav class="navbar navbar-inverse">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="#">BSPC</a>
					</div>
					<?php if(User::loggedin()) : ?>
						<ul class="nav navbar-nav">
							<li class=""><a href="index.php">Home</a></li>

							<?php if(AccessRights::require_admin_receptionist_access()): ?>
								<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Administration <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="registration.php">Registration</a></li>
										<li><a href="appointment.php">Appointment</a></li>
										<li><a href="patients.php">Patients</a></li>
										<li><a href="staff.php">Staff</a></li>
									</ul>
								</li>
							<?php endif; ?>

							<?php if(AccessRights::has_admin_receptionist_access()): ?>
								<li class=""><a href="reports.php">Reports</a></li>
							<?php endif; ?>

							<?php if(AccessRights::require_patient_access() || AccessRights::require_hcp_access()): ?>
								<li class=""><a href="my_appointments.php">Appointments</a></li>
							<?php endif; ?>
						</ul>
						<ul class="nav navbar-nav navbar-right">
							<li><a><?= User::get_name(); ?> (<?= User::get_user_info()->Role; ?>)</a></li>
							<li><a href="logout.php">Logout <span class="glyphicon glyphicon-log-in"> </span> </a></li>
						</ul>
					<?php endif; ?>
				</div>
			</nav>
		</div>