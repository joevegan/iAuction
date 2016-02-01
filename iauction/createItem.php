<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
// Include database connection and functions here.  See 3.1. 

sec_session_start(); 

if(login_check($mysqli) == true) {
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	
}
        // Add your protected page content here!
?>           
<div style="display:inline;">   
	<div id="createItemPanel" class="panel panel-primary" style="float:left; width:40%; margin-left:2em; margin-right:2em;">
	 <div class="panel-heading"><h3>Create Item</h3></div>
  		<div class="panel-body">
	  		<form name="createItemForm" action="processCreateItem.php" method="post" enctype="multipart/form-data">
		  		Item Name: <input class="form-control" type="text" name="itemname" id="itemname"/>
		  		Description: <input class="form-control" type="textarea" name="description" id="description"/>
		  		Image: <input class="form-control" type="file" id="image" name="image" required />
		  		Starting Bid: <input class="form-control" type="text" name="startbid" id="startbid"/><br>
				<input class="btn btn-primary" type="submit" name="submit" id="submit"/>
				<input class="btn btn-warning" type="reset" name="reset" id="reset"/>
	
	  		</form>
  		</div>
  	</div>
  	
  	<div id="linkItemPanel" class="panel panel-primary" style="float:right; width:40%; margin-left:2em; margin-right:2em;">
	 <div class="panel-heading"><h3>Link Item</h3></div>
  		<div class="panel-body">
	  		<form name="linkItemForm" action="processLink.php" method="post">
		  		Auction: 
		  		<select name="auctionid" id="auctionid" class="form-control">
		  			<option value="">Please choose an auction</option>
		  		<?php
		  			$sql = "select a.id as id, 
						a.name as name
							from auctions a
								where a.enddate > now();";
					$result = $mysqli->query($sql);
				
					if ($result->num_rows > 0) {
					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	
					        echo '<option value=' .$row["id"] . '>' . $row["name"]. '</option>';
					    }
					} else {
					    echo "<option>Hmm, no auctions make one first...</option>";
					}
		  		?>
		  		</select><br>
		  		Item Name: 
		  		<select name="itemid" id="itemid" class="form-control">
		  			<option value="">Please choose an item</option>

	  			<?php
		  			$sql = "select i.id as id, 
						i.name as name
							from item i
								where i.id not in (select itemid from auctionitem)";
					$result = $mysqli->query($sql);
				
					if ($result->num_rows > 0) {
					    // output data of each row
					    while($row = $result->fetch_assoc()) {
					    	
					        echo '<option value=' .$row["id"] . '>' . $row["name"]. '</option>';
					    }
					} else {
					    echo "<option>Hmm, no items make one first...</option>";
					}
					$mysqli->close();
		  		?>
		  		</select><br>
				<input class="btn btn-primary" type="submit" name="submit" id="submit"/>
				<input class="btn btn-warning" type="reset" name="reset" id="reset"/>
	
	  		</form>
  		</div>
  	</div>
</div>