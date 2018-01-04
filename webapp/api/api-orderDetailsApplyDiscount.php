<?php
include "config.php";
session_start();


$sql = "UPDATE `order` SET `total_cost` = '".$_POST['total_cost']."', `sub_total` = '".$_POST['sub_total']."', `gen_sales_tax` = '".$_POST['gen_sales_tax']."', `discount` = '".$_POST['discount']."' WHERE `order`.`id` = ".$_POST['order_id'].";";
$toReturn = '';
if ($conn->query($sql) === TRUE) {
    $toReturn = "1";
} else {
    echo $conn->error;
}


$conn->close();


echo $toReturn;

?>
