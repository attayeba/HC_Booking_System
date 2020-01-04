<?php

	include_once("../database/database_connect.php");
	include_once("Equipment.php");

    //Execute when form is sumbitted
	if(isset($_REQUEST["submitted"])){
		
		$errors = array();
		
		
		//Get equipment information
		$Name = "";
		if(isset($_POST["Name"])){
			$Name = $_POST["Name"];
		}
		else{
			array_push($errors, "Equipment name is required");
		}
		
		if(Equipment::equipment_exists($Name)){
			array_push($errors, "Equipment already exists");
		}
		
		//If there are validation errors, display error message and stop page
        if(count($errors) > 0){
            echo implode("\n", $errors);
            die();
        }

		
		$connection->beginTransaction();
		
		//create the equipment
		Equipment::create_equipment($Name);
		

		$connection->commit();
		
	}
?>