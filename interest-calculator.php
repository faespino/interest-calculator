<?php 
	require('app/calculations.php');
?>
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
		<script>
			$(document).ready(function() {
				//this function sends user input data to server for processing
				//if successful successCallback is called
				function postRequest(postData, successCallback) {
					var request = 
						$.ajax({
							url: "app/calculations.php",
							method: "POST",
							data: postData		
						})
					request.done(successCallback);	
				}
				
				//this function is called when a request to the server is successful
				//it returns the data from the server and appends it to the html body
				function successCallback(data) {
					console.log("this is data from sever, ", data);
					$('body').append(data);
				}
	
				//when the user submits the form, we send their data through the serialize 
				//function that handles spaces in user input
				//then we make a request to the server that will process the data
				$('#submitInfo').on('click', function(event){
						event.preventDefault();
						var postData = $('#calc').serialize();
						console.log("this is postData sent to the server, ", postData);
						postRequest(postData, successCallback);
				});
			});
		
		
		</script>
		<link href="css/style.css" type="text/css" rel="stylesheet">
		<!--<link href="css/main.css" rel="stylesheet" type='text/css'>-->
		<link href='https://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="container">
			<h1 class="page-header"><span class="glyphicon glyphicon-calendar"></span> Loan Payment Calculator</h1>
		<h2>Enter Loan Information</h2>
			<form role="form" id="calc" name="calc1">
				<div class="form-group" id="lrate">
					<label for="rate">Enter interest Rate: <span class="err">*<?php echo $rateErr; ?></span></label>
					<input type="text" class="form-control" name="rate" value="<?php echo $rate; ?>" placeholder="e.g. 3.4">
				</div>
				<div class="form-group" id="lamount">
					<label for="loanAmt">Amount of Loan: <span class="err">*<?php echo $amountErr; ?></span></label>
					<input type="text" class="form-control" name="amount" value="<?php echo $amount; ?>" placeholder="e.g 5000"> 
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
					<button type="submit" class="btn btn-default" name="payment" id="submitInfo" pull-left>Calculate Monthly Payment</button>

					<button type="reset" class="btn btn-default pull-right" name="payment" id="resetForm">Reset Form</button>
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
						<h1 id="payment"></h1>
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