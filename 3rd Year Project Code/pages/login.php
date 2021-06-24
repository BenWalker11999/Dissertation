<!-- Login form to enter username and password, the checkUser function retrieves the login forms data and checks it against details stored in the database if the details are incorrect it will error
elsewise it will set the session loggedin to true and set the userData to the users details -->
<?php
	if(isset($_POST['username']) || isset($_POST['password'])){
		if(!$_POST['username'] || !$_POST['password']){
			$error = "Please enter a username and password";
		}
		
		if(!$error){
			require_once('classes/users.classes.php');
			
			$usersObj = new users($DBH);
			$checkUser = $usersObj->checkUser($_POST['username'],$_POST['password']);
			
			if($checkUser){
				//User found
				$_SESSION['loggedin'] = true;
				$_SESSION['userData'] = $checkUser;
				
				echo "<script> window.location.assign('index.php?p=mystuff');</script>";
			}else{
				$error = "Username or Password Incorrect";
			}
		}
	}

?>	

<div class="card container mt-5 formLogin">
	<div class="card-body">
		<h1 class="mb-3">Login to your account</h1>
		<form action="index.php?p=login" method="post">
			<?php if($error){
				echo '<div class="alert alert-danger" role="alert">
						<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
						<span class="sr-only">Error:</span>
						'.$error.'
				</div>';
			} ?>
			<div class="form-group">
				<label for="username">Username:</label>
				<input type="username" class="form-control" id="username" name="username" placeholder="username">
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="password">
			</div>
			<div class="col text-center">
				<button type="submit" class="btn btn-info">Login</button>
			</div>
		</form>
	</div>
</div>