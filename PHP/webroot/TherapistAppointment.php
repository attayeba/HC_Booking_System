<?php 
    $pageTitle = 'TherapistAppointment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
	include_once('../includes/database/database_connect.php');
	include_once('../includes/TherapistAppointment/TherapistAppointment.php');
	
	$AppointmentID=$_GET['AppointmentID'];
	$TherapistAppointmentID=TherapistAppointment::retrieve_therapist_appointmentID($AppointmentID);
	$_SESSION['TherapistAppointmentID']=$TherapistAppointmentID;
	
	$TheAptInfo=TherapistAppointment::retrieve_therapist_appointment($TherapistAppointmentID);

	$Therapist_Select = array();
	foreach($TheAptInfo as $TheAptInfo){
		array_push($Therapist_Select, [$TheAptInfo["DoctorsNote"], $TheAptInfo["Diagnosis"], $TheAptInfo["Description"], $TheAptInfo["Cost"], $TheAptInfo["Name"]]);
	}
	
	if(count($Therapist_Select) > 0)
	{
		$TheNote=$TheAptInfo["DoctorsNote"];
		$TheDiagnosis=$TheAptInfo["Diagnosis"];
		$TheTreatment=$TheAptInfo["Description"];
		$TheTrCost=$TheAptInfo["Cost"];
		$TheEquipment=$TheAptInfo["Name"];
	}
	else
	{
		$TheNote="";
		$TheDiagnosis="";
		$TheTreatment="";
		$TheTrCost="";
		$TheEquipment="";
	}

?>

<div id="content">
    <?php
        FormGenerator::generate_form("Therapist Patient Appointment Update", "../includes/TherapistAppointment/TherapistAppointmentRegistration.php", "Registration Succeeded",
            [
				FormGenerator::generate_element("Note", "text", [$TheNote]),
				FormGenerator::generate_element("Diagnosis", "text", [$TheDiagnosis]),
				FormGenerator::generate_element("Treatment", "text", [$TheTreatment]),
				FormGenerator::generate_element("Treatment_Cost", "text", [$TheTrCost]),
				FormGenerator::generate_element("Equipment", "text", [$TheEquipment])
            ]
        );
    ?>
</div>

<?php include('../includes/footer.php'); ?>