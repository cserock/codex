<?php
include("common/define.php");
include("common/util.php");
include("common/dbopen.php");
include("common/html_header.php");

	$result_song_info = array();
	$query = 'SELECT * FROM song_info ORDER BY song_number desc;';
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	while($row = $result->fetch_assoc()) {
		array_push($result_song_info, $row);	
	}
	// var_dump($result_song_info);
?>

<style>
    
    table{
	    width: 800px;
	}
    
    
    td {
	    height:20px;
	    border:1px dotted green;
	    text-align:center;
	    font-family: "나눔고딕";
	    font-size: 8pt;
	}
    
	.regist_form_li {
		height:50px;
		border-bottom:1px dotted green;
		padding-top:10px;
		padding-bottom:10px;
	}
</style>

<div>
	<h3>Welcome to CODEX.</h3>
	<li class="regist_form_li">
		<button onclick="goRegistPage();return false;" style="width:300px;height:30px;">Go Regist Page</button>
	</li>
</div>

<div>
	<h3>Song List (<?=count($result_song_info)?>)</h3>
	<table>
	<tr>
		<td style="width:620px;">제목</td>
		<td style="width:60px;">곡번호</td>
		<td style="width:60px;">박자</td>
		<td style="width:60px;">코드</td>
	</tr>
<?php
	for($i=0;$i<count($result_song_info);$i++){
?>
		<tr>
			<td onclick="goInfoPage(<?=$result_song_info[$i]['song_info_id']?>);"><?=$result_song_info[$i]['song_title']?></td>
			<td><?=$result_song_info[$i]['song_number']?></td>
			<td><?=$result_song_info[$i]['beat']?></td>
			<td><?=$result_song_info[$i]['chord']?><?=$result_song_info[$i]['chord_pitch']?><?=$result_song_info[$i]['chord_option']?></td>
			
		</tr>

<?php
	}
?>	
	</table>
</div>

<script type="text/javascript">
	
	function goRegistPage(){
		window.location.replace(SERVER_URL + '/song_info/view_regist_form.php');
	    return false;
	}
	
	function goDetailPage(song_info_id){
		window.location.replace(SERVER_URL + '/song_data/view_regist_form.php?song_info_id=' + song_info_id);
	    return false;
	}
	
	function goInfoPage(song_info_id){
		window.location.replace(SERVER_URL + '/song_info/view_regist_form.php?song_info_id=' + song_info_id);
	    return false;
	}
</script>

<?php
include("common/html_footer.php");
?>