<?php
include "config.php";
session_start();

$timeOut = '';
$toReturn = '';
$colWidthTimer = 12;
$sql = "SELECT o.id as order_id, oi.item_id as item_id, oi.order_time, oi.notes, oi.id as order_item_id, i.name as item_name, i.prepration_time as prepration_time 
FROM `order` o, order_items oi,item i
WHERE o.check_out_time is null and oi.order_id = o.id and oi.wastage_status = 'No' and oi.status = 'Kitchen' and i.id = oi.item_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $timeOut = '';
        $toReturn .= ' 
        <div class="col-md-3 border" style="min-height: 250px;">
            <div class="row">
                
                <div class="col-md-12 text-centre">
                    <p class="order_qty text-center">'.$row['item_name'].'</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-4 text-left" style="margin-top: 10px;">
                    <p style="margin-bottom: 2px;"><b></b></p>
                    <p style="margin-left: 12px;">';

        $conn2=mysqli_connect("localhost", "root", "", "resturant");
        $sql2 = "select a.name from order_items_addon oia, addon a where a.id = oia.addon_id and  oia.order_items_id =  " . $row['order_item_id'];
        if ($result2=mysqli_query($conn2,$sql2))
        {
            while ($row2=mysqli_fetch_row($result2))
            {
                $toReturn .=  $row2[0]."<br>";
                $colWidthTimer = 8;
            }
        }

        if(($row['prepration_time']*60) < round((strtotime(date("H:i:s")))-strtotime($row['order_time']))){
            $timeOut = 'animate-flicker';
        }


        $toReturn .= '</p>
                </div>
                <div class="col-md-'.$colWidthTimer.'">
                <div class="'.$timeOut.'">
                    <div class="count-down" data-timer="'.(($row['prepration_time']*60)-round((strtotime(date("H:i:s")))-strtotime($row['order_time']))).'">
                    </div>
                </div>
                </div>

            </div>

            <div class="row" >
                <div class="col-md-12 " style="margin-top: 0px;">
                    <p class="text-center">'.$row['notes'].'</p>
                </div>
            </div>
        </div>
    ';
    }
}

echo $toReturn;




?>
