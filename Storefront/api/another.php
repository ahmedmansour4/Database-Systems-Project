 <?php
    //Sample Database Connection Syntax for PHP and MySQL.
    
    //Connect To Database

    $hostname="107.180.109.30";
    $username="ahmed";
    $password="2KDKRpen3%ty";
    $dbname="amazoffdb";

    
    $link = mysqli_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
    mysqli_select_db($dbname);
    
    # Check If Record Exists
    sendResultInfoAsJson(mysqli_connect_error());
	
    $query = "SELECT * FROM User";
    
    $result = mysqli_query($query);
    
    if($result){
        while($row = mysqli_fetch_array($result)){
            $name = $row["UserId"];
            sendResultInfoAsJson( "Name: ".$name."<br/>");
        }
    }
	else
	{
		sendResultInfoAsJson("didnt go in to if");
		echo "Test";
	}
	
	function sendResultInfoAsJson( $obj )
    {
        header('Content-type: application/json');
        echo $obj;
    }
?>