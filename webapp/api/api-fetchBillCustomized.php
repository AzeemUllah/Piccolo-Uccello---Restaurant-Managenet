<?php
include "config.php";
session_start();

$toReturn = '';
$sql = '';

if($_POST['day'] == 'today') {
    $sql = 'SELECT * from `bill` where payment_mode = \'credit\' and DATE_FORMAT(date, \'%Y-%m-%d\') = CURDATE()';
}else if($_POST['day'] == 'yesterday'){
    $sql = 'SELECT * from `bill` where payment_mode = \'credit\' and DATE_FORMAT(date, \'%Y-%m-%d\') = DATE_SUB(CURDATE(), INTERVAL 1 DAY)';
}else if($_POST['day'] == 'today-yesterday'){
    $sql = 'SELECT * from `bill` where payment_mode = \'credit\' and DATE_FORMAT(date, \'%Y-%m-%d\') BETWEEN CURDATE() - INTERVAL 2 DAY AND CURDATE()';
}else if($_POST['day'] == 'range'){
    $sql = 'SELECT * from `bill` where payment_mode = \'credit\' and DATE_FORMAT(date, \'%m-%d-%Y\') BETWEEN \''.$_POST['from'].'\'  AND \''.$_POST['to'].'\'';
}

$result = $conn->query($sql);
// check_out_time is NULL and
if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<tr>
                                                    <td class="text-center">' . $row['id'] . '</td>
                                                    <td class="text-center">' . $row['order_id'] . '</td>
                                                     <td>' . $row['date'] . '</td>
                                                    <td>' . $row['sub_total'] . '</td>
                                                    <td>' . $row['gen_sales_tax'] . '</td>
                                                    <td>' . $row['discount'] . '</td>                                                    
                                                    <td>' . $row['grand_total'] . '</td>                                                    
                                                </tr>';


    }
}



echo $toReturn;



$conn->close();
?>
