<?php

session_start();

$table_id = '';
$toReturn = '0';

$conn2=mysqli_connect("localhost", "root", "", "resturant");
$sql2 = "select table_id from `order` where id=".$_POST['id'];
if ($result2=mysqli_query($conn2,$sql2))
{
    // Fetch one and one row
    while ($row2=mysqli_fetch_row($result2))
    {
        $table_id = $row2[0];
    }
    mysqli_free_result($result2);
}


$conn3=mysqli_connect("localhost", "root", "", "resturant");
$sql3 = "UPDATE `table_status` SET `status` = 'Yes' WHERE `table_status`.`table_id` =".$table_id;
if ($result3=mysqli_query($conn3,$sql3))
{
    $toReturn = '1';
}





return $toReturn;
?>
