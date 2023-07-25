<?php 

	$dbc = mysqli_connect('localhost', 'root', '', 'bookLibrary');
	session_start();
	if(!$dbc){
		die("Could not connect to database");
	} else {
		// var_dump("connection is good");
	}