<?php
include_once 'db_connect.php';
include_once 'functions.php';

//$mysqli = new mysqli('localhost', 'ibanksec', 'applesauce123', 'ibank2');

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
} else {
	$email = "test@example.com";
	$stmt = $mysqli->prepare("SELECT id, username, password, salt FROM `users` WHERE email = ? LIMIT 1");
	$stmt->bind_param('s', $email);  // Bind "$email" to parameter.
	$results = $stmt->execute();    // Execute the prepared query.
	echo $results . "yeh";
}



?>