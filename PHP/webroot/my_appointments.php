<?php 
    include_once ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php'); 
    include_once ('../includes/authentication/User.php');
    include_once ('../includes/form/FormGenerator.php');
    include_once ("../includes/database/database_connect.php");
    include_once ('../includes/appointment/Appointment.php');

    $User = User::get_user_info();
	
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
	
    if($User->Role == "Patient"){
		$PatientID=Appointment::retrieve_patientID($User->UserID);
        $Patient_Appointment_DR  = Appointment::get_patient_appointment_doctor($PatientID);
        $Patient_Appointment_TH = Appointment::get_patient_appointment_therapist($PatientID);
		
		$_SESSION['PatientID']=$PatientID;
		
?> 
        <h1>My Appointments</h1>
        <div id="content">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#Doctor-Appointments">Doctor Appointments</a></li>
                <li><a data-toggle="tab" href="#Therapist-Appointments">Therapist Appointments</a></li>
            </ul>
            <div class="tab-content well">
                <div id="Doctor-Appointments" class="tab-pane fade in active">
                 
						<div id="Doctor">
							<?php
								FormGenerator::generate_form("Add Doctor Appointment", "../includes/appointment/patient_appointmentScheduling.php", "Doctor Appointment added Succeeded",
								[
									FormGenerator::generate_element("Appointment_Date", "date", []),
									FormGenerator::generate_element("Doctor_ID", "select", $Doctors_Select)
								]
							);
							?>
					</div>
					   <h2 class="text-center">Doctor Appointments</h2>
                    <table class="table well">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Doctor Name</th>
                                <th>View Details<th/>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($Patient_Appointment_DR as $PatientAppointment) { ?>
                                <tr>
                                    <td><?= $PatientAppointment ["Appointment_Date"];?></td>
                                    <td><?= $PatientAppointment["First_Name"] . " " . $PatientAppointment["Last_Name"]; ?></td>
                                    <td>
                                        <a href="my_appointment.php?AppointmentID=<?= $PatientAppointment["AppointmentID"]; ?>&Type=Doctor" class="btn btn-info" role="button">View Details</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div  id="Therapist-Appointments" class="tab-pane fade in">

							<div id="Therapist">
							<?php
								FormGenerator::generate_form("Add Therapist Appointment", "../includes/appointment/patient_appointmentScheduling.php", "Therapist Appointment added Succeeded",
								[
									FormGenerator::generate_element("Appointment_Date", "date", []),
									FormGenerator::generate_element("Therapist_ID", "select", $Therapist_Select)
								]
							);
							?>
						</div>
					<h2 class="text-center">Therapist Appointments</h2>
                    <table class="table well">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Therapist Name</th>
                                <th>View Details<th/>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($Patient_Appointment_TH as $Patient_Appointment_TH) { ?>
                                <tr>
                                    <td><?= $Patient_Appointment_TH ["Appointment_Date"]; ?></td>
                                    <td><?= $Patient_Appointment_TH["First_Name"] . " " . $Patient_Appointment_TH["Last_Name"]; ?></td>
                                    <td>
                                        <a href="my_appointment.php?AppointmentID=<?= $Patient_Appointment_TH["AppointmentID"] ?>&Type=Therapist" class="btn btn-info" role="button">View Details</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<?php 
    }
    elseif($User->Role == "Doctor" || $User->Role == "Therapist"){
        $Appointments = null;
        if($User->Role == "Doctor"){
            $DoctorID = User::retrieve_doctor($User->UserID)["DoctorID"];
            $Appointments = Appointment::get_doctor_appointments($DoctorID);
        }
        else{
            $TherapistID = User::retrieve_therapist($User->UserID)["TherapistID"];
            $Appointments = Appointment::get_therapist_appointments($TherapistID);
        }
?>
        <h2>My scheduled <?= $User->Role; ?> Appointments</h2>
        <table class="table well">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Patient Name</th>
                    <th>View Details<th/>
                </tr>
            </thead>
            <tbody>
                <?php foreach($Appointments as $Appointment) { ?>
                    <tr>
                        <td><?= $Appointment ["Appointment_Date"];?></td>
                        <td><?= $Appointment ["First_Name"] . " " . $Appointment["Last_Name"];?></td>
						<td>
                            <a href="my_appointment.php?AppointmentID=<?= $Appointment["AppointmentID"]; ?>&Type=<?= $User->Role; ?>" class="btn btn-info" role="button">View Details</a>
                        </td>
						<td>
						  <?php 
							  if($User->Role=="Doctor")
							  {?>
										<div class="col-sm-offset-2 col-lg-4">
										  <a href="DoctorAppointment.php?AppointmentID=<?= $Appointment["AppointmentID"]; ?>&Type=<?= $User->Role; ?>" class="btn btn-info" role="button">Update Record</a>						
										</div>	
					    <?php } 
		             	      elseif($User->Role=="Therapist")
						      {?>
										<div class="col-sm-offset-2 col-lg-4">
										  <a href="TherapistAppointment.php?AppointmentID=<?= $Appointment["AppointmentID"]; ?>&Type=<?= $User->Role; ?>" class="btn btn-info" role="button">Update Record</a>						
										</div>	
					     <?php }?>
						 </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
    }
    else{
        echo "This page is only for Patients, Doctors and Therapists";
    }
    include ('../includes/footer.php'); 
?>
