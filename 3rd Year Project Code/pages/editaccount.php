<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
	
?>
<!-- If the form below is submitted the data is retrieved using the post message and along with the sessions username is passed into the updateAccount function to update a users account details,
the form below already contains the current user details-->
<div class="container card editaccounts">
	<div class="card-body">
		<h1>Edit your account</h1>
		
		<?php
    		require_once('classes/users.classes.php');
    		$userObj = new users($DBH); 

    		if(isset($_POST['submit'])){

    			$updateAccount = $userObj->updateAccount($_SESSION['userData']['username'], $_POST['forename'], $_POST['surname'], $_POST['gender']); 

    			if($updateAccount){
    				echo '<div class="alert alert-success" role="alert">Your profile has been updated!</div>';
    			}
    			
    		}
			
    		$account = $userObj->getUser($_SESSION['userData']['username']); 
    	?>
		
    	<form method="post" action="" enctype="multipart/form-data">
    		<div class="form-group">
    			<label for="forename">Forename:</label>
    			<input type="text" class="form-control" id="forename" name="forename" value="<?php echo $account['forename']; ?>">
    		</div>
			<div class="form-group">
    			<label for="surname">Surname:</label>
    			<input type="text" class="form-control" id="surname" name="surname" value="<?php echo $account['surname']; ?>">
    		</div>
    		<div class="form-group">
    			<label for="gender">Gender:</label>
    			<select class="form-control" id="gender" name="gender">
					<option value="" <?php if ($account['gender'] == '') echo ' selected="selected"'; ?>>Gender</option>
					<option value="Male" <?php if ($account['gender'] == 'Male') echo ' selected="selected"'; ?>>Male</option>
					<option value="Female" <?php if ($account['gender'] == 'Female') echo ' selected="selected"'; ?>>Female</option>
					<option value="Other" <?php if ($account['gender'] == 'Other') echo ' selected="selected"'; ?>>Other</option>
				</select>
    		</div>
			<div class="col text-center">
				<button type="submit" name="submit" class="btn btn-info">Update Account</button>
			</div>
    	</form>
	</div>
</div>