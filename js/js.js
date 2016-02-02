$(document).ready(function() {
	//if users hits the reset button, clear form by 
	//removing all data an error messages and alerts
	$('#resetForm').on('click', function(){
		$('div').removeClass('alert alert-danger');
		$('.rateErr').empty();
		$('.amountErr').empty();
	});	
	
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