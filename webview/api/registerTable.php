<?php
include "config.php";
session_start();

$toReturn = 0;
$sql = "UPDATE `table_status` SET `status` = 'No' WHERE `table_status`.`table_id` = ". $_POST['tableId'];

if ($conn->query($sql) === TRUE) {
    $toReturn = "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

$last_id = '';
$conn2 = new mysqli("localhost", "root", "", "resturant");
$sql2 = "INSERT INTO `order` (`id`, `table_id`, `check_in_time`, `check_out_time`, `waiter_id`, `number_of_people`, `sub_total`, `gen_sales_tax`, `discount`, `paid_bill`, `balance`, `waiter_name`) 
VALUES (NULL, '".$_POST['tableId']."',  NOW(), NULL, NULL, '".$_POST['numberPeople']."', '', '', '', NULL, NULL, '".$_SESSION['username']."');";

if ($conn2->query($sql2) === TRUE) {
    $last_id = $conn2->insert_id;
    $toReturn = "1";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn2->error;
}

$conn2->close();

$arrayReturned = array($toReturn, $last_id);

echo json_encode($arrayReturned);
?>
