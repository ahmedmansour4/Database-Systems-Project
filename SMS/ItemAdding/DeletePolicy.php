<?php

    

    // Extract users information from the json

    $inData = getRequestInfo();

    


	$product = $inData["deleteVal"];

   

    

    // Connect to the database

    $conn = new mysqli("127.0.0.1", "connor", "!AHpd45y@!dT", "amazoffdb", 3306);

    

    if ( $conn->connect_error )

    {

        returnWithError( $conn->connect_error );

    }

    else

    {

        // Before inserting the user, check to make sure that DiscountCategoryId is not already taken

        $checkStatus = "SELECT DiscountCategoryId FROM DiscountCategory WHERE DiscountCategoryId='".$product."'";

        $alreadyTaken = $conn->query($checkStatus);

        

        // If the query returned any rows, that indicates there is alredy a user with that productID

        if ($alreadyTaken->num_rows == 0)

        {

            returnWithError( "That DiscountCategoryId is not available" );

        }

        else

        {

            // If we get here the productID is available. This creates an sql statement to insert the user

            $sql = "DELETE FROM DiscountCategory WHERE DiscountCategoryId='".$product."'";

            

            // Insert the product, if its not possible, return an error

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

		$myJSON = json_encode($obj);

        echo $myJSON;

    }

    

    // Creates a json package with information provided by the user

    function returnWithInfo()

    {

        $retValue->Mess = "Success!";

        sendResultInfoAsJson($retValue);

    }

    

    // Creates a json package with an error message

    function returnWithError( $err )

    {

        $retValue->error = $err;

        sendResultInfoAsJson( $retValue );

    }

?>