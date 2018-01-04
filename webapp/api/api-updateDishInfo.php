<?php
include "config.php";
session_start();

$cosineName = $_POST["name"];
$cosineImage =  $_REQUEST["dishImageSrc"];


define('UPLOAD_DIR', '../uploads/');

$img = str_replace('data:image/png;base64,', '', $cosineImage);
$img = str_replace('data:image/jpeg;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.jpg';
$success = file_put_contents($file, $data);
//echo $success ? $file : 'Unable to save the file.';

if (strpos($file, '../') !== false) {
    $file = str_replace("../","",$file);
    $sql = "UPDATE `item` SET `name` = '".$_POST['name']."', `price_per_unit` = '".$_POST['dishPrice']."', `prepration_time` = '".$_POST['preprationTime']."', `category_type_id` = '".$_POST['cosineId']."', `dist_type_id` = '".$_POST['typeId']."', `desc` = '".$_POST['description']."', `image_url` = '".$file."', `avaliablity` = 'Y' WHERE `item`.`id` =" .$_POST["id"] ;

    if ($conn->query($sql) === TRUE) {
        echo "1";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
else{
    echo "0";
}





$conn->close();
?>