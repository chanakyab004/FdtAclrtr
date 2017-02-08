<?php
	include_once 'includes/settings.php';

	//id1 is encrypted email, id2 is encrypted customerID
	if(isset($_GET['id1'])) {
		if(isset($_GET['id2'])) {
			$id1 = filter_input(INPUT_GET, 'id1', FILTER_SANITIZE_ENCODED);
			$id1 = urldecode($id1);

			$id2 = filter_input(INPUT_GET, 'id2', FILTER_SANITIZE_ENCODED);
			$id2 = urldecode($id2);
			
			include_once('includes/classes/class_AES.php');

			$blockSize = 256;
			$key1 = "QIY2TFpa7yK6gXU5YPM4L65xMas0awHj";
			$key2 = "Dx4ycsbIoyq7ZncWiu3qSpLNPd3QVFAX";

			$aes1 = new AES($id1, $key1, $blockSize);
			$aes2 = new AES($id2, $key2, $blockSize);
			// $enc = $aes->encrypt();
			// $aes1->setData($id1);
			// $aes2->setData($id2);
			$linkedEmail = $aes1->decrypt();
			$linkedID = $aes2->decrypt();
			$disabled = '';
		}
		else{
			$formMessage = "Error, user doesn't exist";
			$linkedEmail = '';
			$linkedID = '';
			$disabled = 'disabled';
		}
	}
	else{
		$formMessage = "Error, user doesn't exist";
		$linkedEmail = '';
		$linkedID = '';
		$disabled = 'disabled';
	}

	include_once('includes/classes/class_Unsubscribe.php');

	if (isset($_POST["submit"])) {
			
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$customerID = filter_input(INPUT_POST, 'customerID', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		$object = new Unsubscribe();
		$object->setEmail($email);
		$object->setCustomerID($customerID);
		$object->unsubscribe();
		$formMessage = $object->getResults();	
	}

?>
<?php include "templates/unsubscribe.html";  ?>
