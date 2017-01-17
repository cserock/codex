<?php
    echo "Hello world";

//phpinfo();
exit;

include("common/define.php");
include("common/dbopen.php");

	function insert(){
		global $mysqli;
		$stmt = $mysqli->prepare("INSERT INTO song_info(song_title) VALUES (?)");
		$stmt->bind_param('s', $title);
		$title = "test 1234";
		$stmt->execute();
		printf("%d Row inserted.\n", $stmt->affected_rows);
		$newId = $stmt->insert_id;
		$stmt->close();
	}
	
	function update(){
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE song_info SET song_title=? WHERE song_info_id=?");
		$stmt->bind_param('si', $title, $id);
		$title = "new test 1234";
		$id = 3;
		$stmt->execute();
		printf("%d Row updated.\n", $stmt->affected_rows);
		$stmt->close();
	}
	
	function select(){
		global $mysqli;
		// select
		$query = "SELECT * FROM `song_info`";
		$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
		
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo stripslashes($row['song_title']);	
			}
		}
		else {
			echo 'NO RESULTS';	
		}
	}
	
	function delete(){
		global $mysqli;
		$stmt = $mysqli->prepare("DELETE FROM song_info WHERE song_info_id=?");
		$stmt->bind_param('i', $id);
		$id = 8;
		$stmt->execute();
		printf("%d Row deleted.\n", $stmt->affected_rows);
		$stmt->close();
	}

include("common/dbclose.php");
?>