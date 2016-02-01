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
	<div id="aboutSection" class="panel panel-primary" style="margin-left:2em; margin-right:2em;">
	 	<div class="panel-heading">About</div>
  			<div class="panel-body">
  				<p>iAuction is a web base application for creating, running, and managing small private auctions. Originally created by Justin Hanley using open source tools (LAMP, bootstrap) with intent to showcase some bootstrap features and eventually create an open source porject on GITHUB with GPL license.</p>
  			</div>
  		
  	

		<div id="supportSection" class="panel panel-info" style="margin:2em;">
			<div class="panel-heading">Support</div>
		  		<div class="panel-body">
		  			<p>Found a bug? or perhaps you'd like a new feature added? Submit a ticket through <a href="https://github.com/joevegan/iAuction/issues">GITHUB</a> and we'll follow up shortly.</p>
				</div>       
		</div>

	</div>


<?php
} else { 
        echo 'You are not authorized to access this page, redirecting you to the <a href="./index.php">login page</a>.';
        echo '<META http-equiv="refresh" content="2;URL=./index.php">';        
}

?>