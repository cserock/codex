<?php
include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");

	$mode = 'regist';
	
	if(isset($_REQUEST['song_info_id']) && ($_REQUEST['song_info_id'] !="")){
		$song_info_id = trim($_REQUEST['song_info_id']);
		$mode = 'update';
	}
	
	if($mode == 'regist'){
		$stmt = $mysqli->prepare("INSERT INTO song_info(
									`song_title`,
									`song_number`,
									`song_lyric_start`,
									`song_lyric_refrain`,
									`song_lyric_keyword`,
									`beat`,
									`chord`,
									`chord_pitch`,
									`chord_option`,
									`bar_count`,
									`lyric_count`
								) VALUES (?,?,?,?,?,?,?,?,?,?,?)"
		);
		
		$stmt->bind_param('sisssssssii', $song_title, $song_number, $song_lyric_start, $song_lyric_refrain, $song_lyric_keyword, $beat, $chord, $chord_pitch, $chord_option, $bar_count, $lyric_count);
	} else {
		$stmt = $mysqli->prepare("UPDATE song_info SET
									song_title=?,
									song_number=?,
									song_lyric_start=?,
									song_lyric_refrain=?,
									song_lyric_keyword=?,
									beat=?,
									chord=?,
									chord_pitch=?,
									chord_option=?,
									bar_count=?,
									lyric_count=?
									WHERE song_info_id=?");
		
		$stmt->bind_param('sisssssssiii', $song_title, $song_number, $song_lyric_start, $song_lyric_refrain, $song_lyric_keyword, $beat, $chord, $chord_pitch, $chord_option, $bar_count, $lyric_count, $song_info_id);
		
		if(isset($_REQUEST['song_info_id'])){
			$song_info_id = trim($_REQUEST['song_info_id']);
		} else {
			exitWithError('invalidated data');
		}
		
	}
	if(isset($_REQUEST['song_title'])){
		$song_title = trim($_REQUEST['song_title']);
	} else {
		exitWithError('invalidated data');
	}
	
	if(isset($_REQUEST['song_number'])){
		$song_number = trim($_REQUEST['song_number']);
	} else {
		$song_number = "";
	}
	
	if(isset($_REQUEST['song_lyric_start'])){
		$song_lyric_start = trim($_REQUEST['song_lyric_start']);
	} else {
		$song_lyric_start = "";
	}
	
	if(isset($_REQUEST['song_lyric_refrain'])){
		$song_lyric_refrain = trim($_REQUEST['song_lyric_refrain']);
	} else {
		$song_lyric_refrain = "";
	}
	
	if(isset($_REQUEST['song_lyric_keyword'])){
		$song_lyric_keyword = trim($_REQUEST['song_lyric_keyword']);
	} else {
		$song_lyric_keyword = "";
	}
	
	if(isset($_REQUEST['beat'])){
		$beat = trim($_REQUEST['beat']);
	} else {
		$beat = "";
	}
	
	if(isset($_REQUEST['chord'])){
		$chord = trim($_REQUEST['chord']);
	} else {
		$chord = "";
	}
	
	if(isset($_REQUEST['chord_pitch'])){
		$chord_pitch = trim($_REQUEST['chord_pitch']);
	} else {
		$chord_pitch = "";
	}
	
	if(isset($_REQUEST['chord_option'])){
		$chord_option = trim($_REQUEST['chord_option']);
	} else {
		$chord_option = "";
	}
	
	if(isset($_REQUEST['bar_count'])){
		$bar_count = trim($_REQUEST['bar_count']);
	} else {
		$bar_count = "";
	}
	
	if(isset($_REQUEST['lyric_count'])){
		$lyric_count = trim($_REQUEST['lyric_count']);
	} else {
		$lyric_count = "";
	}
	
	$stmt->execute();
	// printf("%d Row inserted.\n", $stmt->affected_rows);
	
	if($mode == 'regist'){
		$newId = $stmt->insert_id;	
	} else {
		$newId = $song_info_id;
	}
	
	$stmt->close();
	
	$_RESULT['data']['insert_id'] = $newId;
	echo json_encode($_RESULT);
	
	
include("../common/dbclose.php");
?>