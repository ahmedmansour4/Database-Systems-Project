<?php

$connection = new mysqli($dbServer, $dbUserName, $dbPassword, $dbName, 3306);

if($connection->connect_errno)
{
    //echo "Database Connection Failed. Reason: ".$connection->connect_error;
    exit("Database Connection Failed. Reason: ".$connection->connect_error);
}

?>