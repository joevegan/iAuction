<?php
	include_once './includes/functions.php';
	include_once './includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once './includes/header.php';
	include_once './includes/navbar.php';	

        // Add your protected page content here!

	$target_dir = "uploads/";
	$path_parts = pathinfo($_FILES["image"]["name"]);
	$image_path = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
	$target_file = $target_dir . $image_path;	
	
	
	
	 
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	
	$itemName =  $_POST["itemname"];
	$description =  $_POST["description"];
	$startBid =  $_POST["startbid"];	
	
	
	// Check if image file is a actual image or fake image

	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if($check !== false) {
		//echo "File is an image - " . $check["mime"] . ".";
		$uploadOk = 1;
	} else {
		echo '<p style="margin:2em;" class="alert alert-danger">File is not an image.</p>';
	        echo '<META http-equiv="refresh" content="5;URL=./createItem.php">';
		$uploadOk = 0;
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		echo '<p style="margin:2em;" class="alert alert-danger">Sorry, file already exists.</p>';
		echo '<META http-equiv="refresh" content="5;URL=./createItem.php">';
		$uploadOk = 0;
	}
	// Check file size
	if ($_FILES["image"]["size"] > 500000) {
		echo '<p style="margin:2em;" class="alert alert-danger">Sorry, your file is too large.</p>';
		echo '<META http-equiv="refresh" content="5;URL=./createItem.php">';		
		$uploadOk = 0;
	}

	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" &&
	   $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "JPEG" && $imageFileType != "GIF" ) {
		echo '<p style="margin:2em;" class="alert alert-danger">Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>';
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		echo '<p style="margin:2em;" class="alert alert-danger">Sorry, your file was not uploaded.</p>';
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
			//echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
			
			// Insert the new person into the database 
			$prep_stmt = "insert into item (name,description,startbid,image) VALUES (?, ?, ?, ?)";
			if ($insert_stmt = $mysqli->prepare($prep_stmt)) {
			    $insert_stmt->bind_param('ssss', $itemName , $description , $startBid, $target_file);
			    // Execute the prepared query.
			    if (! $insert_stmt->execute()) {
			        echo '<p style="margin:2em;" class="alert alert-danger">Failed to add Item: ' . $itemName . '<br>desc: ' . $description . '<br>Start Bid: ' . $startBid . '<br>Image:' . $target_file . '</p>';
			        echo '<META http-equiv="refresh" content="5;URL=./createItem.php">';
			    } else {
			    	echo '<p style="margin:2em;" class="alert alert-success">Item Added!</p>';
				echo '<META http-equiv="refresh" content="2;URL=./createItem.php">';
			    }
			}	
		
		} else {
			echo "Sorry, there was an error uploading your file.";
		}
	}


}


?>