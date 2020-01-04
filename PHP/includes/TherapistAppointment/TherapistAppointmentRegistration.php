<?php
    include_once("../database/database_connect.php");
    include_once("TherapistAppointment.php");
	session_start();
    //TODO check for access rights here, use die() function
    
    //Only execute this when form is submitted
    //Use <input type="hidden" name="submitted" value="true" />
		
    if(isset($_REQUEST["submitted"])){
        
        $errors = array();
		$EquipmentID;
		$DiagnosisID;
		$TreatmentID;
		
        // Get User data

		$TherapistAppointmentID = $_SESSION['TherapistAppointmentID'];
		$Therapist_Appointment= $TherapistAppointmentID;

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
		
		$Treatment = "";
		if(isset($_POST["Treatment"]) && !empty($_POST["Treatment"])){
			$Treatment = $_POST["Treatment"];
		}
		else{
			array_push($errors, "Treatment description is required");
		}
		
		$Treatment_Cost = "";
		if(isset($_POST["Treatment_Cost"]) && !empty($_POST["Treatment_Cost"])){
			$Treatment_Cost = $_POST["Treatment_Cost"];
		}
		else{
			array_push($errors, "Treatment cost is required");
		}
		
		$Equipment = "";
		if(isset($_POST["Equipment"])){
			$Equipment = $_POST["Equipment"];
		}
		else{
			array_push($errors, "Equipment is is required for a treatment");
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
			
			$TreatmentID=TherapistAppointment::create_treatment($EquipmentID,$Treatment,$Treatment_Cost);
		}
		

		$PrescriptionID=TherapistAppointment::create_prescription($Note,$Diagnosis);
		TherapistAppointment::create_therapist_appointment($Therapist_Appointment,$PrescriptionID,$TreatmentID);
		$_SESSION["PrescriptionID"]=$PrescriptionID;
		$_SESSION["AppointmentID"]=TherapistAppointment::retrieve_appointmentID($Therapist_Appointment);
		$_SESSION["TherapistID"]=TherapistAppointment::retrieve_therapistID($Therapist_Appointment);
		
		
        $connection->commit();
		
		echo "Patient Information Updated Successfully. <br/>";
		echo "Would you like to add a treatment?.\n <a href='treatment.php'>Click here.</a>";
		
    }
?>