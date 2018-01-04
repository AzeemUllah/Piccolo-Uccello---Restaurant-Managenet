<?php
include "config.php";
session_start();

$toReturn = '';

$sql = 'select * from inventory';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $toReturn .= '<tr>
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['quantity_on_hand'].'</td>
                                                    <td>'.$row['quantity_unit'].'</td>
                                                    <td>'.$row['unit_price'].'</td>
                                                    <td>'.$row['expiry_date'].'</td>
                                                    <td>'.$row['category'].'</td>
                                                    <td>
														<div class="" style="width:35px; height:35px;">
                                                            <img src="'.$row['image'].'" alt="..." height="24px" width="24px">
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
