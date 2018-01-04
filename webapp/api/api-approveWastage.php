<?php
include "config.php";
session_start();



$sql = "UPDATE wastage SET approved='Yes' WHERE id=" .$_POST["id"] ;

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "0";
}

$conn->close();
?>
