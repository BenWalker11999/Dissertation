<!-- A form is used for the user to add their details upon registration, if everything is set correctly the data will add to the database - the password is encrypted before it is added additionally 
it must be larger than 5 characters long and less than 20, the email is also verified before it is added to the database, if something is not correct it will error -->
<?php
	if(isset($_POST['email']) || isset($_POST['username']) || isset($_POST['password']) 
		|| isset($_POST['forename']) || isset($_POST['surname']) || isset($_POST['gender'])){
		
		if(!$_POST['email'] || !$_POST['username'] || !$_POST['password']
		|| !$_POST['forename'] || !$_POST['surname'] || !$_POST['gender']){
			$error = "Please enter an email, username, password, forename, surname and gender";
		}
		
		if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)){
		
			if (strlen($_POST['password']) > 5 && strlen($_POST['password']) <= 20){
		
				if(!$error){
					//No errors- let's create the account
					//Encrypt the password with a salt
					$encryptedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
					//Insert DB
					$query = "INSERT INTO User (Email, Username, Password, Forename, Surname, Gender) VALUES (:email, :username, :password, :forename, :surname, :gender)";
					$result = $DBH->prepare($query);
					$result->bindParam(':email', $_POST['email']);
					$result->bindParam(':username', $_POST['username']);
					$result->bindParam(':password', $encryptedPass);
					$result->bindParam(':forename', $_POST['forename']);
					$result->bindParam(':surname', $_POST['surname']);
					$result->bindParam(':gender', $_POST['gender']);
					$result->execute();
			
					echo "<script> window.location.assign('index.php?p=account'); </script>";
				}
			}else{
				$passworderror = "Please enter a valid password over 5 characters long and less than 20";
			}
		}else{
			$emailerror = "Please enter a valid email address";
		}
	}
	
?>

<div class="card container mt-5 regForm">
	<div class="card-body">
		<h1 class="mb-3">Register</h1>
		<form action="index.php?p=register" method="post">
			<?php if($error){
				echo '<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">Error:</span>
				'.$error.'
				</div>';
			}
			if($passworderror){
				echo '<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">PasswordError:</span>
				'.$passworderror.'
				</div>';
			} 
			if($emailerror){
				echo '<div class="alert alert-danger" role="alert">
				<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
				<span class="sr-only">EmailError:</span>
				'.$emailerror.'
				</div>';
			}
			?>
				<div class="form-group">
					<label for="email">Email address:</label>
					<input type="email" class="form-control" id="email" name="email" placeholder="email">
				</div>
				<div class="form-group">
					<label for="username">Username:</label>
					<input type="username" class="form-control" id="username" name="username" placeholder="username">
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="password">
				</div>
				<div class="form-group">
					<label for="forename">Forename:</label>
					<input type="text" class="form-control" id="forename" name="forename" placeholder="forename">
				</div>
				<div class="form-group">
					<label for="surname">Surname:</label>
					<input type="text" class="form-control" id="surname" name="surname" placeholder="surname">
				</div>
				<div class="form-group">
					<label for="gender">Gender:</label>
					<select class="form-control" id="gender" name="gender">
						<option value="">Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Other">Other</option>
					</select>
				</div>
				<div class="col text-center">
					<button type="submit" class="btn btn-info">Register</button>
				</div>
		</form>
	</div>
</div>