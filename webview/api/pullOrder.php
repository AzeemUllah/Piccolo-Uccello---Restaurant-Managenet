<?php
include "config.php";
session_start();

$last_id = '';
$toReturn = 0;
$code = '';

$conn3 = new mysqli("localhost", "root", "", "resturant");
$sql3 = "select oi.id as oiId, i.name, i.price_per_unit, oi.quantity,oi.status from item i, order_items oi where oi.order_id = ".$_POST['orderId']." and i.id = oi.item_id";
$result3 = $conn3->query($sql3);
if ($result3->num_rows > 0) {
    while($row3 = $result3->fetch_assoc()) {
        $code .= '
                        <div class="row" style="margin: 0px;">
                            <div class="col-xs-3 text-left padd text-center">
                                <p class="margin-bottom-zero">'.$row3['quantity'].'</p>
                            </div>
                            <div class="col-xs-3 text-center padd">
                                <p class="margin-bottom-zero">'.$row3['name'].'</p>
                            </div>
                            <div class="col-xs-3 text-right padd">
                                <p class="margin-bottom-zero">PKR. '.$row3['price_per_unit'] * $row3['quantity'].'</p>
                            </div>
                             <div class="col-xs-3 text-right padd text-center">
                                
                                ';

                            if($row3['status'] != 'Kitchen') {
                                $code .= '<button class="theme-btn btn btn-default cancel-btn" onclick="deleteOneDish(' . $row3['oiId'] . ');">X</button>';
                            }

                           $code .= '
                            
                            </div>
                        </div>';

        $conn4 = new mysqli("localhost", "root", "", "resturant");
        $sql4 = "select a.name, a.price from addon a, order_items_addon oia where oia.order_items_id = ".$row3['oiId']." and a.id = oia.addon_id";
        $result4 = $conn4->query($sql4);
        if ($result4->num_rows > 0) {
            while($row4 = $result4->fetch_assoc()) {
                $code .= '
                        <div class="row" style="margin: 0px;">
                            <div class="col-xs-3 text-left padd text-center">
                                <p class="margin-bottom-zero">1</p>
                            </div>
                            <div class="col-xs-3 text-center padd">
                                <p class="margin-bottom-zero">'.$row4['name'].'</p>
                            </div>
                            <div class="col-xs-3 text-right padd">
                                <p class="margin-bottom-zero">'.$row4['price'].'</p>
                            </div>
                           
                        </div>';

            }
        }


    }
}


echo $code;
?>
