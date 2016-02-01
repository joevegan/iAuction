<?php
	include_once 'includes/functions.php';
	include_once 'includes/db_connect.php';
	
sec_session_start(); 

if(login_check($mysqli) == true) {	
	include_once 'includes/header.php';
	include_once 'includes/navbar.php';	

        // Add your protected page content here!
		


$search =  $_POST["search"];
$sql = "SELECT * FROM pers WHERE (firstname LIKE '%" .$search. "%' OR lastname LIKE '%". $search. "%')LIMIT 100";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["id"]. "*" . $row["firstname"]. "*" .$row["lastname"] . "\n";
    }
} else {
    echo "0 results";
}
$mysqli->close();

	    
}



?>