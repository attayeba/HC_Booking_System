<?php
    include_once ("UserInfo.php");
    // User based functions
    class User{

        const Patient = "Patient";
        const Nurse = "Nurse";
        const Therapist = "Therapist";
        const Doctor = "Doctor";
        const Receptionist = "Receptionist";
		
		public static function retrieve_therapists()
		{
			global $connection;
			$stmt = $connection->prepare("SELECT TherapistID,UserInformation.First_Name,UserInformation.Last_Name 
												FROM Therapist, UserInformation
													WHERE Therapist.UserID = UserInformation.UserID");
			$stmt->execute();
			
			return $stmt->fetchAll();
		}
		
		public static function retrieve_patients()
		{
			global $connection;
			$stmt = $connection->prepare("SELECT PatientID, User.UserID, First_Name,Last_Name, Phone_Number, Age 
											FROM Patient, User, UserInformation 
												WHERE Patient.UserID = User.UserID AND User.UserID = UserInformation.UserID");					
			$stmt->execute();
			
			return $stmt->fetchAll();
		}

        public static function retrieve_patient($UserID){
            global $connection;
			$stmt = $connection->prepare("SELECT PatientID, User.UserID, First_Name, Last_Name, Phone_Number, Age 
											FROM Patient, User, UserInformation 
												WHERE Patient.UserID = User.UserID 
                                                AND User.UserID = UserInformation.UserID
                                                AND (User.UserID = :UserID OR Patient.UserID = :UserID)");
            $stmt->bindParam(':UserID', $UserID);					
			$stmt->execute();
			
			return $stmt->fetch();
        }
		
		public static function retrieve_doctors()
		{
			global $connection;
			$sql = 'SELECT DoctorID,UserInformation.First_Name,UserInformation.Last_Name 
						FROM Doctor, UserInformation
							WHERE Doctor.UserID = UserInformation.UserID';
			$stmt = $connection->prepare($sql);
			$stmt->execute();
			
			return $stmt->fetchAll();
		}

        public static function retrieve_doctor($UserID){
            global $connection;
			$stmt = $connection->prepare("SELECT DoctorID, User.UserID, First_Name,Last_Name, Phone_Number, Age 
											FROM Doctor, User, UserInformation 
												WHERE Doctor.UserID = User.UserID 
                                                AND User.UserID = UserInformation.UserID
                                                AND User.UserID = :UserID");
            $stmt->bindParam(':UserID', $UserID);					
			$stmt->execute();
			
			return $stmt->fetch();
        }

        public static function retrieve_therapist($UserID){
            global $connection;
			$stmt = $connection->prepare("SELECT TherapistID, User.UserID, First_Name,Last_Name, Phone_Number, Age 
											FROM Therapist, User, UserInformation 
												WHERE Therapist.UserID = User.UserID 
                                                AND User.UserID = UserInformation.UserID
                                                AND User.UserID = :UserID");
            $stmt->bindParam(':UserID', $UserID);					
			$stmt->execute();
			
			return $stmt->fetch();
        }

        // Gets user information on the specified user
        public static function retrieve_user($UserID){
            global $connection;
			$stmt = $connection->prepare("SELECT User.UserID, First_Name, Last_Name, Phone_Number, Age 
											FROM User, UserInformation 
                                            WHERE User.UserID = UserInformation.UserID
                                            AND User.UserID = :UserID");
            $stmt->bindParam(':UserID', $UserID);					
			$stmt->execute();
			
			return $stmt->fetch();
        }
		
        // Creates a user and returns their id
        public static function create_user($AccessRightsID, $Username, $Password){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO User VALUES(0, :AccessRightsID, :Username, :Password)"); 
            $stmt->bindParam(':AccessRightsID', $AccessRightsID);
            $stmt->bindParam(':Username', $Username);
            $stmt->bindParam(':Password', $Password);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        //Creates a user's user information
        public static function create_user_information($UserID, $First_Name, $Last_Name, $Phone_Number, $Age){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO UserInformation VALUES(0, :UserID, :First_Name, :Last_Name, :Phone_Number, :Age)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->bindParam(':First_Name', $First_Name);
            $stmt->bindParam(':Last_Name', $Last_Name);
            $stmt->bindParam(':Phone_Number', $Phone_Number);
            $stmt->bindParam(':Age', $Age);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        // Check  if username already exists
        public static function username_exists($Username){
            global $connection;
            $stmt = $connection->prepare("SELECT Username FROM User WHERE Username = :Username"); 
            $stmt->bindParam(':Username', $Username);
            $stmt->execute();
            $row = $stmt->fetch();
            return $stmt->rowCount() > 0;
        }

        // Gets access rights based on a role name
        public static function get_access_rights($Role){
            global $connection;
            $stmt = $connection->prepare("SELECT AccessRightsID FROM AccessRights WHERE Name = :Role"); 
            $stmt->bindParam(':Role', $Role);
            $stmt->execute();
            $row = $stmt->fetch();
            return $row["AccessRightsID"];
        }

        public static function login($Username, $Password){
            global $connection;
            $sql = 'SELECT UserID, Password, AccessLevel, Name FROM User
                    INNER JOIN AccessRights USING (AccessRightsID)
                    WHERE Username = :Username';
		
            $statement = $connection->prepare($sql);
            
            $statement->bindParam(':Username', $Username);
            
            $statement->execute();
            $row=$statement->fetch();
            
            // Make sure username is found
            if($statement->rowCount() && password_verify($Password, $row["Password"])){
                //Success
                $UserID = $row["UserID"];
                $AccessLevel = $row["AccessLevel"];
                $Role = $row["Name"];
                
                $userInfo = new UserInfo($UserID, $AccessLevel, $Role);
                
                session_start();

                $_SESSION["User"] = serialize($userInfo);
            }
            else{
                //Failure
                echo "The provided credentials are not correct";
            }
        }

        // Checks wether the user is logged in or not
        public static function loggedin(){
            return isset($_SESSION["User"]);
        }

        // Gets User session information as an object
        public static function get_user_info(){
            return unserialize($_SESSION["User"]);
        }

        // Ends the users session
        public static function logout(){
            unset($_SESSION["User"]);
        }

        // Gets the name of the logged in user
        public static function get_name(){
            $User = User::get_user_info();
            $UserID = $User->UserID;
            $User = User::retrieve_user($UserID);
            return $User["First_Name"] . " " . $User["Last_Name"];
        }

        // Create user with Doctor role
        public static function create_doctor($UserID, $Experience){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Doctor VALUES(0, :UserID, :Experience)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->bindParam(':Experience', $Experience);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        // Create user with Therapist role
        public static function create_therapist($UserID, $Experience){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Therapist VALUES(0, :UserID, :Experience)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->bindParam(':Experience', $Experience);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        // Create user with Nurse role
        public static function create_nurse($UserID){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Nurse VALUES(0, :UserID)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        // Create user with Receptionist role
        public static function create_receptionist($UserID){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Receptionist VALUES(0, :UserID)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            return $connection->lastInsertId();
        }

        // Create user with Patient role
        public static function create_patient($UserID){
            global $connection;
            $stmt = $connection->prepare("INSERT INTO Patient VALUES(0, :UserID)"); 
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            return $connection->lastInsertId();
        }

    }
?>