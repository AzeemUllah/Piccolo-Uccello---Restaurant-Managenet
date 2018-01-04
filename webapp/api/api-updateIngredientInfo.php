<?php
include "config.php";
session_start();

if(isset($_POST['addonIds'])) {
    $addonIds = $_REQUEST['addonIds'];
}
$addonNames = $_REQUEST["addonNames"];
$addonPrices = $_REQUEST["addonPrices"];

$dish_id = $_REQUEST["dish_id"];

$toReturn = 0;


$count = 0;




if(isset($_POST['addonIds'])) {
    $totalPrevious = count($addonIds);

    if ($totalPrevious > 0) {
        foreach ($addonIds as &$value) {
            $sql = "UPDATE `item_recipes` SET `inventory_id` = '$addonNames[$count]', `quantity_used` = '" . $addonPrices[$count] . "' WHERE `item_recipes`.`id` = " . $value;

            if ($conn->query($sql) === TRUE) {
                $toReturn = 1;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
                $toReturn = 0;
                return;
            }
            $count++;
        }
    }
}


$total = count($addonNames);
for( $i = $count; $i<$total; $i++ ) {
    $sql = "INSERT INTO `item_recipes` (`id`, `item_id`, `inventory_id`, `quantity_used`) VALUES (NULL, '".$dish_id."', '".$addonNames[$i]."', '$addonPrices[$i]');";

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
