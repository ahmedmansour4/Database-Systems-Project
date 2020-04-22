

var urlBase = 'http://' + 'amazoff.fun/';

var extension = 'php';

console.log(urlBase);

var userId = 0;

var firstName = "";

var lastName = "";

var CID = 0;



function doAddItem() {

	var id = document.getElementById("productID").value;
	
	var name = document.getElementById("productName").value;
	
	var description = document.getElementById("productDesc").value;

	var price = document.getElementById("productPrice").value;

	var amazonLink = document.getElementById("amazonLink").value;

	var imageLink = document.getElementById("imageLink").value;

	

	console.log(id + " " + name + " " + description + " " + price + " " + amazonLink + " " + imageLink);


	

	var jsonPayload = '{ "id" : "' + id + '", "name" : "' + name + '", "description" : "' + description + '", "price" : "' + price + '" , "amazonLink" : "' + amazonLink + '", "imageLink" : "' + imageLink + '" }';

	console.log("asdasdbefore send1		!");
	//document.getElementById("addItemResult").innerHTML = "before Send1";

	//var jsonPayload = '{ "email" : "' + email + '" }';

	console.log("before send1		!");

	var url = urlBase + 'sms/ItemAdding/AddItem.' + extension;

	var xhr = new XMLHttpRequest();

	console.log("before send2!");
	//document.getElementById("addItemResult").innerHTML = "before send 2";

	xhr.open("POST", url, false);

	xhr.setRequestHeader("Content-type", "application/json; charset=UTF-8");

	try {

		console.log("before send!3");
		//document.getElementById("addItemResult").innerHTML = "before Send!3";

		xhr.send(jsonPayload);

		console.log("got past send!");

		var jsonObject = JSON.parse(xhr.responseText);

		console.log("successfully parsed!");

		console.log(jsonObject.Mess);

		var message = jsonObject.Mess;



		if (message != "Success!" || message != "ReferenceError: saveCookie is not defined") {

			document.getElementById("addItemResult").innerHTML = message;

			return;

		}

		saveCookie();



		window.location.href = "../index.html";

	}

	catch (err) {

		return document.getElementById("addItemResult").innerHTML = err;

	}

}