<?php
	include_once './includes/functions.php';
	include_once './includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once './includes/header.php';
	include_once './includes/navbar.php';	

        // Add your protected page content here!
		
	$auctionid =  $_POST["auctionid"];
	$itemid =  $_POST["itemid"];

	// Insert the new person into the database 
	$prep_stmt = "insert into auctionitem (auctionid,itemid) VALUES (?, ?)";
	if ($insert_stmt = $mysqli->prepare($prep_stmt)) {
	    $insert_stmt->bind_param('ii', $auctionid , $itemid);
	    // Execute the prepared query.
	    if (! $insert_stmt->execute()) {
	        echo 'Failed to link auction: ' . $auctionid . '<br>itemid: ' . $itemid;
	    } else {
	    	echo '<p style="margin:2em;" class="alert alert-success">Item linked to Auction!</p>';
		echo '<META http-equiv="refresh" content="2;URL=./createItem.php">';
	    }
	}
}


?>