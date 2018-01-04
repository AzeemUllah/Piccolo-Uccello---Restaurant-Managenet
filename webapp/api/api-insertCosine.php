<?php
include "config.php";
session_start();

$cosineName = $_POST["cosineName"];
$cosineImage =  $_REQUEST["cosineImage"];


define('UPLOAD_DIR', '../uploads/');

	$img = str_replace('data:image/png;base64,', '', $cosineImage);
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.jpg';
	$success = file_put_contents($file, $data);
	//echo $success ? $file : 'Unable to save the file.';
	
	if (strpos($file, '../') !== false) {
		$file = str_replace("../","",$file);
		$sql = "INSERT INTO item_category (id, category_name, image_url) VALUES ('', '".$cosineName."', '".$file."')";

		if ($conn->query($sql) === TRUE) {
			echo "1";
		} else {
			 echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}
	else{
		echo "0";
	}
	
	
	


$conn->close();
?>
