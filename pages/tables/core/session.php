<?php
session_start();

if(isset($_SESSION['uid']) && $_SESSION['uid']!=''){
	$logged_in_user = $_SESSION['uid'];
}

// Set JWT Support

?>