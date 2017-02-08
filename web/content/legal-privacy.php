<?php
	include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();

			
?>
<?php include "templates/legal-privacy.html";  ?>