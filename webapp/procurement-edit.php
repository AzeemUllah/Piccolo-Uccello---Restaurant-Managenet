<?php

	session_start();
	
	if (!(isset($_SESSION['username'])  ))
	{
		 header('Location: index.php');
	}

if(($_SESSION['type'] == 'manager')){
    header('Location: index.php');
}


if (isset($_GET['id'])) {
    include "api/config.php";
    $id = $_GET['id'];
    $name = '';
    $quantity = '';
    $unit = '';
    $unitPrice = '';
    $order = '';
    $arival = '';
    $expiry = '';
$image = '';
$category = '';

    $sql = "SELECT * from procurement where id ='" . $id . "'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $quantity = $row['quantity'];
            $unit = $row['quantity_unit'];
            $unitPrice = $row['unit_price'];
            $order = $row['order_date'];
            $arival = $row['arival_date'];
            $expiry = $row['expire_date'];
            $image = $row['image'];
            $category = $row['category'];
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

<body>
<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>

<script>
    function fetch(){
        //alert("abc");
        $.ajax({
            url:"api/api-fetchProcurement.php",
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
                        <a class="navbar-brand" href="#"> Edit Procurement </a>
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
                                    <h4 class="card-title">Edit Procurement</h4>
                                </div>
                                <div class="card-content">

                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Name: </label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name=name id=name value='<?php echo $name; ?>'>
                                                <span class="help-block">Enter name of item.</span>
                                            </div>
                                        </div>

                                        <label class="col-sm-2 label-on-left">Quantity: </label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name=quantity id=quantity value='<?php echo $quantity; ?>'>
                                                <span class="help-block">Enter quantity of item.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">


                                        <label class="col-sm-2 label-on-left">Unit Price</label>
                                        <div class="col-sm-3">
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"></label>
                                                <input type="text" class="form-control" name=unitPrice id=unitPrice value='<?php echo $unitPrice; ?>'>
                                                <span class="help-block">Enter unit price.</span>
                                            </div>
                                        </div>


                                        <label class="col-sm-2 label-on-left">Unit of Measure</label>
                                        <div class="col-md-3">
                                            <select class="selectpicker" name=unit id=unit data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                <option disabled selected value="">Choose a unit</option>
                                                <option  <?php if($unit == 'gal') echo "selected"; ?> value="gal">Gallon</option>
                                                <option  <?php if($unit == 'ml') echo "selected"; ?>  value="ml">Milliliter</option>
                                                <option <?php if($unit == 'l') echo "selected"; ?>   value="l">Liter</option>
                                                <option  <?php if($unit == 'lb') echo "selected"; ?>  value="lb">Pound</option>
                                                <option  <?php if($unit == 'oz') echo "selected"; ?>  value="oz">Ounce</option>
                                                <option <?php if($unit == 'mg') echo "selected"; ?>   value="mg">Miligram</option>
                                                <option  <?php if($unit == 'g') echo "selected"; ?>  value="g">Gram</option>
                                                <option  <?php if($unit == 'kg') echo "selected"; ?>  value="kg">Kilogram</option>
                                                <option  <?php if($unit == 'unit') echo "selected"; ?>  value="unit">Unit</option>

                                            </select>
                                        </div>

                                    </div>



                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Order Date</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" id=order name=order value="<?php echo $order; ?>">
                                            <span class="material-input"></span>
                                        </div>


                                        <label class="col-sm-2 label-on-left">Arival Date</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" id=arival name=arival value="<?php echo $arival; ?>">
                                            <span class="material-input"></span>
                                        </div>



                                    </div>


									<div class="row">


                                        <label class="col-sm-2 label-on-left">Expiry Date</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control datepicker" id=expiry name=expiry value="<?php echo $expiry; ?>">
                                            <span class="material-input"></span>
                                        </div>





                                        <label class="col-sm-2 label-on-left">Item Category: </label>
                                        <div class="col-md-4">
                                            <select class="selectpicker" name=itemCategory id=itemCategory data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                                <option disabled value="">Choose a Category</option>
                                                <option <?php if($category == 'meat') echo "selected"; ?> value="meat">Meat</option>
                                                <option <?php if($category == 'sauses') echo "selected"; ?> value="sauses">Sauses</option>
                                                <option <?php if($category == 'vegetable') echo "selected"; ?> value="vegetable">Vegetable</option>
                                                <option <?php if($category == 'fruits') echo "selected"; ?> value="fruits">Fruits</option>
                                                <option <?php if($category == 'nuts') echo "selected"; ?> value="nuts">Nuts</option>
                                                <option <?php if($category == 'bakery') echo "selected"; ?> value="bakery">Bakery</option>
                                                <option <?php if($category == 'can') echo "selected"; ?> value="can">Can</option>
                                                <option <?php if($category == 'housekeeping') echo "selected"; ?> value="housekeeping">Housekeeping</option>
                                                <option <?php if($category == 'tools') echo "selected"; ?> value="tools">Tools</option>
                                                <option <?php if($category == 'beverages') echo "selected"; ?> value="beverages">Beverages</option>
                                            </select>
                                        </div>






									</div>



                                    <div class="row">
                                        <label class="col-sm-2 label-on-left">Procurement Image: </label>
                                        <div class="fileinput fileinput-new text-center col-md-3" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail" id="imageDiv2">
                                                <?php if(isset($image)){
                                                    echo '<img id=myimg src="'.$image.'" alt="...">';
                                                }
                                                else{
                                                    echo '<img src="assets/img/image_placeholder.jpg" alt="...">';
                                                }?>
                                            </div>
                                            <div id=imageDiv class="fileinput-preview fileinput-exists thumbnail">

                                            </div>
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






									


                                    <div class="row">

                                       
                                            <input type="text" style='display:none;' class="form-control " id=id name=id value="<?php echo  $_GET['id']; ?>">
                                       

						
                                        
										<div class="col-md-12 text-right">
                                            <button type=button class="btn btn-rose" name=submit id=submit>Update Procurement<div class="ripple-container"></div></button>
                                        </div>
                                    </div>



                                </div>
                            </form>
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
    function getBase64Image(img) {
        var canvas = document.createElement("canvas");
        canvas.width = img.width;
        canvas.height = img.height;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);
        var dataURL = canvas.toDataURL("image/png");
        return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
    }

    $(document).ready(function() {

        // Javascript method's body can be found in assets/js/demos.js

        //md.initSliders()
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-chevron-up",
                down: "fa fa-chevron-down",
                previous: 'fa fa-chevron-left',
                next: 'fa fa-chevron-right',
                today: 'fa fa-screenshot',
                clear: 'fa fa-trash',
                close: 'fa fa-remove',
                inline: true
            }
        });
        //demo.initFormExtendedDatetimepickers();
    });



    $("#submit").click(function() {
//alert("abc");
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
            url:"api/api-updateProcurement.php",
            type:"POST",

            data:{
                name:  $('#name').val(),
                quantity:  $('#quantity').val(),
                unit_price:  $('#unitPrice').val(),
                quantity_unit:  $('#unit').val() ,
                expiry_date: $('#expiry').val(),
                order_date: $('#order').val(),
                arival_date: $('#arival').val(),
				id: $('#id').val(),
                procurementImage: mysrc,
                itemCategory: jQuery("#itemCategory option:selected").val()

            },
            success:function(data) {
               // console.log(data);
                if(data == "1"){
/*
                    $("#tableName").val('');
                    fetch();
                    $('#name').val('');
                    $('#quantity').val('');
                    $('#unitPrice').val('');
                    $('#unit').val('');
                    $('#expiry').val('');
*/
                    //console.log(data);
                    $.notify({
                        icon: "notifications",
                        message: "Procurement Inserted."

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
                    console.log(data);
                    $.notify({
                        icon: "notifications",
                        message: "Error. Procurement not added."

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