<?php
include "config.php";
session_start();

$cosineImage = $_REQUEST["ImageSrc"];
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
		$sql = "INSERT INTO `users` (`user_id`, `name`, `password`, `type`, `image_url`) VALUES (NULL, '".$_POST['name']."', '".$_POST['password']."', '".$_POST['type']."', '".$file."');";

		if ($conn->query($sql) === TRUE) {
			echo "1";
		} else {
			 echo "0";
		}
	}
	else{
		echo "0";
	}
	
	
	


$conn->close();
?>
