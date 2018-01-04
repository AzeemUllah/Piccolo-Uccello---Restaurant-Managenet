<?php
include "config.php";
session_start();

$toReturn = '';

//query if not in inventory

//query if in inventory
$sql = "select * from procurement where id=" . $_POST['procurementId'];
$result = $conn->query($sql);

$id = '';
$name = '';
$quantity = '';
$quantity_unit = '';
$unit_price = '';
$order_date  = '';
$arival_date = '';
$expire_date = '';
$status = '';
$inventory_id = '';
$image = '';

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $id=$row['id'];
        $name=$row['name'];
        $quantity=$row['quantity'];
        $quantity_unit=$row['quantity_unit'];
        $unit_price=$row['unit_price'];
        $order_date=$row['order_date'];
        $arival_date=$row['arival_date'];
        $expire_date=$row['expire_date'];
        $status=$row['status'];
        $inventory_id=$row['inventory_id'];
        $category = $row['category'];
        $image = $row['image'];
    }
}
else{
    echo $conn->error;
}

$quantity_on_hand = '';
if($inventory_id == '0'){
    $sql = "INSERT INTO `inventory` 
(`id`, `name`, `quantity_on_hand`, `unit_price`, `quantity_unit`, `expiry_date`,`category`,`image`)
 VALUES (NULL, '".$name."', '".$quantity."', '".$unit_price."', '".$quantity_unit."', '".$expire_date."', '".$category."', '".$image."');";
}
else{
    //echo "here";
    $conn2=mysqli_connect("localhost", "root", "", "resturant");
    $sql2 = "select quantity_on_hand from inventory where id=".$inventory_id;
    if ($result2=mysqli_query($conn2,$sql2))
    {

        // Fetch one and one row
        while ($row2=mysqli_fetch_row($result2))
        {
            $quantity_on_hand = $row2[0];
            $quantity_on_hand = $quantity_on_hand + $quantity;
            $sql = "update `inventory` 
            set name='".$name."', quantity_on_hand='".$quantity_on_hand."', unit_price='".$unit_price."', quantity_unit='".$quantity_unit."', expiry_date='".$expire_date."' , category='".$category."'  , image='".$image."' where id=".$inventory_id;
        }
    }
}


$conn3=mysqli_connect("localhost", "root", "", "resturant");
if ($result3=mysqli_query($conn3,$sql))
{
    $toReturn = "1";
}






$sql = "UPDATE procurement SET status='Yes' where id='".$_POST['procurementId']."'";
$result = $conn->query($sql);
if ($conn->query($sql) === TRUE) {
    $toReturn =  "1";
} else {
    echo $conn->error;
}



echo $toReturn;



$conn->close();
?>
