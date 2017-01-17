<?php
include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");

	$song_info_id = $_REQUEST['song_info_id'];
	$result_song_info = array();
	
	if($song_info_id != ""){
		$query = 'SELECT * FROM song_info WHERE song_info_id = '.$song_info_id .';';	
	} else {
		$query = 'SELECT * FROM song_info ORDER BY song_number;' ;
	}
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	while($row = $result->fetch_assoc()) {
		array_push($result_song_info, $row);	
	}
	// var_dump($result_song_info);
	include("../common/dbclose.php");
	
	echo json_encode($result_song_info);
	exit;
?>
