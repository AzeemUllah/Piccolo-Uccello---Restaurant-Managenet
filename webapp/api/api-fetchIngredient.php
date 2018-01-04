<?php
include "config.php";
session_start();

$toReturn = '';

											$sql = "SELECT * from inventory";
											$result = $conn->query($sql);

											if ($result->num_rows > 0) {
												// output data of each row
												while($row = $result->fetch_assoc()) {
													$toReturn .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
												}
												
											}
											else{
												echo "0";
												return;
											}
											
											
											echo $toReturn;
											


$conn->close();
?>
