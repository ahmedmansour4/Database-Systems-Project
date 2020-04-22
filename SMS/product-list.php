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
        <title>SMS Products Potential Buyers</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.png">
        <link href="assets/styles.css" rel="stylesheet">
    </head>
    <body>
        <div class="header">
            <img src="Amazoff-logo.png" style="height: 150px;" />
            <span style="padding-left: 100px;">Store Management System - Products Potential Buyers</span>            
        </div>        
        <section class="container" >
            <div class="sidenav">
                <div id="cssmenu">
                    <ul>
                       <li><a href="index.php"><span>Home</span></a></li>
                       <li><a href="discount-list.php">Expired Codes</a></li>
                       <li class="active"><a href="product-list.php">Potential Buyers</a></li>
                       <li><a href="ItemAdding/AdjustDiscountPolicy.html">Adjust Discounts</a></li>
					   <li><a href="ItemAdding/AddItem.html">Add or Delete Items</a></li>
                    </ul>
                </div>
            </div>
            <div class="main">
                <table>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Opportunities</th>
                    </tr>
                    <?php while($row = $resultObj->fetch_assoc()): ?>
                        <tr>
                            <td><?=$row['ProductID']?></td>
                            <td><a style="color: white; text-decoration: underline;" href="<?=$row['AmazonUrl']?>"><?=$row['Name']?></a></td>
                            <td><?=$row['Price']?></td>
                            <td><img style="width:100px" src="<?=$row['ImageUrl']?>" /></td>
                            <td><a style="color: white; text-decoration: underline;" href="possible-buyer-list.php?<?=$row['ProductID']?>">See possible <?=$row['PossibleBuyers']?> buyers</a></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
            
        </section>
    </body>
</html>

<?php

$resultObj->close();
$connection->close();

?>