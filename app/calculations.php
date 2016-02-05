<?php 
			$rateErr = $amountErr = $termErr = "";
			$rate = $amount = $payment = $termErr = "";

			
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
				//echo $_POST['rate'];
			//check rate input. Only integers and floating numbers are allowed. 
				if (!isset($_POST["rate"]) || empty($_POST["rate"])) 
				{
					$rateErr = "Interest rate must be provided!";
					//$rate = $_POST["rate"];
					echo '<script>$(document).ready(function(){$("#lrate").addClass("alert alert-danger"); $(".rateErr").html("*' . $rateErr . '");});</script>';
				//check if rate is a valid float or integer
				} else if (!is_numeric($_POST["rate"]))
				{
					$rateErr = "Interest rate must be a valid number eg. 4.5, 3, or 27!";
					echo '<script>$(document).ready(function(){$("#lrate").addClass("alert alert-danger"); $(".rateErr").html("*' . $rateErr . '");});</script>';
			 	} else
				{
				//if rate is valide number trim removes any plus or minus sign from user input, we don't need negative interest numbers
					$rate = trim($_POST["rate"], "-+");
					echo '<script>$("#lrate").removeClass("alert alert-danger"); $(".rateErr").html("*' . $rateErr . '");</script>';
					//echo "this is rate after urlecode" . $rate;
				}	
				
			//check amount input. Only integers and floating point numbers are allowed.
				if (!isset($_POST["amount"] ) || empty($_POST["amount"])) 
				{
					$amountErr = "Amount of loan must be provided!";
					echo '<script>$(document).ready(function(){$("#lamount").addClass("alert alert-danger"); $(".amountErr").html("*' . $amountErr . '");});</script>';
				} else if (!is_numeric($_POST["amount"]))
				{
					$amountErr = "Amount must be a valid number eg. if amount is $10,580 enter 10580";
					echo '<script>$(document).ready(function(){$("#lamount").addClass("alert alert-danger"); $(".amountErr").html("*' . $amountErr . '");});</script>';
				} else 
				{
					$amount = trim($_POST["amount"], "-+$,");
					echo '<script>$("#lamount").removeClass("alert alert-danger"); $(".amountErr").html("*' . $amountErr . '");</script>';
				}	
			
			//check term input
				if (!isset($_POST["term"] ) || empty($_POST["term"])) 
				{
					$termErr = "The term period of your loan must be selected!";
					echo '<script>$(document).ready(function(){$(".termErr").addClass("alert alert-danger"); $(".termErr").html("*' . $termErr . '");});</script>';
				} else {
					$term = $_POST["term"];
					echo '<script>$(".termErr").removeClass("alert alert-danger"); $(".termErr").html("*' . $termErr . '");</script>';
				}
					
			
	
			//if input passes validation, show calculate and show monthly payment
			if (isset($rate) && !empty($rate) && isset($amount) && !empty($amount) && isset($term) && !empty($term))
			{ 
				$percentage_rate = ( $rate / 100 ) / 12;
        $top = pow( 1 + $percentage_rate, $term);
        $bottom = pow(1 + $percentage_rate, $term) - 1;
        $payment = round(( $amount * $percentage_rate ) * ( $top / $bottom ), 2); 
		    // Show the Modal that displays info
				//echo "<p>succesfully connected to server</p>";
				print '<script>$(document).ready(function(){ $("#payment").html(' . $payment . '); $("#myModal").modal("show"); $(".amountErr").html("*' . $amountErr . '");});</script>';
			} 
		}
?>