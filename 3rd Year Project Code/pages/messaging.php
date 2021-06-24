<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
?>
<!-- The messaging page is used to show messages received and sent by users, a form is used to input a message - next to the message the users username will display, the two getUsername2 function 
calls are used to retrived the usernames of the two users messaging eachother, the current users username is retrived through the session data whereas the other users details are retrieved 
through the url, the addingMessage function adds the sent message to the database - the sender and receivers details are stored along with the message, the showMessage function shows received and sent
messages -->

<?php
	require_once('classes/users.classes.php');
    $userObj = new users($DBH);
	
	$user_id = $_GET['id'];
	$username1 = $userObj->getUsername2($user_id);
	$username = $userObj->getUsername2($_SESSION['userData'][user_id]);
	
	if(isset($_POST['submit'])){
		$message = $userObj->addingMessage($_SESSION['userData']['user_id'], $_GET['id'], $_SESSION['userData']['username'], $username1[0][0], $_POST['message']);
	}
	
	$messageshow = $userObj->showMessage($_SESSION['userData']['user_id'], $_GET['id']);
	
	foreach ($messageshow as $key => $value) {
		echo "<div class='container-fluid'><div class='row messages'>
		<h3>".$value['outbound_username'].":&nbsp</h3><p>".$value['message']."</p></div></div>";
	}
	
?>

<form class="messageform" method="post" id="messageform" action="#messageform">
	<label for="message"><?php echo $username[0][0]?>: </label>
	<textarea id="message" name="message" rows="7" cols="80"></textarea>
	<br><br>
	<input type="submit" name="submit" value="Submit" class="btn btn-info messagebutton">
</form>