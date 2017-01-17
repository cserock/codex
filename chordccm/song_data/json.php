<?php
include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");

	$song_info_id = $_REQUEST['song_info_id'];
	$result_song_data = array();
	
	if($song_info_id != ""){
		$query = 'SELECT * FROM song_data WHERE song_info_id = '.$song_info_id .' ORDER BY beat_index ;';	
	} else {
		$query = 'SELECT * FROM song_data ORDER BY song_info_id, beat_index ;';
	}
	
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	while($row = $result->fetch_assoc()) {
		array_push($result_song_data, $row);	
	}
	// var_dump($result_song_info);
	include("../common/dbclose.php");
	
	echo json_encode($result_song_data);
	exit;
?>
