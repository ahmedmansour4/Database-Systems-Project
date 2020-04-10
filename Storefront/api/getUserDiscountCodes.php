<?php

	$inData = getRequestInfo();
	
	$UserId = $inData["UserId"];
	$Password = $inData["Password"];
	
	$conn = new mysqli("107.180.47.58", "jason", "Qv#CBVhfxb77", "3306", "amazoffdb");
	
	if ($conn->connect_error)
	{
		returnWithError($conn->connect_error);
	}
	else
	{
		// SQL statement checks to make sure the UserID and Password combo are valid. If invalid, the statement will output no relation.
		// If valid, then it will display all of the User's discount codes.
		$sql = "SELECT DiscountCode FROM amazoffdb.Order O INNER JOIN (SELECT U.UserId FROM amazoffdb.User U WHERE U.UserId = $UserId AND U.Password = $Password) U2 ON U2.UserId = O.UserId;";
		
		$result = $conn->query($sql);
		$userDiscountCodes = getResults($result);
		
        if ($userDiscountCodes == "")
        {
            returnWithError("No Discount Codes Found");
        }
        else
        {
            returnWithInfo($userDiscountCodes);
        }
        $conn->close();
	}

	function getRequestInfo()
    {
		return json_decode(file_get_contents('php://input'), true);
    }

    function getResults($result)
    {
        $searchResults = "";
        $searchCount = 0;
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                if ($searchCount > 0)
                {
                    $searchResults .= "\n";
                }
                $searchCount++;
                $searchResults .= '"' . $row["Discount"] . '"';
            }
        }
        return $searchResults;
    }    

    function sendResultInfoAsJson($obj)
    {
        header('Content-type: application/json');
        echo $obj;
    }
   
    function returnWithInfo($searchResults)
    {
        $retValue = '{"results":[' . $searchResults . '],"error":""}';
        sendResultInfoAsJson($retValue);
    }

	function returnWithError($err)
		{
			$retValue = '{"error":"' . $err . '"}';
			sendResultInfoAsJson($retValue);
		}

?>