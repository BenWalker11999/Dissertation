<?php

	class users
	{
		protected $db = null;
		
		public function __construct($db){
			$this->db = $db;
		}
		
		//Function to verify users data
		public function checkUser($username, $password){
			//lets get user
			$query = "SELECT * FROM User WHERE username = :username";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':username',$username);
			$pdo->execute();
		
			$user = $pdo->fetch(PDO::FETCH_ASSOC);
		
			if(empty($user)){
				return false;
			}else if(password_verify($password, $user['password'])){
				return $user;
			}else{
				return false;
			}
		}
		
		//Function to retrieve users data for the accounts page
		public function getUser($username){
			//Let's get the users information
			$query = "SELECT * FROM User WHERE username = :username";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':username', $username);
			$pdo->execute();
			
			return $pdo->fetch(PDO::FETCH_ASSOC);
		}
		
		//Function to update a users account
		public function updateAccount($username, $forename, $surname, $gender){
			$query = "UPDATE User SET forename = :forename, surname = :surname, gender = :gender 
			WHERE username = :username";
			
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':forename', $forename);
			$pdo->bindParam(':surname', $surname);
			$pdo->bindParam(':gender', $gender);
			$pdo->bindParam(':username', $username);
			
			if($pdo->execute()){
				return true;
			}else{
				return false;
			}
		}
		
		//Function to retrieve a users current items
		public function getCurrentFiles($userid, $searchTerm = null){
			if(isset($searchTerm)){
				$searchTerm = '%'.$searchTerm.'%';
				$query = "SELECT * FROM User_Items WHERE user_id = :userid AND item_name LIKE :search";
				$pdo = $this->db->prepare($query);
				$pdo->bindParam(':userid', $userid);
				$pdo->bindParam(':search', $searchTerm);
			}else{
				$query = "SELECT * FROM User_Items WHERE user_id = :userid";
				$pdo = $this->db->prepare($query);
				$pdo->bindParam(':userid', $userid);
			}
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to add a item to the database, the file is verified before being added to the database
		public function addingFile ($userid, $file = null, $name_of_item, $publicprivate){
			
			if($file["tmp_name"]){
		
				$newFilename = md5(uniqid(rand(), true)).$file["name"];
				$target_file = "./images/" . basename($newFilename);
				$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
				$error1 = false;
				date_default_timezone_set('Europe/London');
				$date = date('Y-m-d H:i:s');

				$check = getimagesize($file["tmp_name"]);
				if($check === false) {
					echo '<div class="alert alert-danger" role="alert">File is not an image!</div>';
					$error1 = true;
					
				}

				if (file_exists($target_file)) {
					echo '<div class="alert alert-danger" role="alert">Sorry, file already exists</div>';
					$error1 = true;
				}

				if ($_FILES["file"]["size"] > 500000) {
					echo '<div class="alert alert-danger" role="alert">Sorry, your file is too large</div>';
					$error1 = true;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
					echo '<div class="alert alert-danger" role="alert">Sorry, only JPG, JPEG, PNG and GIF files are allowed</div>';
					$error1 = true;
				}
				
				if ($error1 == false) {
					move_uploaded_file($file["tmp_name"], $target_file);
					$query = "INSERT INTO User_Items (user_id, item_file, item_name, visibility, datetime) VALUES (:userid, :file, :name_of_item, :publicprivate, :datetime)";
					$pdo = $this->db->prepare($query);
					$pdo->bindParam(':file', $newFilename);
					$pdo->bindParam(':userid', $userid);
					$pdo->bindParam(':name_of_item', $name_of_item);
					$pdo->bindParam(':publicprivate', $publicprivate);
					$pdo->bindParam(':datetime', $date);
					
					if($pdo->execute()){
						return true;
					}else{
						return false;
					}
				}else {
					return false;
				}
			}
		}
		
		//Function to update an item stored
		public function updateItem ($itemid, $name_of_item, $publicprivate){
			$query = "UPDATE User_Items SET item_name = :name_of_item, visibility = :publicprivate WHERE item_id = :itemid";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':name_of_item', $name_of_item);
			$pdo->bindParam(':itemid', $itemid);
			$pdo->bindParam(':publicprivate', $publicprivate);
			
			if($pdo->execute()){
				return true;
			}else{
				return false;
			}
		}
		
		//Function to delete an item stored
		public function deleteItem($item_id){
			//Let's get the users information
			$query = "DELETE FROM User_Items WHERE item_id = :item_id";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':item_id', $item_id);
			$pdo->execute();
			
			echo "<script> window.location.assign('index.php?p=mystuff'); </script>";
			return $pdo->fetch(PDO::FETCH_ASSOC);
		}
		
		//Function to retrieve new files ordered by the time descending
		public function getNewFiles () {
			$query = "SELECT * FROM User_Items ORDER BY datetime DESC";
			$pdo = $this->db->prepare($query);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to retrieve top files ordered by the score descending
		public function getTopFiles () {
			$query = "SELECT * FROM User_Items ORDER BY score DESC";
			$pdo = $this->db->prepare($query);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to retrieve hot files, divides score by the time stamp difference (between the time uploaded and the time now), ordered by dateDiff
		public function getHotFiles () {
			date_default_timezone_set('Europe/London');
			$query = "SELECT item_id, user_id, item_file, item_name, visibility, score, score/TIMESTAMPDIFF(MINUTE, datetime, CURRENT_TIMESTAMP) AS DateDiff FROM User_Items ORDER BY dateDiff DESC";
			$pdo = $this->db->prepare($query);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		
		//Function to update an items score
		public function review ($itemid) {
			$query = "UPDATE User_Items SET score = score + 1 WHERE item_id = :itemid";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':itemid', $itemid);
			$pdo->execute();
		}
		
		//Function to insert the user_id and item_id to the review table
		public function button ($userid, $itemid) {
			$query = "INSERT INTO Reviews (user_id, item_id) VALUES (:userid, :itemid)";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':userid', $userid);
			$pdo->bindParam(':itemid', $itemid);
			$pdo->execute();
		}
		
		//Function to hide the love button if the item_id and user_id match in the database
		public function show ($userid) {
			$query = "SELECT item_id FROM Reviews WHERE user_id = :userid";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':userid', $userid);
			$pdo->execute();
			$show = $pdo->fetchAll();
			foreach ($show as $key => $value){
				echo "<script> document.getElementById(".$value['item_id'].").style.display = 'none';</script>";
			}
		}
		
		//Function to retrieve username 
		public function getUsername1($itemid){
			$query = "SELECT u.username FROM User_Items ui INNER JOIN User u ON u.user_id = ui.user_id WHERE item_id = :itemid";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':itemid', $itemid);
			$pdo->execute();
			$usernamereturn = $pdo->fetchAll();
			return $usernamereturn;
		}
		
		//Function another function to retrieve username 
		public function getUsername2($user_id) {
			$query = "SELECT username FROM User WHERE user_id = :user_id";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':user_id', $user_id);
			$pdo->execute();
			$username = $pdo->fetchAll();
			return $username;
		}
		
		
		//Function to add a message to the database
		public function addingMessage($user_id1, $user_id2, $username1, $username2, $message) {
			$query = "INSERT INTO Messaging (outbound_id, inbound_id, outbound_username, inbound_username, message) VALUES (:user_id1, :user_id2, :username1, :username2, :message)";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':user_id1', $user_id1);
			$pdo->bindParam(':user_id2', $user_id2);
			$pdo->bindParam(':username1', $username1);
			$pdo->bindParam(':username2', $username2);
			$pdo->bindParam(':message', $message);
			$pdo->execute();
		}
		
		//Function to show a message stored in the database
		public function showMessage ($user_id1, $user_id2) {
			$query = "SELECT message, outbound_username FROM Messaging WHERE (outbound_id = :user_id1 OR outbound_id = :user_id2) AND (inbound_id = :user_id2 OR inbound_id = :user_id1)";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':user_id1', $user_id1);
			$pdo->bindParam(':user_id2', $user_id2);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to show a list of users who have messaged the current logged in user
		public function showMessageList ($user_id) {
			$query = "SELECT DISTINCT outbound_id, inbound_id, outbound_username, inbound_username FROM Messaging WHERE (outbound_id = :user_id OR inbound_id = :user_id)";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':user_id', $user_id);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to add a discussion to the database
		public function addDiscussion ($user_id, $username, $post) {
			date_default_timezone_set('Europe/London');
			$time = date('Y-m-d H:i:s');
			$query = "INSERT INTO Discussion (user_id, username, discussion, time) VALUES (:user_id, :username, :post, :time)";
			$pdo = $this->db->prepare($query);
			$pdo->bindParam(':user_id', $user_id);
			$pdo->bindParam(':username', $username);
			$pdo->bindParam(':post', $post);
			$pdo->bindParam(':time', $time);
			$pdo->execute();
			return $pdo->fetchAll();
		}
		
		//Function to retrieve discussions to the database
		public function getDiscussion () {
			$query = "SELECT * FROM Discussion ORDER BY time DESC";
			$pdo = $this->db->prepare($query);
			$pdo->execute();
			return $pdo->fetchAll();
		}
	}
?>