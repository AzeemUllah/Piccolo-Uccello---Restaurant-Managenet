<?php
include "config.php";
session_start();

$toReturn = '';

$sql = 'select * from table_status';
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row['status'] == 'No'){
            $toReturn .= '<tr class="danger">
                                                    <td class="text-center">'.$row['table_id'].'</td>
                                                    <td>'.$row['name'].'</td>
                                                    <td>'.$row['status'].'</td>
                                                 
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="edit(\''.$row['table_id'].'\')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="del(\''.$row['table_id'].'\')">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                    </td>
                                                </tr>';
        }

else {

    $toReturn .= '<tr>
                                                    <td class="text-center">' . $row['table_id'] . '</td>
                                                    <td>' . $row['name'] . '</td>
                                                    <td>' . $row['status'] . '</td>
                                                 
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-success btn-round" onclick="edit(\'' . $row['table_id'] . '\')">
                                                            <i class="material-icons">edit</i>
                                                        </button>
                                                        <button type="button" rel="tooltip" class="btn btn-danger btn-round" onclick="del(\'' . $row['table_id'] . '\')">
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
