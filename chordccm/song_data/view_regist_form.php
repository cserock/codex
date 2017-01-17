<?php

include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");
include("../common/html_header.php");
	
	
	if(!isset($_REQUEST['song_info_id'])){
		exitWithError();
	}
	
	$song_info_id = $_REQUEST['song_info_id'];
	
	$result_song_info = array();
	$query = 'SELECT * FROM song_info WHERE song_info_id = '.$song_info_id .';';
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	while($row = $result->fetch_assoc()) {
		array_push($result_song_info, $row);	
	}
	// var_dump($result_song_info);
	
	$result_song_data = array();
	$query = 'SELECT * FROM song_data WHERE song_info_id = '.$song_info_id .' ORDER BY beat_index ;';
	$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
	while($row = $result->fetch_assoc()) {
		array_push($result_song_data, $row);	
	}
	// var_dump($result_song_data);
	$result_song_data_json = json_encode($result_song_data);
	
	include("../common/dbclose.php");
?>

<style>
    
    table{
/*	    width: 800px;*/
	}
    
    
    td {
	    width: 40px;
	    height:20px;
	    border:1px dotted green;
	    text-align:center;
	    font-family: "나눔고딕";
	    font-size: 8pt;
	}
    
	.grid_table {
		width:30px;
		height:20px;
		border:1px dotted green;
	}
	
	.td_bar {
		border-right:2px solid black;
	}
	
	.regist_form_li {
		height:15px;
		border-bottom:1px dotted green;
		padding-top:10px;
		margin-left:10px;
		padding-bottom:10px;
		font-family: "나눔고딕";
	    font-size: 10pt;
	}
</style>
<form id="form_song_data" name="form_song_data" enctype="multipart/form-data" >
<input type="hidden" id="song_info_id" name="song_info_id" value="<?=$result_song_info[0]['song_info_id']?>" />
<div>
	<h3>Regist Song Detail</h3>
	<li class="regist_form_li"><span>제목</span> : <?=$result_song_info[0]['song_title']?></li>
	<li class="regist_form_li"><span>박자</span> : <?=$result_song_info[0]['beat']?></li>
	<li class="regist_form_li"><span>코드</span> : <?=$result_song_info[0]['chord']?><?=$result_song_info[0]['chord_pitch']?><?=$result_song_info[0]['chord_option']?></li>
	<li class="regist_form_li"><span>전체 마디 수</span> : <?=$result_song_info[0]['bar_count']?></li>
	<br />
	<button onclick="regist();return false;" style="width:300px;height:30px;">Save</button>&nbsp;&nbsp;&nbsp;
	<button onclick="goMain();return false;" style="width:80px;height:30px;">Exit</button>
	<br />
	<br />
</div>
<div id="grid"></div>
<button onclick="regist();return false;" style="width:300px;height:30px;">Save</button>&nbsp;&nbsp;&nbsp;
<button onclick="goMain();return false;" style="width:80px;height:30px;">Exit</button>
<div id="form_hidden"></div>
</form>



<div id="popup_form_chord" title="코드 입력">
<form>
<fieldset>
<label for="chord_1">코드 #1</label>
<select name='popup_chord_1' id='popup_chord_1'>
  <option value="C">C</option>
  <option value="CM">CM</option>
  <option value="Cm">Cm</option>
  <option value="D">D</option>
  <option value="DM">DM</option>
  <option value="Dm">Dm</option>
  <option value="E">E</option>
  <option value="EM">EM</option>
  <option value="Em">Em</option>
  <option value="F">F</option>
  <option value="FM">FM</option>
  <option value="Fm">Fm</option>
  <option value="G">G</option>
  <option value="GM">GM</option>
  <option value="Gm">Gm</option>
  <option value="A">A</option>
  <option value="AM">AM</option>
  <option value="Am">Am</option>
  <option value="B">B</option>
  <option value="BM">BM</option>
  <option value="Bm">Bm</option>
</select><br />
<label for="chord_pitch_1">코드 피치 #1</label>
<select name='popup_chord_pitch_1' id='popup_chord_pitch_1'>
  <option value=""></option>
  <option value="+">♯</option>
  <option value="-">♭</option>  
</select><br />
<label for="chord_option_1">코드 옵션 #1</label>
<select name='popup_chord_option_1' id='popup_chord_option_1'>
  <option value=""></option>
  <option value="2">2</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="6sus4">6sus4</option>
  <option value="7">7</option>
  <option value="7-5">7-5</option>
  <option value="7+">7+</option>
  <option value="7(9+)">7(9+)</option>
  <option value="7#">7#</option>
  <option value="7#9">7#9</option>
  <option value="7♭5">7♭5</option>
  <option value="7sus4">7sus4</option>
  <option value="9">9</option>
  <option value="9(11)">9(11)</option>
  <option value="dim">dim</option>  
  <option value="+">+</option>
  <option value="11">11</option>
  <option value="13">13</option>
  <option value="add2">add2</option>
  <option value="add6">add6</option>
  <option value="add9">add9</option>
  <option value="addE">addE</option>
  <option value="addG">addG</option>
  <option value="sus">sus</option>
  <option value="sus2">sus2</option>
  <option value="sus4">sus4</option>
  <option value="sus9">sus9</option>
  <option value="maj">maj</option>
  <option value="maj7">maj7</option>
  <option value="maj7sus">maj7sus</option>
  <option value="maj9">maj9</option>
</select>
<hr></hr>
<label for="chord">코드 #2</label>
<select name='popup_chord_2' id='popup_chord_2'>
  <option value="" selected="true"></option>
  <option value="C">C</option>
  <option value="CM">CM</option>
  <option value="Cm">Cm</option>
  <option value="D">D</option>
  <option value="DM">DM</option>
  <option value="Dm">Dm</option>
  <option value="E">E</option>
  <option value="EM">EM</option>
  <option value="Em">Em</option>
  <option value="F">F</option>
  <option value="FM">FM</option>
  <option value="Fm">Fm</option>
  <option value="G">G</option>
  <option value="GM">GM</option>
  <option value="Gm">Gm</option>
  <option value="A">A</option>
  <option value="AM">AM</option>
  <option value="Am">Am</option>
  <option value="B">B</option>
  <option value="BM">BM</option>
  <option value="Bm">Bm</option>
</select><br />
<label for="chord_pitch_2">코드 피치 #2</label>
<select name='popup_chord_pitch_2' id='popup_chord_pitch_2'>
  <option value=""></option>
  <option value="+">♯</option>
  <option value="-">♭</option>  
</select><br />
<label for="chord_option_2">코드 옵션 #2</label>
<select name='popup_chord_option_2' id='popup_chord_option_2'>
  <option value=""></option>
  <option value="2">2</option>
  <option value="4">4</option>
  <option value="5">5</option>
  <option value="6">6</option>
  <option value="6sus4">6sus4</option>
  <option value="7">7</option>
  <option value="7-5">7-5</option>
  <option value="7+">7+</option>
  <option value="7(9+)">7(9+)</option>
  <option value="7#">7#</option>
  <option value="7#9">7#9</option>
  <option value="7♭5">7♭5</option>
  <option value="7sus4">7sus4</option>
  <option value="9">9</option>
  <option value="9(11)">9(11)</option>
  <option value="dim">dim</option>  
  <option value="+">+</option>
  <option value="11">11</option>
  <option value="13">13</option>
  <option value="add2">add2</option>
  <option value="add6">add6</option>
  <option value="add9">add9</option>
  <option value="addE">addE</option>
  <option value="addG">addG</option>
  <option value="sus">sus</option>
  <option value="sus2">sus2</option>
  <option value="sus4">sus4</option>
  <option value="sus9">sus9</option>
  <option value="maj">maj</option>
  <option value="maj7">maj7</option>
  <option value="maj7sus">maj7sus</option>
  <option value="maj9">maj9</option>
</select>
</fieldset>
</form>
</div>

<div id="popup_form_rest_type" title="쉼표 입력">
<form>
<fieldset>
<label for="rest_type">쉼표 입력</label>
<select name='popup_rest_type' id='popup_rest_type'>
  <option value="1">온쉼표</option>
  <option value="2">점2분쉼표</option>
  <option value="3">2분쉼표</option>
  <option value="4">점4분쉼표</option>
  <option value="5">4분쉼표</option>
  <option value="6">점8분쉼표</option>
  <option value="7">8분쉼표</option>
  <option value="8">16분쉼표</option>
</select>
</fieldset>
</form>
</div>

<div id="popup_form_bar_type" title="마디 타입 입력">
<form>
<fieldset>
<label for="bar_type">마디 타입 입력</label>
<select name='popup_bar_type' id='popup_bar_type'>
<!--   <option value="0">스탠다드</option> -->
  <option value="1">더블</option>
  <option value="2">종료</option>
  <option value="3">시작 도돌이</option>
  <option value="4">끝 도돌이</option>
</select>
</fieldset>
</form>
</div>

<div id="popup_form_play_type" title="연주 순서 입력">
<form>
<fieldset>
<label for="play_type">연주 순서 입력</label>
<select name='popup_play_type' id='popup_play_type'>
  <option value="D.C">D.C</option>
  <option value="Fine">Fine</option>
  <option value="D.S">D.S</option>
  <option value="segno">segno</option>
  <option value="coda">coda</option>
  <option value="1.">1.</option>
  <option value="2.">2.</option>
  <option value="3.">3.</option>
  <option value="4.">4.</option>
</select>
</fieldset>
</form>
</div>

<div id="popup_form_go_main" title="나가기">
<form>
<fieldset>
<label for="play_type">메인으로 이동하시겠습니까?<br />저장 후 이동하세요.</label>
</fieldset>
</form>
</div>

<script type="text/javascript">

	var _SONG_DATA = <?=$result_song_data_json?>;
	var _SONG_BEAT = '<?=$result_song_info[0]['beat']?>';
	var _SONG_BAR_COUNT = <?=$result_song_info[0]['bar_count']?>;
	
	var _TABLE_COUNT = 0;
	var _BEAT_COUNT_IN_BAR = 0; 
	var _BEAT_MAX_COUNT = 0;
	var _SELECTED_BEAT_INDEX = 0;
	
	
	
	function init(){
		
		// set table count
		_TABLE_COUNT = Math.ceil(_SONG_BAR_COUNT / 4);
		
		// set beat count in bar
		var tmpArray = _SONG_BEAT.split('/');
		var beat_first = parseInt(tmpArray[0]);
		if((beat_first%3) == 0){
			_BEAT_COUNT_IN_BAR = 6;
		} else {
			_BEAT_COUNT_IN_BAR = 8;
		}
		
		// set beat max count
		_BEAT_MAX_COUNT = _SONG_BAR_COUNT * _BEAT_COUNT_IN_BAR;
		// alert(_TABLE_COUNT + "___" + _BEAT_COUNT_IN_BAR + "___" + _BEAT_MAX_COUNT);
		
		// make form
		makeForm();
		
		// make table
		for(var i=0; i<_TABLE_COUNT;i++){
			makeTable(i);	
		}
	}
	
	function makeTable(nowTable) {
		
	   var tablecontents = "";
	   tablecontents = "<table cellpadding=0 cellspacing=0>";
	   for (var i = 0; i < 10; i ++)
	   {
	   		tablecontents += "<tr>";
	   		
	   		// set column name
	   		var col_name = "";
	   		
	   		switch(i){
	   			case 0:
	   				col_name = "마디";
	   				break;
				case 1:
	   				col_name = "비트";
	   				break;
	   			case 2:
	   				col_name = "코드";
	   				break;
	   			case 3:
	   				col_name = "가사 1절";
	   				break;
	   			case 4:
	   				col_name = "가사 2절";
	   				break;
	   			case 5:
	   				col_name = "가사 3절";
	   				break;
	   			case 6:
	   				col_name = "가사 4절";
	   				break;
	   			case 7:
	   				col_name = "쉼표";
	   				break;	
	   			case 8:
	   				col_name = "마디 타입";
	   				break;	
	   			case 9:
	   				col_name = "연주 순서";
	   				break;
	   			default:
	   				col_name = "";
	   				break;
	   		}
	   		
	   		tablecontents += "<td style='width:100px;'>"+ col_name +"</td>";
	   	
	   		if(i == 0){
	   			for (var k = 0; k < 4; k ++){
	   				var bar_index = ((nowTable*4) + k + 1);
	   				tablecontents += "<td class='td_bar' colspan='"+ _BEAT_COUNT_IN_BAR + "'>" + bar_index + "</td>";
	   			}
	   		} else {
	   			for (var j = 0; j < _BEAT_COUNT_IN_BAR * 4; j ++){
	   				
	   				var beat_index = ((nowTable*_BEAT_COUNT_IN_BAR * 4) + j + 1);
	   				
	   				// set song_data
	   				var song_data = "";
	   				
	   				for(var k=0;k<_SONG_DATA.length;k++){
	   					if(_SONG_DATA[k].beat_index == beat_index){
	   						song_data = _SONG_DATA[k];
	   						break;
	   					}
	   				}
	   				
					var td_class = "";
					if(((j+1)%_BEAT_COUNT_IN_BAR) == 0){
						td_class = "td_bar";
					}
					
					// 비트
					if(i == 1){
						var display_beat_index = beat_index;
						tablecontents += "<td class='" + td_class + "' " + onclick_function + " >" + display_beat_index + "</td>";
					
					// 코드
					} else if(i == 2){
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.chord_1;
							shown_data += song_data.chord_1_pitch;
							shown_data += song_data.chord_1_option;
							
							// set input
							$( "#chord_1_"+beat_index).val(song_data.chord_1);
							$( "#chord_1_pitch_"+beat_index).val(song_data.chord_1_pitch);
							$( "#chord_1_option_"+beat_index).val(song_data.chord_1_option);
							
							if(song_data.chord_2 != ""){
								shown_data += "/";
								shown_data += song_data.chord_2;
								shown_data += song_data.chord_2_pitch;
								shown_data += song_data.chord_2_option;
								
								// set input
								$( "#chord_2_"+beat_index).val(song_data.chord_2);
								$( "#chord_2_pitch_"+beat_index).val(song_data.chord_2_pitch);
								$( "#chord_2_option_"+beat_index).val(song_data.chord_2_option);
							}
						}
						var onclick_function = "onclick='showPopupChord("+ beat_index +");return false;'";
						tablecontents += "<td class='" + td_class + "' " + onclick_function + " ><span id='span_chord_info_" +beat_index+ "'>" + shown_data + "</span></td>";
					
					// 가사 #1
					} else if(i == 3){
						
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.lyric_1;
						}
						
						var formcontents = "<input type='text' id='lyric_1_" +beat_index+ "' name='lyric_1_" +beat_index+ "' style='width:25px;height:10px;' value='"+shown_data+"' />";
						tablecontents += "<td class='" + td_class + "' >"+formcontents+"</td>";
					
					// 가사 #2
					} else if(i == 4){
						
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.lyric_2;
						}
						
						var formcontents = "<input type='text' id='lyric_2_" +beat_index+ "' name='lyric_2_" +beat_index+ "' style='width:25px;height:10px;' value='"+shown_data+"'/>";
						tablecontents += "<td class='" + td_class + "' >"+formcontents+"</td>";
					
					// 가사 #3
					} else if(i == 5){
						
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.lyric_3;
						}
						
						var formcontents = "<input type='text' id='lyric_3_" +beat_index+ "' name='lyric_3_" +beat_index+ "' style='width:25px;height:10px;' value='"+shown_data+"'/>";
						tablecontents += "<td class='" + td_class + "' >"+formcontents+"</td>";
					
					// 가사 #4
					} else if(i == 6){
						
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.lyric_4;
						}
						
						var formcontents = "<input type='text' id='lyric_4_" +beat_index+ "' name='lyric_4_" +beat_index+ "' style='width:25px;height:10px;' value='"+shown_data+"'/>";
						tablecontents += "<td class='" + td_class + "' >"+formcontents+"</td>";
					
					// 쉼포
					} else if(i == 7){
						
						var shown_data = "";
						if(song_data != ""){
							shown_data = song_data.rest_type;
							$( "#rest_type_"+beat_index).val(song_data.rest_type);
						}
						
						if(shown_data == "0"){
							shown_data = "";
							$( "#rest_type_"+beat_index).val("");
						}
						
						var onclick_function = "onclick='showPopupRestType("+ beat_index +");return false;'";
						tablecontents += "<td class='" + td_class + "' " + onclick_function + " ><span id='span_rest_type_" +beat_index+ "'>" + shown_data + "</span></td>";
					
					// 마디 표현
					} else if(i == 8){
						if((((j+1)%_BEAT_COUNT_IN_BAR) == 0) || (((j+1)%_BEAT_COUNT_IN_BAR) == 1)){
							
							var shown_data = "";
							if(song_data != ""){
								shown_data = song_data.bar_type;
								$( "#bar_type_"+beat_index).val(song_data.bar_type);
							}
							
							if(shown_data == "0"){
								shown_data = "";
								$( "#bar_type_"+beat_index).val("");
							}
							
							var onclick_function = "onclick='showPopupBarType("+ beat_index +");return false;'";
							tablecontents += "<td class='" + td_class + "' " + onclick_function + " ><span id='span_bar_type_" +beat_index+ "'>" + shown_data + "</span></td>";
						} else {
							tablecontents += "<td class='" + td_class + "' ></td>";
						}
						
					// 연주순서
					} else if(i == 9){
						if((((j+1)%_BEAT_COUNT_IN_BAR) == 0) || (((j+1)%_BEAT_COUNT_IN_BAR) == 1)){
							
							var shown_data = "";
							if(song_data != ""){
								shown_data = song_data.play_type;
								$( "#play_type_"+beat_index).val(song_data.play_type);
							}
							
							var onclick_function = "onclick='showPopupPlayType("+ beat_index +");return false;'";
							tablecontents += "<td class='" + td_class + "' " + onclick_function + " ><span id='span_play_type_" +beat_index+ "'>" + shown_data + "</span></td>";
						} else {
							tablecontents += "<td class='" + td_class + "' ></td>";
						}
					// 그외
					} else {
						tablecontents += "<td class='" + td_class + "' ></td>";
					}
					
				}	
	   		}
			tablecontents += "</tr>";
	   }
	   tablecontents += "</table>";
	   tablecontents += "<br />";
	   // alert(tablecontents);
	   $('#grid').append(tablecontents);
	}
	
	function makeForm() {
		
	   var formcontents = "";
	   for (var i = 1; i < _BEAT_MAX_COUNT+1; i++)
	   {
	   		formcontents += "<input type='hidden' id='chord_1_" +i+ "' name='chord_1_" +i+ "' />";
	   		formcontents += "<input type='hidden' id='chord_1_pitch_"+i+"' name='chord_1_pitch_"+i+"' />";
	   		formcontents += "<input type='hidden' id='chord_1_option_"+i+"' name='chord_1_option_"+i+"' />";
	   		formcontents += "<input type='hidden' id='chord_2_" +i+ "' name='chord_2_" +i+ "' />";
	   		formcontents += "<input type='hidden' id='chord_2_pitch_"+i+"' name='chord_2_pitch_"+i+"' />";
	   		formcontents += "<input type='hidden' id='chord_2_option_"+i+"' name='chord_2_option_"+i+"' />";
	   		formcontents += "<input type='hidden' id='rest_type_" +i+ "' name='rest_type_" +i+ "' />";
	   		formcontents += "<input type='hidden' id='bar_type_" +i+ "' name='bar_type_" +i+ "' />";
	   		formcontents += "<input type='hidden' id='play_type_" +i+ "' name='play_type_" +i+ "' />";
	   }
	   // alert(formcontents);
	   $('#form_hidden').html(formcontents);
	}
	
	
	function showPopupChord(beat_index){
		_SELECTED_BEAT_INDEX = beat_index;
		$( "#popup_form_chord" ).dialog( "open" );
		return false;
	}
	
	function showPopupRestType(beat_index){
		_SELECTED_BEAT_INDEX = beat_index;
		$( "#popup_form_rest_type" ).dialog( "open" );
		return false;
	}
	
	function showPopupPlayType(beat_index){
		_SELECTED_BEAT_INDEX = beat_index;
		$( "#popup_form_play_type" ).dialog( "open" );
		return false;
	}
	
	function showPopupBarType(beat_index){
		_SELECTED_BEAT_INDEX = beat_index;
		$( "#popup_form_bar_type" ).dialog( "open" );
		return false;
	}
	
	function regist(){
		
		var params = $("form[name=form_song_data]").serialize();

		// $('#form_hidden').html(params);
		// return false;
 		$.ajax({      
	        type:"POST",
	        dataType: "json",
	        url:SERVER_URL + '/song_data/regist.php',
	        data: params,
	        success:function(response, status, request){ 
	        	hideLoading();
	        	
	        	if(!response.error){
	        		alert('저장 완료');
	        		// window.location.replace(SERVER_URL + '/song_data/view_regist_form.php?song_info_id='+response.data.insert_id);
	        	} else {
	        		alert('에러 발생');	
	        	}
	        	
	        	
	        },   
	        beforeSend:showLoading,  
	        error:function(e){
	        	hideLoading();  
	            // alert(e.responseText);  
	        }  
	    });  
	    return false;
	}
	
	function goMain(){
		$( "#popup_form_go_main" ).dialog( "open" );
		return false;
	}
	
	init();
	
	
	
	$( "#popup_form_chord" ).dialog({
		autoOpen: false,
		height: 360,
		width: 350,
		modal: true,
		buttons: {
			"입력": function() {
				// alert(_SELECTED_BEAT_INDEX);
				var chord_1 = $('#popup_chord_1').val();
				var chord_pitch_1 = $('#popup_chord_pitch_1').val();
				var chord_option_1 = $('#popup_chord_option_1').val();
				
				var chord_2 = $('#popup_chord_2').val();
				var chord_pitch_2 = $('#popup_chord_pitch_2').val();
				var chord_option_2 = $('#popup_chord_option_2').val();
				
				// set input
				$('#chord_1_'+_SELECTED_BEAT_INDEX).val(chord_1);
				$('#chord_1_pitch_'+_SELECTED_BEAT_INDEX).val(chord_pitch_1);
				$('#chord_1_option_'+_SELECTED_BEAT_INDEX).val(chord_option_1);
				
				// show chord info
				$('#span_chord_info_'+_SELECTED_BEAT_INDEX).html(chord_1 + chord_pitch_1 + chord_option_1);
				
				if(chord_2){
					// set input
					$('#chord_2_'+_SELECTED_BEAT_INDEX).val(chord_2);
					$('#chord_2_pitch_'+_SELECTED_BEAT_INDEX).val(chord_pitch_2);
					$('#chord_2_option_'+_SELECTED_BEAT_INDEX).val(chord_option_2);
					
					// show chord info
					$('#span_chord_info_'+_SELECTED_BEAT_INDEX).append(' / ' + chord_2 + chord_pitch_2 + chord_option_2);
				}
				
				$( this ).dialog( "close" );
			},
			"삭제": function() {
				
				// reset input
				$('#chord_1_'+_SELECTED_BEAT_INDEX).val('');
				$('#chord_1_pitch_'+_SELECTED_BEAT_INDEX).val('');
				$('#chord_1_option_'+_SELECTED_BEAT_INDEX).val('');
				
				$('#chord_2_'+_SELECTED_BEAT_INDEX).val('');
				$('#chord_2_pitch_'+_SELECTED_BEAT_INDEX).val('');
				$('#chord_2_option_'+_SELECTED_BEAT_INDEX).val('');

				// show chord info 
				$('#span_chord_info_'+_SELECTED_BEAT_INDEX).html('');
				
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			},
			"닫기": function() {
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			_SELECTED_BEAT_INDEX = 0;
		}
	});
	
	$( "#popup_form_rest_type" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		buttons: {
			"입력": function() {
				// alert(_SELECTED_BEAT_INDEX);
				var rest_type = $('#popup_rest_type').val();
				
				// set input
				$('#rest_type_'+_SELECTED_BEAT_INDEX).val(rest_type);
				
				// show chord info
				$('#span_rest_type_'+_SELECTED_BEAT_INDEX).html(rest_type);
				
				$( this ).dialog( "close" );
			},
			"삭제": function() {
				
				// reset input
				$('#rest_type_'+_SELECTED_BEAT_INDEX).val('');
			
				// show play type
				$('#span_rest_type_'+_SELECTED_BEAT_INDEX).html('');
				
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			},
			"닫기": function() {
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			_SELECTED_BEAT_INDEX = 0;
		}
	});
	
	
	$( "#popup_form_play_type" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		buttons: {
			"입력": function() {
				// alert(_SELECTED_BEAT_INDEX);
				var play_type = $('#popup_play_type').val();
				
				// set input
				$('#play_type_'+_SELECTED_BEAT_INDEX).val(play_type);
				
				// show chord info
				$('#span_play_type_'+_SELECTED_BEAT_INDEX).html(play_type);
				
				$( this ).dialog( "close" );
			},
			"삭제": function() {
				
				// reset input
				$('#play_type_'+_SELECTED_BEAT_INDEX).val('');
			
				// show play type
				$('#span_play_type_'+_SELECTED_BEAT_INDEX).html('');
				
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			},
			"닫기": function() {
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			_SELECTED_BEAT_INDEX = 0;
		}
	});
	
	$( "#popup_form_bar_type" ).dialog({
		autoOpen: false,
		height: 200,
		width: 350,
		modal: true,
		buttons: {
			"입력": function() {
				// alert(_SELECTED_BEAT_INDEX);
				var bar_type = $('#popup_bar_type').val();
				
				// set input
				$('#bar_type_'+_SELECTED_BEAT_INDEX).val(bar_type);
				
				// show chord info
				$('#span_bar_type_'+_SELECTED_BEAT_INDEX).html(bar_type);
				
				$( this ).dialog( "close" );
			},
			"삭제": function() {
				
				// reset input
				$('#bar_type_'+_SELECTED_BEAT_INDEX).val('');
			
				// show play type
				$('#span_bar_type_'+_SELECTED_BEAT_INDEX).html('');
				
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			},
			"닫기": function() {
				_SELECTED_BEAT_INDEX = 0;
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			_SELECTED_BEAT_INDEX = 0;
		}
	});
	
	$( "#popup_form_go_main" ).dialog({
		autoOpen: false,
		height: 220,
		width: 350,
		modal: true,
		buttons: {
			"메인으로": function() {
				window.location.replace(SERVER_URL);
			},
			"취소": function() {
				$( this ).dialog( "close" );
			}
		},
		close: function() {
			_SELECTED_BEAT_INDEX = 0;
		}
	});
	
</script>

<?php
include("../common/html_footer.php");
?>