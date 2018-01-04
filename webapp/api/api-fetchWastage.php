<?php
include "config.php";
session_start();

$toReturn = '';



$sql = "SELECT w.id as wastage_id, i.name, w.quantity, w.cost, w.approved, w.category, w.image FROM `wastage` w, `inventory` i where w.inventory_id = i.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row['approved'] == 'Yes'){
            $toReturn .= '<tr class="success">
                                                  <td class="text-center">'.$row['wastage_id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td>'.$row['cost'].'</td>
                                                    <td>' . $row['category'] . '</td>
                                                    <td>'.$row['approved'].'</td>
                                                    
                                                      <td>
														<div class="" style="width:35px; height:35px;">
                                                            <img src="'.$row['image'].'" alt="..." height="24px" width="24px">
                                                        </div>
													
													
													</td>
                                                    <td class="td-actions text-right">
                                                        
                                                    </td>
                                                    
                                                </tr>';
        }


else {
    $toReturn .= '<tr>
                                                   <td class="text-center">'.$row['wastage_id'].'</td>
                                                    <td>' . $row['name'] . '</td>
                                                    <td>' . $row['quantity'] . '</td>
                                                    <td>' . $row['cost'] . '</td>
                                                    <td>' . $row['category'] . '</td>
                                                    <td>' . $row['approved'] . '</td>
                                                      <td>
														<div class="" style="width:35px; height:35px;">
                                                            <img src="'.$row['image'].'" alt="..." height="24px" width="24px">
                                                        </div>
													
													
													</td>
                                                    
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="approve(\'' . $row['wastage_id'] . '\')">
                                                            <i class="material-icons">done</i>
                                                        </button>
                                                    </td>
                                                    
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
