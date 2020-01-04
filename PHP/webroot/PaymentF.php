<?php 
    $pageTitle = 'Payment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
	include_once('../includes/database/database_connect.php');
	include_once('../includes/Payment/Payment.php');


/*    $Payment = Payment::retrieve_payment();
	$Payment_Select = array();
	foreach($Payment as $Payment){
		array_push($Payment_Select, [$Payment["PaymentType"], $Payment["AccountNumber"] . " " . $Payment["Amount"]]);
	}

    $DailyPayment = DailyPayment::retrieve_dailypayment();
	$DailyPayment_Select = array();
	foreach($DailyPayment as $DailyPayment){
		array_push($DailyPayment_Select, [$DailyPayment["PaymentType"], $DailyPayment["AccountNumber"] . " " . $DailyPayment["Amount"]]);
	}
	*/
	
?>

<div id="content">
    <?php
        FormGenerator::generate_form("Payment", "../includes/Payment/PaymentRegistration.php", "Registration Succeeded",
            [
				FormGenerator::generate_element("Payment_Type", "select", ["Cash","Credit","Debit","Cheque"]),
				FormGenerator::generate_element("Account_Number", "text", []),
				FormGenerator::generate_element("Amount", "text", [])
            ]
        );
    ?>
</div>

<?php include('../includes/footer.php'); ?>