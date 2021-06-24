<div class="container">
	<div class="row" id="row">
		<div class="homenav col-4">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Top</a>
			</li>
		</div>
		<div class="homenav col-4">
			<li class="nav-item">
				<a class="nav-link" href="index.php?p=hot">Hot</a>
			</li>
		</div>
		<div class="homenav col-4">
			<li class="nav-item">
				<a class="nav-link" href="index.php?p=new">New</a>
			</li>
		</div>
	</div>
</div>

<h1 class="homepages">New</h1>
<!-- This page is used to show the newest items in the database, getNewFiles retrieves the items from the database, it loops through the retrieved items and displays them, 
the review function is used to add to the score if the love button is pressed (the love button only shows if a user is logged in), the button function matches the item_id and user_id so 
a user can only add one score per item, to display images correctly I check whether they are portrait or landscape judging by the image dimensions and display them accordingly, only items
marked public are displayed on the frontpages, details about the item are also displayed next to the item such as name of the item and creator(the creator name also serves as a link to their 
personal page, the show button at the bottom of the page removes the love button if a user has already clicked it (on any frontpage) -->
<?php

	require_once('classes/users.classes.php');
    $userObj = new users($DBH); 
	
	$newFiles = $userObj->getNewFiles();
	
	foreach ($newFiles as $key => $value) {
		list($width, $height) = getimagesize("./images/".$value['item_file']);
		if ($width > $height) {
			$orientation = "Landscape"; }
		else {
			$orientation = "Portrait"; }
		if ($value['visibility'] == 'Public' && $orientation == 'Landscape') {
			if ($_SESSION['loggedin']){
				$username = $userObj->getUsername1($value['item_id']);
				if(isset($_POST[$value['item_id']])){
					$reviewfunction = $userObj->review($value['item_id']);
					$buttonfunction = $userObj->button($_SESSION['userData']['user_id'], $value['item_id']);
					$value['score'] = $value['score'] + 1;
				}	
				echo "<div class='container-fluid item newitems'><div class='row'><div class='col-md-3 blank'></div>
			    <div class='col-md-3 description_art'><h2>".$value['item_name']."</h2>
				<li>By: <a href='index.php?p=yourstuff&id=".$value["user_id"]."'>".$username[0]['username']."</a></li><h3>Score: ".$value['score']."</h3>
				<form '#' method='post'><div class='text-center'><button type='submit' class='btn btn-info' id=".$value['item_id']." name=".$value['item_id'].">Love</button></div></form></div>
				<div class='col-md-3 responsive_art'><img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='500' height='400'></div>
				<div class='col-md-3 blank'></div></div></div>";
			}else {
				$username = $userObj->getUsername1($value['item_id']);
				echo "<div class='container-fluid item newitems'><div class='row'><div class='col-md-3 blank'></div>
				<div class='col-md-3 description_art'><h2>".$value['item_name']."</h2>
				<li>By: <a href='index.php?p=yourstuff&id=".$value["user_id"]."'>".$username[0]['username']."</a></li><h3>Score: ".$value['score']."</h3></div>
				<div class='col-md-3 responsive_art'><img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='500' height='400'></div>
				<div class='col-md-3 blank'></div></div></div>";
			}
		}
		if ($value['visibility'] == 'Public' && $orientation == 'Portrait') {
			if ($_SESSION['loggedin']){
				$username = $userObj->getUsername1($value['item_id']);
				if(isset($_POST[$value['item_id']])){
					$reviewfunction = $userObj->review($value['item_id']);
					$buttonfunction = $userObj->button($_SESSION['userData']['user_id'], $value['item_id']);
					$value['score'] = $value['score'] + 1;
				}	
				echo "<div class='container-fluid item newitems'><div class='row'><div class='col-md-3 blank'></div>
				<div class='col-md-3 description_art'><h2>".$value['item_name']."</h2>
				<li>By: <a href='index.php?p=yourstuff&id=".$value["user_id"]."'>".$username[0]['username']."</a></li><h3>Score: ".$value['score']."</h3>
				<form '#' method='post'><div class='text-center'><button type='submit' class='btn btn-info' id=".$value['item_id']." name=".$value['item_id'].">Love</button></div></form></div>
				<div class='col-md-3 responsive_art_portrait'><img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='300' height='400'></div>
				<div class='col-md-3 blank'></div></div></div>";
			}else{
				$username = $userObj->getUsername1($value['item_id']);
				echo "<div class='container-fluid item newitems'><div class='row'><div class='col-md-3 blank'></div>
				<div class='col-md-3 description_art'><h2>".$value['item_name']."</h2>
				<li>By: <a href='index.php?p=yourstuff&id=".$value["user_id"]."'>".$username[0]['username']."</a></li><h3>Score: ".$value['score']."</h3></div>
				<div class='col-md-3 responsive_art_portrait'><img src='./images/".$value['item_file']."' alt='".$value['item_name']."' width='300' height='400'></div>
				<div class='col-md-3 blank'></div></div></div>";
			}
		}
	}
	$showfunction = $userObj->show($_SESSION['userData']['user_id']);
	
?>
