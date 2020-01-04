<?php
    include_once ('AccessRights.php'); 
    include_once ('../includes/form/FormGenerator.php');
?>


<div id="content">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#Patient-Registration">Patient Registration</a></li>
		<li><a data-toggle="tab" href="#Employee-Registration">Employee Registration</a></li>
	</ul>
	<div class="tab-content well">
		<div id="Patient-Registration" class="tab-pane fade in active">
			<?php
				FormGenerator::generate_form("Patient Register", "../includes/authentication/registration.php", "Registration Succeeded",
				[
					FormGenerator::generate_element("Referral", "text", []),
					FormGenerator::generate_element("Username", "text", []),
					FormGenerator::generate_element("Password", "password", []),
					FormGenerator::generate_element("First_Name", "text", []),
					FormGenerator::generate_element("Last_Name", "text", []),
					FormGenerator::generate_element("Phone_Number", "text", []),
					FormGenerator::generate_element("Age", "text", []),
					FormGenerator::generate_element("Role", "hidden", ["Patient"]),
				]
			);
			?>
		</div>
		<div id="Employee-Registration" class="tab-pane fade">
			<?php
			FormGenerator::generate_form("Employee Register", "../includes/authentication/registration.php", "Registration Succeeded",
            [
					FormGenerator::generate_element("Username", "text", []),
					FormGenerator::generate_element("Password", "password", []),
					FormGenerator::generate_element("Role", "select", ["Nurse", "Therapist", "Doctor", "Receptionist"]),
					FormGenerator::generate_element("Experience", "text", []),
					FormGenerator::generate_element("First_Name", "text", []),
					FormGenerator::generate_element("Last_Name", "text", []),
					FormGenerator::generate_element("Phone_Number", "text", []),
					FormGenerator::generate_element("Age", "text", [])
			]
			);
			?>
		</div>
	</div>
</div>