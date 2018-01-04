<?php
include "config.php";
session_start();

$toReturn = '';

$sql = 'select i.id, i.name as item_name, i.price_per_unit, i.prepration_time, i.desc, i.image_url, ic.category_name as cat_name, it.name as type_name from item i, item_category ic, item_type it where i.category_type_id = ic.id and i.dist_type_id = it.id';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $toReturn .= '<tr>
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['item_name'].'</td>
                                                    <td>'.$row['price_per_unit'].'</td>
                                                    <td>'.$row['prepration_time'].'</td>
                                                    <td>'.$row['desc'].'</td>
                                                    <td>'.$row['cat_name'].'</td>
                                                    <td>'.$row['type_name'].'</td>
                                                    
                                                    
                                                    <td>
														<div class="" style="width:35px; height:35px;">
                                                            <img src="'.$row['image_url'].'" alt="..." height="24px" width="24px">
                                                        </div>
													
													
													</td>
                                                  
                                                    
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="edit(\''.$row['id'].'\')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="del(\''.$row['id'].'\')">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>';
    }

}
else{
    echo "0";
    return;
}


echo $toReturn;



$conn->close();
?>
