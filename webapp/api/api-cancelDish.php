<?php
include "config.php";
session_start();

$inventory_id = '';
$quantity = '';

$sql = "UPDATE order_items SET cancel_order='Yes', total_price = '0' WHERE order_id='" .$_POST["orderId"] ."' and item_id='".$_POST["itemId"]."'";
$toReturn = '';
if ($conn->query($sql) === TRUE) {
    //echo "done";
} else {
    echo $conn->error;
}

$sql = "UPDATE `order` SET `discount` = '0.00' WHERE `order`.`id` = " . $_POST['orderId'];
$toReturn = '';
if ($conn->query($sql) === TRUE) {
    //echo "done";
} else {
    echo $conn->error;
}





$conn->close();

return $toReturn;

?>
