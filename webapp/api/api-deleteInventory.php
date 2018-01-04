<?php
include "config.php";
session_start();


$sql = "DELETE FROM inventory WHERE id=" .  $_POST["deleteId"];

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo $conn->error;
}

$conn->close();
?>
