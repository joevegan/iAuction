<?php
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';
	
sec_session_start(); 


$auctionid = $_GET["auctionid"];
if(login_check($mysqli) == true) {	
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	
	
	$sql = "select a.name as name, a.enddate as enddate from auctions a where a.id =$auctionid";
	$result = $mysqli->query($sql);
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$endDate = $row["enddate"];
		$auctionName = $row["name"];
		}
	}
	$userid = $_SESSION["username"];
	$sql = "select sum(bidamount) as sum 
		from auctionitembid 
		where biduser = '$userid'
		and auctionid = $auctionid";
		
		
	$sql = "select sum(aib.bidamount) as sum 
		from auctionitembid aib
		where aib.biduser = '$userid'
		and aib.auctionid = $auctionid
		and aib.biduser = (select aib3.biduser 
                       		from auctionitembid aib3 
                       			where aib3.itemid = aib.itemid 
                       			and aib3.auctionid = aib.auctionid 
                       			and aib3.bidamount = (select max(aib2.bidamount) 
                                                 		from auctionitembid aib2 
                                                            where aib2.itemid = aib.itemid 
                                                 			and aib2.auctionid = aib.auctionid))
		and aib.bidamount = (select max(aib2.bidamount) from auctionitembid aib2 where aib2.itemid = aib.itemid and aib2.auctionid = aib.auctionid)";
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
	
	

	
?>

<div class="panel panel-primary" style="margin:0 2em 0 2em;">
  <!-- Default panel contents -->
  <div class="panel-heading">Auction Details</div>
    <div class="panel-body">
        <div style="float:left; width:30%;">
		<ul class="list-group">
			<li class="list-group-item"><b>Action Name</li>
			<li class="list-group-item">End</li>
			<li class="list-group-item">Number of items</li>
			<li class="list-group-item">Current User</li>
			<li class="list-group-item">Current Investment</b></li>
		</ul>
	</div>
    	<?php 
    	echo '<div style="margin-left:30%;">
		<ul class="list-group">
			<li class="list-group-item">' .$auctionName .'</li>
			<li class="list-group-item">' . $endDate . '</li>
			<li class="list-group-item">' . $itemcount . '</li>
			<li class="list-group-item">' . $_SESSION["username"] . '</li>
			<li class="list-group-item">$ ' . $sum. '</li>
		</ul>
		</div>';
    	
    	//echo 'Action Name: ' .$auctionName . '<br>End Date: ' .$endDate . '<br>Number of items: ' . $itemcount . '<br>User: ' . $_SESSION["username"] . '<br>Current Investment: '. $sum; 
    	
    	?>	
  </div>


  
</div>

<div class="panel panel-primary" style="margin:2em;">
  <!-- Default panel contents -->
  <div class="panel-heading">Auction Items</div>
<?php
        // Add your protected page content here!
		
	
	
	//$sql = "select a.name as name, i.name, i.id as itemid, ai.currbid bid, a.enddate from auctions a, item i, auctionitem ai where a.id = ai.auctionid and i.id = ai.itemid and a.id =$auctionid";
	
	$sql= "select a.id as auctionid,
		i.id as itemid,
		i.image as image,
		a.name as auctionname,
		i.name as name,
		i.description as description,
		(select max(aib.bidamount) from auctionitembid aib where aib.itemid = i.id and aib.auctionid = a.id) as amount,
		(select aib.biduser from auctionitembid aib where aib.itemid = i.id and aib.auctionid = a.id and aib.bidamount = (select max(aib2.bidamount) from auctionitembid aib2 where aib2.itemid = i.id and aib2.auctionid = a.id)) as userid
		from auctionitem ai, item i, auctions a
		where a.id = ai.auctionid
		and i.id = ai.itemid
		and a.id = $auctionid"
		;
                            		
	$result = $mysqli->query($sql);
	echo '<table class="table">
		<th>Image</th>
		<th>Name</th>
		<th>Description</th>
		<th>Current Bid</th>
		<th>High Bidder</th>
		<th>Amount</th>';
		
	if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	    	$itemid = $row["itemid"];

	        echo '<tr><td><a href="' . $row["image"] . '" ><img src="' . $row["image"] .'" alt="' . $row["name"] . ' (image)" style="width:64px;height:64px;"></a></td><td>' . $row["name"] . '</td><td>' . $row["description"] . '</td><td> $ ' . $row ["amount"] . '</td><td>' . $row["userid"] .'        
</td>
	        <td>
	        <form method="post" action="submitBid.php">
	        	<input type="text" name="auctionid" id="auctionid" value="' . $auctionid . '" hidden/>
	       		<input type="text" name="itemid" id="itemid" value="' . $itemid. '" hidden/>
	       		<input type="text" name="userid" id="userid" value="' . $userid . '" hidden/>
	        	<input type="text" name="amount" id="amount"/>
	        	<input class="btn btn-success" type="submit" value="Bid!"/>
	        </form></td></tr>' ;
	    }
	    
	} else {
	    echo "No Data!<br>";
	    //echo $sql .'<br>';
	   //echo $auctionid;

	}
	$mysqli->close();
	echo '</table></div>';
}

?>