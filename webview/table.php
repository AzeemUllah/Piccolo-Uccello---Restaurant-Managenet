<?php
include "api/config.php";
session_start();



?>
<!DOCTYPE html>

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


    <link rel="stylesheet" type="text/css" href="css/s_index.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <title>Table</title>
</head>
<script>
    function registerTable(tableId) {
        $.ajax({
            url: "api/registerTable.php",
            type: "POST",
            dataType: 'json',
            data: {
                tableId: tableId, numberPeople: $('#membersPeople'+tableId).val()
            },
            success: function (data) {
                console.log(data[0]);
                if (data[0] == '1') {
                    window.location.href = "./list.php?tableId="+tableId+"&orderId="+data[1];
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


    function redirectToList(orderId,tableId){
        window.location.href = "./list.php?tableId="+tableId+"&orderId="+orderId;
    }
    
</script>
<body class="mainbody">

<div class="col-md-12">

</div>


<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 5px;">


    <?php

    $sql = 'select * from table_status';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $orderId = '';
        $waiterName = '';
        $total_cost = '';
        $tableId = $row['table_id'];

        $conn2 = new mysqli("localhost", "root", "", "resturant");
        $sql2 = 'select id, total_cost, waiter_name from `order` where check_out_time is null and table_id =' . $row['table_id'];
        $result2 = $conn2->query($sql2);

        if ($result2->num_rows > 0) {
            while($row2 = $result2->fetch_assoc()) {
                $total_cost = $row2['total_cost'];
                $waiterName = $row2['waiter_name'];
                $orderId = $row2['id'];
            }
        }


            echo '<div class="col-md-4 col-sm-4 col-xs-4" ';


        if($row['status'] == 'No') {
            echo 'onclick = "redirectToList('.$orderId.','.$tableId.');"';
}


        echo ' data-toggle="modal" data-target="#myModal'.$row['table_id'].'" style="border: 2px solid #b91f25;background-color: white; padding: 0px;">
        <div class="col-md-12 col-sm-12 col-xs-12"><h4>'.$row['name'].'</h4></div>

        <!--manager name-->
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
            <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right: 0px;">
                <h5 style="margin: 0px;color: black;">Waiter: </h5>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0px;">
                <h5 style="margin: 0px;color: black;">'.$waiterName.'</h5>
            </div>
        </div>
<!--status-->
        <div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
            <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right: 0px;">
                <h5 style="margin: 0px;color: black;">Status: </h5>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0px;">
                ';

            if($row['status'] == 'Yes'){
                echo '<h5 style="margin: 0px;color: #59d359;font-weight: bold;">Avaliable</h5>
 </div>
        </div>';

        echo '<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
            <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right: 0px;padding-bottom: 10px">
                <h5 style="margin: 0px;color: black;">Amount: </h5>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0px;">
                <h5 style="margin: 0px;color: black;">Rs. </h5>
            </div>
        </div>
    </div>
';

                echo '<div id="myModal'.$row['table_id'].'" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Enter No.of Guests</label>
                            <input type="number" class="form-control" id="membersPeople'.$row['table_id'].'" placeholder="No.of Members">
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="registerTable('.$row['table_id'].');">ADD</button>
                </div>
            </div>

        </div>
    </div>';



            }
            else{
                echo '<h5 style="margin: 0px;color: red;font-weight: bold;font-size: 12px;">not-Available</h5>
                 </div>
                        </div>';


        echo '<div class="col-md-12 col-sm-12 col-xs-12" style="padding: 0px;">
            <div class="col-md-5 col-sm-5 col-xs-5" style="padding-right: 0px;padding-bottom: 10px">
                <h5 style="margin: 0px;color: black;">Amount: </h5>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6" style="padding: 0px;">
                <h5 style="margin: 0px;color: black;">'.$total_cost.'</h5>
            </div>
        </div>
    </div>';
            }









        }
    }

    ?>







</div>

<div class="col-md-12 col-sm-12 col-xs-12" style="padding-bottom: 5px;">



</div>



<!-- Modal -->



<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="cordova.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript">
    app.initialize();
</script>
</body>

</html>