<?php 
	
	session_start();
	
	if (!(isset($_SESSION['username'])  ))
	{
		 header('Location: index.php');
	}






if (isset($_GET['id'])) {
    include "api/config.php";

    $sales_tax_percentage_db = 1;
    $sales_tax_db = 1;

$conn44 = new mysqli("localhost", "root", "", "resturant");
$sql44 = "SELECT * FROM `accounts_setting` where id=1";
$result44 = mysqli_query($conn44, $sql44);




if (mysqli_num_rows($result44) > 0) {
    while ($row44 = mysqli_fetch_assoc($result44)) {
        $sales_tax_percentage_db = $row44['sales_tax_percentage'];
        $sales_tax_db =  $row44['sales_tax'];
    }
}






    $sub_total_calculated = '';
    $sales_tax_calculated = 0;
    $sub_total_calculated_wastage = '';
    $total_cost_calculated = 0;
    $sales_tax_new_calculated = 0;

    $conn22 = new mysqli("localhost", "root", "", "resturant");
    $sql22 = "select sum(total_price) as total from `order_items` where order_id = '".$_GET['id']."'";
    $result22 = mysqli_query($conn22, $sql22);

    if (mysqli_num_rows($result22) > 0) {
        while ($row22 = mysqli_fetch_assoc($result22)) {
            $sub_total_calculated = $row22['total'];

            $conn7 = new mysqli("localhost", "root", "", "resturant");
            $sql7 = "select a.name, a.price from order_items oi, order_items_addon oia, addon a where oia.order_items_id = oi.id and a.id = oia.addon_id and oi.order_id='".$_GET['id']."'";
            $result7 = mysqli_query($conn7, $sql7);

            if (mysqli_num_rows($result7) > 0) {
                while ($row7 = mysqli_fetch_assoc($result7)) {
                    $sub_total_calculated += $row7['price'];
                }
            }




        }
    }


    $conn33 = new mysqli("localhost", "root", "", "resturant");
    $sql33 = "select sum(total_price) as total from `order_items` where wastage_status='Yes' and order_id = '".$_GET['id']."'";
    $result33 = mysqli_query($conn33, $sql33);

    if (mysqli_num_rows($result33) > 0) {
        while ($row33 = mysqli_fetch_assoc($result33)) {
            $sub_total_calculated_wastage = $row33['total'];
        }
    }


    if(isset($sub_total_calculated)){
        $sales_tax_calculated = ($sub_total_calculated-$sub_total_calculated_wastage)  * $sales_tax_percentage_db;
    }


    if(isset($sub_total_calculated)){
        $sales_tax_new_calculated = ($sub_total_calculated-$sub_total_calculated_wastage)  * $sales_tax_db;
    }


    if(isset($sub_total_calculated)){
        $total_cost_calculated = $sub_total_calculated + $sales_tax_calculated - $sub_total_calculated_wastage;
    }

	
	
   $conn73 = new mysqli("localhost", "root", "", "resturant");
    $sql73 = "select discount from `order` where id='".$_GET['id']."'";
    $result73 = mysqli_query($conn73, $sql73);

    if (mysqli_num_rows($result73) > 0) {
        while ($row73 = mysqli_fetch_assoc($result73)) {
            if($row73['discount'] != '0.00'){
				$total_cost_calculated = $total_cost_calculated - $row73['discount'];
			}
		}
	}



                $conn55 = new mysqli("localhost", "root", "", "resturant");
                $sql55 = "UPDATE `order` SET `total_cost` = '".$total_cost_calculated."', `sub_total` = '".$sub_total_calculated."', `gen_sales_tax` = '".$sales_tax_calculated."' WHERE `order`.`id` = ".$_GET['id'].";";
                $result55 = mysqli_query($conn55, $sql55);

                if (!($conn55->query($sql55) === TRUE)) {
                    echo "No previous orders.";
                }
                $conn9 = new mysqli("localhost", "root", "", "resturant");
                $sql9 = "select oi.id,oi.total_price as oldTotal, i.price_per_unit*oi.quantity as newTotal from order_items oi, item i where oi.item_id = i.id and oi.order_id = ".$_GET['id'];
                $result9 = mysqli_query($conn9, $sql9);
                if (mysqli_num_rows($result9) > 0) {
                    while ($row9 = mysqli_fetch_assoc($result9)) {
                        if(!(isset($row9['oldTotal']))) {
                            $conn8 = new mysqli("localhost", "root", "", "resturant");
                            $sql8 = "UPDATE `order_items` SET `total_price` = '" . $row9['newTotal'] . "' WHERE `order_items`.`id` = " . $row9['id'] . ";";
                            if (!($conn8->query($sql8) === TRUE)) {
                                echo "Order items not updated";
                            }
                        }
                    }
                }















    $id = $_GET['id'];
    $table_name= '';
    $total_cost = '';
    $check_in_time = '';
    $check_out_time = '';
    $number_of_people = '';
    $subTotal = '';
    $gen_sales_tax = '';
    $discount = '';
    $table_status = '';
    $paid_bill = '';
    $balance = '';
	$tip = '';

    $sql = "SELECT o.id, o.paid_bill,o.balance, ts.name as table_name,ts.status as status, o.total_cost, o.check_in_time,o.tip, o.check_out_time, o.sub_total, o.gen_sales_tax, o.discount, o.number_of_people FROM `table_status` ts, `order` o where ts.table_id = o.table_id and id ='" . $id . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $table_name = $row['table_name'];
            $total_cost = $row['total_cost'];
            $check_in_time = $row['check_in_time'];
            $check_out_time = $row['check_out_time'];
            $number_of_people = $row['number_of_people'];
            $subTotal = $row['sub_total'];
            $gen_sales_tax = $row['gen_sales_tax'];
            $discount = $row['discount'];
            $table_status = $row['status'];
            $paid_bill = $row['paid_bill'];
            $balance = $row['balance'];
			$tip = $row['tip'];
        }
    } else {
        echo "0 results";
    }

    mysqli_close($conn);
}














?>








<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="assets/img/favicon.png" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Resturant Management System</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
   <link rel="stylesheet" type="text/css" href="assets/css/material-icons.css" />
</head>

<body class="sidebar-mini">


<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>




<script>

    function complementryDish(orderId, itemId){
        $.ajax({
            url:"api/api-complementryDish.php",
            type:"POST",
            data:{
                orderId:  orderId,
                itemId: itemId
            },
            success:function(data) {
                // console.log(data);
                fetch();
                setTimeout(function() {
                    location.reload();
                }, 1000);

                if(data != "0"){
                    $.notify({
                        icon: "notifications",
                        message: "Item marked as Complementry."

                    },{
                        type: "success",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });

                }
                else{
                    $.notify({
                        icon: "notifications",
                        message: "Error. Item Not Marked as Complementry."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }

        });
    }



    function cancelDish(orderId, itemId){
        $.ajax({
            url:"api/api-cancelDish.php",
            type:"POST",
            data:{
                orderId:  orderId,
                itemId: itemId
            },
            success:function(data) {
                // console.log(data);
                fetch();
                setTimeout(function() {
                    location.reload();
                }, 1000);

                if(data != "0"){
                    $.notify({
                        icon: "notifications",
                        message: "Item marked as Canceled."

                    },{
                        type: "success",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });

                }
                else{
                    $.notify({
                        icon: "notifications",
                        message: "Error. Item Not Marked as Canceled."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }

        });
    }



    function fetch(){
        //alert("abc");
        $.ajax({
            url:"api/api-fetchOrderDetails.php",
            type:"POST",
            data:{

                id: <?php echo $_GET['id'] ?>
            },
            success:function(data) {
                //console.log(data);

                if(data != "0"){
                    $('#tableBody').contents().remove();
                    $( "#tableBody" ).append(data);
                }
            },
            error:function(){
                console.log("error");
            }
        });
    }



    function printBill(id){
        $.ajax({
            url:"autoPrintSystem/autoPrintSystem.php",
            type:"POST",
            data:{
                id: <?php echo $_GET['id'] ?>,
                type: 'counter'
            },
            success:function(data) {
                console.log(data);
            },
            error:function(){
                alert("Error");
            }
        });
    }


    function printKitchen(id){
        $.ajax({
            url:"autoPrintSystem/autoPrintSystem.php",
            type:"POST",
            data:{
                id: <?php echo $_GET['id'] ?>,
                type: 'waiter'
            },
            success:function(data) {
                console.log(data);
            },
            error:function(){
                alert("Error");
            }
        });
    }




    function updatePayment(){
        //alert($('#subTotal').val());

        $.ajax({

            url:"api/api-updateOrderPayment.php",
            type:"POST",
            data:{

                sub_total:  $('#subTotal').val().substr(4),
                gen_sales_tax: $('#genSalesTax').val().substr(4),
                discount: $('#discount').val().substr(4),
                total_cost: $('#totalCostModal').val(),
                methord: jQuery("#methordModal option:selected").val(),
                paid_bill:$('#paidBillModal').val(),
                balance:$('#balanceModal').val(),
				tip: $('#tipModal').val(),
                id: <?php echo $_GET['id'] ?>
            },
            success:function(data) {

                if(data != "0"){
                    location.reload();
                } else{
                    $.notify({
                        icon: "notifications",
                        message: "Error. Order not Paid."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }
        });
    }




    function freeTable(){
        //alert("abc");
        $.ajax({
            url:"api/api-orderFreeTable.php",
            type:"POST",
            data:{
                id: <?php echo $_GET['id'] ?>
            },
            success:function(data) {
                //console.log(data);
                //console.log(data);
                if(data != "0"){
                    $.notify({
                        icon: "notifications",
                        message: "Table Forcefully Free."

                    },{
                        type: "success",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                } else{
                    $.notify({
                        icon: "notifications",
                        message: "Table Forcefully Not Free."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }
        });
    }

    $( document ).ready(function() {
        $('#paidBillModal').focusout(function () {
            $('#balanceModal').val("");
            if( $('#tipModal').val() == ''){
                $('#tipModal').val("0");
            }
            $('#balanceModal').val(parseFloat(Math.round($('#totalCostModal').val() - $('#paidBillModal').val())) + parseFloat($('#tipModal').val()));
        });

        $('#tipModal').focusout(function () {
			$('#balanceModal').val("");
			if( $('#tipModal').val() == ''){
                $('#tipModal').val("0");
            }
            $('#balanceModal').val(parseFloat(Math.round($('#totalCostModal').val() - $('#paidBillModal').val())) + parseFloat($('#tipModal').val()));
        });


    });



    function wastage(oId,iId){
        //alert("abc");
        $.ajax({
            url:"api/api-putToWastage.php",
            type:"POST",
            data:{
                orderId:  oId,
                itemId: iId
            },
            success:function(data) {
               // console.log(data);
                fetch();
                setTimeout(function() {
                    location.reload();
                }, 1000);

                if(data != "0"){
                    $.notify({
                        icon: "notifications",
                        message: "Item marked as wastage."

                    },{
                        type: "success",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });

                }
                else{
                    $.notify({
                        icon: "notifications",
                        message: "Error. Item Not Marked as wastage."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }

        });
    }





</script>

    <div class="wrapper">
        <div class="sidebar" data-active-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
            <!--
        Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
        Tip 2: you can also add an image using data-image tag
        Tip 3: you can change the color of the sidebar with data-background-color="white | black"
    -->
            <div class="logo">
                <a href="#" class="simple-text">
                    <img src="assets\img\favicon.png" width="40px" height="40px"/>
                    Piccolo Uccello
                </a>
            </div>
            <div class="logo logo-mini">
                <a href="" class="simple-text">
                    <img src="assets\img\favicon.png" width="40px" height="40px"/>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <div class="user">
                    <div class="photo">
                        <img src=<?php echo "'" . $_SESSION['image_url'] . "'" ?> />
                    </div>
                    <div class="info">
                        <a  href="#" class="collapsed">
                            <?php echo $_SESSION['username'] ?>
                           
                        </a>
                        
                    </div>
                </div>
                <ul class="nav">
                    <?php
                    if(!($_SESSION['type'] == 'procurement')){
                        echo ' <li >
                        <a href="dashboard.php">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li>
                        <a  href="kitchen.php">
                            <i class="material-icons">kitchen</i>
                            <p>Kitchen

                            </p>
                        </a>

                    </li>';
                    }
                    ?>


                    <li>
                        <a  href="order.php">
                            <i class="material-icons">border_color</i>
                            <p>Order

                            </p>
                        </a>

                    </li>

                    <?php
                    if(!($_SESSION['type'] == 'procurement')) {
                        echo '<li >
                        <a  href = "table.php" >
                            <i class="material-icons" > airline_seat_recline_normal</i >
                            <p > Table

                            </p >
                        </a >

                    </li >
                    <li>
                        <a data-toggle="collapse" href="#relatedDishes">
                            <i class="material-icons">free_breakfast</i>
                            <p>Dishes
                                <b class="caret"></b>
                            </p>
                        </a>
                        <div class="collapse" id="relatedDishes">
                            <ul class="nav">
                                <li>
                                    <a href="cosine.php">Cuisine</a>
                                </li>
                                <li>
                                    <a href="dishType.php">Dish Type</a>
                                </li>
                                <li>
                                    <a href="dish.php">Add Dish</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                     <li>
                        <a href="bill.php">
                            <i class="material-icons">credit_card</i>
                            <p>Accounts </p>
                        </a>
                    </li>';
                    }
                    ?>


                    <li class="">
                        <a href="accountsSummry.php?startDate=<?php echo date("m-d-Y");?>&endDate=<?php echo date("m-d-Y");?>"</a>
                            <i class="material-icons">report</i>
                            <p>Accounts Summary</p>
                        </a>
                    </li>



                    <li>
                        <a href="inventory.php">
                            <i class="material-icons">storage</i>
                            <p>Inventory</p>
                        </a>
                    </li>
                    <?php
                    if(($_SESSION['type'] == 'admin')){
                        echo '<li>
                        <a href="procurement.php">
                            <i class="material-icons">local_shipping</i>
                            <p>Procurement</p>
                        </a>
                    </li>

                    <li>
                        <a href="wastage.php">
                            <i class="material-icons">delete_sweep</i>
                            <p>Wastage</p>
                        </a>
                    </li>

                    <li>
                        <a  href="users.php">
                            <i class="material-icons">person_add</i>
                            <p>Add Users

                            </p>
                        </a>

                    </li>';
                    }
                    else if(($_SESSION['type'] == 'procurement')){

                        echo '<li>
                        <a href="procurement.php">
                            <i class="material-icons">local_shipping</i>
                            <p>Procurement</p>
                        </a>
                    </li>

                    <li>
                        <a href="wastage.php">
                            <i class="material-icons">delete_sweep</i>
                            <p>Wastage</p>
                        </a>
                    </li>

                   ';

                    }
                    else if(($_SESSION['type'] == 'manager')){

                        echo ' ';

                    }
                    ?>

                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-minimize">
                        <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                            <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                            <i class="material-icons visible-on-sidebar-mini">view_list</i>
                        </button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" >
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> Order Details </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            <li>
                                <a href="./api/api-logout.php">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">Logout</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                        
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">
                    <div class="col-md-12">
                        <div class="col-md-8">
                            <div class="card">
                                <form method="get" action="/" class="form-horizontal">
                                    <div class="card-header card-header-text" data-background-color="rose">
                                        <h4 class="card-title"><?php echo "Order # " . $id; ?></h4>
                                    </div>

                                    <div class="card-content">
                                        <div class="row ">
                                            <?php
                                            if (empty($check_out_time)) {
                                                echo '<div class="col-md-2">
                                            <button class="btn  btn-reddit" type=button data-target="#payment" data-toggle="modal">
                                                <i class="fa fa-money"></i> Pay
                                                <div class="ripple-container"></div>
                                            </button>
                                        </div>';
                                            }
                                            ?>







                                            <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

                                                <?php
                                                $sub_total_calculated = '';
                                                $sales_tax_calculated = 0; //general sales tax
                                                $sales_tax_new_calculated2 = 0;

                                                $conn2 = new mysqli("localhost", "root", "", "resturant");
                                                $sql2 = "select sum(total_price) as total from `order_items` where order_id = '".$_GET['id']."'";
                                                $result2 = mysqli_query($conn2, $sql2);

                                                if (mysqli_num_rows($result2) > 0) {
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        $sub_total_calculated = $row2['total'];
                                                    }
                                                }



                                                // replace this below block with discount **************



                                                $sub_total_calculated_wastage = '';
                                                $conn3 = new mysqli("localhost", "root", "", "resturant");
                                                $sql3 = "select sum(total_price) as total from `order_items` where wastage_status='Yes' and order_id = '".$_GET['id']."'";
                                                $result3 = mysqli_query($conn3, $sql3);

                                                if (mysqli_num_rows($result3) > 0) {
                                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                                        $sub_total_calculated_wastage = $row3['total'];
                                                    }
                                                }





                                                $tax_rate = '';
                                                $conn99 = new mysqli("localhost", "root", "", "resturant");
                                                $sql99 = "select sales_tax_percentage from `accounts_setting` where id=1";
                                                $result99 = mysqli_query($conn99, $sql99);

                                                if (mysqli_num_rows($result99) > 0) {
                                                    while ($row99 = mysqli_fetch_assoc($result99)) {
                                                        $tax_rate = $row99['sales_tax_percentage'];

                                                    }
                                                }


                                                // replace this above block with discount **************


                                                if(isset($sub_total_calculated)){
                                                    $sales_tax_calculated = ($sub_total_calculated-$sub_total_calculated_wastage)  * $tax_rate; //gst
                                                   // $sales_tax_new_calculated2 = ($sub_total_calculated-$sub_total_calculated_wastage)  * $sales_tax_rate;

                                                }


                                                $total_cost_calculated = 0;
                                                if(isset($sub_total_calculated)){
                                                    $total_cost_calculated = $sub_total_calculated + $sales_tax_calculated - $sub_total_calculated_wastage;
                                                }


                                                mysqli_close($conn2);
                                                ?>




                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                                                <i class="material-icons">clear</i>
                                                            </button>
                                                            <h4 class="modal-title">Payment Details</h4>
                                                        </div>
                                                        <div class="modal-body">


                                                            <div class="row">






                                                                <div class="col-sm-5">
                                                                    <div class="form-group label-floating

                                                                <?php
                                                                    if(isset($sales_tax_calculated)){
                                                                        echo "is-focused";
                                                                    }
                                                                    else{
                                                                        echo "is-empty";
                                                                    }
                                                                    ?>


                                                                    ">
                                                                        <label class="control-label">Net Bill</label>
                                                                        <input type="text" class="form-control"  name=totalCostModal id=totalCostModal value='<?php echo $total_cost; ?>'>
                                                                    </div>
                                                                </div>




                                                                <div class="col-sm-5">
                                                                    <div class="form-group label-floating

                                                                <?php
                                                                    if(isset($paid_bill)){
                                                                        echo "is-focused";
                                                                    }
                                                                    else{
                                                                        echo "is-empty";
                                                                    }
                                                                    ?>


                                                                    ">
                                                                        <label class="control-label">Paid Bill</label>
                                                                        <input type="text" class="form-control"  name=paidBillModal id=paidBillModal value='<?php echo $paid_bill; ?>'>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <label class="control-label"></label>
                                                                </div>



                                                                <div class="col-sm-5">
                                                                    <div class="form-group label-floating is-empty">
                                                                        <label class="control-label">Tip</label>
                                                                        <input type="text" class="form-control"  name=tipModal id=tipModal value=''>
                                                                    </div>
                                                                </div>


                                                                <div class="col-sm-5">
                                                                    <div class="form-group label-floating is-focused


                                                                    ">
                                                                        <label class="control-label">Balance</label>
                                                                        <input type="text" class="form-control"  name=balanceModal id=balanceModal value='<?php echo $balance; ?>'>
                                                                    </div>
                                                                </div>









                                                            </div>









                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <select class="selectpicker" name=methordModal id=methordModal data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                                        <option disabled selected value="cash">Payment Type</option>
                                                                        <option value="credit">Credit Card</option>
                                                                        <option value="cash">Cash</option>
                                                                    </select>
                                                                </div>
                                                            </div>




                                                            <hr>




                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-simple btn-success" onclick="updatePayment()" >Paid</button>
                                                            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal" >Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




















                                            <div class="col-md-3 " style="">
                                                <button class="btn btn-github" type="button" onclick="printBill(<?php echo $_GET['id'] ?>)">
                                                    <i class="fa fa-print"></i> Print
                                                    <div class="ripple-container"></div>
                                                </button>
                                            </div>


<?php

if (empty($check_out_time)) {

    echo '                                       <div class="col-md-4">
                                                <button class="btn  btn-youtube" type="button" onclick="printKitchen(' . $_GET['id'] . ')">
                                                    <i class="fa fa-print"></i> Print to Kitchen
                                                    <div class="ripple-container"></div>
                                                </button>
                                        </div>';
}
 ?>
                                            <?php





                                            if($table_status == 'No'){
                                                echo '<div class="col-md-3">
                                        <button class="btn  btn-twitter" type="button" onclick="freeTable()">
                                            <i class="fa fa-repeat"></i> Free Table
                                            <div class="ripple-container"></div></button>
                                    </div>';
                                            }
                                            ?>




                                        </div>

                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Table Name: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=tableName id=tableName value='<?php echo $table_name; ?>'>

                                                </div>
                                            </div>

                                            <label class="col-sm-2 label-on-left">Number of People</label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=numPeople id=numPeople value='<?php echo $number_of_people; ?>'>
                                                </div>
                                            </div>




                                        </div>

                                        <div class="row">



                                            <label class="col-sm-2 label-on-left">Check in Time</label>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control datepicker" disabled id=checkin name=checkin value="<?php echo $check_in_time; ?>">
                                                <span class="material-input"></span>
                                            </div>




                                            <label class="col-sm-2 label-on-left">Check Out Time</label>

                                            <div class="col-sm-3">
                                                <input type="text" class="form-control datepicker" disabled id=checkout name=checkout value="<?php echo $check_out_time; ?>">
                                                <span class="material-input"></span>
                                            </div>
                                        </div>

                                        <hr>



                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Sub Total: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=subTotal id=subTotal value='Rs. <?php echo $subTotal; ?>'>

                                                </div>
                                            </div>

                                            <label class="col-sm-2 label-on-left">Sales Tax:</label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=genSalesTax id=genSalesTax value='Rs. <?php echo $gen_sales_tax; ?>'>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Discount: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=discount id=discount value='Rs. <?php echo $discount; ?>'>

                                                </div>
                                            </div>

                                            <label class="col-sm-2 label-on-left">Net Bill: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=totalCost id=totalCost value='Rs. <?php echo $total_cost; ?>'>

                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Paid Bill: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=paidBill id=paidBill value='Rs. <?php echo $paid_bill; ?>'>

                                                </div>
                                            </div>

                                            <label class="col-sm-2 label-on-left">Balance: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=balance id=balance value='Rs. <?php echo $balance; ?>'>

                                                </div>
                                            </div>

                                        </div>




                                        <div class="row">
                                            <label class="col-sm-2 label-on-left">Tip: </label>
                                            <div class="col-sm-3">
                                                <div class="form-group label-floating is-empty">
                                                    <label class="control-label"></label>
                                                    <input type="text" class="form-control" disabled name=tip id=tip value='Rs. <?php echo $tip ?>'>

                                                </div>
                                            </div>
                                        </div>



									 <?php
                                                                    if(isset($paid_bill)){
                                                                        echo "";
                                                                    }
                                                                    else{
                                                                        echo ' <div class="row">
                                            <label class="col-sm-2 label-on-left">Discount: </label>
                                            <div class="col-sm-3">
                                                <select class="selectpicker" name=discountPercentage id=discountPercentage data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                    <option disabled selected value="0">Discount %</option>
                                                    <option value="0.05">5%</option>
                                                    <option value="0.10">10%</option>
                                                    <option value="0.14">14%</option>
                                                    <option value="0.15">15%</option>
                                                    <option value="0.20">20%</option>
                                                    <option value="0.25">25%</option>
                                                    <option value="0.30">30%</option>
                                                    <option value="0.50">50%</option>
                                                    <option value="1">100%</option>

                                                </select>
                                            </div>
                                            <div class="col-md-1">
                                            </div>
                                        </div>';
                                                                    }
                                                                    ?>
                                       










                                    </div>
                                </form>
                            </div>
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title">Order Dishes</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>

                                                <th>Dish Name</th>
                                                <th>Dish Category</th>
                                                <th>Dish Type</th>
                                                <th>Wastage</th>
                                                <th>Quantity</th>
                                                <th class="text-right">Unit Price</th>
                                                <th class="text-right">Total Amount</th>
                                                <th class="text-right td-actions">Actions</th>

                                            </tr>
                                            </thead>
                                            <tbody id="tableBody">


                                            <script>
                                                fetch();
                                            </script>


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4">

                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">reorder</i>
                                </div>
                                <h4 class="card-title"><b>Bill Review</b></h4>
                                <div class="card-content">
                                    <iframe class="col-md-4 col-sm-4 col-xs-4" frameBorder="0" style="height: 1000px; width:100%;" scrolling="yes" id="printf" name="printf" src="recipt-preview.php?id=<?php echo $_GET['id']?>"></iframe>

                                </div>
                            </div>


                        </div>


                    </div>



            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        
                    </nav>
                    <p class="copyright pull-right">
                        &copy;
                        <script>
                            document.write(new Date().getFullYear())
                        </script>
                        <a href="#">4Slash</a>, made with &hearts; for a better Resturant Managemet
                    </p>
                </div>
            </footer>
        </div>
    </div>
    
</body>
<!--   Core JS Files   -->
<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/js/material.min.js" type="text/javascript"></script>
<script src="assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="assets/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="assets/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="assets/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="assets/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="assets/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<script src="assets/js/jquery.sharrre.js"></script>
<!-- DateTimePicker Plugin -->
<script src="assets/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="assets/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="assets/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<!-- Select Plugin -->
<script src="assets/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="assets/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="assets/js/sweetalert2.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="assets/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="assets/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="assets/js/demo.js"></script>
<script type="text/javascript">

	

    $('#discountPercentage').on('change', function() {
        $('#discount').val("Rs. "+ <?php echo $subTotal; ?> * $('#discountPercentage').val());
        $('#totalCost').val("Rs. "+((<?php echo $gen_sales_tax; ?> + <?php echo $subTotal; ?>) - (<?php echo $subTotal; ?> * $('#discountPercentage').val()) ).toFixed(2))
        //api-updateOrderPayment.php

        console.log($('#subTotal').val().substr(3));


        $.ajax({
            url:"api/api-orderDetailsApplyDiscount.php",
            type:"POST",
            data:{
                sub_total:  $('#subTotal').val().substr(4),
                gen_sales_tax: $('#genSalesTax').val().substr(4),
                discount: $('#discount').val().substr(4),
                total_cost: $('#totalCost').val().substr(4),
                order_id: <?php echo $_GET['id'] ?>
            },
            success:function(data) {

                if(data == "1"){
                    location.reload();
                   // console.log(data);
                } else{
                    console.log(data);
                    $.notify({
                        icon: "notifications",
                        message: "Error. Discount not added."

                    },{
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }


            },
            error:function(){
                console.log("error");

            }
        });


    });

	

    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();
    });

    function print(){
        window.frames["printf"].focus();
        window.frames["printf"].print();
    }
</script>

</html>