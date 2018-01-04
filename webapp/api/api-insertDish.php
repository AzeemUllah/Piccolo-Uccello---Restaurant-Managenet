<?php
include "config.php";
session_start();


$addonNames = $_REQUEST['addonNames'];
//$addonNames = $_POST["addonNames"];

$cosineImage = $_REQUEST["dishImageSrc"];
$addonPrice = $_REQUEST["addonPrice"];
$ingredientIds = $_REQUEST["ingredientIds"];
$ingredientQuantities = $_REQUEST["ingredientQuantities"];

$last_id = 0;

define('UPLOAD_DIR', '../uploads/');
	
	$img = str_replace('data:image/png;base64,', '', $cosineImage);
	$img = str_replace('data:image/jpeg;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$file = UPLOAD_DIR . uniqid() . '.png';
	$success = file_put_contents($file, $data);
	//echo $success ? $file : 'Unable to save the file.';
	
	if (strpos($file, '../') !== false) {
		$file = str_replace("../","",$file);
		$sql = "INSERT INTO `item` (`id`, `name`, `price_per_unit`, `prepration_time`, `category_type_id`, `dist_type_id`, `desc`, `image_url`, `avaliablity`, `location`) VALUES 
		(NULL, '".$_POST["name"]."', '".$_POST["dishPrice"]."', '".$_POST["preprationTime"]."', '".$_POST["cosineId"]."', '".$_POST["typeId"]."', '".$_POST["description"]."', '".$file."', 'Y', '".$_POST['locationName']."');";

		if ($conn->query($sql) === TRUE) {
			$last_id = $conn->insert_id;

			foreach ($addonNames as $key => $value) {
				$sql = "INSERT INTO `addon` (`id`, `item_id`, `name`, `price`) VALUES (NULL, '".$last_id."', '".$addonNames[$key]."', '".$addonPrice[$key]."')";
	
				if(!($conn->query($sql) == TRUE)){
					echo "0";
				}
			}
			foreach ($ingredientIds as $key => $value) {
				$sql = "INSERT INTO `item_recipes` (`item_id`, `inventory_id`, `quantity_used`) VALUES ('".$last_id."', '".$ingredientIds[$key]."', '".$ingredientQuantities[$key]."')";

				if(!($conn->query($sql) == TRUE)){
					echo "0";
				}
			}
			
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
