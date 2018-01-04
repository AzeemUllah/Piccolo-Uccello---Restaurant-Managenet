<?php

include "api/config.php";

session_start();

if (!(isset($_SESSION['username'])  ))
{
    header('Location: index.php');
}


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
	$tip = '';

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
			$tip = $row['tip'];
			
            
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
<html>
<head>
    <meta charset="UTF-8">
    <title>Piccolo Ucello | Payment Recipt</title>
</head>
<body>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Piccolo Ucello | Payment Recipt</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script src="assets/js/jquery-3.1.1.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<div style="padding-top: 25px; float:left; width:400px; box-shadow:0 0 3px #aaa; height:auto;color:#666;">
    <div style="width:100%; padding:10px; float:left;  color:#fff; font-size:30px; text-align:center; border-bottom: 1px solid #cccccc;">

        <p style="font-size:130%;">
            <font face="verdana" color="black"><img src="icon 1.png" alt="Smiley face" height="100" width="100"></font>
        </p>

        <p style="font-size:130%;">
            <font face="verdana" color="black">Piccolo Uccello</font>
        </p>
        <p style="font-size:40%;">
            <font face="verdana" color="black">25-C, Main Khayaban-e-Nishat,<br> Phase 6, DHA
                745500 Karachi, Pakistan</font>
        </p>
        <p style="font-size:38%;">
            <font face="verdana" color="black">Phone# 0321 2021222
            </font>
        </p>
        <p style="font-size:50%;">
            <font face="verdana" color="black">PAYMENT BILL</font>
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
            <th style="text-align: center; border-bottom: none;">Item</th>
            <th style="text-align: center; border-bottom: none;">Price</th>
        </tr>
        </thead>
        <tbody>

        <?php
        $conn2 = new mysqli("localhost", "root", "", "resturant");
        $sql2 = "select oi.id, oi.quantity, oi.cancel_order,i.dist_type_id ,i.name, oi.total_price, oi.wastage_status from order_items oi, item i where oi.item_id = i.id and oi.order_id=".$_GET['id']." order by i.dist_type_id";
        $result2 = $conn2->query($sql2);
        $toPrint = '';
        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                echo '<tr>
            <td style="text-align: center;">'.$row2['quantity'].'</td>
            <td style="display: grid; ">'.$row2["name"].'                       
            <span>';
                if($row2['wastage_status'] == 'Yes' || $row2['cancel_order'] == 'Yes' )
                {
                    echo "Canceled order";
                }
                else{
                    echo "Regular Order";
                }
                echo'</span>
              
                
            </td>
            <td style="text-align: center;">'.$row2['total_price'].'

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
                                             <td style="text-align: center; border-top: none; border-bottom: none;">'.$row98['price'].'</td>
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
    <div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Subtotal</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $sub_total; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>GST(<?php echo $tax_rate*100; ?>%)</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $gen_sales_tax; ?></p>
            </div>
        </div>





        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Discount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $discount; ?></p>
            </div>
        </div>
		
		<div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Tip</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $tip; ?></p>
            </div>
        </div>
		
        <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid lightgrey; ">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Net Bill</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $total_cost; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="font-size: 17px; font-weight: bolder;">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Paid Amount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $paid_bill; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid lightgrey; font-size: 17px; font-weight: bolder;">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Balance</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $balance; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>
    </div>
    <div style="padding-top: 157px">
        <p style="text-align:center">SNTN: 1185112-7</p>
        <p style="text-align:center">Now Order Online &amp; for Reservations</p>
        <p style="text-align:center">http://piccolouccello.pk</p>
        <p style="text-align:center">Facebook.com/PiccoloUccelloPK</p>
    </div>

    <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #eeeeee;">
        <p style="text-align: center">&copy; Copyright 2017 - 4Slash </p>
    </div>
</body>
</html>
</body>
</html>
