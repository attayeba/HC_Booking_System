<?php 
    
    include_once("../database/database_connect.php");
    include_once("Payment.php");

    if(isset($_REQUEST["submitted"])){
        
        $errors = array();
		
		$AppointmentID = "";
        if(isset($_POST["AppointmentID"])){
            $AppointmentID = $_POST["AppointmentID"];
        }
		else
		{
			array_push($errors, "Appointment is required");
		}
		
		$Payment_Type = "";
        if(isset($_POST["Payment_Type"])){
            $Payment_Type = $_POST["Payment_Type"];
        }
		else
		{
			array_push($errors, "Payment type is required");
		}
		
		$Account_Number_for_card_or_cheque = "";
		if($Payment_Type != 1)
		{
			if(isset($_POST["Account_Number_for_card_or_cheque"]) && !empty($_POST["Account_Number_for_card_or_cheque"])){
				$Account_Number_for_card_or_cheque = $_POST["Account_Number_for_card_or_cheque"];
			}
			else
			{
				array_push($errors, "Account number for cards or cheque is required");
			}
		}

		
		$Amount;
        if(isset($_POST["Amount"])){
            $Amount = $_POST["Amount"];
        }
		else
		{
			array_push($errors, "Amount is required");
		}
		//If there are validation errors, display error message and stop page
        if(count($errors) > 0){
            echo implode($errors, "<br/>");
            die();
        }
		
        $connection->beginTransaction();
		
		if(Payment::payment_exists($AppointmentID))
		{
			echo "Thank you for wanting to give us more money, but no thanks!";
		}
		else
		{
			if($Payment_Type == Payment::Cash){
				Payment::create_Payment($Payment_Type,$AppointmentID,$Amount, null);
			}
			elseif($Payment_Type == Payment::Cheque){
				Payment::create_Payment($Payment_Type,$AppointmentID,$Amount, $Account_Number_for_card_or_cheque);
			}
			elseif($Payment_Type == Payment::Debit){
				Payment::create_DailyPayment($Payment_Type,$AppointmentID,$Amount, $Account_Number_for_card_or_cheque);
			}
			else{//$Payment_Type == Payment::Credit
				Payment::create_DailyPayment($Payment_Type,$AppointmentID,$Amount, $Account_Number_for_card_or_cheque);
			}

			echo "Thank you! Your payment has been received!";
        }

        
        $connection->commit();
        
	}
?>