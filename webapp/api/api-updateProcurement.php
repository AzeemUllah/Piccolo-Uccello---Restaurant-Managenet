<?php
include "config.php";
session_start();


$cosineImage =  $_REQUEST["procurementImage"];

define('UPLOAD_DIR', '../uploads/');

$img = str_replace('data:image/png;base64,', '', $cosineImage);
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.jpg';
$success = file_put_contents($file, $data);
//echo $success ? $file : 'Unable to save the file.';

if (strpos($file, '../') !== false) {
    $file = str_replace("../", "", $file);
    $sql = "UPDATE `procurement` SET `name` = '" . $_POST["name"] . "', `quantity` = '" . $_POST["quantity"] . "', `unit_price` = '" . $_POST["unit_price"] . "',
 `order_date` = '" . $_POST["order_date"] . "', `arival_date` = '" . $_POST["arival_date"] . "', `expire_date` = '" . $_POST["expiry_date"] . "',
 `quantity_unit` = '" . $_POST["quantity_unit"] . "',`image` = '".$file."', `category` = '".$_POST['itemCategory']."' WHERE `procurement`.`id` = '" . $_POST["id"] . "'";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
