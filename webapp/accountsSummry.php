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



    <script>
        function fetchCustomized(day){
            if(day == "today"){
                var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/accountsSummry.php?startDate="+moment().format('MM-DD-YY') + "&endDate="+moment().format('MM-DD-YY'));
                window.location.href = path;
            }
            else if(day == "yesterday"){
                var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/accountsSummry.php?startDate="+moment().add(-1, 'days').format('MM-DD-YY') + "&endDate="+moment().add(-1, 'days').format('MM-DD-YY'));
                window.location.href = path;
            }
            else if(day == "today-yesterday"){
                var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/accountsSummry.php?startDate="+moment().add(-1, 'days').format('MM-DD-YY') + "&endDate="+moment().format('MM-DD-YY'));
                window.location.href = path;
            }

            //window.frames["printf"].focus();
            //window.frames["printf"].print();
            //var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/recipt.php?id="+id);
            //window.location.href = path;
        }

        function go(){
            var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/accountsSummry.php?startDate="+$("#dateFrom").val() + "&endDate="+$("#dateTo").val());
            window.location.href = path;
        }

        function printBill(id){
            window.frames["printf"].focus();
            window.frames["printf"].print();
            //var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/recipt.php?id="+id);
            //window.location.href = path;
        }


    </script>
</head>

<body class="sidebar-mini">
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


<div class="row">
    <div class="col-md-7">
                <div class="card">

                        <div class="card-header card-header-text" data-background-color="rose">
                            <h4 class="card-title">Accounts Summary</h4>
                        </div>

                        <div class="card-content">

                            <div class="row">

                                <button type=button class="btn btn-info" name=today id=today onclick="fetchCustomized('today')">Today</button>

                                <button type=button class="btn btn-warning" name=today id=yesterday onclick="fetchCustomized('yesterday')">Yesterday</button>

                                <button type=button class="btn btn-rose" name=today id=today-yesterday onclick="fetchCustomized('today-yesterday')">Today/Yesterday</button>
                            </div>
                            <div class="row">
                                <div class="col-md-4 pull-right" style="padding-top: 25px;">
                                    <button type=button class="btn  btn-rose" onclick="go();" name=go id=range onclick="">Go<div class="ripple-container"></div></button>
                                </div>
                                <div class="col-md-4 pull-right">
                                    <label style="color:black;"><b>To</b></label>
                                    <input type="text" class="form-control datepicker" id="dateTo" value="">
                                </div>
                                <div class="col-md-4 pull-right">
                                    <label style="color:black;"><b>From</b></label>
                                    <input type="text" class="form-control datepicker" id="dateFrom" value="">
                                </div>


                            </div>



                        </div>

                </div>

    </div>

    <div class="col-md-4">
        <div class="card">

                <div class="card-header card-header-text" data-background-color="rose">
                    <h4 class="card-title">Accounts Summary</h4>
                </div>

                <div class="card-content">

                    <div class="row">
                        <iframe class="col-md-4 col-sm-4 col-xs-4" frameBorder="0" style="height: 650px; width:100%;" scrolling="yes" id="printf" name="printf" src="summry-report-preview.php?startDate=<?php echo $_GET['startDate'] ?>&endDate=<?php echo $_GET['endDate'] ?>"></iframe>
                    </div>

                    <div class="row">
                        <div class="col-md-4 pull-right" style="padding-top: 25px;">
                            <button type=button class="btn  btn-rose" onclick="printBill();" name=go id=range onclick="">Go<div class="ripple-container"></div></button>
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

        demo.initFormExtendedDatetimepickers();

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

</script>

</html>