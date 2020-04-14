<?php

include 'assets/include.php';
include 'assets/db.php';

if(isset($_SESSION['UserId']))
{
    $userId = $_SESSION['UserId'];
    $username = $_SESSION['UserName'];
    $firstname = $_SESSION['FirstName'];
    $lastname = $_SESSION['LastName'];
    $email = $_SESSION['Email'];
    $isAdmin = $_SESSION['isAdmin'];
}
else
{
    header('Location: login.php');   
}

$query = "
    SELECT 
        ProductID,
        `Name`,
        Description,
        Price,
        AmazonUrl,
        ImageUrl,
        (`amazoffdb`.`fnGetSuggestedBuyerCount`(ProductID)) PossibleBuyers
    FROM amazoffdb.Product;";

$resultObj = $connection->query($query);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Product List</title>
    </head>
    <body>
        <div id="Header">
            <h2>
                    Product list
            </h2>
        </div>        
        <div id="Body">
            <table>
                <tr>
                    <th>Product ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Amazon Url</th>
                    <th>Image Url</th>
                    <th>Possible Buyers</th>
                </tr>
                <?php while($row = $resultObj->fetch_assoc()): ?>
                    <tr>
                        <td><?=$row['ProductID']?></td>
                        <td><?=$row['Name']?></td>
                        <td><?=$row['Description']?></td>
                        <td><?=$row['Price']?></td>
                        <td><?=$row['AmazonUrl']?></td>
                        <td><?=$row['ImageUrl']?></td>
                        <td><a href="possible-buyer-list.php?<?=$row['ProductID']?>"><?=$row['PossibleBuyers']?></a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <a href="index.php">Go back home.</a>
	</body>
</html>

<?php

$resultObj->close();
$connection->close();

?>