<?php
include "config.php";
session_start();


$sql = "DELETE FROM `table_status` WHERE table_id=" .  $_POST["id"];

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "0";
}


$conn->close();
?>
