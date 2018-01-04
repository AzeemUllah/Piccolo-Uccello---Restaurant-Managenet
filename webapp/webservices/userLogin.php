<?php
$outp = new \stdClass();
$conn = new mysqli("localhost", "root", "", "resturant");




if ($conn->connect_error) {
    $outp->status = "Error";
    $outp->message = "Error connecting to database.";
    $outp->results = "";
    echo json_encode($outp);
} else{
    $result = $conn->query("SELECT * FROM users");
    $outp->status = "Ok";
    $outp->message = "";
    $outp->results = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($outp);
}

$conn->close();
?>