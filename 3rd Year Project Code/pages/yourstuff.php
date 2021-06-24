<!-- The yourstuff page is for users to view another users public items and to message them, the users id is retrieved throught the id in the url and their username is retrieved by calling the 
getUsername2 function, the users current files are retrieved using the getCurrentFiles function, a link to message the user is shown, public items are shown whether they are landscape or portrait is
also taken into account -->
<?php
	require_once('classes/users.classes.php');
    $userObj = new users($DBH);

	$user_id = $_GET['id'];
	$username = $userObj->getUsername2($user_id);
	$currentFiles = $userObj->getCurrentFiles($user_id);
?>

<div class="container">
	<div class="row">
		<div class="yourstuffitemfilespublic col-12">
			<h1><?php echo $username[0][0] ?>'s work</h1>
			<?php
				if ($_SESSION['loggedin']){
					echo "<li class='messagelink'>Message: <a href='index.php?p=messaging&id=".$user_id['id']."'>".$username[0]['username']."</a></li>";
				}	
			?>
			<?php
				foreach ($currentFiles as $key => $value) {
					list($width, $height) = getimagesize("./images/".$value['item_file']);
					if ($width > $height) {
						$orientation = "Landscape"; }
					else {
						$orientation = "Portrait"; }
					if ($value['visibility'] == 'Public' && $orientation == 'Landscape') {
						echo "<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='500' height='300'>
						<h2>".$value['item_name']."</h2>";
					}
					if ($value['visibility'] == 'Public' && $orientation == 'Portrait') {
						echo "<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='300' height='500'>
						<h2>".$value['item_name']."</h2>";
					}
				}
			?>
		</div>
	</div>
</div>