<!-- includes different files so they do not need to be typed out every time such as the database details, header and footer -->
<?php
	require_once('includes/db.php');
	require_once('includes/header.php');

	if($_GET['p']){
		require_once('pages/'.$_GET['p'].'.php');
	}else{
		require_once('pages/home.php');
	}
	
	require_once('includes/footer.php');
	
?>