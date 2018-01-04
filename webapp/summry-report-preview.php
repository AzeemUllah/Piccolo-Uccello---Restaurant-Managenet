<?php

include "api/config.php";

session_start();

if (!(isset($_SESSION['username'])  ))
{
    header('Location: index.php');
}


if (isset($_GET['startDate']) && isset($_GET['endDate'])) {

    $total_cost = 0;
    $sub_total = 0;
    $gen_sales_tax = 0;
    $discount = 0;
    $paid_bill = 0;
    $balance = 0;
    $tip = 0;

    $conn1 = new mysqli("localhost", "root", "", "resturant");
    $sql1 = "select sum(grand_total) as total_cost, sum(sub_total) as sub_total, sum(gen_sales_tax) as gen_sales_tax, sum(discount) as discount, sum(paid_bill) as paid_bill, sum(balance) as balance, sum(tip) as tip from `bill` where payment_mode = 'cash' and DATE_FORMAT(date, '%m-%d-%Y') BETWEEN '".$_GET['startDate']."'  AND '".$_GET['endDate']."' ";
    $result1 = mysqli_query($conn1, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $total_cost = $row1['total_cost'];
            $sub_total = $row1['sub_total'];
            $gen_sales_tax = $row1['gen_sales_tax'];
            $discount = $row1['discount'];
            $paid_bill = $row1['paid_bill'];
            $balance = $row1['balance'];
            $tip = $row1['tip'];
        }
    }


    $total_cost1 = 0;
    $sub_total1 = 0;
    $gen_sales_tax1 = 0;
    $discount1 = 0;
    $paid_bill1 = 0;
    $balance1 = 0;
    $tip1 = 0;

    $conn2 = new mysqli("localhost", "root", "", "resturant");
    $sql2 = "select sum(grand_total) as total_cost, sum(sub_total) as sub_total, sum(gen_sales_tax) as gen_sales_tax, sum(discount) as discount, sum(paid_bill) as paid_bill, sum(balance) as balance, sum(tip) as tip from `bill` where payment_mode = 'credit' and DATE_FORMAT(date, '%m-%d-%Y') BETWEEN '".$_GET['startDate']."'  AND '".$_GET['endDate']."' ";
    $result2 = mysqli_query($conn2, $sql2);

    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $total_cost1 = $row2['total_cost'];
            $sub_total1 = $row2['sub_total'];
            $gen_sales_tax1 = $row2['gen_sales_tax'];
            $discount1 = $row2['discount'];
            $paid_bill1 = $row2['paid_bill'];
            $balance1 = $row2['balance'];
            $tip1 = $row2['tip'];
        }
    }


    if($tip == ''){
        $tip = 0.00;
    }
    if($tip1 == ''){
        $tip1 = 0.00;
    }
    if($total_cost1 == ''){
        $total_cost1 = 0.00;
    }
    if($total_cost == ''){
        $total_cost = 0.00;
    }
    if($sub_total1 == ''){
        $total_cost1 = 0.00;
    }
    if($gen_sales_tax1 == ''){
        $gen_sales_tax1 = 0.00;
    }
    if($gen_sales_tax == ''){
        $gen_sales_tax = 0.00;
    }
    if($discount1 == ''){
        $discount1 = 0.00;
    }
    if($discount == ''){
        $discount = 0.00;
    }
    if($paid_bill1 == ''){
        $paid_bill1 = 0.00;
    }
    if($paid_bill == ''){
        $paid_bill = 0.00;
    }
    if($balance1 == ''){
        $balance1 = 0.00;
    }
    if($balance == ''){
        $balance = 0.00;
    }
    if($tip1 == ''){
        $tip1 = 0.00;
    }
    if($tip == ''){
        $tip = 0.00;
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Piccolo Ucello | Account Summary</title>
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
            <font face="verdana" color="black">Piccolo Uccello</font>
        </p>

        <p style="font-size:50%;">
            <font face="verdana" color="black">Accounts Summary</font>
        </p>
    </div>
    <div>
        <div  class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 10px; ">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Date From</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $_GET['startDate']; ?></p>
            </div>
        </div>
        <div  class="col-md-12 col-sm-12 col-xs-12" style="">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Date To</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $_GET['endDate']; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" >
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: left;">Generated on Date/Time</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo date("Y/m/d-h:i:sa");?></p>
            </div>
        </div>


        <div class="col-md-12 col-sm-12 col-xs-12" style="height: 30px;border-bottom: 1px solid #dddddd;" >
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Generated By</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><?php echo $_SESSION['username'];?></p>
            </div>
        </div>
    </div>
    <hr>
    <div>
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding-top: 20px;">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Cash Sale</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $total_cost; ?></p>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Credit Sale</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $total_cost1; ?></p>

            </div>
        </div>





        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Cash Tip Amount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $tip; ?></p>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Credit Tip Amount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $tip1; ?></p>
            </div>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Cash Total Discount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $discount; ?></p>
            </div>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Credit Total Discount</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $discount; ?></p>
            </div>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12" style="">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Cash GST</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $gen_sales_tax; ?></p>
            </div>
        </div>

        <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid lightgrey; ">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p>Credit GST</p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;">Rs. <?php echo $gen_sales_tax1; ?></p>
            </div>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid lightgrey; ">
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p><b>Net Sales</b></p>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                <p style="float: right;"><b>Rs. <?php echo $total_cost+$total_cost1; ?></b></p>
            </div>
        </div>



        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <p></p>
        </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12" style="border-bottom: 1px solid #eeeeee;">
        <p style="text-align: center">&copy; Copyright 2017 - 4Slash </p>
    </div>
</body>
</html>

