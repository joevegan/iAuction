<?php
	include_once 'includes/functions.php';
	include_once 'includes/db_connect.php';
// Include database connection and functions here.  See 3.1. 

sec_session_start(); 

if(login_check($mysqli) == true) {
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	

        // Add your protected page content here!
?>              

	<div id="auctionSection" class="panel panel-primary" style="margin-left:2em; margin-right:2em;">
	 <div class="panel-heading"><h3>Auctions</h3></div>
  		<div class="panel-body">
  			<table class="table">
  				<th>Auction Name</th>
  				<th>End Time</th>
  				<th>View</th>
<?php

		$sql = "select a.id as id, 
			a.name as name, 
			a.enddate as enddate,
			count(distinct itemid) as itemcount
			    from auctions a, auctionitem ai 
			        where ai.auctionid = a.id
			        and enddate > NOW()
					group by a.name, a.enddate;";
		$result = $mysqli->query($sql);
		
		if ($result->num_rows > 0) {
		    // output data of each row
		    while($row = $result->fetch_assoc()) {
		    echo '<tr><td>' . $row["name"] . '</td><td>' . $row["enddate"] . '</td><td>
		        	<a href="./showAuction.php?auctionid=' . $row["id"] .'" class="btn btn-success"> 
		        		<span class="glyphicon glyphicon-tags" aria-hidden="true"></span> View 
		        		<span class="badge">'. $row["itemcount"] .'</span>
		        	</a></div>';
		    
		    }
		} else {
		    echo "Aw, there is no Auctions. You should create one by going Create -> Auction. Then make some times Create -> items and link them to the auction.";
		}
		$mysqli->close();
?>
			</table>	

		</div>
	</div>
	<div id="correctionSections" class="panel panel-info" style="margin-left:2em; margin-right:2em;">
	 <div class="panel-heading"><h3>Bug fixes, Updates</h3></div>
  		<div class="panel-body">
  		<p></p>
			<!-- List group -->
			<ul class="list-group">
				<li class="list-group-item list-group-item-success">Invested sum amount not calculating correctly, SQL query needs updated.-- FIXED</li>
				<li class="list-group-item list-group-item-success">Create item now allows for image to be added (required).-- ADDED</li>
				<li class="list-group-item list-group-item-success">Maintain->auction needs created.--ADDED</li>
				<li class="list-group-item list-group-item-success">Maintain->item needs created.--ADDED </li>
				<li class="list-group-item list-group-item-success">Create->Item->Link Item drop downs need to exclude items that are already linked, SQL query needs updated, jQuery.--FIXED</li>				
			</ul>
		</div>
	</div>	
	
	<div id="newsSection" class="panel panel-info" style="margin-left:2em; margin-right:2em;">
	 <div class="panel-heading"><h3>Issues</h3></div>
  		<div class="panel-body">
  		<p></p>
			<!-- List group -->
			<ul class="list-group">
				<li class="list-group-item list-group-item-warning">Search bar not functinoal yet.</li>
				
				
				<li class="list-group-item list-group-item-warning">Create->Userneeds created. </li>
				
				<li class="list-group-item list-group-item-warning">Maintain->System needs created.</li>
				<li class="list-group-item list-group-item-warning">Maintain->User needs created.</li>
				<li class="list-group-item list-group-item-warning">Update forms to display success instead of loading new page.</li>
				<li class="list-group-item list-group-item-danger">Create Change user password form.</li>
			</ul>
		</div>
	</div>
	
<?php	
} else { 
        echo 'You are not authorized to access this page, redirecting you to the <a href="./index.php">login page</a>.';
        echo '<META http-equiv="refresh" content="2;URL=./index.php">';        
}

?>