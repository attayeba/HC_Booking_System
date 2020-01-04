<?php 
    $pageTitle = 'Registration';
    include ('../includes/header.php'); 
    include_once ('../includes/authentication/AccessRights.php'); 
    include_once ('../includes/authentication/User.php');
    include_once ('../includes/form/FormGenerator.php'); 
    AccessRights::verify_admin_receptionist();
    $Patients = User::retrieve_patients();
?>

<div id="content">
    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#Patients-List">Patients List</a></li>
        <li><a data-toggle="tab" href="#Patient-Search">Patient Search</a></li>
	</ul>
	<div class="tab-content well">
        <div id="Patients-List" class="tab-pane fade in active">
            <h2>Patients</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>PHN</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Age</th>
                        <th>View Appointments</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($Patients as $Patient) { ?>
                        <tr>
                            <td><?= sprintf("%08d", $Patient["UserID"]); ?></td>
                            <td><?= $Patient["First_Name"]; ?></td>
                            <td><?= $Patient["Last_Name"]; ?></td>
                            <td><?= $Patient["Phone_Number"]; ?></td>
                            <td><?= $Patient["Age"]; ?></td>
                            <td><a class="btn btn-primary" href="patient_appointments.php?PatientID=<?= $Patient["PatientID"]; ?>">View Appointments</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
		</div>
        <div id="Patient-Search" class="tab-pane fade in">
			<?php
                FormGenerator::generate_form("Patient Search", "../includes/authentication/patient_search.php", "Search successful",
					[
						FormGenerator::generate_element("PHN", "text", [])
					]
				);
            ?>
		</div>
	</div>

    
</div>

<?php include('../includes/footer.php'); ?>