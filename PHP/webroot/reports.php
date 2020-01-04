<?php 
    $pageTitle = 'Reports';
    include ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php');
    include_once ('../includes/form/FormGenerator.php'); 
    include_once ('../includes/reports/Reports.php');
    include_once ("../includes/authentication/User.php");
    AccessRights::verify_admin_receptionist();
?>

<div id="content">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Therapist-Patients">Therapist Number Of Patients</a></li>
		<li><a data-toggle="tab" href="#Equipment-Never-Used">Equipment Never Used</a></li>
        <li><a data-toggle="tab" href="#Patient-Visitation-List">Patient Visitation List</a></li>
        <li><a data-toggle="tab" href="#Therapist-Visitation-List">Therapist Visitation List</a></li>
	</ul>
	<div class="tab-content well">
        <div id="Therapist-Patients" class="tab-pane fade in active">
            <?php
                FormGenerator::generate_form("Therapist Number Of Patients", "../includes/reports/number_of_patients.php", "Search successful",
					[
						FormGenerator::generate_element("Start_Date", "date", []),
                        FormGenerator::generate_element("End_Date", "date", [])
					]
				);
            ?>
		</div>
        <div id="Equipment-Never-Used" class="tab-pane fade in">
            <h2>Equipment Never Used</h2>
			<table class="table">
                <thead>
                    <tr>
                        <th>Equipment ID</th>
                        <th>Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $EquipmentNeverUsed = Reports::equipment_never_used();
                        foreach($EquipmentNeverUsed as $Equipment) { ?>
                        <tr>
                            <td><?= $Equipment["EquipmentID"]; ?></td>
                            <td><?= $Equipment["Name"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
        <div id="Patient-Visitation-List" class="tab-pane fade in">
            <h2>Patient Visitation List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Patient ID</th>
                        <th>Patient Name</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $Patients = Reports::patients_list();
                        foreach($Patients as $Patient) { ?>
                        <tr>
                            <td><?= $Patient["PatientID"]; ?></td>
                            <td><?= $Patient["Patient_Name"]; ?></td>
                            <td><?= $Patient["Phone_Number"]; ?></td>
                            <td><?= $Patient["Age"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="Therapist-Visitation-List" class="tab-pane fade in">
            <h2>Therapist Visitation List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Therapist ID</th>
                        <th>Therapist Name</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>Experience</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $Therapists = Reports::therapist_list();
                        foreach($Therapists as $Therapist) { ?>
                        <tr>
                            <td><?= $Therapist["TherapistID"]; ?></td>
                            <td><?= $Therapist["Therapist_Name"]; ?></td>
                            <td><?= $Therapist["Phone_Number"]; ?></td>
                            <td><?= $Therapist["Age"]; ?></td>
                            <td><?= $Therapist["Experience"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
	</div>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Working-Therapist-List">Working Therapist List</a></li>
        <li><a data-toggle="tab" href="#Patient-Reservations">Patient Reservations</a></li>
        <li><a data-toggle="tab" href="#Doctor-Therapist-Availabilities">Doctor/Therapist-Availabilities</a></li>
        <li><a data-toggle="tab" href="#Patient-Count">Number Of Patients</a></li>
    </ul>
    <div class="tab-content well">
        <div id="Working-Therapist-List" class="tab-pane fade in active">
            <h2>Working Therapist List</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Therapist ID</th>
                        <th>Therapist Name</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>Experience</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $WorkingTherapists = Reports::working_therapist_list();
                        foreach($WorkingTherapists as $WorkingTherapist) { ?>
                        <tr>
                            <td><?= $WorkingTherapist["TherapistID"]; ?></td>
                            <td><?= $WorkingTherapist["Therapist_Name"]; ?></td>
                            <td><?= $WorkingTherapist["Phone_Number"]; ?></td>
                            <td><?= $WorkingTherapist["Age"]; ?></td>
                            <td><?= $WorkingTherapist["Experience"]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div id="Patient-Reservations" class="tab-pane fade in">
            <?php
                $Patients = User::retrieve_patients();
                $Patients_Select = array();
                foreach($Patients as $Patient){
                    array_push($Patients_Select, [$Patient["PatientID"], $Patient["First_Name"] . " " . $Patient["Last_Name"]]);
                }
	
                FormGenerator::generate_form("Patient Reservations", "../includes/reports/patient_reservations.php", "Search successful",
					[
						FormGenerator::generate_element("Patient", "select", $Patients_Select)
					]
				);
            ?>
		</div>
        <div id="Doctor-Therapist-Availabilities" class="tab-pane fade in">
            <?php
                $Doctors = User::retrieve_doctors();
                $Doctors_Select = array();
                foreach($Doctors as $Doctor){
                    array_push($Doctors_Select, [$Doctor["DoctorID"], $Doctor["First_Name"] . " " . $Doctor["Last_Name"]]);
                }

                $Therapists = User::retrieve_therapists();
                $Therapists_Select = array();
                foreach($Therapists as $Therapist){
                    array_push($Therapists_Select, [$Therapist["TherapistID"], $Therapist["First_Name"] . " " . $Therapist["Last_Name"]]);
                }
            ?>
            <div class="row">
                <div class="col-md-6">
                    <?php
                        FormGenerator::generate_form("Doctor Availabilities", "../includes/reports/availabilities.php", "Search successful",
                            [
                                FormGenerator::generate_element("Doctor", "select", $Doctors_Select),
                                FormGenerator::generate_element("Start_Date", "date", []),
                                FormGenerator::generate_element("End_Date", "date", [])
                            ]
                        );
                    ?>
                </div>
                <div class="col-md-6">
                    <?php
                        FormGenerator::generate_form("Therapist Availabilities", "../includes/reports/availabilities.php", "Search successful",
                            [
                                FormGenerator::generate_element("Therapist", "select", $Therapists_Select),
                                FormGenerator::generate_element("Start_Date", "date", []),
                                FormGenerator::generate_element("End_Date", "date", [])
                            ]
                        );
                    ?>
                </div>
            </div>
		</div>
        <div id="Patient-Count" class="tab-pane fade in">
            <?php
                $NumPatients = Reports::num_patients();
            ?>
            <h1>There are a total of <?= $NumPatients; ?> patients registered at the center.</h1>
        </div>
	</div>	
		
	<ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Therapist-Daily-Appointments">Therapist Daily Appointments</a></li>
        <li><a data-toggle="tab" href="#Doctor-Daily-Appointments">Doctor Daily Appointments</a></li>
        <li><a data-toggle="tab" href="#Patient-Daily-Appointments">Patient Daily Appointments</a></li>
    </ul>
    <div class="tab-content well">
		<div id="Therapist-Daily-Appointments" class="tab-pane fade in active">
		    <?php
                $Therapist = User::retrieve_therapists();
                $Therapist_Select = array();
				
				foreach($Therapist as $Therapist){
                    array_push($Therapist_Select, [$Therapist["TherapistID"], $Therapist["First_Name"] . " " .$Therapist["Last_Name"]]);
                }

                FormGenerator::generate_form("Therapist Daily Appointments", "../includes/reports/therapist_daily_appointments.php", "Search successful",
					[
						FormGenerator::generate_element("Therapist", "select", $Therapist_Select)
					]
				);
            ?>
        </div>
		<div id="Doctor-Daily-Appointments" class="tab-pane fade in">
		    <?php
                $Doctors = User::retrieve_doctors();
                $Doctor_Select = array();
				
				foreach($Doctors as $Doctor){
                    array_push($Doctor_Select, [$Doctor["DoctorID"], $Doctor["First_Name"] . " " .$Doctor["Last_Name"]]);
                }

                FormGenerator::generate_form("Doctor Daily Appointments", "../includes/reports/doctor_daily_appointments.php", "Search successful",
					[
						FormGenerator::generate_element("Doctor", "select", $Doctor_Select)
					]
				);
            ?>
        </div>
        <div id="Patient-Daily-Appointments" class="tab-pane fade in">
		    <?php
                $Patients = User::retrieve_patients();
                $Patient_Select = array();
				
				foreach($Patients as $Patient){
                    array_push($Patient_Select, [$Patient["PatientID"], $Patient["First_Name"] . " " . $Patient["Last_Name"]]);
                }

                FormGenerator::generate_form("Patient Daily Appointments", "../includes/reports/patient_daily_appointments.php", "Search successful",
					[
						FormGenerator::generate_element("Patient", "select", $Patient_Select)
					]
				);
            ?>
        </div>
	</div>
</div>

<?php include ('../includes/footer.php'); ?>