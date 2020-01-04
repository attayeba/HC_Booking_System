<?php

	include_once("../database/database_connect.php");
	include_once("TherapistAppointment.php");
	session_start();

    //Execute when form is sumbitted
	if(isset($_REQUEST["submitted"])){
		
		$AppointmentID = $_SESSION['AppointmentID'];
		$PrescriptionID=$_SESSION["PrescriptionID"];
		$TherapistID=$_SESSION["TherapistID"];
		
		$errors = array();
						
		//Get equipment information
		
		$Treatment = "";
		if(isset($_POST["Treatment"]) && !empty($_POST["Treatment"])){
			$Treatment = $_POST["Treatment"];
		}
		else{
			array_push($errors, "Treatment description is required");
		}

		$Cost = "";
		if(isset($_POST["Cost"]) && !empty($_POST["Treatment"])){
			$Cost = $_POST["Cost"];
		}
		else{
			array_push($errors, "Treatment cost is required");
		}
		
		$Equipment = "";
		if(isset($_POST["Equipment"])){
			$Equipment = $_POST["Equipment"];
		}
		else{
			array_push($errors, "Equipment is required");
		}
		
		//If there are validation errors, display error message and stop page
        if(count($errors) > 0){
            echo implode("\n", $errors);
            die();
        }

		
		$connection->beginTransaction();
		
		if(TherapistAppointment::treatment_exists($Treatment))
		{
			$TreatmentID=TherapistAppointment::retrieve_treatmentID($Treatment);
		}
		else
		{
			if(TherapistAppointment::equipment_exists($Equipment))
			{
				$EquipmentID=TherapistAppointment::retrieve_equipmentID($Equipment);
			}
			else
			{
				$EquipmentID=TherapistAppointment::create_equipment($Equipment);
			}
			
			$TreatmentID=TherapistAppointment::create_treatment($EquipmentID,$Treatment,$Cost);
		}
		
		TherapistAppointment::add_treatment($AppointmentID,$TherapistID,$PrescriptionID,$TreatmentID);
				

		$connection->commit();
		
		echo "Treatment added Successfully. <br/>";
		echo "Would you like to add a treatment?.\n <a href='treatment.php'>Click here.</a>";
		
	}
?>