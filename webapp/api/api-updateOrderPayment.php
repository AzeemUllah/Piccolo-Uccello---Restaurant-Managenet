<?php
include "config.php";
session_start();

$table_id = '';
$toReturn = '0';

$sql = "UPDATE `order` SET sub_total='".$_POST["sub_total"]."', gen_sales_tax='".$_POST["gen_sales_tax"]."', discount='".$_POST["discount"]."' ,total_cost='".$_POST["total_cost"]."', check_out_time=now(),paid_bill='".$_POST['paid_bill']."' ,balance='".$_POST['balance']."' , tip = '".$_POST['tip']."'  WHERE id=" .$_POST["id"] ;

if ($conn->query($sql) === TRUE) {
    $toReturn = "1";
} else {
    echo $conn->error;
}

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


$conn6=mysqli_connect("localhost", "root", "", "resturant");
$sql6 = "UPDATE `order_items` SET `status` = 'Checked Out' WHERE `order_id`.`id` =".$_POST['id'];
if ($result6=mysqli_query($conn6,$sql6))
{
    $toReturn = '1';
}

$conn3=mysqli_connect("localhost", "root", "", "resturant");
$sql3 = "UPDATE `table_status` SET `status` = 'Yes' WHERE `table_status`.`table_id` =".$table_id;
if ($result3=mysqli_query($conn3,$sql3))
{
    $toReturn = '1';
}

$conn4=mysqli_connect("localhost", "root", "", "resturant");
$sql4 = "INSERT INTO `bill` (`id`, `order_id`, `grand_total`, `customer_id`, `sub_total`, `gen_sales_tax`, `discount`, `payment_mode`,`paid_bill`,`balance`,`tip`,`date`) 
VALUES (NULL, ".$_POST['id'].", '".$_POST["total_cost"]."', NULL, '".$_POST["sub_total"]."', '".$_POST["gen_sales_tax"]."', '".$_POST["discount"]."', '".$_POST['methord']."', '".$_POST['paid_bill']."', '".$_POST['balance']."', '".$_POST['tip']."', NOW() );";
if ($result4=mysqli_query($conn4,$sql4))
{
    $toReturn = '1';
}


$conn5=mysqli_connect("localhost", "root", "", "resturant");
$sql5 = "select i.*, ir.quantity_used from order_items oi, item_recipes ir, inventory i where oi.wastage_status = 'No' and oi.order_id = ".$_POST['id']." and ir.item_id = oi.item_id and i.id = ir.inventory_id";
if ($result5=mysqli_query($conn5,$sql5))
{
    while ($row5=mysqli_fetch_row($result5))
    {
        $newTotal = $row5[2] - $row5[7];
        $sql6 = "UPDATE `inventory` SET `quantity_on_hand` = '".$newTotal."' WHERE `inventory`.`id` = ".$row5[0].";";
        echo $sql6;
        $conn6=mysqli_connect("localhost", "root", "", "resturant");
        if ($result6=mysqli_query($conn6,$sql6))
        {
            $toReturn = '1';
        }
    }
}








$conn->close();
return $toReturn;
?>
