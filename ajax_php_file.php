<?php
include_once('database.php');
$action_type = $_POST["ajax-action"];
if($action_type == 'upload'){
	if (isset($_FILES["file"]["type"])) {
		$validextensions = array("jpeg", "jpg", "png");
		$temporary = explode(".", $_FILES["file"]["name"]);
		$file_extension = end($temporary);
		$file_extension = strtolower($file_extension);
		if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")) && ($_FILES["file"]["size"] < 71943040) && in_array($file_extension, $validextensions)) {
			if ($_FILES["file"]["error"] > 0) {
				echo "1"; // upload error
			} else {
				$date = new DateTime();
				$filename = $date->getTimestamp() . "." . $file_extension;
				$sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
				$targetPath = "./upload/" . $filename; // Target path where file is to be stored
				move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
	
				$imageURL = $_POST["img-url"];
				$imageDesc = $_POST["img-desc"];
	
				$sql = "INSERT INTO ".$tbname." (imgName, imgURL, imgDescription) VALUES ( '". $filename . "',
				'".$imageURL ."','".$imageDesc."')";
				if ($conn->query($sql) === TRUE) {
					echo "0"; //success
				} 
				else {
					echo "2"; // insert into table error
				}
			}
		} else {
			echo "3"; // Invalid file Size or Type
		}
	}	
}
else if($action_type == 'delete'){
	$sql = "Delete from ".$tbname." where id = ".$_POST["active-img"];
	if ($conn->query($sql) === TRUE) {
		echo "0"; //success
	} 
	else {
		echo "4"; // Delete Error
	}
}
else if($action_type == 'update'){
	$sql = "Update ".$tbname." set imgURL='".$_POST["img-url"]."', imgDescription='".$_POST["img-desc"]."'  where id = ".$_POST["active-img"];
	if ($conn->query($sql) === TRUE) {
		echo "0"; //success
	} 
	else {
		echo "5"; // Update Error
	}
}
else {
	echo "6";
}
$conn->close();
?>
