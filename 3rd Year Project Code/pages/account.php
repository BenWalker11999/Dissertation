<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
	
?>
<!-- Calls the getUser function to retrieve users data and stores it in the $account variable, based on the sessions username -->
<?php
	
	if($_SESSION['loggedin'] = true){
		require_once('classes/users.classes.php');
		$userObj = new users($DBH);
		$account = $userObj->getUser($_SESSION['userData'][username]); 
		
	}else{
		$error = "No account found.";
	}
	
?>
<!-- Shows the users current details which were stored in the $account variable, if they click the button they can edit their details -->
<div class="container card mt-5 accounts">
	<div class="card-body">
		<?php 
			if($error){
				echo "<h1>Error!</h1>";
				echo "<p>".$error."</p>";
			}else{
		?>
				<h1><?php echo $account['forename']; ?>'s account page </h1>
				<p><strong>Surname:</strong> <?php echo $account['surname']; ?></p>
				<p><strong>Gender:</strong> <?php echo $account['gender']; ?></p>
				<div class="editaccountbutton col text-center">
					<button class="btn btn-info" onclick="window.location.href='index.php?p=editaccount';">Edit Account</button>
				</div>
			<?php } ?>
	</div>
</div>

