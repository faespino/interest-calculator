$(document).ready(function() {
	//if users hits the reset button, clear form by 
	//removing all data an error messages and alerts
	$('#resetForm').on('click', function(){
		$('div').removeClass('alert alert-danger');
		$('span.termErr').removeClass('alert alert-danger');
		$('.rateErr').empty();
		$('.amountErr').empty();
		$('.termErr').empty();
	});	
	
	//this function sends user input data to server for processing
	//if successful successCallback is called 
	//if request to server fails, failureCallBack is called
	function postRequest(postData, successCallback, failureCallBack) {
		var request = 
			$.ajax({
				url: "app/calculations.php",
				method: "POST",
				data: postData		
			})
			request.done(successCallback);
			request.fail(failureCallback)
	}
				
	//this function is called when a request to the server is successful
	//it returns the data from the server and appends it to the html body
	function successCallback(data) {
		console.log("this is data from sever, ", data);
		$('body').append(data);
	}
	
	
	//this function is called when a request to the server is unsuccessful
	//it informs the user of the error sent back to the server
	function failureCallback(xhr, status) {
				console.log("this is xhr, ", xhr)
		console.log("this is status from sever, ", status.status + status.statusText);

		//$('body').append(data);
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