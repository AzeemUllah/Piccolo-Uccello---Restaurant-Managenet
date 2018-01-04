<?php
include "config.php";
session_start();

$inventory_id = '';
$quantity = '';

$sql = "UPDATE order_items SET wastage_status='Yes', total_price = '0' WHERE order_id='" .$_POST["orderId"] ."' and item_id='".$_POST["itemId"]."'";
$toReturn = '';
if ($conn->query($sql) === TRUE) {
    //echo "done";
} else {
    echo $conn->error;
}


$conn2=mysqli_connect("localhost", "root", "", "resturant");
$sql2 = "select ir.inventory_id, ir.quantity_used, i.unit_price from  item_recipes ir, inventory i where item_id = ".$_POST['itemId']." and ir.inventory_id = i.id";

if ($result2=mysqli_query($conn2,$sql2))
{
    // Fetch one and one row
    while ($row2=mysqli_fetch_row($result2))
    {
        $conn3=mysqli_connect("localhost", "root", "", "resturant");
        $sql3 = "INSERT INTO `wastage` (`id`, `inventory_id`, `order_id`, `quantity`, `cost`, `approved`)
                  VALUES (NULL, '".$row2[0]."', '".$_POST["orderId"]."', '".$row2[1]."', '".$row2[2]."', 'No');";
        $inventory_id = $row2[0];
        $quantity = $row2[1];
        if ($result3=mysqli_query($conn3,$sql3))
        {
          $toReturn = "1";
        }
    }
    // Free result set
    mysqli_free_result($result2);
}

mysqli_close($conn2);

mysqli_close($conn3);


$conn4=mysqli_connect("localhost", "root", "", "resturant");
$sql4 = "UPDATE `inventory` SET `quantity_on_hand` = quantity_on_hand-".$quantity." WHERE `inventory`.`id` = ".$inventory_id.";";
if (!($result4=mysqli_query($conn4,$sql4))) {
// Fetch one and one row
    echo "error";
}


$sql = "UPDATE `order` SET `discount` = '0.00' WHERE `order`.`id` = " . $_POST['orderId'];

if ($conn->query($sql) === TRUE) {
    //echo "done";
} else {
    echo $conn->error;
}







$conn->close();

return $toReturn;

?>
