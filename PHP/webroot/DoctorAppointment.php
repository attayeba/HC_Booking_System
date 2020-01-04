<?php 
    $pageTitle = 'DoctorAppointment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
	include_once('../includes/database/database_connect.php');
	include_once('../includes/DoctorAppointment/DoctorAppointment.php');
	
	$AppointmentID=$_GET['AppointmentID'];
	$DoctorAppointmentID=DoctorAppointment::retrieve_doctor_appointmentID($AppointmentID);
	$_SESSION['DoctorAppointmentID']=$DoctorAppointmentID;
	
	$DocAptInfo=DoctorAppointment::retrive_doctor_appointment($AppointmentID);
	
	$Doctor_Select = array();
	foreach($DocAptInfo as $DocAptInfo){
		array_push($Doctor_Select, [$DocAptInfo["DoctorsNote"], $DocAptInfo["Diagnosis"]]);
	}
	
	if(count($Doctor_Select) > 0)
	{
		$DocNote=$DocAptInfo["DoctorsNote"];
		$DocDiagnosis=$DocAptInfo["Diagnosis"];
	}
	else
	{
		$DocNote="";
		$DocDiagnosis="";
	}
	
?>

<div id="content">
    <?php
        FormGenerator::generate_form("Doctor Patient Appointment Update", "../includes/DoctorAppointment/DoctorAppointmentRegistration.php", "Registration Succeeded",
            [
				FormGenerator::generate_element("Note", "text", [$DocNote]),
				FormGenerator::generate_element("Diagnosis", "text", [$DocDiagnosis])
			]
        );
    ?>
</div>

<?php include('../includes/footer.php'); ?>