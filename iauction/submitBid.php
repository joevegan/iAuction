<?php
	include_once 'includes/functions.php';
	include_once 'includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	

        // Add your protected page content here!
		
	$auctionid =  $_POST["auctionid"];
	$itemid =  $_POST["itemid"];	
	$userid =  $_SESSION['username'];	
	$amount =  $_POST["amount"];	
	

	// Insert the new person into the database 
	$prep_stmt = "insert into auctionitembid values (?,?,?,?, NOW())";
	if ($insert_stmt = $mysqli->prepare($prep_stmt)) {
	    $insert_stmt->bind_param('ssss', $auctionid , $itemid , $userid, $amount);
	    // Execute the prepared query.
	    if (! $insert_stmt->execute()) {
	        echo 'Failed to add auctionid: ' . $auctionid . '<br>itemid: ' . $itemid . '<br>userid: ' . $userid . '<br>amount: ' . $amount; 
	    } else {
	    	echo '<p style="margin:2em;" class="alert alert-success">Bid Accepted!</p>';
		echo '<META http-equiv="refresh" content="2;URL=./showAuction.php?auctionid='. $auctionid .'">';
	    }
	}
}

?>