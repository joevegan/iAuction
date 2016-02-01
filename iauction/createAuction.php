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
        
        
if (isset($_POST["submit"])){
	$startDate =  $_POST["startdate"];
	$endDate =  $_POST["enddate"];
	$name =  $_POST["auctionname"];	

	// Insert the new person into the database 
	$prep_stmt = "insert into auctions (name,startdate,enddate) VALUES (?, ?, ?)";
	if ($insert_stmt = $mysqli->prepare($prep_stmt)) {
	    $insert_stmt->bind_param('sss', $name , $startDate , $endDate);
	    // Execute the prepared query.
	    if (! $insert_stmt->execute()) {
	        echo 'Failed to add $name: ' . $name . '<br>startdate: ' . $startDate . '<br>enddate: ' . $endDate ;
	    } else {
	    	echo '<p style="margin:0 2em 1em 2em;" class="alert alert-success">Auction Added!</p>';
		echo '<META http-equiv="refresh" content="1;URL=./createAuction.php">';
	    }
	}
        
}
?>              
	<div id="createAuctionPanel" class="panel panel-primary" style="width:40%; margin:0 2em 0 2em;">
	 <div class="panel-heading"><h3>Create Auction</h3></div>
  		<div class="panel-body">
	  		<form name="createAuction" action="createAuction.php" method="post">
		  		Auction Name: <input class="form-control" type="text" name="auctionname" id="auctionname"/>
		  		Start Date: <input class="form-control" type="date" name="startdate" id="startdate"/>
		  		End Date: <input class="form-control" type="date" name="enddate" id="enddate"/><br>
				<input class="btn btn-primary" type="submit" name="submit" id="submit"/>
				<input class="btn btn-warning" type="reset" name="reset" id="reset"/>
	
	  		</form>
  		</div>