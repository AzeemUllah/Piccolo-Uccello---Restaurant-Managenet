<?php
include "config.php";
session_start();


$addonIds = $_REQUEST['addonIds'];
$addonNames = $_REQUEST["addonNames"];
$addonPrices = $_REQUEST["addonPrices"];

$dish_id = $_REQUEST["dish_id"];

$toReturn = 0;


$count = 0;
foreach ($addonIds as &$value) {
    $sql = "UPDATE `addon` SET `name` = '$addonNames[$count]', `price` = '".$addonPrices[$count]."' WHERE `addon`.`id` = ".$value;

    if ($conn->query($sql) === TRUE) {
        $toReturn = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $toReturn = 0;
        return;
    }
    $count++;
}

$total = count($addonNames);
for( $i = $count; $i<$total; $i++ ) {
    $sql = "INSERT INTO `addon` (`id`, `item_id`, `name`, `price`) VALUES (NULL, '".$dish_id."', '".$addonNames[$i]."', '$addonPrices[$i]');";

    if ($conn->query($sql) === TRUE) {
        $toReturn = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $toReturn = 0;
        return;
    }
}




echo $toReturn;



$conn->close();

?>
