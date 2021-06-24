<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
	
?>
<!-- A form to add items to your mystuff page, a user can set whether the item is public or private (whether other users can see the item) the addingFile function retrieves this data from the form so
it can be added to the database -->
<div class="container card mt-5 mystuff">
	<div class="card-body">
		<h1>Add Work To Your Profile</h1>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<input type="file" name="file" id="file">
			</div>
			<div class="form-group">
					<label for="name_of_item">Name of Item:</label>
					<input type="text" class="form-control" id="name_of_item" name="name_of_item" placeholder="Name of Item">
			</div>
			<div class="form-group">
    			<label for="public-private">Do you want others to see this work?</label>
    			<select class="form-control" id="public-private" name="public-private">
					<option value="">Public or Private</option>
					<option value="Public">Public</option>
					<option value="Private">Private</option>
				</select>
    		</div>	
			<div class="text-center">
				<button type="submit" name="submit" class="btn btn-info">Add Your Work</button>
			</div>
		</form>
	</div>
</div>

<?php 
	require_once('classes/users.classes.php');
    $userObj = new users($DBH); 

	if(isset($_POST['submit'])){
		$file = $userObj->addingFile($_SESSION['userData']['user_id'], $_FILES['file'], $_POST['name_of_item'], $_POST['public-private']);
	}
?>
<!-- Users work is displayed using the getCurrentFiles function, the page is split into public and private items, portrait and landscape items will present differently on the page, a user can
also search for different pieces they have uploaded -->
<div class="container card mt-5">
	<div class="card-body">
		<form class="form-inline" action="" method="post">
			<div class="form-group">
				<label for="search">Search for work you have uploaded:</label>
				<input type="text" class="form-control" id="search" name="search" style="margin-left: 5px;">
			</div>
			<button type="submit" class="btn btn-info" style="margin-left: 5px;">Search</button>
		</form>
	</div>
</div>
	
<?php
	$currentFiles = $userObj->getCurrentFiles($_SESSION['userData']['user_id'], $_POST['search']);
	
?>

<div class="container">
	<div class="row">
		<div class="itemfilespublic col-6">
			<h1>Public work</h1>
			<?php
				foreach ($currentFiles as $key => $value) {
					list($width, $height) = getimagesize("./images/".$value['item_file']);
					if ($width > $height) {
						$orientation = "Landscape"; }
					else {
						$orientation = "Portrait"; }
					if ($value['visibility'] == 'Public' && $orientation == 'Landscape') {
						echo "<a href='index.php?p=edititem&id=".$value["item_id"]."'>
						<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='500' height='300'>
						<h2>".$value['item_name']."</h2>
						</a>";
					}
					if ($value['visibility'] == 'Public' && $orientation == 'Portrait') {
						echo "<a href='index.php?p=edititem&id=".$value["item_id"]."'>
						<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='300' height='500'>
						<h2>".$value['item_name']."</h2>
						</a>";
					}
				}
			?>
		</div>
		<div class="itemfilesprivate col-6">
			<h1>Private work</h1>
			<?php
				foreach ($currentFiles as $key => $value) {
					list($width, $height) = getimagesize("./images/".$value['item_file']);
					if ($width > $height) {
						$orientation = "Landscape"; }
					else {
						$orientation = "Portrait"; }
					if ($value['visibility'] == 'Private' && $orientation == 'Landscape') {
						echo "<a href='index.php?p=edititem&id=".$value["item_id"]."'>
						<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='500' height='300'>
						<h2>".$value['item_name']."</h2>
						</a>";
					}
					if ($value['visibility'] == 'Private' && $orientation == 'Portrait') {
						echo "<a href='index.php?p=edititem&id=".$value["item_id"]."'>
						<img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='300' height='500'>
						<h2>".$value['item_name']."</h2>
						</a>";
					}
				}
			?>
		</div>
	</div>
</div>
	

