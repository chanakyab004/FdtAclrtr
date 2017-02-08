<?php
include "includes/include.php";

	$object = new Session();
	$object->sessionCheck();

	set_error_handler('error_handler');

	if(isset($_SESSION["userID"])) {
		$userID = $_SESSION['userID'];
	}

require_once dirname(__FILE__) . '/includes/quickbooks-config.php';

if ($IntuitAnywhere->disconnect($the_username, $the_tenant))
{
	
}

//require_once dirname(__FILE__) . '/views/header.tpl.php';

?>


		<div style="text-align: center; font-family: sans-serif; font-weight: bold;">
			DISCONNECTED! Please wait...
		</div>
		
		
		<script type="text/javascript">
			window.setTimeout('window.location = \'./company-profile.php\';', 2000);
		</script>
			
<?php

//require_once dirname(__FILE__) . '/views/footer.tpl.php';

?>