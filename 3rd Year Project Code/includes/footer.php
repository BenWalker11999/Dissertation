<!-- The footer is used for registering, logging in and out, going to your account and viewing the about page if a user is logged in the log out button will display and the login button 
will not and vice versa -->
<footer class="page-footer bg-dark">
			
<div class="container-fluid">
	<div class="row">
		<div class="col-md">
			<ul class="footer-nav">
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=about">About</a>
				</li>
			</ul>
		</div>
		<?php if(!$_SESSION['loggedin']){ ?>
		<div class="col-md">
			<ul>
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=register">Sign Up</a>
				</li>
			</ul>
		</div>
	<?php } ?>
		<div class="col-md">
			<ul>
			<?php if($_SESSION['loggedin']){ ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=logout">Log Out</a>
				</li>
			<?php }else{ ?>
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=login">Sign In</a>
				</li>
			<?php } ?>
			</ul>
		</div>
		<div class="col-md">
			<ul>
				<li class="nav-item">
					<a class="nav-link" href="index.php?p=account">Your Account</a>
				</li>
			</ul>
		</div>
	</div>
</div>

</footer>

</body>
</html>