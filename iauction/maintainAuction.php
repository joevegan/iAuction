<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	
	// get list of auctions
	$sql = "select a.name as name, a.id as id from auctions a where a.enddate > NOW()";
	$auctionList= $mysqli->query($sql);
	

	$userid = $_SESSION["username"];
	$sql = "select sum(bidamount) as sum 
		from auctionitembid 
		where biduser = '$userid'
		and auctionid = $auctionid";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$sum = $row["sum"];
		}
	}
	$sql = "select count(distinct itemid) as itemcount
		from auctionitem 
		where auctionid = $auctionid;";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$itemcount = $row["itemcount"];
		}
	}
	
	
if (isset($_POST['deleteAuction'])) {
	
	$id =  $_POST["auctionid"];
	// Insert the new person into the database 
	$prep_stmt = "delete from auctions where id = ?";
	if ($stmt = $mysqli->prepare($prep_stmt)) {
	    $stmt->bind_param('i', $id);
	    // Execute the prepared query.
	    if (! $stmt->execute()) {
	        echo 'Failed to delete acution id: ' . $id;
	    } else {
	    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-danger">Auction ' . $_POST["auctionname"] . ' Removed!</p>';
		echo '<META http-equiv="refresh" content="2;URL=./maintainAuction.php">';
	    }
	}
}

if (isset($_POST['deleteAuctionItem'])) {
	$auctionId =  $_POST["auctionid"];
	$itemId = $_POST["itemid"];
	// Insert the new person into the database 
	$prep_stmt = "delete from auctionitem where auctionid = ? and itemid = ?";
	if ($stmt = $mysqli->prepare($prep_stmt)) {
	    $stmt->bind_param('ii', $auctionId, $itemId);
	    // Execute the prepared query.
	    if (! $stmt->execute()) {
	        echo 'Failed to delete acutionitem auctionid: ' . $auctionId . ' itemid: ' . $itemId;
	    } else {
	    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-danger">Auction item Removed!</p>';
		echo '<META http-equiv="refresh" content="2;URL=./maintainAuction.php">';
	    }
	}
}

if (isset($_POST['updateAuction'])) {
	
	$endDate = $_POST["enddate"];
	// Insert the new person into the database 
	$prep_stmt = "update auctions
			set name = ?,
			startdate = ?,
			enddate = ?
			 where id = ?";
	if ($stmt = $mysqli->prepare($prep_stmt)) {
	    $stmt->bind_param('sssi', $_POST["auctionname"], $_POST["startdate"], $endDate, $_POST["auctionid"]);
	    // Execute the prepared query.
	    if (! $stmt->execute()) {
	        echo '<p style="margin:0 2em 0 2em;" class="alert alert-danger">Failed to update acution id: ' . $_POST["auctionid"] . '</p>';
	    } else {
	    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-success">Auction ' . $_POST["auctionname"] . ' Updated!</p>';
		echo '<META http-equiv="refresh" content="2;URL=./maintainAuction.php">';
	    }
	}
	
}



?>


<div class="panel panel-primary" style="margin: 0 2em 0 2em;">
  <!-- Default panel contents -->
  <div class="panel-heading">Auctions <a href="./createAuction.php" style="" class="btn btn-sm btn-success">Create...</a></div>

<?php

        // Add your protected page content here!			
	
	//$sql = "select a.name as name, i.name, i.id as itemid, ai.currbid bid, a.enddate from auctions a, item i, auctionitem ai where a.id = ai.auctionid and i.id = ai.itemid and a.id =$auctionid";
	
	$sql= "select a.id as id, 
			a.name as name,
			DATE(a.startdate) as startdate, 
			DATE(a.enddate) as enddate,
			(select count(distinct ai.itemid) from auctionitem ai where ai.auctionid = a.id) as itemcount
			    from auctions a			     
			        where enddate > NOW()
					group by a.name, a.enddate;";
                            		
	$result = $mysqli->query($sql);
	echo '<table class="table">
		<th>#</th>
		<th>Auction Name</th>
		<th>Start</th>
		<th>End</th>
		<th># of items</th>
		<th>Action</th>';
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        echo '<form method="post" name="maintainAuction" id="maintainAuction" action="maintainAuction.php">

	        <tr>
	        	<td>' . $row["id"]. '</td>
	        	<td><input type="text" class="form-control" name="auctionname" id="auctionname" value="' . $row["name"] . '" /></td>
	       		<td><input type="date" class="form-control" name="startdate" id="startdate" value="' . $row["startdate"] . '" /></td>	        	
	        	<td><input type="date" class="form-control" name="enddate" id="enddate" value="' . $row["enddate"]. '" /></td>
	        	<td>' . $row["itemcount"] .' </td>
	        	<td>
	        	
		        <input name="auctionid" id="auctionid" value="' . $row["id"] . '" hidden/>
		        
		        <button class="btn btn-success" type="submit" name="updateAuction" value="Update">
		        	<span class="glyphicon glyphicon-ok"></span>
		        </button>
		        <button class="btn btn-danger" type="submit" name="deleteAuction" value="Delete">
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

</div>

<div name="selectAuctionSection" id="selectAuctionSection" class="panel panel-primary" style="margin:2em;">
  <!-- Default panel contents -->
  <div class="panel-heading">Auction Items</div>
	<form id="selectauctionForm" method="post" action="maintainAuction.php" name="selectauctionForm" style="margin:2em;">
		<div style="display:inline-block;"><select style="width:20em; float:left;" name="selectAuction" id="selectAuction" class="form-control">
			<option value = 0>Select an Auction...</option>
		<?php
			if ($auctionList->num_rows > 0) {
				while($row = $auctionList->fetch_assoc()) {
					$auctionid = $row["id"];
					$auctionName = $row["name"];
					echo '<option name value=' . $auctionid .'>' . $auctionName . '</option> ';
				}
			}
		?>
		</select>
		<input type="text" id="auctionname" name="auctionname" value="<?php echo $auctionName; ?>" hidden/>

		<button class="btn btn-primary" type="submit" name="selectAuctionItems" value="selectAuctionItems" style="float:right;">
			<span class="glyphicon glyphicon-th-list"></span> Show Items
		</button>
		</div>
	</form>
		

	<?php
	if (isset($_POST['selectAuctionItems'])) {	
	$auctionItemListId = $_POST["selectAuction"];	
		$sql= "select a.id as auctionid,
			i.id as itemid,
			i.image as image,
			i.description as description,
			a.name as auctionname,
			i.name as name
			from auctionitem ai, item i, auctions a
			where a.id = ai.auctionid
			and i.id = ai.itemid
			and a.id = $auctionItemListId";

		echo '<div name="auctionItems" id="auctionItems" class="panel panel-primary" style="margin:2em;">
		  <!-- Default panel contents -->
		  <div class="panel-heading">' . $auctionNameList  . ' Items</div>';		
					                            		
		$result = $mysqli->query($sql);
		echo '<table class="table">
			<th>Image</th>
			<th>Name</th>
			<th>Description</th>
			<th>Action</th>';
			
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {

		        echo '<tr><td><a href="' . $row["image"] . '" ><img src="' . $row["image"] .'" alt="' . $row["name"] . ' (image)" style="width:64px;height:64px;"></a></td><td>' . $row ["name"] . '</td>
		        <td>' . $row["description"] . '</td><td>
		        <form method="post" action="maintainAuction.php">
		        	<input type="text" name="auctionid" id="auctionid" value="' . $row["auctionid"]. '" hidden/>
		       		<input type="text" name="itemid" id="itemid" value="' . $row["itemid"]. '" hidden/>

				<button class="btn btn-danger" type="submit" name="deleteAuctionItem">
					<span class="glyphicon glyphicon-remove"></span>
				</button>
		        </form></td></tr>';
		    }
		    
		} else {
		    echo "No Data!<br>";
		    //echo $sql .'<br>';
		   //echo $auctionid;
	
		}
		$mysqli->close();
		echo '</table></div>';		
}
	
echo '</div>';

}
?>