<?php

	require_once dirname(__FILE__) . '/includes/QuickBooks.php';
	$AES = QuickBooks_Encryption_Factory::create('aes');
	$encryption_key = 'bcde1234';
	$encrypted_token = $AES->encrypt($encryption_key, 'qyprdakSQyzyrtfKJBEFsMlGBlDZXKNQIjnsWS8M3fqrLyMS');
	$encrypted_token_secret = $AES->encrypt($encryption_key, 'd1L2bS2kF6dPz6ekEynchyrhmnuo373nYWxJMJNl');

	echo $encrypted_token;
	echo '<br/>';
	echo $encrypted_token_secret;
				
?>