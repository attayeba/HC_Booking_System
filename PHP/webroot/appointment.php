<?php 
	$pageTitle = 'New Appointment';
	include ('../includes/header.php'); 
	include_once ('../includes/form/FormGenerator.php');
	include_once ("../includes/authentication/User.php");
	include_once ("../includes/database/database_connect.php");
	
	$Patients = User::retrieve_patients();
	$Patients_Select = array();
	foreach($Patients as $Patient){
		array_push($Patients_Select, [$Patient["PatientID"], $Patient["First_Name"] . " " . $Patient["Last_Name"]]);
	}
	
	$Doctors = User::retrieve_doctors();
	$Doctors_Select = array();
	foreach($Doctors as $Doctor){
		array_push($Doctors_Select, [$Doctor["DoctorID"], $Doctor["First_Name"] . " " . $Doctor["Last_Name"]]);
	}
	
	$Therapists = User::retrieve_therapists();
	$Therapist_Select = array();
	foreach($Therapists as $Therapist){
		array_push($Therapist_Select, [$Therapist["TherapistID"], $Therapist["First_Name"] . " " . $Therapist["Last_Name"]]);
	}
?>
<div id="content">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#Doctor">Doctor</a></li>
		<li><a data-toggle="tab" href="#Therapist">Therapist</a></li>
	</ul>
	<div class="tab-content well">
		<div id="Doctor" class="tab-pane fade in active">
			<?php
				FormGenerator::generate_form("Add Doctor Appointment", "../includes/appointment/AppointmentScheduling.php", "Doctor Appointment added Succeeded",
					[
						FormGenerator::generate_element("Appointment_Date", "date", []),
						FormGenerator::generate_element("Patient_ID", "select", $Patients_Select),
						FormGenerator::generate_element("Doctor_ID", "select", $Doctors_Select)

					]
				);
			?>
		</div>
		<div id="Therapist" class="tab-pane fade">
			<?php
				FormGenerator::generate_form("Add Therapist Appointment", "../includes/appointment/AppointmentScheduling.php", "Doctor Appointment added Succeeded",
					[
						FormGenerator::generate_element("Appointment_Date", "date", []),
						FormGenerator::generate_element("Patient_ID", "select", $Patients_Select),
						FormGenerator::generate_element("Therapist_ID", "select", $Therapist_Select)

					]
				);
			?>
		</div>
	</div>
</div>
<?php include('../includes/footer.php'); ?>

