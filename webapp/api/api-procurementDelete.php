<?php
include "config.php";
session_start();


$sql = "DELETE FROM procurement WHERE id=" .  $_POST["deleteId"];

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "0";
}


$conn->close();
?>
