<?php
include "config.php";
session_start();

$toReturn = '';
$closed = '';

$conn2=mysqli_connect("localhost", "root", "", "resturant");
$sql2 = "select check_out_time from `order` where id = " . $_POST['id'];

if ($result2=mysqli_query($conn2,$sql2))
{
    // Fetch one and one row
    while ($row2=mysqli_fetch_row($result2))
    {

        if(is_null($row2[0])){
            $closed = 'N';
        }
        else{
            $closed = 'Y';
        }
    }
    // Free result set
    mysqli_free_result($result2);
}

mysqli_close($conn2);



$sql = 'SELECT oi.item_id, oi.order_id ,oi.cancel_order ,i.name as item_name,ic.category_name, it.name as item_type, i.price_per_unit, oi.total_price, i.image_url, oi.wastage_status, oi.notes, oi.quantity FROM `order_items` oi, `item` i, `item_category` ic, `item_type` it where oi.item_id = i.id and ic.id = i.category_type_id and it.id = i.dist_type_id and oi.order_id='.$_POST['id'];
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        if ($row['wastage_status'] == 'Yes' || $row['cancel_order'] == 'Yes') {
            $toReturn .= '<tr class="danger">
                                            <td class="text-center">' . $row['item_id'] . '</td>
                                        
                                            <td>' . $row['item_name'] . '</td>
                                            <td>' . $row['category_name'] . '</td>
                                            <td>' . $row['item_type'] . '</td>
                                            <td>' . $row['wastage_status'] . '</td>
                                            <td>' . $row['quantity'] . '</td>
                                            <td class="text-right">Rs. ' . $row['price_per_unit'] . '</td>
                                            <td class="text-right">Rs. ' . $row['total_price'] . '</td>
                                            <td class="td-actions text-right">';
            if($closed == 'N') {
                $toReturn .= '
                                                  <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="cancelDish(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\');">
                                                      Cancel
                                                 </button>
                                                 <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="wastage(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\')">
                                                      Wastage
                                                 </button>
                                                  <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="complementryDish(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\');">
                                                      Complementry
                                                 </button>
                            ';
            }

            $toReturn .= '
                                            </td>
                                         
                                        </tr>';

        } else {
            $toReturn .= '
                                        <tr>
                                            <td class="text-center">' . $row['item_id'] . '</td>
                                        
                                            <td>' . $row['item_name'] . '</td>
                                            <td>' . $row['category_name'] . '</td>
                                            <td>' . $row['item_type'] . '</td>
                                            <td>' . $row['wastage_status'] . '</td>
                                            <td>' . $row['quantity'] . '</td>
                                            <td class="text-right">Rs. ' . $row['price_per_unit'] . '</td>
                                            <td class="text-right">RS. ' . $row['total_price'] . '</td>
                                            <td class="td-actions text-right">';

if($closed == 'N') {

    $toReturn .= '
                                                        <button type="button" rel="tooltip" class="btn btn-warning btn-round" onclick="cancelDish(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\');">
                                                      Cancel
                                                 </button>
                                                  <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="wastage(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\')">
                                                            Wastage
                                                        </button>
                                                     <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="complementryDish(\'' . $row['order_id'] . '\',\'' . $row['item_id'] . '\');">
                                                      Complementry
                                                 </button>
             ';
}
            $toReturn .= '    </td>
                                           
                                        </tr>';

        }
    }

}
else{
    echo "0";
    return;
}

echo $toReturn;



$conn->close();
?>
