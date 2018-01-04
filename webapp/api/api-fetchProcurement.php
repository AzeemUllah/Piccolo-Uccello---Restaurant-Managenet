<?php
include "config.php";
session_start();

$toReturn = '';

$sql = 'select * from procurement';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row['status'] == 'Yes'){
            $toReturn .= '<tr class="info">
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td>'.$row['quantity_unit'].'</td>
                                                    <td>'.$row['unit_price'].'</td>
                                                    <td>'.$row['order_date'].'</td>
                                                    <td>'.$row['arival_date'].'</td>
                                                    <td>'.$row['expire_date'].'</td>
                                                    <td>'.$row['status'].'</td>
                                                    <td>
														<div  style="width:35px; height:35px;">
                                                            <img src="'.$row['image'].'" alt="..." height="24px" width="24px">
                                                        </div>
													<td>'.$row['category'].'</td>
													
													</td>
                                                    <td class="td-actions text-right">';
            if($row['status'] != 'Yes'){
                $toReturn .= '<button type="button" rel="tooltip" class="btn btn-info btn-round procure_class" onclick="procure(\''.$row['id'].'\')">
                                                            <i class="material-icons">beenhere</i>
                                                        </button>';
            }else{
                $toReturn .='';
            }
            $toReturn .='<button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="edit(\''.$row['id'].'\')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="del(\''.$row['id'].'\')">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                        
                                                    </td>
                                                </tr>';
        }
else
{
        $toReturn .= '<tr>
                                                    <td class="text-center">'.$row['id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['quantity'].'</td>
                                                    <td>'.$row['quantity_unit'].'</td>
                                                    <td>'.$row['unit_price'].'</td>
                                                    <td>'.$row['order_date'].'</td>
                                                    <td>'.$row['arival_date'].'</td>
                                                    <td>'.$row['expire_date'].'</td>
                                                    <td>'.$row['status'].'</td>
                                                    <td>
														<div  style="width:35px; height:35px;">
                                                            <img src="'.$row['image'].'" alt="..." height="24px" width="24px">
                                                        </div>
													</td>
													
													<td>'.$row['category'].'</td>
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="procure(\''.$row['id'].'\')">
                                                            <i class="material-icons">beenhere</i>
                                                        </button>
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

}
else{
    echo "0";
    return;
}


echo $toReturn;



$conn->close();
?>
