<!-- Retrieves and destroys the sessions details upon logout -->
<?php
	$_SESSION = [];
	//Destroy Session
	session_destroy();
	echo "<script> window.location.assign('index.php?p=login'); </script>";

?>