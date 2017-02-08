<?php
	session_start();


	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}	

			
?>
<?php include "templates/user-agreement.html";  ?>