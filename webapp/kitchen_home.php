<?php
session_start();
include 'db.php';

$st = '';
if (isset($_REQUEST['kid'])) {
    $status = $_REQUEST['status'];
    $id = $_REQUEST['kid'];
    if ($status == "0") {
        $status = "1";
    } else if ($status == "1") {
        $status = "2";
    } else if ($status = "2") {
        $status = "2";
    }
    $updatestatus = "UPDATE orderdetails SET status='$status' WHERE id='$id'";
    mysqli_query($conn, $updatestatus);
}

?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Fortin Restaurant</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme-panel.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>
<!--    <div id="kitchen">-->
<div class="col-sm-12 col-md-12" style="padding: 0px;margin-top: -50px;">
    <div class="container-fluid">

        <div class="">
        </div>



        <div class="row">
            <div class="col-md-12" style="padding: 0px;">
                <div class="panel with-nav-tabs panel-primary">
                    <div class="panel-heading">
                        <ul class="nav nav-tabs">
                            <a href="DashBoard.php" class="btn btn-danger" style="float: right;">BACK</a>

                             <li><a href="#tab1primary" data-toggle="tab">New Order</a></li>
<!--                            <li><a href="#tab2primary" data-toggle="tab">Served Order</a></li>-->
<!--                            <li><a href="#tab2primary" data-toggle="tab">Recieved Order</a></li>-->
                        </ul>
                    </div>
                    <div class="panel-body" style="padding: 0px;">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab1primary">
                                <div class="col-sm-9 col-md-12  main">
                                    <div class="table-responsive" >

                                        <div class="col-md-12" style="padding: 0px;background: blanchedalmond;">
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                               <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                                </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12" style="padding: 0px;background:white;">
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-12" style="padding: 0px;background:aquamarine;">
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>
                                            <div class="col-md-3" style="border: 1px solid black; height: 155px;display: grid;">

                                                <h6 style="text-align: right; margin-bottom: 0px;font-size: 28px">Order id</h6>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;margin: 0px">WADA PAO<span style="padding-left: 10px">x1</span></h2>
                                                    <h1 style="display: inline-block;float: right;;margin: 0px;font-size: 65px;">00:00</h1>
                                                </div>
                                                <div>
                                                    <h2 style="display: inline-block;float: left;;margin: 0px">Extra Cheese</h2>
                                                </div>
                                            </div>

                                        </div>

                                        

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Bootstrap core JavaScript
   ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
<script type="text/javascript">

    //    $(document).ready(function() {
    ////        $.ajaxSetup({cache: false}); // This part addresses an IE bug. without it, IE will only load the first number and will never refresh
    ////        setInterval(function() {
    ////            $('#kitchen').load('kitchenHome.php');
    ////        }, 90000); // the "3000" here refers to the time to refresh the div. it is in milliseconds.
    //
    //    });

    $(document).ready(function() {
        var page_name = document.getElementById("page_name").value;
        $("#" + page_name).addClass("active");
    });
    $(document).ready(function() {
        $('#tbkitchen').dataTable();
        $('#tbkitchen1').dataTable();
    });
</script>
</body>
</html>