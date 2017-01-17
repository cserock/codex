<?php
function exitWithError($message){
	
	global $_RESULT;
	$_RESULT['error'] = false;
	$_RESULT['data'] = $message;
	
	@mysqli_close($mysqli);
	echo json_encode($_RESULT);
	exit;
}

?>
