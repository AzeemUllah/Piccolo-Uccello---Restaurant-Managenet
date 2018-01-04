<?php
include "config.php";
session_start();


$sql = "INSERT INTO `table_status` (`table_id`, `name`, `status`) VALUES (NULL, '".$_POST["name"]."', '".$_POST["status"]."');";

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
