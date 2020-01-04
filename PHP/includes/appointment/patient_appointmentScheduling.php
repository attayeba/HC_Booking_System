<?php
	include_once("../database/database_connect.php");
	include_once("Appointment.php");
	session_start();

	
	global $connection;
	$errors = array();
	$previousID;
	$PatientID = $_SESSION['PatientID'];
	
	if(isset($_POST["Appointment_Date"]) && !empty($_POST["Appointment_Date"]))
	{	
		$enteredDate=$_POST["Appointment_Date"];
		
		if($enteredDate!=null)
		{
			$diff=Appointment::appointment_time_constraint($enteredDate);
			$diffStringSign=$diff->format("%R");
			$diffStringValue=$diff->format("%a");
			
			if($diffStringSign=="-")
			{
				array_push($errors, "Appointment can not be in the past!");
			}
			elseif($diffStringValue<56)
			{
				array_push($errors, "Appointment must be at least 8 weeks away. To get an earlier appointment, contact us");	
			}
			elseif(Appointment::multiple_appointment_patient($PatientID,$enteredDate))
			{
				array_push($errors, "You already have an appointment on this day. PLease chose another date");
			}
			else
			{
						if(isset($_POST["Therapist_ID"]))
						{
							if(Appointment::multiple_appointment_therapist($_POST["Therapist_ID"],$enteredDate))
							{
								array_push($errors, "Therapist is busy on said day. Please chose another date or therapist");
							}
							else
							{
									$previousID = Appointment::book_appointment($PatientID,$_POST["Appointment_Date"]);
									Appointment::book_therapist_appointment($previousID,$_POST["Therapist_ID"],null,null);
									echo "Successfully added therapists appointment.";
							}
						}
						elseif(isset($_POST["Doctor_ID"]))
						{	
							if(Appointment::multiple_appointment_doctor($_POST["Doctor_ID"],$enteredDate))
							{
								array_push($errors, "Doctor is busy on said day. Please chose another date or doctor");
							}
							else
							{
								$previousID = Appointment::book_appointment($PatientID,$_POST["Appointment_Date"]);
								Appointment::book_doctor_appointment($previousID,$_POST["Doctor_ID"],null);
										
							//echo "Successfully added doctors appointment.";  */
?>				
						<h2>Successfully added doctors appointment.</h2>
						<script>
							window.location.replace("");
						</script>
<?php
							}
						}
						else
						{
							array_push($errors, "You must fill up all of the required fields");
						}
			}
		}

	}
	else
	{
		echo "Please check the required fields.";
	}
	
	if(count($errors) > 0)
	{
		echo implode("/n", $errors);
		die();
	}
			
?>