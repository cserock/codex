<?php

include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");

    /*
    $size = (int) $_SERVER['CONTENT_LENGTH'];

    var_dump($_SERVER);

    echo $size;

    var_dump($_REQUEST);
    var_dump($_POST);
    var_dump($_GET);
    exit;
    */

	if(!isset($_REQUEST['song_info_id'])){
		exitWithError('invalidated data');
	}
	
	$song_info_id = $_REQUEST['song_info_id'];
	
	// init request data
	$request_data = array();
	
	foreach($_REQUEST as $key=>$val){
		// echo "key : $key  ~~~  val : $val<br>";
		$arr_tmp = explode('_', $key);
		$last_index = count($arr_tmp) - 1;
		
		if(is_numeric($arr_tmp[$last_index])){
		
			$first_key = $arr_tmp[$last_index];
			// echo " first key : ".$first_key."<br>";
				
			$second_key = "";
			for($i=0;$i<$last_index;$i++){
				$second_key.=$arr_tmp[$i].'_';
			}
			
			$second_key = substr($second_key, 0, strlen($second_key)-1);
			// echo " second key : ".$second_key."<br>";
			$request_data[$first_key][$second_key] = $val;
		}
	}
	// var_dump($request_data[43]);
	
	foreach($request_data as $beat_index=>$first_val){
		// echo " beat_index : ".$beat_index."<br>";
		
		$result_song_data = array();
		$query = 'SELECT * FROM song_data WHERE song_info_id = '.$song_info_id .' AND beat_index = '.$beat_index.' ;';
		$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
		while($row = $result->fetch_assoc()) {
			array_push($result_song_data, $row);	
		}
		// var_dump($result_song_data);
		
		// update or delete
		if($result_song_data){
			
			$query_value = "";
			$is_exist_data = false;
			
			foreach($first_val as $second_key=>$second_val){
					
				$query_value .= $second_key." = ";
				
				if($second_val != ""){
					$is_exist_data = true;
				}
	
				// if(is_numeric($second_val)){
				if(($second_key == "song_info_id") || ($second_key == "beat_index") || ($second_key == "rest_type") || ($second_key == "bar_type")){
						
					if($second_val == ""){
						$second_val = 0;
					}
						
					$query_value .= $second_val.",";
				} else {
					$query_value .= "'".$second_val."',";
				}
				
				// echo " second key : ".$second_key."<br>";
				// echo " second val : ".$second_val."<br>";
			}	
			
			$query_value = substr($query_value, 0, strlen($query_value)-1);
			
			if($is_exist_data){
				$query = "UPDATE song_data SET ";
				$query .= $query_value;
				$query .= " WHERE ";
				$query .= " song_info_id = ".$song_info_id ." AND beat_index = ".$beat_index." ;";
			} else {
				$query = "DELETE FROM song_data ";
				$query .= " WHERE ";
				$query .= " song_info_id = ".$song_info_id ." AND beat_index = ".$beat_index." ;";
			}
			
			// if($beat_index == 7){
				// echo $query;
			// }
			// echo $query;
			$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
			
		// insert
		} else {
			
			$query_field = "";
			$query_value = "";
			$is_exist_data = false;
			
			foreach($first_val as $second_key=>$second_val){
					
				$query_field .= "`".$second_key."`,";
				
				if($second_val != ""){
					$is_exist_data = true;
				}
				
				// if(is_numeric($second_val)){
				if(($second_key == "song_info_id") || ($second_key == "beat_index") || ($second_key == "rest_type") || ($second_key == "bar_type")){
					if($second_val == ""){
						$second_val = 0;
					}
					$query_value .= $second_val.",";
				} else {
					$query_value .= "'".$second_val."',";
				}
			}	
			
			$query_field = substr($query_field, 0, strlen($query_field)-1);
			$query_value = substr($query_value, 0, strlen($query_value)-1);
			
			if($is_exist_data){
				$query = "INSERT INTO song_data (`song_info_id`, `beat_index`, ";
				$query .= $query_field;
				$query .= ") VALUES (";
				$query .= $song_info_id.", ".$beat_index.", ";
				$query .= $query_value;
				$query .= ");";
			}
			// echo $query;
			// if($beat_index == 7){
				// echo $query;
			// }
			$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
		}
	}
	
	$_RESULT['data'] = $result;
	echo json_encode($_RESULT);
	
include("../common/dbclose.php");
?>