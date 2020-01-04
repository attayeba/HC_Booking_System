<?php
    include_once("../database/database_connect.php");
    include_once("DoctorAppointment.php");
	session_start();
    //TODO check for access rights here, use die() function
    
    //Only execute this when form is submitted
    //Use <input type="hidden" name="submitted" value="true" />
    if(isset($_REQUEST["submitted"])){
        
        $errors = array();
		$DiagnosisID;
		
		
        // Get User data
		
		$DoctorAppointmentID = $_SESSION['DoctorAppointmentID'];
		
        $Doctor_Appointment= $DoctorAppointmentID;
		
		$Note = "";
		if(isset($_POST["Note"]) && !empty($_POST["Note"])){
			$Note = $_POST["Note"];
		}
		else{
			array_push($errors, "Prescription Notes is required");
		}

		$Diagnosis = "";
		if(isset($_POST["Diagnosis"]) && !empty($_POST["Diagnosis"])){
			$Diagnosis = $_POST["Diagnosis"];
		}
		else{
			array_push($errors, "Diagnosis description is required");
		}
		
		
		//If there are validation errors, display error message and stop page
        if(count($errors) > 0){
            echo implode("\n", $errors);
            die();
        }
		

		$connection->beginTransaction();

		$PrescriptionID=DoctorAppointment::create_prescription($Note,$Diagnosis);
		DoctorAppointment::create_doctor_appointment($Doctor_Appointment,$PrescriptionID);
		
        $connection->commit();
		echo "Patient Information Updated Successfully.";
    }
?>