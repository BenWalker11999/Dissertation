<!-- Makes sure the session is equivalent to logged in elsewise it redirects them to the login page -->
<?php
	
	if(!$_SESSION['loggedin']){
		//User is not logged in
		echo "<h1>Access Denied</h1>";
		echo "<script> window.location.assign('index.php?p=login'); </script>";
		exit;
	}
	
?>
<!-- If the form below is submitted the updateItem function is called to update an items details, the id of said item is retrieved from the url and the details to be changed are retrieved 
from the form below and passed into the function, the form contains the current details, there is also a deleteItem function which can be used to delete a item, the id from the url is used to 
determine which item to delete  -->
<div class="container card mt-5 mystuff">
	<div class="card-body">
		<h1>Edit an Item</h1>
		<?php
			require_once('classes/users.classes.php');
    		$userObj = new users($DBH); 

    		if(isset($_POST['submit'])){

    			$updateItem = $userObj->updateItem($_GET['id'],  $_POST['name_of_item'], $_POST['public-private']); 

    			if($updateItem){
    				echo '<div class="alert alert-success" role="alert">Item has been updated!</div>';
    			}
    			
    		}
		
			$originalitem = $userObj->getCurrentFiles($_SESSION['userData']['user_id']);
			foreach ($originalitem as $key => $value) {
					if ($value['item_id'] == $_GET['id']) {
						$name = $value['item_name'];
					}
			}
			
			if(isset($_POST['deleteItem'])){
					$deleteItem = $userObj->deleteItem($_GET['id']);
				}
		?>
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
					<label for="name_of_item">Name of Item:</label>
					<input type="text" class="form-control" id="name_of_item" name="name_of_item" value="<?php echo $name; ?>">
			</div>
			<div class="form-group">
    			<label for="public-private">Do you want others to see this work?</label>
    			<select class="form-control" id="public-private" name="public-private">
					<option value="" <?php if ($value['visibility'] == '') echo ' selected="selected"'; ?>>Public or Private</option>
					<option value="Public" <?php if ($value['visibility'] == 'Public') echo ' selected="selected"'; ?>>Public</option>
					<option value="Private" <?php if ($value['visibility'] == 'Private') echo ' selected="selected"'; ?>>Private</option>
				</select>
    		</div>	
			<div class="text-center">
				<button type="submit" name="submit" class="btn btn-info">Change item details</button>
			</div>
			<div class="col text-center">
				<button type="submit" name="deleteItem" id="deleteItem" class="btn btn-info deleteItem" style="margin-top: 10px">Delete item</button>
			</div>
		</form>
	</div>
</div>