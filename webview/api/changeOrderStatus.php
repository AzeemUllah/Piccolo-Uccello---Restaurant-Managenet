<?php
include "config.php";
session_start();

$toReturn = 0;


$sql = "UPDATE `order_items` SET `status` = 'Kitchen' WHERE status = 'Pending' and order_id =". $_POST['orderId'];

if ($conn->query($sql) === TRUE) {
    $toReturn = "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();


echo $toReturn;
?>
