<?php
include "api/config.php";
session_start();



?>


<!DOCTYPE html>
<!--
    Copyright (c) 2012-2016 Adobe Systems Incorporated. All rights reserved.

    Licensed to the Apache Software Foundation (ASF) under one
    or more contributor license agreements.  See the NOTICE file
    distributed with this work for additional information
    regarding copyright ownership.  The ASF licenses this file
    to you under the Apache License, Version 2.0 (the
    "License"); you may not use this file except in compliance
    with the License.  You may obtain a copy of the License at

    http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing,
    software distributed under the License is distributed on an
    "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
     KIND, either express or implied.  See the License for the
    specific language governing permissions and limitat ions
    under the License.
-->
<html>

<head>
    <meta charset="utf-8"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <!-- This is a wide open CSP declaration. To lock this down for production, see below. -->
    <meta http-equiv="Content-Security-Policy"
          content="default-src * 'unsafe-inline'; style-src 'self' 'unsafe-inline'; media-src *"/>
    <!-- Good default declaration:
    * gap: is required only on iOS (when using UIWebView) and is needed for JS->native communication
    * https://ssl.gstatic.com is required only on Android and is needed for TalkBack to function properly
    * Disables use of eval() and inline scripts in order to mitigate risk of XSS vulnerabilities. To change this:
        * Enable inline JS: add 'unsafe-inline' to default-src
        * Enable eval(): add 'unsafe-eval' to default-src
    * Create your own at http://cspisawesome.com
    -->
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self' data: gap: 'unsafe-inline' https://ssl.gstatic.com; style-src 'self' 'unsafe-inline'; media-src *" /> -->

    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.2.1.min.js"></script>
    <title>Hello World</title>
</head>
<script>


    function changeOrderStatus(orderId){



        $.ajax({
            url: "api/changeOrderStatus.php",
            type: "POST",
            data: {
                orderId: <?php echo $_GET['orderId']; ?>
            },
            success: function (data) {
                if (data == "1") {
                    pullOrder(orderId);
                    alert("Order Submited!");
                    $.ajax({
                        url:"../restuarant/autoPrintSystem/autoPrintSystem.php",
                        type:"POST",
                        data:{
                            id: orderId,
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
                else {
                    alert(data);
                }
            },
            error: function () {
                alert("Server error.");
            }

        });
    }






    

    function deleteOneDish(orderItemId){
        $.ajax({
            url: "api/deleteOneDish.php",
            type: "POST",
            data: {
                orderId: orderItemId
            },
            success: function (data) {
                if (data == "1") {
                    pullOrder(<?php echo $_GET['orderId']; ?>);
                }
                else {
                    alert("Someting went worng");
                }
            },
            error: function () {
                alert("Server error.");
            }

        });
    }






    $( document ).ready(function() {
        $.ajax({
            url: "api/pullOrder.php",
            type: "POST",
            data: {
                orderId: <?php echo $_GET['orderId'] ?>
            },
            success: function (data) {
                if (data) {
                    jQuery('#addOrderHere').html('');
                    jQuery('#addOrderHere').html(data);
                }

            },
            error: function () {
                alert("Server error.");
            }

        });
    });




    function saveOrder(dishId,orderId,addonName,quantity){
        var arrayAddon = [];
        var notes = $('#dishNotes'+addonName).val();
        $("input:checkbox[name="+addonName+"]:checked").each(function(){
            arrayAddon.push($(this).val());
        });

       // console.log(quantity.id);

        var quantityValue = document.getElementById(quantity.id).value;

        if(quantityValue == 0)
        {
            quantityValue = 1;
        }

        //console.log(quantityValue);

        $.ajax({
            url: "api/addOrder.php",
            type: "POST",

            data: {
                orderId: orderId, dishId: dishId, addonList: arrayAddon, orderNotes: notes, quantity: quantityValue
            },
            success: function (data) {

                if (data == '1') {
                        pullOrder(orderId);
                    $('.modal').modal('hide');
                }
                else {
                    alert(data);
                }
            },
            error: function () {
                alert("Server error.");
            }

        });
    }


    function pullOrder(orderId){

        $.ajax({
            url: "api/pullOrder.php",
            type: "POST",
            data: {
                orderId: orderId
            },
            success: function (data) {
                if (data) {
                    jQuery('#addOrderHere').html('');
                    jQuery('#addOrderHere').html(data);
                }
                else {
                    alert("Someting went worng");
                }
            },
            error: function () {
                alert("Server error.");
            }

        });
    }




    function displayDishes(typeId) {
        $.ajax({
            url: "api/displayDishes.php",
            type: "POST",

            data: {
                typeId: typeId, orderId: <?php echo $_GET['orderId'] ?>
            },
            success: function (data) {
                if (data) {
                    jQuery('#dishesList').html('');
                    jQuery('#dishesList').html(data);
                }
            },
            error: function () {
                alert("Server error.");
            }

        });
    }
</script>


<?php
$tableName = '';
$sql = 'select * from table_status where table_id = ' . $_GET['tableId'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $tableName = $row['name'];
    }
}

?>


<body class="mainbody">
<div class="col-xs-6 padd-gap">
    <a style="color: white;" href="table.php"><button style="width:80px;" class="theme-btn btn btn-default"><</button></a>
    <span class="table_no"><?php echo $tableName;?></span>
    <span class="waiter_name"><?php echo $_SESSION['username']?></span>
    <span class="waiter_name">Order #: <?php echo $_GET['orderId']?></span>
</div>
<div class="col-xs-6 text-right padd-gap">
    <ul class="top-head">
        <li>

        </li>
        <li>
            <button type="button" class="btn btn-default theme-btn" onclick="changeOrderStatus(<?php echo $_GET['orderId']; ?>)">Confirm</button>
        </li>
        <li>
            
        </li>
    </ul>
</div>
<div class="col-xs-6"></div>
<div class="col-md-12 col-sm-12 col-xs-12 zero_padd">
    <div class="col-md-2 col-sm-2 dishes-box zero_padd">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Categories</h3>
            </div>
            <div class="list-group">
<?php
                $sql = 'select * from item_type';
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                        echo '<button type="button" class="list-group-item" onclick="displayDishes('.$row['id'].')"><b>'.$row['name'].'</b></button>';
                    }
                }
?>


            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 dishes-box zero_padd">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Dishes</h3>
            </div>


            <div id="dishesList">
            </div>

        </div>
    </div>
    <div class="col-md-4 col-sm-4 dishes-box zero_padd">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Order Details</h3>
            </div>
            <div class="panel panel-default">
                <div class="panel-body zero_padd">
                    <div class="col-xs-12">
                        <div class="col-xs-3 text-left padd text-center">
                            <p><b>Qty</b></p>
                        </div>
                        <div class="col-xs-3 text-center padd">
                            <p><b>Item</b></p>
                        </div>
                        <div class="col-xs-3 text-right padd">
                            <p><b>Price</b></p>
                        </div>
                        <div class="col-xs-3 text-right padd">
                            <p><b>Delete</b></p>
                        </div>
                    </div>
                    <div class="col-xs-12">


                        <div id="addOrderHere" class="row">
                        </div>






                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Addons</h4>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="form-group form-inline">
                            <input type="checkbox" name="addons" id="cheese">
                            <label for="cheese">Extra Cheese</label>
                        </div>
                        <div class="form-group form-inline">
                            <input type="checkbox" name="addons" id="ketchup">
                            <label for="ketchup">Extra Ketchup</label>
                        </div>
                        <div class="form-group form-inline">
                            <input type="checkbox" name="addons" id="Mayonese">
                            <label for="Mayonese">Extra Mayonese</label>
                        </div>
                        <div class="form-group form-inline">
                            <input type="checkbox" name="addons" id="Sauce">
                            <label for="Sauce">Extra Sauce</label>
                        </div>
                        <div class="form-group">
                            <div class="panel panel-default">
                                <div class="panel-heading"
                                     style="background-color: white !important; color: black !important;">
                                    <h3 class="panel-title">Extra Notes</h3>
                                </div>
                                <div class="panel-body">
                                    <textarea name="" id="" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" >Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="cordova.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript">
    app.initialize();
</script>
</body>

</html>