<?php
    
    // Extract users information from the json
    $inData = getRequestInfo();
    
	$userName = $inData["userName"];
	$firstName = $inData["firstName"];
	$lastName = $inData["lastName"];
	$email = $inData["email"];
	$phone = $inData["phone"];
	$address = $inData["address"];
    $passWord = md5($inData["passWord"]);
	$adminFlag = $inData["adminFlag"];
   
	sendResultInfoAsJson('email = ' . $email . '!');
	var_dump($inData);
    
    // Connect to the database
    $conn = new mysqli("127.0.0.1", "ahmed", "2KDKRpen3%ty", "amazoffdb", 3306);
    
    if ( $conn->connect_error )
    {
        returnWithError( $conn->connect_error );
    }
    else
    {
        // Before inserting the user, check to make sure that username is not already taken
        $checkStatus = "SELECT Email FROM User WHERE email='".$email."'";
        $alreadyTaken = $conn->query($checkStatus);
        
        // If the query returned any rows, that indicates there is alredy a user with that username
        if ($alreadyTaken->num_rows > 0)
        {
            returnWithError( "That userName is not available" );
        }
        else
        {
            // If we get here the username is available. This creates an sql statement to insert the user
            $sql = "INSERT INTO User (UserName, FirstName, LastName, Email, Phone, Address, PassHashed, AdminFlag) VALUES ('$userName', '$firstName', '$lastName', '$email', '$phone', '$address', '$passWord', '$adminFlag')";
            
            // Insert the user, if its not possible, return an error
            if ( $result = $conn->query($sql) != TRUE)
            {
                returnWithError ($conn->error);
            }
            
            returnWithInfo();
        }
        
        // Lastly close the connection to the database
        $conn->close();
    }
    
    // This function will decode the json package
    function getRequestInfo()
    {

        return json_decode(file_get_contents('php://input'), true);
    }
    
    // Sends information queried from the database, to the javascript on the frontend as json
    function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }
    
    // Creates a json package with information provided by the user
    function returnWithInfo()
    {
        $retValue = '{"Mess":' . "Success!" . '}';
        sendResultInfoAsJson($retValue);
    }
    
    // Creates a json package with an error message
    function returnWithError( $err )
    {
        $retValue = '{"error":"' . $err . '"}';
        sendResultInfoAsJson( $retValue );
    }
?>