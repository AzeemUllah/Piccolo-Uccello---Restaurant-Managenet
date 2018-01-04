<?php

session_start();

if (!(isset($_SESSION['username']) )) {
    header('Location: index.php');
}
include "api/config.php";

?>

<?php
$sql = "SELECT * FROM inventory";
$result = $conn->query($sql);
$toPrint = '';
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        $toPrint .= '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png"/>
    <link rel="icon" type="image/png" href="assets/img/favicon.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <title>Resturant Management System</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport'/>
    <meta name="viewport" content="width=device-width"/>
    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!--  Material Dashboard CSS    -->
    <link href="assets/css/material-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet"/>
    <!--     Fonts and icons     -->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
    <link rel="stylesheet" type="text/css" href="assets/css/material-icons.css" />
</head>
<body>
<script src="assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="assets/js/jquery-ui.min.js" type="text/javascript"></script>


<script>

    function edit(id){
        var path = (window.location.pathname.split('/').slice(0, -1).join('/') + "/edit-dish.php?id="+id);
        window.location.href = path;
    }




    function fetchIngredient() {
        //alert("abc");
        $.ajax({
            url: "api/api-fetchIngredient.php",
            type: "POST",

            success: function (data) {
                //console.log(data);
                if (data != "0") {
                    $('#tableBody').contents().remove();
                    $("#tableBody").append(data);
                }


            },
            error: function () {
                console.log("error");

            }

        });
    }


    function fetch() {
        //alert("abc");
        $.ajax({
            url: "api/api-fetchDish.php",
            type: "POST",

            success: function (data) {
                //console.log(data);
                if (data != "0") {
                    $('#tableBody').contents().remove();
                    $("#tableBody").append(data);
                }


            },
            error: function () {
                console.log("error");

            }

        });
    }


    function del(id) {
        $.ajax({
            url: "api/api-deleteDish.php",
            type: "POST",

            data: {
                id: id
            },
            success: function (data) {
                //console.log(data);
                fetch();
                if (data == "1") {
                    //console.log(data);
                    $.notify({
                        icon: "notifications",
                        message: "Cosine Deleted."

                    }, {
                        type: "success",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });


                }
                else {
                    $.notify({
                        icon: "notifications",
                        message: "Error. Cosine not Deleted."

                    }, {
                        type: "rose",
                        timer: 3000,
                        placement: {
                            from: "top",
                            align: "right"
                        }
                    });
                }

            },
            error: function () {
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
                    <img src=
                         <?php echo "'" . $_SESSION['image_url'] . "'" ?>/>
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
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> Dish </a>
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
                        <form method="get" id=form1 action="/" class="form-horizontal">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Dish Discription</h4>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Dish Name: </label>
                                    <div class="col-sm-5">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=dishName id=dishName value=''>
                                            <span class="help-block">Enter name of cosine.</span>
                                        </div>
                                    </div>
                                    <label class="col-md-2 label-on-left">Cosine</label>
                                    <div class="col-md-3">
                                        <select class="selectpicker" name=cosineId id=cosineId
                                                data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                            <option disabled selected>Choose Cosine</option>
                                            <?php
                                            $sql = "SELECT * FROM item_category";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['category_name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row"></div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Dish Price: </label>
                                    <div class="col-sm-5">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=dishPrice id=dishPrice
                                                   value=''>
                                            <span class="help-block">Enter price of Dish.</span>
                                        </div>
                                    </div>
                                    <label class="col-md-2 label-on-left">Type</label>
                                    <div class="col-md-3">

                                        <select class="selectpicker" name=typeId id=typeId
                                                data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                            <option disabled selected>Choose Type</option>


                                            <?php

                                            $sql = "SELECT * FROM  item_type";
                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                                // output data of each row
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Description: </label>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <textarea type="textarea" class="form-control" name=description
                                                      id=description value=''></textarea>
                                        </div>
                                    </div>
                                    <label class="col-sm-3 label-on-left">Prepration time: </label>
                                    <div class="col-sm-2">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=prepration id=prepration
                                                   value=''>
                                            <span class="help-block">Enter time in minutes.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">



                                    <label class="col-md-2 label-on-left">Location</label>
                                    <div class="col-md-3">

                                        <select class="selectpicker" name=locationId id=locationId
                                                data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                            <option disabled selected>Choose Location</option>
                                            <option value="Kitchen" > Kitchen </option>
                                            <option value="Bar" > Bar </option>
                                        </select>
                                    </div>




                                    <label class="col-sm-2 label-on-left">Dish Image: </label>
                                    <div class="col-md-5 fileinput fileinput-new text-center" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="assets/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div id=imageDiv class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
																	<span class="btn btn-rose btn-round btn-file">
																		<span class="fileinput-new">Select image</span>
																		<span class="fileinput-exists">Change</span>
																		<input type="file" name="cosineImage"/>
																	</span>
                                            <a id=removeImage href="#pablo"
                                               class="btn btn-danger btn-round fileinput-exists"
                                               data-dismiss="fileinput">
                                                <i class="fa fa-times"></i> Remove
                                            </a>
                                        </div>
                                    </div>



                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <form method="get" action="/" id=form2 class="form-horizontal">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Dish Addons</h4>
                            </div>
                            <div class="card-content">
                                <div class="row">
                                    <label class="col-sm-2 label-on-left">Addon Name: </label>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=addonName1 id=addonName1
                                                   value=''>
                                            <span class="help-block">Enter name of addon.</span>
                                        </div>
                                    </div>
                                    <label class="col-sm-2 label-on-left">Addon Price: </label>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=addonPrice1 id=addonPrice1
                                                   value=''>
                                            <span class="help-block">Enter Price of addon.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id=addAddon></div>
                                <div class="row">
                                    <div class='text-right'>
                                        <button class="btn btn-just-icon btn-round btn-rose" id=recipyButton
                                                type="button">
                                            <i class="material-icons">note_add</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <form method="get" id=form3 action="/" class="form-horizontal">
                            <div class="card-header card-header-text" data-background-color="rose">
                                <h4 class="card-title">Dish Ingredients</h4>
                            </div>
                            <div class="card-content">
                                <div class="row" id="ingredientFirstDiv">
                                    <label class="col-md-2 label-on-left">Ingredient Name: </label>
                                    <div class="col-md-3">
                                        <select class="selectpicker" id=ingredientId1 name=ingredientId1
                                                data-style="btn btn-rose btn-round" title="Single Select" data-size="7">
                                            <option disabled selected>Choose Ingredient</option>
                                            <?php echo $toPrint; ?>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 label-on-left">Ingredient Quantity: </label>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="control-label"></label>
                                            <input type="text" class="form-control" name=ingredientQuantity1
                                                   id=ingredientQuantity1 value=''>
                                            <span class="help-block">Enter Price of addon.</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id=addIngredient></div>
                                <div class="row">
                                    <div class='text-right'>
                                        <button class="btn btn-just-icon btn-round btn-rose" id=ingredientButton
                                                type="button">
                                            <i class="material-icons">note_add</i>
                                            <div class="ripple-container"></div>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-12 text-right">
                                    <button type=button class="btn btn-rose" name=submit id=submit>Add Dish
                                        <div class="ripple-container"></div>
                                    </button>
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
                            <h4 class="card-title">Dish Types</h4>
                            <div class="card-content">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Name</th>
                                            <th>Price per Unit</th>
                                            <th>Prepration Time</th>
                                            <th>Description</th>
                                            <th>Cosine Name</th>
                                            <th>Type Name</th>
                                            <th>Image</th>
                                            <th class="text-right">Actions</th>
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
                <nav class="pull-left"></nav>
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
    $(document).ready(function () {

        // Javascript method's body can be found in assets/js/demos.js
        demo.initDashboardPageCharts();

        demo.initVectorMap();

        var countIngredient = 2;

        var php_var = '<?php echo $toPrint; ?>';

        $("#ingredientButton").click(function () {
            $('#addIngredient').before("<div class='row' id=''> <label class='col-md-2 label-on-left'>Ingredient Name: </label> <div class='col-md-3'> <select class='selectpicker' id=ingredientId" + countIngredient + " name=ingredientId" + countIngredient + " data-style='btn btn-rose btn-round' title='Single Select' data-size='7'> <option disabled selected>Choose Ingredient</option> " + php_var + " </select> </div> <label class='col-sm-2 label-on-left'>Ingredient Quantity: </label> <div class='col-sm-4'> <div class='form-group label-floating is-empty'> <label class='control-label'></label> <input type='text' class='form-control' name=ingredientQuantity" + countIngredient + " id=ingredientQuantity" + countIngredient + " value=''> <span class='help-block'>Enter Price of addon.</span> </div> </div> </div>");
            countIngredient = countIngredient + 1;
            $('.selectpicker').selectpicker();


        });

        var countRecipy = 2;

        $("#recipyButton").click(function () {

            $('#addAddon').before("<div class='row' id='result'> <label class='col-sm-2 label-on-left'>Addon Name: </label> <div class='col-sm-4'> <div class='form-group label-floating is-empty'> <label class='control-label'></label> <input type='text' class='form-control' name=addonName" + countRecipy + " id=addonName" + countRecipy + " value=''> <span class='help-block'>Enter name of addon.</span> </div> </div> <label class='col-sm-2 label-on-left'>Addon Price: </label> <div class='col-sm-4'> <div class='form-group label-floating is-empty'> <label class='control-label'></label> <input type='text' class='form-control' name=addonPrice" + countRecipy + " id=addonPrice" + countRecipy + " value=''> <span class='help-block'>Enter Price of addon.</span> </div> </div> </div>");


            countRecipy = countRecipy + 1;
        });


        $("#submit").click(function () {


            arrayAddonName = [];
            arrayAddonPrice = [];
            for (i = 1; i < countRecipy; i++) {
                if (!($("#addonName" + i).val().length == 0 || $("#addonPrice" + i).val().length == 0)) {
                    arrayAddonName.push($("#addonName" + i).val());
                    arrayAddonPrice.push($("#addonPrice" + i).val());
                }
            }

            arrayIngredientId = [];
            arrayIngredientQuantity = [];
            for (i = 1; i < countIngredient; i++) {

                arrayIngredientId.push($("#ingredientId" + i).val());
                arrayIngredientQuantity.push($("#ingredientQuantity" + i).val());

            }

            var mysrc = '';
            var someimage = document.getElementById('imageDiv');
            var myimg = someimage.getElementsByTagName('img')[0];


            if(myimg){
                mysrc = myimg.src;
            }
            else{
                mysrc = '<?php echo base64_encode(file_get_contents('assets/img/image_placeholder.jpg'));?>';
            }

            console.log(arrayAddonName);
            console.log(arrayAddonPrice);
            console.log(arrayIngredientId);
            console.log(arrayIngredientQuantity);

            $.ajax({
                url: "api/api-insertDish.php",
                type: "POST",
                data: {
                    name: $('#dishName').val(),
                    cosineId: jQuery("#cosineId option:selected").val(),
                    dishPrice: $('#dishPrice').val(),
                    typeId: jQuery("#typeId option:selected").val(),
                    description: $('#description').val(),
                    preprationTime: $('#prepration').val(),
                    locationName: $('#locationId').val(),
                    dishImageSrc: mysrc,

                    addonNames: arrayAddonName,
                    addonPrice: arrayAddonPrice,
                    ingredientIds: arrayIngredientId,
                    ingredientQuantities: arrayIngredientQuantity
                },
                success: function (data) {
                    //console.log(data);
                    if (data != "0") {
                        $('#form1')[0].reset();
                        $('#form2')[0].reset();
                        $('#form3')[0].reset();

                        //$("#typeId").prop("selectedIndex", 0);
                        $("#typeId").val('').selectpicker('refresh');
                        $("#cosineId").val('').selectpicker('refresh');
                        for (i = 1; i < countIngredient; i++) {

                            $("#ingredientId" + i).val('').selectpicker('refresh');
                        }


                        fetch();
                        $.notify({
                            icon: "notifications",
                            message: "Dish Inserted."

                        }, {
                            type: "success",
                            timer: 3000,
                            placement: {
                                from: "top",
                                align: "right"
                            }
                        });
                    }
                    else {
                        $.notify({
                            icon: "notifications",
                            message: "Error. Dish not added."

                        }, {
                            type: "rose",
                            timer: 3000,
                            placement: {
                                from: "top",
                                align: "right"
                            }
                        });
                    }


                },
                error: function () {
                    console.log("error");

                }

            });
        });


    });


</script>
</html>