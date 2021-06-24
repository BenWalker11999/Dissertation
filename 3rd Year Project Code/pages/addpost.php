<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
?>
<!-- This page allows a user to add a discussion about a comic to the site, it calls the addDiscussion function and passes in session data about the user and the post 
retrieved from the form below using the post method-->
<?php
	require_once('classes/users.classes.php');
    $userObj = new users($DBH);
	
	if(isset($_POST['submit'])){
		$adddiscussion = $userObj->addDiscussion($_SESSION['userData']['user_id'], $_SESSION['userData']['username'], $_POST['post']);
		echo "<script> window.location.assign('index.php?p=discussion');</script>";
	}
?>

<h1 class="addpostheader">Add Post</h1>
<form class="addpost" method="post" id="addpost" action="">
	<textarea id="post" name="post" rows="25" cols="100"></textarea>
	<br><br>
	<input type="submit" name="submit" value="Submit" class="btn btn-info">
</form>