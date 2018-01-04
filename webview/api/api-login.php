<?php
include "config.php";
session_start();
	
$sql = "SELECT * from users where name = '". $_POST["username"] ."' and password ='". $_POST["password"] ."'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$_SESSION["username"] = $row["name"];
		$_SESSION["user_id"] = $row["user_id"];
		$_SESSION["type"] = $row["type"];
    }
	echo 1;
} else {
   echo 0;
}
$conn->close();
?>
