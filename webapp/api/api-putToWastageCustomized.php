<?php
include "config.php";
session_start();

$unit_price = '';
$inventoryImage =  $_REQUEST["image"];
$toReturn = 0;

define('UPLOAD_DIR', '../uploads/');

$img = str_replace('data:image/png;base64,', '', $inventoryImage);
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.jpg';
$success = file_put_contents($file, $data);

if (strpos($file, '../') !== false) {
    $file = str_replace("../", "", $file);

    $sql = "select unit_price from inventory where id=".$_POST['inventoryId'];

    if ($conn->query($sql) === TRUE) {
        $unit_price = $row['unit_price'];
        $toReturn = 1;
    } else {
        echo $conn->error;
    }


    $conn2 = new mysqli("localhost", "root", "", "resturant");
    $sql2 = "INSERT INTO `wastage` (`id`, `inventory_id`, `order_id`, `quantity`, `cost`, `approved`, `category`,`image`)
              VALUES (NULL, '".$_POST['inventoryId']."', NULL, '".$_POST['quantity']."', '".$unit_price."', 'No', '".$_POST['categoryType']."', '".$file."');";
    if ($conn2->query($sql2) === TRUE) {
        $toReturn = "1";
    } else {
        echo "Error: " . $sql2 . "<br>" . $conn2->error;
    }


    $conn3 = new mysqli("localhost", "root", "", "resturant");
    $sql3 = "UPDATE `inventory` SET `quantity_on_hand` = quantity_on_hand-".$_POST['quantity']." WHERE `inventory`.`id` =". $_POST['inventoryId'];
    if ($conn3->query($sql3) === TRUE) {
        $toReturn = "1";
    } else {
        echo "Error: " . $sql3 . "<br>" . $conn3->error;
    }



}


$conn->close();
echo $toReturn;

?>
