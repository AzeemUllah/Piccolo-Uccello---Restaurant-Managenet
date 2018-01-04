<?php
include "config.php";
session_start();

$toReturn = '';
$sql = "select * from item where dist_type_id = " . $_POST['typeId'];
$result = $conn->query($sql);
$count = 0;


if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
            $toReturn .= '<div class="panel panel-default">
                <div class="panel-body zero_padd" data-toggle="modal" data-target="#dishModal'.$count.'">
                    <div class="col-xs-12 zero_padd">

                        <div class="col-xs-2 zero_padd">
                            <img src="'.$row['image_url'].'" alt="" width="90px">
                        </div>
                        <div class="col-xs-8">
                            <h4 class="margin-bottom-zero">'.$row['name'].'</h4>
                        </div>
                        <div class="col-xs-2 text-right">
                            <h4>PKR. '.$row['price_per_unit'].'</h4>
                        </div>
                        <div class="col-xs-2"></div>
                        <div class="col-xs-10">
                            <h5 class="margin-top-zero">'.$row['desc'].'</h5>
                        </div>
                    </div>
                </div>
            </div>';

$quantityInfo = "orderQuantity".$row['id'];

            $toReturn .= '<div class="modal fade" id="dishModal'.$count.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                   
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Addons</h4>
                </div>
                <div class="modal-body">
                    <form action="">';
                        $conn2 = new mysqli("localhost", "root", "", "resturant");
                        $sql2 = "select * from addon where item_id = " . $row['id'];
                        $result2 = $conn2->query($sql2);
                        if ($result2->num_rows > 0) {
                                    while($row2 = $result2->fetch_assoc()) {
                                            $toReturn .= '<div class="form-group form-inline">
                                                <input type="checkbox" name="'.$count.'" id="addonId'.$row2['id'].'" value="'.$row2['id'].'">
                                                <label for="" style="color: black">'.$row2['name'].'</label>
                                            </div>';
                                        }
                        }
                                       $toReturn .= '<div class="form-group">
                            <div class="panel panel-default">
                                <div class="panel-heading"
                                     style="background-color: white !important; color: black !important;">
                                    <h3 class="panel-title">Extra Notes</h3>
                                </div>
                                 <input type="hidden" name="orderId" id="orderId'.$_POST['orderId'].'" value="'.$_POST['orderId'].'">
                                 <input type="hidden" name="dishId" id="dishId'.$row['id'].'" value="'.$row['id'].'">
                                 
                                 <label style="color:black; padding-left: 20px;">Quantity</label>
                                 <input type="" style="margin-top: 10px; color:black" name=""  id="orderQuantity'.$row['id'].'">
                                    
                                <div class="panel-body">
                                    <textarea name="" id="dishNotes'.$count.'" cols="30" rows="10" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="saveOrder('.$row['id'].','.$_POST['orderId'] . ','.$count.','.$quantityInfo.');">Submit</button>
                </div>
            </div>
        </div>
    </div>';


$count++;


    }
}

$conn->close();

echo $toReturn;
?>
