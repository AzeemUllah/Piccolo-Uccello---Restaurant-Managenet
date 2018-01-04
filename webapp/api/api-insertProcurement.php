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
    $sql = "INSERT INTO `procurement` (`id`, `name`, `quantity`, `unit_price`, `order_date`, `arival_date`, `status`, `vendor_id`, `expire_date`, `quantity_unit`,`inventory_id`,`image`,`category`,`brand_name`) VALUES (NULL, '" . $_POST["name"] . "', '" . $_POST["quantity"] . "', '" . $_POST["unit_price"] . "', '" . $_POST["order_date"] . "', '" . $_POST["arival_date"] . "', 'No', NULL, '" . $_POST["expiry_date"] . "', '" . $_POST["quantity_unit"] . "', '" . $_POST["inventory_id"] . "','".$file."','".$_POST['itemCategory']."','".$_POST['brandName']."');";

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>
