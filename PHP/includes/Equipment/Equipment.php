<?php

    //Class to add equipment
    class Equipment{
		
        // Creates an equipment
        public static function create_equipment($Name){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Equipment VALUES(0,:Name)"); 
            $stmt->bindParam(':Name', $Name);
            $stmt->execute();
            return $connection->lastInsertId();
        }
	
		public static function retrieve_equipment()
		{
			global $connection;
			$stmt=$connection->prepare("SELECT EquipmentID,Name FROM Equipment");
			$stmt->execute();
			return $stmt->fetchAll();
		}
		
        // Check  if equipment already exists
        public static function equipment_exists($Name){
            global $connection;
			$stmt = $connection->prepare("SELECT Name FROM Equipment WHERE Name = :Name"); 
            $stmt->bindParam(':Name', $Name);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
        }
	
    }
?>