<?php
include "config.php";
session_start();

$toReturn = '';

$sql = 'SELECT o.id, t.name as table_name, o.total_cost, o.check_in_time, o.check_out_time, o.number_of_people, DATE_FORMAT(o.check_in_time, \'%Y-%m-%d\') FROM `order` o, `table_status` t where o.table_id = t.table_id and DATE_FORMAT(o.check_in_time, \'%Y-%m-%d\') = CURDATE()';
$result = $conn->query($sql);
// check_out_time is NULL and
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        if (is_null($row['check_out_time'])) {
            $toReturn .= '<tr class="warning">
                                                    <td class="text-center">' . $row['id'] . '</td>
                                                    <td>' . $row['table_name'] . '</td>
                                                    <td>' . $row['check_in_time'] . '</td>
                                                    <td>' . $row['check_out_time'] . '</td>
                                                   
                                                    <td>' . $row['number_of_people'] . '</td>
                                                    <td>Rs. ' . $row['total_cost'] . '</td>
                                                  
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="edit(\'' . $row['id'] . '\')">
                                                            <i class="material-icons">description</i>
                                                        </button>
                                                        
                                                    </td>
                                                </tr>';
        } else {
            $toReturn .= '<tr>
                                                    <td class="text-center">' . $row['id'] . '</td>
                                                    <td>' . $row['table_name'] . '</td>
                                                    <td>' . $row['check_in_time'] . '</td>
                                                    <td>' . $row['check_out_time'] . '</td>
                                                   
                                                    <td>' . $row['number_of_people'] . '</td>
                                                    <td>Rs. ' . $row['total_cost'] . '</td>
                                                  
                                                    <td class="td-actions text-right">
                                                        <button type="button" rel="tooltip" class="btn btn-info btn-round" onclick="edit(\'' . $row['id'] . '\')">
                                                            <i class="material-icons">description</i>
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
