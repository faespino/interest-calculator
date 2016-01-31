<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Interest Calculator</title>
		<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/clock.js"></script>
		<script src="js/showFields.js" type="text/javascript"></script>
		<script src="js/toControllers.js" type="text/javascript"></script>
		<link href="css/style.css" type="text/css" rel="stylesheet">
		<!--<link href="css/main.css" rel="stylesheet" type='text/css'>-->
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<?php 
			$rateErr = $amountErr = $termErr = "";
			$rate = $amount = $termErr = "";
			$payment = "hello";
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
			{
			
			//check rate input
				if (!isset($_POST["rate"]) || empty($_POST["rate"])) 
				{
					$rateErr = "Interest rate must be provider!";
					$rate = $_POST["rate"];
					echo '<script>$(document).ready(function(){$("#lrate").addClass("alert alert-danger")});</script>';
				//check if rate is a valid float or integer
				} else if (!is_numeric($_POST["rate"]))
				{
					$rateErr = "Interest rate must be a valid number eg. 4.5 or 3!";
					echo '<script>$(document).ready(function(){$("#lrate").addClass("alert alert-danger")});</script>';;
			 	} else
				{
				//if rate is valide number trim removes any plus or minus sign from user input, we don't need negative interest numbers
					$rate = trim($_POST["rate"], "-+");
					//echo "this is rate after urlecode" . $rate;
				}	
				
			//check amount input
				if (!isset($_POST["amount"] ) || empty($_POST["amount"])) 
				{
					$amountErr = "Amount of loan must be provided!";
					echo '<script>$(document).ready(function(){$("#lamount").addClass("alert alert-danger")});</script>';
				} else {
					$amount = $_POST["amount"];
				}	
			
			//check term input
				if (!isset($_POST["term"] ) || empty($_POST["term"])) 
				{
					$termErr = "The term period of your loan must be selected!";
					echo '<script>$(document).ready(function(){$("#lterm").addClass("alert alert-danger")});</script>';
				} else {
					$term = $_POST["term"];
				}
					
			}
	
			//if input passes validation, show calculate and show monthly payment
			if (isset($rate) && !empty($rate) && isset($amount) && !empty($amount) && isset($term) && !empty($term))
			{ 
				$percentage_rate = ( $rate / 100 ) / 12;
        $top = pow( 1 + $percentage_rate, $term);
        $bottom = pow(1 + $percentage_rate, $term) - 1;
        $payment = round(( $amount * $percentage_rate ) * ( $top / $bottom ), 2); 
		    // Show the Modal that displays info
				print '<script>$(document).ready(function(){ $("#myModal").modal("show"); });</script>';
			} 
		?>
		<div class="container">
			<h1 class="page-header"><span class="glyphicon glyphicon-calendar"></span> Loan Payment Calculator</h1>
		<h2>Enter Loan Information</h2>
			<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group" id="lrate">
					<label for="rate">Enter interest Rate: <span class="err">*<?php echo $rateErr; ?></span></label>
					<input type="text" class="form-control" name="rate" value="<?php echo $rate; ?>">
				</div>
				<div class="form-group" id="lamount">
					<label for="loanAmt">Amount of Loan: <span class="err">*<?php echo $amountErr; ?></span></label>
					<input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>" placeholder="$"> 
				</div>
				<div class="form-group" id="lterm">
					<label for="term">Term: <span>*<?php echo $termErr; ?></span></label>
					<div class="radio">
						<label class="radio-inline"><input type="radio" name="term" value="36" <?php if (isset($term) && $term == 36) { echo "checked"; } ?>>36 months</label>
						<label class="radio-inline"><input type="radio" name="term" value="60" <?php if (isset($term) && $term == 60) { echo "checked"; } ?>>60 months</label>
						<label class="radio-inline"><input type="radio" name="term" value="72" <?php if (isset($term) && $term == 72) { echo "checked"; } ?>>72 months</label>
					</div>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-default" name="payment" id="submit" pull-left>Calculate Monthly Payment</button>
				</div>
			</form>

		<!--DISPLAY MONTHLY PAYMENT IN MODAL-->
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Your Calulated Monthly Payment</h4>
					</div>
					<div class="modal-body">
						<h1>$<?php print $payment; ?></h1>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		</div>

	</body>
	</html>