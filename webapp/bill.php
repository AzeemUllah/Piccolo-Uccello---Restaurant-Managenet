<?php 
	
	session_start();
if($_SESSION['type'] == 'waiter'){
    header('Location: index.php');
}

if (!(isset($_SESSION['username']) ))
	{
		 header('Location: index.php');
	}
include "api/config.php";
	// color rose #E91E63
    // color red #c71f26


$sql = "select * from `accounts_setting` where id=1";
$result = $conn->query($sql);
$taxPercentage = '';
$taxPercentage2 = '';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $taxPercentage = $row['sales_tax_percentage'];

    }
}
else{
    echo $conn->error;

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

<body>
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
                        <a data-toggle="collapse" href="#" class="collapsed">
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
                    <li class="">
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
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="./dashboard.php"> Payment </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">

                            
                            <li>
                                <a href="./api/api-logout.php">
                                    <i class="material-icons">person</i>
                                    <p class="hidden-lg hidden-md">ogout</p>
                                </a>
                            </li>
                            <li class="separator hidden-lg hidden-md"></li>
                        </ul>
                        
                    </div>
                </div>
            </nav>
            <div class="content">
                <div class="container-fluid">



                    <div class="row animated" id=displayTable>
                        <div class="col-md-10">
                            <div class="card">
                                <form method="get" action="/" class="form-horizontal">
                                <div class="card-header card-header-text" data-background-color="rose">
                                    <h4 class="card-title">Accounts Setting</h4>
                                </div>

                                <div class="card-content">

                                <div class="row">
                                    <label class="col-sm-2 label-on-left">GST Percentage: </label>
                                    <div class="col-sm-3">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=taxPercentage id=taxPercentage value='<?php if(isset($taxPercentage)){echo ($taxPercentage*100);}?>
'>
                                            <span class="help-block">Enter amount of tax.</span>
                                        </div>
                                    </div>







                                </div>




                                    <div class="row">


                                        <div class="col-md-12 text-right">
                                            <button type=button class="btn btn-rose" name=submit id=submit>Save<div class="ripple-container"></div></button>
                                        </div>
                                    </div>

                                </div>
                                </form>
                            </div>
                        </div>



                    </div>





                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="title text-center">Accounts Reports</h3>
                            <br />
                            <div class="nav-center">
                                <ul class="nav nav-pills nav-pills-danger nav-pills-icons" role="tablist">
                                    <!--
                        color-classes: "nav-pills-primary", "nav-pills-info", "nav-pills-success", "nav-pills-warning","nav-pills-danger"
                    -->
                                    <li class="active">
                                        <a href="#description-1" role="tab" data-toggle="tab">
                                            <i class="material-icons">credit_card</i> Credit Card
                                        </a>
                                    </li>
                                    <li >
                                        <a href="#schedule-1" role="tab" data-toggle="tab">
                                            <i class="material-icons">attach_money</i> Cash
                                        </a>
                                    </li>

                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane active" id="description-1">
                                    <div class="card">
                                       <div class="toolbar">




                                           <div class="row" style="padding-left: 25px; padding-top: 20px;">
                                               <button type=button class="btn btn-info"  name=today id=today1 onclick="fetchCustomized1('today')">Today</button>
                                               <button type=button class="btn btn-warning" name=today id=yesterday1 onclick="fetchCustomized1('yesterday')">Yesterday</button>
                                               <button type=button class="btn btn-rose" name=today id=today-yesterday1 onclick="fetchCustomized1('today-yesterday')">Today/Yesterday</button>
                                               <div class="col-md-2 pull-right">
                                                   <button type=button class="btn  btn-primary" name=go id=range1 onclick="">Go</button>
                                               </div>
                                               <div class="col-md-2 pull-right">
                                                   <label style="color:black;"><b>To</b></label>
                                                   <input type="text" class="form-control datepicker" id="dateTo1" value="">
                                               </div>
                                               <div class="col-md-2 pull-right">
                                                   <label style="color:black;"><b>From</b></label>
                                                   <input type="text" class="form-control datepicker" id="dateFrom1" value="">
                                               </div>
                                           </div>




                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                <tr class="info">
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Order Id</th>
                                                    <th>Date Time</th>
                                                    <th>Sub Total</th>
                                                    <th>Sales Tax</th>
                                                    <th>Discount</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                                </thead>
                                                <tbody id=tableBody1>
                                                <?php


                                                $sql = 'SELECT * from `bill` where payment_mode = \'credit\' and DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()';
                                                $result = $conn->query($sql);
                                                // check_out_time is NULL and
                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<tr>
                                                    <td class="text-center">' . $row['id'] . '</td>
                                                    <td class="text-center">' . $row['order_id'] . '</td>
                                                     <td>' . $row['date'] . '</td>
                                                    <td>' . $row['sub_total'] . '</td>
                                                    <td>' . $row['gen_sales_tax'] . '</td>
                                                    <td>' . $row['discount'] . '</td>                                                    
                                                    <td>' . $row['grand_total'] . '</td>                                                    
                                                </tr>';


                                                    }
                                                }




                                                ?>







                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane " id="schedule-1">
                                    <div class="card">
                                       <div class="toolbar">


                                           <div class="row" style="padding-left: 25px; padding-top: 20px;">
                                               <button type=button class="btn btn-info" name=today id=today2 onclick="fetchCustomized2('today')">Today</button>
                                               <button type=button class="btn btn-warning" name=today id=yesterday2 onclick="fetchCustomized2('yesterday')">Yesterday</button>
                                               <button type=button class="btn btn-rose" name=today id=today-yesterday2 onclick="fetchCustomized2('today-yesterday')">Today/Yesterday</button>
                                               <div class="col-md-2 pull-right">
                                                   <button type=button class="btn  btn-primary" name=go id=range2 onclick="">Go</button>
                                               </div>
                                               <div class="col-md-2 pull-right">
                                                   <label style="color:black;"><b>To</b></label>
                                                   <input type="text" class="form-control datepicker" id="dateTo2" value="">
                                               </div>
                                               <div class="col-md-2 pull-right">
                                                   <label style="color:black;"><b>From</b></label>
                                                   <input type="text" class="form-control datepicker" id="dateFrom2" value="">
                                               </div>
                                           </div>


                                    </div>
                                    <div class="material-datatables">
                                        <table id="datatables1" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                                <thead>
                                                <tr class="info">
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">Order Id</th>
                                                    <th>Date Time</th>
                                                    <th>Sub Total</th>
                                                    <th>Sales Tax</th>
                                                    <th>Discount</th>
                                                    <th>Total Cost</th>
                                                </tr>
                                                </thead>
                                                <tbody id=tableBody2>
                                                <?php


                                                $sql = 'SELECT * from `bill` where payment_mode = \'cash\' and DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()';
                                                $result = $conn->query($sql);
                                                // check_out_time is NULL and
                                                if ($result->num_rows > 0) {
                                                    // output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo '<tr>
                                                    <td class="text-center">' . $row['id'] . '</td>
                                                    <td class="text-center">' . $row['order_id'] . '</td>
                                                    <td>' . $row['date'] . '</td>
                                                    <td>' . $row['sub_total'] . '</td>
                                                    <td>' . $row['gen_sales_tax'] . '</td>
                                                    <td>' . $row['discount'] . '</td>                                                    
                                                    <td>' . $row['grand_total'] . '</td>                                                    
                                                </tr>';


                                                    }
                                                }




                                                ?>







                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

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
    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();
    });


    $("#submit").click(function() {

        $.ajax({
            url:"api/api-updateSetting.php",
            type:"POST",

            data:{
                tax:  $('#taxPercentage').val()


            },
            success:function(data) {
                //console.log(data);
                if(data == "1"){
                    $.notify({
                        icon: "notifications",
                        message: "Settings Saved."

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
                    //console.log(data);
                    $.notify({
                        icon: "notifications",
                        message: "Error. Settings not Saved."

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
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
            aaSorting: [[0, 'desc']],
            bdestroy: true

        });

		 $('#datatables1').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            },
             aaSorting: [[0, 'desc']],
             bdestroy: true

        });
		
		

        var table1 = $('#datatables').DataTable();
        var table2 = $('#datatables1').DataTable();



         $( "#today1" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized.php",
                 type:"POST",
                 data:{
                     day: "today"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody1').contents().remove();
                         $( "#tableBody1" ).append(data);

                         $('#datatables').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#yesterday1" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized.php",
                 type:"POST",
                 data:{
                     day: "yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody1').contents().remove();
                         $( "#tableBody1" ).append(data);

                         $('#datatables').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#today-yesterday1" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized.php",
                 type:"POST",
                 data:{
                     day: "today-yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody1').contents().remove();
                         $( "#tableBody1" ).append(data);

                         $('#datatables').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#range1" ).click(function() {
             //table.clear();
             console.log($("#dateFrom").val());

             $.ajax({
                 url:"api/api-fetchBillCustomized.php",
                 type:"POST",
                 data:{
                     day: "range",
                     to: $("#dateTo1").val(),
                     from: $("#dateFrom1").val()
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody1').contents().remove();
                         $( "#tableBody1" ).append(data);

                         $('#datatables').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });









         $( "#today2" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized2.php",
                 type:"POST",
                 data:{
                     day: "today"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables1").DataTable().destroy();

                         $('#tableBody2').contents().remove();
                         $( "#tableBody2" ).append(data);

                         $('#datatables1').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#yesterday2" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized2.php",
                 type:"POST",
                 data:{
                     day: "yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables1").DataTable().destroy();

                         $('#tableBody2').contents().remove();
                         $( "#tableBody2" ).append(data);

                         $('#datatables1').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#today-yesterday2" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchBillCustomized2.php",
                 type:"POST",
                 data:{
                     day: "today-yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables1").DataTable().destroy();

                         $('#tableBody2').contents().remove();
                         $( "#tableBody2" ).append(data);

                         $('#datatables1').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });



         $( "#range2" ).click(function() {
             //table.clear();
             console.log($("#dateFrom").val());

             $.ajax({
                 url:"api/api-fetchBillCustomized2.php",
                 type:"POST",
                 data:{
                     day: "range",
                     to: $("#dateTo2").val(),
                     from: $("#dateFrom2").val()
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables1").DataTable().destroy();

                         $('#tableBody2').contents().remove();
                         $( "#tableBody2" ).append(data);

                         $('#datatables1').DataTable({
                             "pagingType": "full_numbers",
                             "lengthMenu": [
                                 [10, 25, 50, -1],
                                 [10, 25, 50, "All"]
                             ],
                             responsive: true,
                             language: {
                                 search: "_INPUT_",
                                 searchPlaceholder: "Search records",
                             },
                             aaSorting: [[0, 'desc']],
                             bdestroy: true

                         });
                     }
                 },
                 error:function(){
                     console.log("error");
                 }

             });
         });





         demo.initFormExtendedDatetimepickers();

         $('.card .material-datatables label').addClass('form-group');
    });

</script>

</html>