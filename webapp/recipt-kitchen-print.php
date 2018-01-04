<?php

include "api/config.php";

session_start();


if (isset($_GET['id'])) {

    $table_id = '';
    $total_cost = '';
    $check_in_time = '';
    $check_out_time = '';
    $waiter_id = '';
    $number_of_people = '';
    $sub_total = '';
    $gen_sales_tax = '';
    $discount = '';
    $waiter_name = '';

    $sql = "select * from `order` where id=".$_GET['id'];
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $table_id = $row['table_id'];
            $total_cost = $row['total_cost'];
            $check_in_time = $row['check_in_time'];
            $check_out_time = $row['check_out_time'];
            $waiter_id = $row['waiter_id'];
            $number_of_people = $row['number_of_people'];
            $sub_total = $row['sub_total'];
            $gen_sales_tax = $row['gen_sales_tax'];

            $discount = $row['discount'];
            $paid_bill = $row['paid_bill'];
            $balance = $row['balance'];
            $waiter_name = $row['waiter_name'];
        }
    } else {
        echo "0 results";
    }


    $table_name = '';
    $sql = "select name from `table_status` where table_id=".$table_id;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $table_name = $row['name'];
        }
    } else {
        echo "0 results";
    }









    mysqli_close($conn);




    $tax_rate = '';
    $tax_rate2 = 0;
    $conn99 = new mysqli("localhost", "root", "", "resturant");
    $sql99 = "select sales_tax_percentage from `accounts_setting` where id=1";
    $result99 = mysqli_query($conn99, $sql99);

    if (mysqli_num_rows($result99) > 0) {
        while ($row99 = mysqli_fetch_assoc($result99)) {
            $tax_rate = $row99['sales_tax_percentage'];
        }
    }




}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Piccolo Ucello | Kitchen Recipt</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: "serif";
        }
    </style>

</head>
<body>
<div style="padding-top: 25px; float:left; width:400px; box-shadow:0 0 3px #aaa; height:auto;color:#666;">
    <div style="width:100%; padding:10px; float:left;  color:#fff; font-size:30px; text-align:center; border-bottom: 1px solid #cccccc;">

        <p style="font-size:130%;">
            <font face="verdana" color="black"><img src="icon 1.png" alt="Smiley face" height="100" width="100"></font>
        </p>


        <p style="font-size:50%;">
            <font face="verdana" color="black">KITCHEN ORDER</font>
        </p>
    </div>
    <div>
        <div  class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 10px; ">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Order Number</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo "PU/" . $_GET['id'] ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" >
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: left;">Order Date/Time</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo date("Y/m/d-h:i:sa");?></p>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Table: <?php echo $table_name;?></p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Person: <?php echo $number_of_people;?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="height: 30px;border-bottom: 1px solid #dddddd;" >
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Waiter</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $waiter_name;?></p>
            </div>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th style="text-align: center; border-bottom: none;">Qty</th>
            <th style=" border-bottom: none;">Item</th>

        </tr>
        </thead>
        <tbody>

        <?php
        $conn2 = new mysqli("localhost", "root", "", "resturant");
        $sql2 = "select oi.id, oi.quantity, i.name, oi.total_price, oi.notes, oi.wastage_status from order_items oi, item i where oi.item_id = i.id and oi.order_id=".$_GET['id'] ." AND i.location='Kitchen' and oi.printed='No'";
        $result2 = $conn2->query($sql2);
        $toPrint = '';
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {

             if(!(isset($_GET['do']))){
                    //if (!($_GET['do'] == 'N')) {
                        $conn3 = new mysqli("localhost", "root", "", "resturant");
                        $sql3 = "UPDATE `order_items` SET `printed` = 'Yes' WHERE `order_items`.`id` = " . $row2['id'];
                        if ($conn3->query($sql3) === TRUE) {

                        } else {
                            echo "Error: " . $sql3 . "<br>" . $conn3->error;
                        }
                   // }
                }

                echo '<tr>
            <td style="text-align: center;">'.$row2['quantity'].'</td>
            <td style="display: grid;">'.$row2["name"].'                 
            <span>Notes: '.$row2['notes'].'</span>
            <span>';

                echo'</span>
              
                
            </td>
         
            
        </tr>';


                $conn98 = new mysqli("localhost", "root", "", "resturant");
                $sql98 = "SELECT a.name, a.price as price FROM `order_items_addon` oia, `addon` a where a.id = oia.addon_id and oia.order_items_id = ".$row2['id'];
                $result98 = $conn2->query($sql98);

                if ($result98->num_rows > 0) {
                    while ($row98 = $result98->fetch_assoc()) {
                        echo '<tr style="border-top: none; border-bottom: none;">
                                             <td style="text-align: center; border-top: none; border-bottom: none;"></td>
                                             <td style="border-top: none; border-bottom: none;">'.$row98['name'].'</td>
                                           
                                    </tr>';
                    }
                }






            }
        } else {
            echo "0 results";
        }
        ?>



        </tbody>
    </table>
    <hr>

</body>
</html>