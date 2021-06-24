<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
?>
<!-- Retrieves a list of messages received from other users from the database using the showMessageList, the list compromises of the username who sent the message 
which acts as a link (retrieves the inbound user_id) which you click to message back, to prevent users from appearing twice we use an array called $unique, this array stores
inbound and outbound usernames if one appears twice $count is equal to one so the link will not display -->
<?php

	require_once('classes/users.classes.php');
    $userObj = new users($DBH);
	
	$messagelist = $userObj->showMessageList($_SESSION['userData']['user_id']);
	
	$unique = array();

	foreach ($messagelist as $key => $value) {
		$count = 0;
		if ($value['outbound_id'] == $_SESSION['userData']['user_id']){
			foreach ($unique as $name) {
				if ($value['inbound_username'] == $name) {
					$count = 1;
				}
			}
			array_push($unique, $value['inbound_username']);
			if ($count == 0){
				echo "<li class='messager'>Message: <a href='index.php?p=messaging&id=".$value['inbound_id']."'>".$value['inbound_username']."</a></li>";
			}
		}else {
			foreach ($unique as $name) {
				if ($value['outbound_username'] == $name) {
					$count = 1;
				}
			}
			array_push($unique, $value['outbound_username']);
			if ($count == 0){
				echo "<li class='messager'>Message: <a href='index.php?p=messaging&id=".$value['outbound_id']."'>".$value['outbound_username']."</a></li>";
			}
		}
	}
?>
		