<?php 
	
	session_start();
	
	if (!(isset($_SESSION['username'])  ))
	{
		 header('Location: index.php');
	}


include "api/config.php";


$sub_total_calculated = '';
$sales_tax_calculated = 0; //gst amount
$sub_total_calculated_wastage = '';
$total_cost_calculated = 0;

$sales_tax_calculated2 = 0; //
$sales_tax_calculated2_rate = 0; //
$sales_tax_percentage_db = 0; //gst rate



$conn44 = new mysqli("localhost", "root", "", "resturant");
$sql44 = "SELECT * FROM `accounts_setting` where id=1";
$result44 = mysqli_query($conn44, $sql44);




if (mysqli_num_rows($result44) > 0) {
    while ($row44 = mysqli_fetch_assoc($result44)) {
        $sales_tax_percentage_db = $row44['sales_tax_percentage'];
        $sales_tax_calculated2_rate =  $row44['sales_tax'];
    }
}



$conn4 = new mysqli("localhost", "root", "", "resturant");
$sql4 = "select * from `order` where check_out_time is null or total_cost is null;";
$result4 = mysqli_query($conn4, $sql4);

if (mysqli_num_rows($result4) > 0) {
    while ($row4 = mysqli_fetch_assoc($result4)) {




        $conn9 = new mysqli("localhost", "root", "", "resturant");
        $sql9 = "select oi.id,oi.total_price as oldTotal, i.price_per_unit*oi.quantity as newTotal from order_items oi, item i where oi.item_id = i.id and oi.order_id = " . $row4['id'];
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




        $conn2 = new mysqli("localhost", "root", "", "resturant");
        $sql2 = "select sum(total_price) as total from `order_items` where order_id = '".$row4['id']."'";
        $result2 = mysqli_query($conn2, $sql2);

        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                $sub_total_calculated = $row2['total'];



                $conn7 = new mysqli("localhost", "root", "", "resturant");
                $sql7 = "select a.name, a.price from order_items oi, order_items_addon oia, addon a where oia.order_items_id = oi.id and a.id = oia.addon_id and oi.order_id='".$row4['id']."'";
                $result7 = mysqli_query($conn7, $sql7);

                if (mysqli_num_rows($result7) > 0) {
                    while ($row7 = mysqli_fetch_assoc($result7)) {
                        $sub_total_calculated += $row7['price'];
                    }
                }



            }
        }


        $conn3 = new mysqli("localhost", "root", "", "resturant");
        $sql3 = "select sum(total_price) as total from `order_items` where wastage_status='Yes' and order_id = '".$row4['id']."'";
        $result3 = mysqli_query($conn3, $sql3);

        if (mysqli_num_rows($result3) > 0) {
            while ($row3 = mysqli_fetch_assoc($result3)) {
                $sub_total_calculated_wastage = $row3['total'];

            }
        }


        if(isset($sub_total_calculated)){
            $sales_tax_calculated = ($sub_total_calculated-$sub_total_calculated_wastage)  * $sales_tax_percentage_db;
            //$sales_tax_calculated2 = ($sub_total_calculated-$sub_total_calculated_wastage)  * $sales_tax_calculated2_rate;

        }






        if(isset($sub_total_calculated)){
            $total_cost_calculated = $sub_total_calculated + $sales_tax_calculated - $sub_total_calculated_wastage;
        }




        $conn73 = new mysqli("localhost", "root", "", "resturant");
        $sql73 = "select discount from `order` where id='".$row4['id']."'";
        $result73 = mysqli_query($conn73, $sql73);

        if (mysqli_num_rows($result73) > 0) {
            while ($row73 = mysqli_fetch_assoc($result73)) {
                if($row73['discount'] != '0.00'){
                    $total_cost_calculated = $total_cost_calculated - $row73['discount'];
                }
            }
        }






        $conn55 = new mysqli("localhost", "root", "", "resturant");
        $sql55 = "UPDATE `order` SET `total_cost` = '".$total_cost_calculated."', `sub_total` = '".$sub_total_calculated."', `gen_sales_tax` = '".$sales_tax_calculated."' WHERE `order`.`id` = ".$row4['id'].";";
       // echo $sql55;
        $result55 = mysqli_query($conn55, $sql55);

        if (!($conn55->query($sql55) === TRUE)) {
            echo "No previous orders.";
        }


    }
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

<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>




<script>

    function fetchCustomized(day){
        $( "#today" ).click(function() {
            //table.clear();

            $.ajax({
                url:"api/api-fetchOrderCustomized.php",
                type:"POST",
                data:{
                    day: "today"
                },
                success:function(data) {
                    //console.log(data);
                    if(data != "0"){
                        $("#datatables").DataTable().destroy();

                        $('#tableBody').contents().remove();
                        $( "#tableBody" ).append(data);

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
    }




    function fetch(){
        //alert("abc");
        $.ajax({
            url:"api/api-fetchOrder.php",
            type:"POST",

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



    function edit(id){
        var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/order-details.php?id="+id);
        window.location.href = path;
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
                        <a class="navbar-brand" href="#"> Order </a>
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









                    <div class="row animated" id=displayTable>
               <!--         < class="col-md-12"> -->
                        <a href="../picollo"><button type="button" class="btn btn-rose pull-right" name="" id="">Book an Order<div class="ripple-container"></div></button></a>
                            <div class="card">

                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title">Orders List</h4>

                                <div class="card-content">
								 <div class="toolbar">
                                     <div class="row">

                                     <button type=button class="btn btn-info" name=today id=today onclick="fetchCustomized('today')">Today</button>

                                             <button type=button class="btn btn-warning" name=today id=yesterday onclick="fetchCustomized('yesterday')">Yesterday</button>

                                                 <button type=button class="btn btn-rose" name=today id=today-yesterday onclick="fetchCustomized('today-yesterday')">Today/Yesterday</button>


                                         <div class="col-md-2 pull-right">
                                             <button type=button class="btn  btn-primary" name=go id=range onclick="">Go</button>
                                         </div>
                                         <div class="col-md-2 pull-right">
                                             <label style="color:black;"><b>To</b></label>
                                             <input type="text" class="form-control datepicker" id="dateTo" value="">
                                         </div>
                                    <div class="col-md-2 pull-right">
                                        <label style="color:black;"><b>From</b></label>
                                        <input type="text" class="form-control datepicker" id="dateFrom" value="">
                                    </div>


                                    </div>
                                 </div>
                                    <div class="material-datatables">
                                        <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                                            <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Table Name</th>
                                                <th>Check In Time</th>
                                                <th>Check Out Time</th>
                                                <th># of People</th>
                                                <th>Net Bill</th>
                                                <th class="text-right">Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody id=tableBody>




                                            <script>
                                                fetch();
                                            </script>



                                            </tbody>
                                        </table>
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


        var table = $('#datatables').DataTable();

         $( "#today" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchOrderCustomized.php",
                 type:"POST",
                 data:{
                     day: "today"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody').contents().remove();
                         $( "#tableBody" ).append(data);

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



         $( "#yesterday" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchOrderCustomized.php",
                 type:"POST",
                 data:{
                     day: "yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody').contents().remove();
                         $( "#tableBody" ).append(data);

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



         $( "#today-yesterday" ).click(function() {
             //table.clear();

             $.ajax({
                 url:"api/api-fetchOrderCustomized.php",
                 type:"POST",
                 data:{
                     day: "today-yesterday"
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody').contents().remove();
                         $( "#tableBody" ).append(data);

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



         $( "#range" ).click(function() {
             //table.clear();
             console.log($("#dateFrom").val());

             $.ajax({
                 url:"api/api-fetchOrderCustomized.php",
                 type:"POST",
                 data:{
                     day: "range",
                     to: $("#dateTo").val(),
                     from: $("#dateFrom").val()
                 },
                 success:function(data) {
                     //console.log(data);
                     if(data != "0"){
                         $("#datatables").DataTable().destroy();

                         $('#tableBody').contents().remove();
                         $( "#tableBody" ).append(data);

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





         $('.card .material-datatables label').addClass('form-group');
         demo.initFormExtendedDatetimepickers();

    });
</script>

</html>