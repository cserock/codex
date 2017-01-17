<?php
include("../common/define.php");
include("../common/util.php");
include("../common/dbopen.php");
include("../common/html_header.php");

	$result_song_info = array();
	$beat_up = "";
	$beat_down = "";
	$song_info_id = "";

	if(isset($_REQUEST['song_info_id'])){
		
		$song_info_id = $_REQUEST['song_info_id'];
		$query = 'SELECT * FROM song_info WHERE song_info_id = '.$song_info_id .';';
		$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
		while($row = $result->fetch_assoc()) {
			array_push($result_song_info, $row);	
		}
	
		$arr_tmp_beat = explode('/', $result_song_info[0]['beat']);
		$beat_up = $arr_tmp_beat[0];
		$beat_down = $arr_tmp_beat[1];
	}
	
include("../common/dbclose.php");
?>

<style>
    
	.regist_form_li {
		height:50px;
		border-bottom:1px dotted green;
		padding-top:10px;
		margin-left:10px;
		padding-bottom:10px;
		font-family: "나눔고딕";
	    font-size: 10pt;
	}
</style>


<div>
	<h3>Regist Song</h3>
	<input type='hidden' name='song_info_id' id='song_info_id' value="<?=$song_info_id?>" />
	<li class="regist_form_li"><span>곡 제목</span><br /><input type='text' name='song_title' id='song_title' style="width:400px;" value="<?=$result_song_info[0]['song_title']?>" /></li>
	<li class="regist_form_li"><span>곡 번호</span><br /><input type='text' name='song_number' id='song_number' style="width:50px;" value="<?=$result_song_info[0]['song_number']?>" /></li>
	<li class="regist_form_li"><span>처음 시작하는 가사</span><br /> <input type='text' name='song_lyric_start' id='song_lyric_start' style="width:400px;" value="<?=$result_song_info[0]['song_lyric_start']?>" /></li>
	<li class="regist_form_li"><span>후렴 시작하는 가사</span><br /> <input type='text' name='song_lyric_refrain' id='song_lyric_refrain' style="width:400px;" value="<?=$result_song_info[0]['song_lyric_refrain']?>" /></li>
	<li class="regist_form_li"><span>검색 키워드</span><br /> <input type='text' name='song_lyric_keyword' id='song_lyric_keyword' style="width:400px;" value="<?=$result_song_info[0]['song_lyric_keyword']?>" /></li>
	<li class="regist_form_li"><span>박자</span><br /> <input type='text' name='beat_up' id='beat_up' style="width:20px;" value="<?=$beat_up?>" /> / <input type='text' name='beat_down' id='beat_down' style="width:20px;" value="<?=$beat_down?>" /></li>
	<li class="regist_form_li"><span>코드 / 피치</span><br /> 
		<select name='chord_1' id='chord'>
		  <option value="C" <? if($result_song_info[0]['chord'] == "C"){ ?>selected="true"<? } ?> >C</option>
		  <option value="CM" <? if($result_song_info[0]['chord'] == "CM"){ ?>selected="true"<? } ?> >CM</option>
		  <option value="Cm" <? if($result_song_info[0]['chord'] == "Cm"){ ?>selected="true"<? } ?> >Cm</option>
		  <option value="D" <? if($result_song_info[0]['chord'] == "D"){ ?>selected="true"<? } ?> >D</option>
		  <option value="DM" <? if($result_song_info[0]['chord'] == "DM"){ ?>selected="true"<? } ?> >DM</option>
		  <option value="Dm" <? if($result_song_info[0]['chord'] == "Dm"){ ?>selected="true"<? } ?> >Dm</option>
		  <option value="E" <? if($result_song_info[0]['chord'] == "E"){ ?>selected="true"<? } ?> >E</option>
		  <option value="EM" <? if($result_song_info[0]['chord'] == "EM"){ ?>selected="true"<? } ?> >EM</option>
		  <option value="Em" <? if($result_song_info[0]['chord'] == "Em"){ ?>selected="true"<? } ?> >Em</option>
		  <option value="F" <? if($result_song_info[0]['chord'] == "F"){ ?>selected="true"<? } ?> >F</option>
		  <option value="FM" <? if($result_song_info[0]['chord'] == "FM"){ ?>selected="true"<? } ?> >FM</option>
		  <option value="Fm" <? if($result_song_info[0]['chord'] == "Fm"){ ?>selected="true"<? } ?> >Fm</option>
		  <option value="G" <? if($result_song_info[0]['chord'] == "G"){ ?>selected="true"<? } ?> >G</option>
		  <option value="GM" <? if($result_song_info[0]['chord'] == "GM"){ ?>selected="true"<? } ?> >GM</option>
		  <option value="Gm" <? if($result_song_info[0]['chord'] == "Gm"){ ?>selected="true"<? } ?> >Gm</option>
		  <option value="A" <? if($result_song_info[0]['chord'] == "A"){ ?>selected="true"<? } ?> >A</option>
		  <option value="AM" <? if($result_song_info[0]['chord'] == "AM"){ ?>selected="true"<? } ?> >AM</option>
		  <option value="Am" <? if($result_song_info[0]['chord'] == "Am"){ ?>selected="true"<? } ?> >Am</option>
		  <option value="B" <? if($result_song_info[0]['chord'] == "B"){ ?>selected="true"<? } ?> >B</option>
		  <option value="BM" <? if($result_song_info[0]['chord'] == "BM"){ ?>selected="true"<? } ?> >BM</option>
		  <option value="Bm" <? if($result_song_info[0]['chord'] == "Bm"){ ?>selected="true"<? } ?> >Bm</option>
		</select> /
		<select name='chord_pitch' id='chord_pitch'>
		  <option value=""></option>
		  <option value="+" <? if($result_song_info[0]['chord_pitch'] == "+"){ ?>selected="true"<? } ?> >♯</option>
		  <option value="-" <? if($result_song_info[0]['chord_pitch'] == "-"){ ?>selected="true"<? } ?> >♭</option>
		</select>
	</li>
	<li class="regist_form_li"><span>코드 옵션</span><br /> 
		<select name='chord_option' id='chord_option'>
		  <option value=""></option>
		  <option value="2" <? if($result_song_info[0]['chord_option'] == "2"){ ?>selected="true"<? } ?> >2</option>
		  <option value="4" <? if($result_song_info[0]['chord_option'] == "4"){ ?>selected="true"<? } ?> >4</option>
		  <option value="5" <? if($result_song_info[0]['chord_option'] == "5"){ ?>selected="true"<? } ?> >5</option>
		  <option value="6" <? if($result_song_info[0]['chord_option'] == "6"){ ?>selected="true"<? } ?> >6</option>
		  <option value="6sus4" <? if($result_song_info[0]['chord_option'] == "6sus4"){ ?>selected="true"<? } ?> >6sus4</option>
		  <option value="7" <? if($result_song_info[0]['chord_option'] == "7"){ ?>selected="true"<? } ?> >7</option>
		  <option value="7-5" <? if($result_song_info[0]['chord_option'] == "7-5"){ ?>selected="true"<? } ?> >7-5</option>
		  <option value="7+" <? if($result_song_info[0]['chord_option'] == "7+"){ ?>selected="true"<? } ?> >7+</option>
		  <option value="7(9+)" <? if($result_song_info[0]['chord_option'] == "7(9+)"){ ?>selected="true"<? } ?> >7(9+)</option>
		  <option value="7#" <? if($result_song_info[0]['chord_option'] == "7#"){ ?>selected="true"<? } ?> >7#</option>
		  <option value="7#9" <? if($result_song_info[0]['chord_option'] == "7#9"){ ?>selected="true"<? } ?> >7#9</option>
		  <option value="7♭5" <? if($result_song_info[0]['chord_option'] == "7♭5"){ ?>selected="true"<? } ?> >7♭5</option>
		  <option value="7sus4" <? if($result_song_info[0]['chord_option'] == "7sus4"){ ?>selected="true"<? } ?> >7sus4</option>
		  <option value="9" <? if($result_song_info[0]['chord_option'] == "9"){ ?>selected="true"<? } ?> >9</option>
		  <option value="9(11)" <? if($result_song_info[0]['chord_option'] == "9(11)"){ ?>selected="true"<? } ?> >9(11)</option>
		  <option value="dim" <? if($result_song_info[0]['chord_option'] == "dim"){ ?>selected="true"<? } ?> >dim</option>  
		  <option value="+" <? if($result_song_info[0]['chord_option'] == "+"){ ?>selected="true"<? } ?> >+</option>
		  <option value="11" <? if($result_song_info[0]['chord_option'] == "11"){ ?>selected="true"<? } ?> >11</option>
		  <option value="13" <? if($result_song_info[0]['chord_option'] == "13"){ ?>selected="true"<? } ?> >13</option>
		  <option value="add2" <? if($result_song_info[0]['chord_option'] == "add2"){ ?>selected="true"<? } ?> >add2</option>
		  <option value="add6" <? if($result_song_info[0]['chord_option'] == "add6"){ ?>selected="true"<? } ?> >add6</option>
		  <option value="add9" <? if($result_song_info[0]['chord_option'] == "add9"){ ?>selected="true"<? } ?> >add9</option>
		  <option value="addE" <? if($result_song_info[0]['chord_option'] == "addE"){ ?>selected="true"<? } ?> >addE</option>
		  <option value="addG" <? if($result_song_info[0]['chord_option'] == "addG"){ ?>selected="true"<? } ?> >addG</option>
		  <option value="sus" <? if($result_song_info[0]['chord_option'] == "sus"){ ?>selected="true"<? } ?> >sus</option>
		  <option value="sus2" <? if($result_song_info[0]['chord_option'] == "sus2"){ ?>selected="true"<? } ?> >sus2</option>
		  <option value="sus4" <? if($result_song_info[0]['chord_option'] == "sus4"){ ?>selected="true"<? } ?> >sus4</option>
		  <option value="sus9" <? if($result_song_info[0]['chord_option'] == "sus9"){ ?>selected="true"<? } ?> >sus9</option>
		  <option value="maj" <? if($result_song_info[0]['chord_option'] == "maj"){ ?>selected="true"<? } ?> >maj</option>
		  <option value="maj7" <? if($result_song_info[0]['chord_option'] == "maj7"){ ?>selected="true"<? } ?> >maj7</option>
		  <option value="maj7sus" <? if($result_song_info[0]['chord_option'] == "maj7sus"){ ?>selected="true"<? } ?> >maj7sus</option>
		  <option value="maj9" <? if($result_song_info[0]['chord_option'] == "maj9"){ ?>selected="true"<? } ?> >maj9</option>
		</select>
	</li>
	<li class="regist_form_li"><span>전체 마디 수</span><br /> <input type='text' name='bar_count' id='bar_count' style="width:50px;" value="<?=$result_song_info[0]['bar_count']?>" /></li>
	<li class="regist_form_li"><span>전체 가사 절 수</span><br /> <input type='text' name='lyric_count' id='lyric_count' style="width:50px;" value="<?=$result_song_info[0]['lyric_count']?>" /></li>
	<br />
	<? if($song_info_id == ""){ ?>
		<button onclick="regist();return false;" style="width:300px;height:30px;">다음 단계</button>
	<? } else { ?>
		<button onclick="regist();return false;" style="width:300px;height:30px;">업데이트</button>&nbsp;&nbsp;&nbsp;
		<button onclick="goDetailPage(<?=$song_info_id?>);return false;" style="width:80px;height:30px;">세부 정보</button>
	<? } ?>
</div>

<script type="text/javascript">
	
	function regist(){
		
		var song_info_id = $.trim($('#song_info_id').val());
		var song_title = $.trim($('#song_title').val());
		var song_number = $.trim($('#song_number').val());
		var song_lyric_start = $.trim($('#song_lyric_start').val());
		var song_lyric_refrain = $.trim($('#song_lyric_refrain').val());
		var song_lyric_keyword = $.trim($('#song_lyric_keyword').val());
		var beat = $.trim($('#beat_up').val()) + "/" + $.trim($('#beat_down').val());
		var chord = $.trim($('#chord').val());
		var chord_pitch = $.trim($('#chord_pitch').val());
		var chord_option = $.trim($('#chord_option').val());
		var bar_count = $.trim($('#bar_count').val());
		var lyric_count = $.trim($('#lyric_count').val());
		
		if(!song_title){
			alert('곡 제목을 입력하세요.');
			return false;
		}
		
		/*
		if(!song_number){
			alert('곡 번호를 입력하세요.');
			return false;
		}
		*/
		
		if(beat == '/'){
			alert('박자를 입력하세요.');
			return false;
		}
		
		if(!chord){
			alert('코드를 입력하세요.');
			return false;
		}
		
		if(!bar_count){
			alert('전체 마디 수를 입력하세요.');
			return false;
		}
		
		if(!lyric_count){
			alert('가사 절 수를 입력하세요.');
			return false;
		}
		
		var params = {
				song_info_id:song_info_id,
				song_title:song_title,
				song_number:song_number,
				song_lyric_start:song_lyric_start,
				song_lyric_refrain:song_lyric_refrain,
				song_lyric_keyword:song_lyric_keyword,
				beat:beat,
				chord:chord,
				chord_pitch:chord_pitch,
				chord_option:chord_option,
				bar_count:bar_count,
				lyric_count:lyric_count
			};
 		
 		$.ajax({      
	        type:"POST",
	        dataType: "json",
	        url:SERVER_URL + '/song_info/regist.php',      
	        data:params,      
	        success:function(response, status, request){ 
	        	hideLoading();
	        	
	        	if(!response.error){
	        		// alert(response.data.insert_id);
	        		window.location.replace(SERVER_URL + '/song_data/view_regist_form.php?song_info_id='+response.data.insert_id);
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
	
	function goDetailPage(song_info_id){
		window.location.replace(SERVER_URL + '/song_data/view_regist_form.php?song_info_id=' + song_info_id);
	    return false;
	}
</script>

<?php
include("../common/html_footer.php");
?>