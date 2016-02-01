<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	
	
	
if (isset($_POST['deleteItem'])) {	
	$prep_stmt = "delete from item where id = ?";
	if ($stmt = $mysqli->prepare($prep_stmt)) {
	    $stmt->bind_param('i', $_POST["itemid"]);
	    // Execute the prepared query.
	    if (! $stmt->execute()) {
	        echo 'Failed to delete itemid: ' . $_POST["itemid"];
	    } else {
	    	$prep_stmt = "delete from auctionitem where itemid = ?";
		if ($stmt = $mysqli->prepare($prep_stmt)) {
		    $stmt->bind_param('i', $_POST["itemid"]);
		    // Execute the prepared query.
		    if (! $stmt->execute()) {
		        echo 'Failed to delete item from auctionitem: ' . $_POST["itemid"];
		    } else {	    	
		    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-danger">Item ' . $_POST["itemname"] . ' Removed!</p>';
			echo '<META http-equiv="refresh" content="2;URL=./maintainItem.php">';	    	    
	    	    }
	    	}
   	    }
	}
}

if (isset($_POST['purge'])) {
	
	// Insert the new person into the database 
	$prep_stmt = "delete from item where id not in (select itemid from auctionitem)";
	if ($stmt = $mysqli->prepare($prep_stmt)) {
		if (! $stmt->execute()) {
			echo 'Failed to purge unused items';
		} else {
			echo '<p style="margin:0 2em 1em 2em;" class="alert alert-danger">Unused items Removed!</p>';
			echo '<META http-equiv="refresh" content="2;URL=./maintainItem.php">';
		}
	} else {
		echo 'statement failed';
	}
	
}

if (isset($_POST['updateItem'])) {
	$itemId = $_POST["itemid"];
	$sql = "select image from item where id = $itemId";
	$imageData= $mysqli->query($sql);
	$row = $imageData->fetch_assoc();
	$currentImage = $row["image"];


	if ($_FILES["image"]["name"] == "" ) {
		// Insert the new person into the database 
		$prep_stmt = "update item
				set name = ?,
				description = ?,
				startbid = ?
				 where id = ?";
		if ($stmt = $mysqli->prepare($prep_stmt)) {
			$stmt->bind_param('sssi', $_POST["itemname"],  $_POST["itemdescription"], $_POST["startbid"], $_POST["itemid"]);
			// Execute the prepared query.
			if (! $stmt->execute()) {
				echo '<p style="margin:0 2em 0 2em;" class="alert alert-danger">Failed to update item id: ' . $_POST["itemid"] . '</p>';
			} else {
				echo '<p style="margin:0 2em 1em 2em;" class="alert alert-success">Item ' . $_POST["itemname"] . ' Updated!</p>';
				echo '<META http-equiv="refresh" content="2;URL=./maintainItem.php">';
			}
		}
	} else {
	
		$target_dir = "uploads/";
		$path_parts = pathinfo($_FILES["image"]["name"]);
		$image_path = $path_parts['filename'].'_'.time().'.'.$path_parts['extension'];
		$target_file = $target_dir . $image_path;	
		
		
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		
		// Check if image file is a actual image or fake image
	
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		if($check !== false) {
			//echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo '<p style="margin:2em;" class="alert alert-danger">File is not an image.</p>';
		        echo '<META http-equiv="refresh" content="5;URL=./maintainItem.php">';
			$uploadOk = 0;
		}
	
		// Check if file already exists
		if (file_exists($target_file)) {
			echo '<p style="margin:2em;" class="alert alert-danger">Sorry, filename already exists.</p>';
			echo '<META http-equiv="refresh" content="5;URL=./maintainItem.php">';
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["image"]["size"] > 500000) {
			echo '<p style="margin:2em;" class="alert alert-danger">Sorry, your file is too large.</p>';
			echo '<META http-equiv="refresh" content="5;URL=./maintainItem.php">';		
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
	
				// Insert the new person into the database 
				$prep_stmt = "update item
						set name = ?,
						image = ?,
						description = ?,
						startbid = ?
						 where id = ?";
				if ($stmt = $mysqli->prepare($prep_stmt)) {
				    $stmt->bind_param('ssssi', $_POST["itemname"], $target_file, $_POST["itemdescription"], $_POST["startbid"], $_POST["itemid"]);
				    // Execute the prepared query.
				    if (! $stmt->execute()) {
				        echo '<p style="margin:0 2em 0 2em;" class="alert alert-danger">Failed to update item id: ' . $_POST["itemid"] . '</p>';
				    } else {
				    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-success">Item ' . $_POST["itemname"] . ' Updated!</p>';
					echo '<META http-equiv="refresh" content="2;URL=./maintainItem.php">';
			   	   }
				}
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	}
		
	
}



?>


<div class="panel panel-primary" style="margin: 0 2em 2em 2em;">
  <!-- Default panel contents -->
  <div class="panel-heading">Items <a href="./createItem.php" style="" class="btn btn-sm btn-success">Create...</a> <form style="float:right;" method="post" action="maintainItem.php"><button class="btn btn-sm btn-danger" type="submit" name="purge">Remove Unused Items</button></form></div>

<?php

        // Add your protected page content here!			
	
	//$sql = "select a.name as name, i.name, i.id as itemid, ai.currbid bid, a.enddate from auctions a, item i, auctionitem ai where a.id = ai.auctionid and i.id = ai.itemid and a.id =$auctionid";
	
	$sql= "select i.id as id, 
		i.name as name,
		i.image as image, 
		i.description as description,
		i.startbid as startbid
			    from item i";
                            		
	$result = $mysqli->query($sql);
	echo '<table class="table">
		<th>#</th>
		<th>Image</th>
		<th>Name</th>
		<th>Description</th>
		<th>Starting Bid</th>		
		<th>Action</th>';
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo '<form method="post" name="maintainItem" id="maintainItem" action="maintainItem.php" enctype="multipart/form-data">

	        <tr>
	        	<td>' . $row["id"]. '</td>
	       		<td><input class="form-control" type="file" id="image" name="image" />
	       		<a href="' . $row["image"] . '" ><img src="' . $row["image"] .'" alt="(image)" style="width:64px;height:64px;"></a></td>
	        	<td><input type="text" class="form-control" name="itemname" id="itemname" value="' . $row["name"] . '" /></td>
	       		<td><input type="text" class="form-control" name="itemdescription" id="itemdescription" value="' . $row["description"] . '" /></td>	        	
	        	<td><input type="text" class="form-control" name="startbid" id="startbid" value="' . $row["startbid"]. '" /></td>
	        	<td>
	        	
		        <input name="itemid" id="itemid" value="' . $row["id"] . '" hidden/>
		        
		        <button class="btn btn-success" type="submit" name="updateItem" value="Update">
		        	<span class="glyphicon glyphicon-ok"></span>
		        </button>
		        <button class="btn btn-danger" type="submit" name="deleteItem" value="Delete">
		       		<span class="glyphicon glyphicon-remove"></span>
		       	</button>
			</td></tr></form>';
	    }
	    
	} else {
	    echo "No Data!<br>";
	    //echo $sql .'<br>';
	   //echo $auctionid;

	}
	echo '</table></div>'; 
?>

</div></div>

<?php
}
?>