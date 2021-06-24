<!-- button to add a discussion, redirects to the addpost page which contains a form to add a discussion -->
<div class="container">
	<div class="row" id="row">
		<div class="addpostlink col-12 ">
			<li class="nav-item">
				<a class="post-link" href="index.php?p=addpost">Add Post</a>
			</li>
		</div>
	</div>
</div>
<!-- retrieves any discussions from the database using the getDiscussion function -->
<?php

	require_once('classes/users.classes.php');
    $userObj = new users($DBH);
	
	$getdiscussion = $userObj->getDiscussion();
	
	foreach ($getdiscussion as $key => $value) {
		echo "<div class='container-fluid'><div class='row discussion-box'><div class='discussion'><li>Discussion by: <a href='index.php?p=yourstuff&id=".$value["user_id"]."'>".$value['username']."</a></li>
		<p>".$value['discussion']."</p></div></div></div>";
	}
			