<?php 
    $pageTitle = 'Payment';
    include('../includes/header.php'); 
	include_once('../includes/authentication/AccessRights.php'); 
    include_once('../includes/form/FormGenerator.php');
	include_once('../includes/database/database_connect.php');
	include_once('../includes/Payment/Payment.php');

	if(isset($_GET["AppointmentID"]) && !empty($_GET["AppointmentID"])){
        $AppointmentID = $_GET["AppointmentID"];
?>

<div id="content">
	<ul class="nav nav-tabs">
		<li class="active"><a data-toggle="tab" href="#Payment">Payment</a></li>
		<li><a data-toggle="tab" href="#Cash">Cash</a></li>
	</ul>
	<div class="tab-content well">
		<div id="Payment" class="tab-pane fade in active">
        <div id="content">
            <h1 class="text-center">Payment for Appointment <?= $AppointmentID?></h1>
            <?php
                FormGenerator::generate_form("Make Payment", "../includes/Payment/PaymentRegistration.php", "",
                    [
                        FormGenerator::generate_element("Payment_Type", "select", 
                        [
                            [Payment::Cheque,   "Cheque"],
                            [Payment::Debit,    "Debit"], 
                            [Payment::Credit,   "Credit"]
                        ]),
                        FormGenerator::generate_element("Account_Number_for_card_or_cheque", "text", []),
                        FormGenerator::generate_element("Amount", "text", []),
                        FormGenerator::generate_element("AppointmentID", "hidden", [$AppointmentID]),

                    ]
                );
            ?>
        </div>
		</div>
		<div id="Cash" class="tab-pane fade">
        <div id="content">
            <h1 class="text-center">Payment for Appointment <?= $AppointmentID?></h1>
            <?php
                FormGenerator::generate_form("Make Cash Payment", "../includes/Payment/PaymentRegistration.php", "",
                    [
                        FormGenerator::generate_element("Amount", "text", []),
                        FormGenerator::generate_element("AppointmentID", "hidden", [$AppointmentID]),
						FormGenerator::generate_element("Payment_Type", "hidden", [Payment::Cash])
                    ]
                );
            ?>
        </div>
		</div>
	</div>
</div>
		
<?php 
    }
    else{
        echo "invalid appointment";
    }
    include('../includes/footer.php'); 
?>

<?php include('../includes/footer.php'); ?>
