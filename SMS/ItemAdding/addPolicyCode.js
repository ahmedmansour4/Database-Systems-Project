

var urlBase = 'http://' + 'amazoff.fun/';

var extension = 'php';

console.log(urlBase);

var userId = 0;

var firstName = "";

var lastName = "";

var CID = 0;



function doChangePolicy() {

	var id = document.getElementById("discountID").value;
	
	var percent = document.getElementById("discountPercent").value;
	
	var minPeople = document.getElementById("minNumberOfPeopleNeeded").value;

	var maxPeople = document.getElementById("maxNumberOfPeopleNeeded").value;

	

	console.log(id + " " + percent + " " + minPeople + " " + maxPeople);


	

	var jsonPayload = '{ "id" : "' + id + '", "percent" : "' + percent + '", "minPeople" : "' + minPeople + '", "maxPeople" : "' + maxPeople + '" }';

	console.log("asdasdbefore send1		!");

	//var jsonPayload = '{ "email" : "' + email + '" }';

	console.log("before send1		!");

	var url = urlBase + 'sms/ItemAdding/AddPolicy.' + extension;

	var xhr = new XMLHttpRequest();

	console.log("before send2!");

	xhr.open("POST", url, false);

	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {

		console.log("before send!3");

		xhr.send(jsonPayload);

		console.log("got past send!");

		var jsonObject = JSON.parse(xhr.responseText);

		console.log("successfully parsed!");

		console.log(jsonObject.Mess);

		var message = jsonObject.Mess;



		if (message != "Success!" || message != "ReferenceError: saveCookie is not defined") {

			document.getElementById("addPolicyResult").innerHTML = message;

			return;

		}

		saveCookie();



		window.location.href = "../index.html";

	}

	catch (err) {

		return document.getElementById("addPolicyResult").innerHTML = err;

	}

}