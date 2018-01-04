<?php
include "config.php";
session_start();

$last_id = '';
$toReturn = 0;
$code = '';

$sql = "INSERT INTO `order_items` (`id`, `item_id`, `order_id`, `wastage_status`, `status`, `notes`, `quantity`, `total_price`, `order_time`,`printed`) 
VALUES (NULL, '".$_POST['dishId']."', '".$_POST['orderId']."', 'No', 'Pending', '".$_POST['orderNotes']."', '".$_POST['quantity']."', NULL, NOW(), 'No');";

if ($conn->query($sql) === TRUE) {
    $last_id = $conn->insert_id;
    $toReturn = "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();

if(isset($_POST['addonList'])) {
    $conn2 = new mysqli("localhost", "root", "", "resturant");
    foreach ($_POST['addonList'] as $value) {
        $sql2 = "INSERT INTO `order_items_addon` (`id`, `order_items_id`, `addon_id`) VALUES (NULL, '" . $last_id . "', '" . $value . "');";
        if ($conn2->query($sql2) === TRUE) {
            $toReturn = "1";
        } else {
            echo "Error: " . $sql2 . "<br>" . $conn2->error;
        }
    }
    $conn2->close();
}

echo $toReturn;
?>
