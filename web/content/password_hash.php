<?php


$password = 'Temporarypassword123';


	$password_hash = password_hash($password, PASSWORD_BCRYPT, array(
				'cost' => 12
			));

	echo $password_hash;

?>