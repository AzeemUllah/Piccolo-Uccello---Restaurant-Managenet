<?php
include "config.php";
session_start();


$sql = "UPDATE `table_status` SET `name` = '".$_POST['name']."', `status` = '".$_POST['status']."' WHERE `table_status`.`table_id` =". $_POST['id'];

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
