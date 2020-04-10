<?php
    
    // Extract users information from the json
   


    
    // Connect to the database
    $conn = new mysqli("127.0.0.1", "ahmed", "2KDKRpen3%ty", "amazoffdb", "3306");
	//conn = new mysqli("sql9.freemysqlhosting.net", "sql9331274", "rkGBNLIgVj", "sql9331274", "3306");
	
    if ( $conn->connect_error )
    {
		sendResultInfoAsJson('couldnt connect!' . $conn->connect_error);
        //returnWithError( $conn->connect_error );
    }
    else
    {
        // Before inserting the user, check to make sure that username is not already taken
        $sql = "SELECT * FROM User";
		$result = $conn->query($sql);
		
		sendResultInfoAsJson('numrows = ' . $result->num_rows . '!');
        if ($result->num_rows > 0)
		{
			sendResultInfoAsJson('all good');
		}
		else
		{
			sendResultInfoAsJson('error: ' . $conn->error . '!');
		}
		
        // if ($result->num_rows > 0) {
			// sendResultInfoAsJson('got something!');
		// }
		// else
		// {
			// sendResultInfoAsJson('didnt get something!');
		// }
    }
    
    // Sends information queried from the database, to the javascript on the frontend as json
    function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }
    /*
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
	*/
?>