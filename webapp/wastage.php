<?php
include "api/config.php";
	session_start();
	
	if (!(isset($_SESSION['username'])  ))
	{
		 header('Location: index.php');
	}
if(($_SESSION['type'] == 'manager')){
    header('Location: index.php');
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


    function fetch(){
        //alert("abc");
        $.ajax({
            url:"api/api-fetchWastage.php",
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







    function approve($id){
        //alert("abc");
        $.ajax({
            url:"api/api-approveWastage.php",
            type:"POST",
            data:{
                id:  $id

            },
            success:function(data) {
                //console.log(data);
                if(data != "0"){
                    fetch();

                    $.notify({
                        icon: "notifications",
                        message: "Wastage Approved."

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
                        message: "Error. Wastage not approved."

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
                        <a class="navbar-brand" href="#"> Wastage </a>
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
                        <div class="card">
                            <form method="get" action="/" class="form-horizontal">
                                <div class="card-header card-header-text" data-background-color="rose">
                                    <h4 class="card-title">Add Wastage</h4>
                                </div>
                                <div class="card-content">

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Select Item: </label>
                                        <div class="col-sm-3">
                                            <select class="selectpicker" name=inventoryId id=inventoryId data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                <option disabled selected>Choose Type</option>

                                                <?php
                                                $sql = "select id, name from `inventory` ";
                                                $result = $conn->query($sql);

                                                if ($result->num_rows > 0) {
                                                    while($row = $result->fetch_assoc()) {
                                                        echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>



                                        <label class="col-sm-2 label-on-left">Wastage Category: </label>
                                        <div class="col-sm-3">
                                            <select class="selectpicker" name=categoryType id=categoryType data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                <option disabled selected>Choose Type</option>
                                                <option value="damaged" >Damaged</option>
                                                <option value="stolen" >Stolen</option>
                                                <option value="misplaced" >Misplaced</option>
                                            </select>
                                        </div>






                                    </div>

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left"></label>
                                        <div class="col-md-3">
                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" id="imageDiv2">
                                                </div>
                                                <div id=imageDiv class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                </div>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Quantity: </label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name=quantity id=quantity value=''>
                                                <span class="help-block">Enter quantity of item wasted.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">








                                        <label class="col-sm-2 label-on-left">Wastage Image: </label>
                                        <div class="col-md-3">
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" id="imageDiv2">
                                                <img src="assets/img/image_placeholder.jpg" alt="...">
                                            </div>
                                            <div id=imageDiv class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                    <span class="btn btn-rose btn-round btn-file">
                                                        <span class="fileinput-new">Select image</span>
                                                        <span class="fileinput-exists">Change</span>
                                                        <input type="file" name="cosineImage" />
                                                    </span>
                                                <a id=removeImage href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Wastage Reason: </label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <textarea type="text" class="form-control" name=quantity id=quantity></textarea>
                                                <span class="help-block">Enter Details of item wasted.</span>
                                            </div>
                                        </div>


                                    </div>



                                    <div class="row">
                                        <div class="col-md-12 text-right">
                                            <button type=button class="btn btn-rose" name=submit id=submit>Add to Wastage<div class="ripple-container"></div></button>
                                        </div>
                                    </div>



                                </div>
                            </form>
                        </div>
                    </div>







                    <div class="row animated" id=displayTable>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="rose">
                                    <i class="material-icons">assignment</i>
                                </div>
                                <h4 class="card-title">Wastage</h4>
                                <div class="card-content">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>

                                                <th class="text-center">#</th>
                                                <th>Name</th>
                                                <th>Quantity</th>
                                                <th>Cost</th>
                                                <th>Category</th>
                                                <th>Approval</th>
                                                <th>Image</th>

                                                <th class="text-right">Approve</th>
                                            </tr>
                                            </thead>
                                            <tbody id=tableBody>
                                            <script> fetch();</script>
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


    $("#submit").click(function() {
        var mysrc = '';
        var someimage = document.getElementById('imageDiv');
        var myimg = someimage.getElementsByTagName('img')[0];


        if(myimg){
            mysrc = myimg.src;
        }
        else{
            mysrc = '<?php echo base64_encode(file_get_contents('assets/img/image_placeholder.jpg'));?>';
        }

        $.ajax({
            url:"api/api-putToWastageCustomized.php",
            type:"POST",

            data:{
                quantity:  $('#quantity').val(),
                inventoryId: jQuery("#inventoryId option:selected").val(),
                categoryType: jQuery("#categoryType option:selected").val(),
                image: mysrc
            },
            success:function(data){
               // console.log(data);
                if(data == "1"){
                 //   console.log(data);
                    fetch();
                    $.notify({
                        icon: "notifications",
                        message: "Item Marked as wastage."

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
                        message: "Item Not Marked as wastage."

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