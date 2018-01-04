<?php
include "config.php";
session_start();


$sql = "UPDATE `accounts_setting` SET `sales_tax_percentage` = '".($_POST['tax']/100)."' WHERE id=1";

if ($conn->query($sql) === TRUE) {
    echo "1";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>



