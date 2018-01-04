<?php
include "config.php";
session_start();


$inventoryImage  =  $_REQUEST["inventoryImage"];


define('UPLOAD_DIR', '../uploads/');

$img = str_replace('data:image/png;base64,', '', $inventoryImage);
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.jpg';
$success = file_put_contents($file, $data);
//echo $success ? $file : 'Unable to save the file.';

if (strpos($file, '../') !== false) {
    $file = str_replace("../", "", $file);

    $sql = "UPDATE `inventory` SET `name` = '" . $_POST["name"] . "', `quantity_on_hand` = '" . $_POST["quantity"] . "', `unit_price` = '" . $_POST["unit_price"] . "',
  `expiry_date` = '" . $_POST["expiry_date"] . "',
 `quantity_unit` = '" . $_POST["quantity_unit"] . "' WHERE `inventory`.`id` = '" . $_POST["id"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
