<?php
/**
 * Quran display logic: sura/verse loading, lazy-load chunks, AJAX handlers, reciter URLs.
 */

if ( ! defined( 'QTM_VERSES_CHUNK_SIZE' ) ) {
	define( 'QTM_VERSES_CHUNK_SIZE', 20 );
}

/** Base URL for reciter MP3s (folder name differs per reciter). */
function qtm_get_recitator_base_url() {
		$opt = get_option( 'quran_recitator' );
		$base = 'https://quran.s3.fr-par.scw.cloud/verset/';
		if ( $opt === 'Maher_al_me-aqly' ) return $base . 'Maheralmeaqly';
		if ( $opt === 'ElGhamidi' ) return $base . 'ElGhamidi';
		if ( $opt === 'Soudais' ) return $base . 'Soudais';
		if ( $opt === 'Al-Hussary' ) return $base . 'Al-Hussary';
		if ( $opt === 'Basfar' ) return $base . 'Basfar';
		if ( $opt === 'Alafasy' ) return $base . 'Alafasy';
		if ( $opt === 'Al-Ajmy' ) return $base . 'Al-Ajmy';
		return $base . 'Soudais';
	}

	/** Output HTML for a range of verses (used by initial render and AJAX load more). */
	function qtm_render_verses_chunk( $sura, $lang, $from_aya, $to_aya ) {
		global $quranFile, $transFile;
		$sura = max( 1, min( 114, (int) $sura ) );
		$from_aya = max( 1, (int) $from_aya );
		$to_aya = max( $from_aya, (int) $to_aya );
		initSuraData();
		$total_ayas = (int) getSuraData( $sura, 'ayas' );
		if ( $total_ayas < 1 ) return;
		$to_aya = min( $to_aya, $total_ayas );
		$quran_base_path = plugin_dir_path( __FILE__ ) . 'quran/';
		$quranFile = $quran_base_path . 'arabe.txt';
		$transFile = $lang ? $quran_base_path . $lang . '.txt' : $quran_base_path . get_option( 'quran_languages' ) . '.txt';
		$suraText = getSuraContents( $sura, $quranFile );
		$transText = getSuraContents( $sura, $transFile );
		if ( empty( $suraText ) || count( $suraText ) < $to_aya ) return;
		$cheikh = qtm_get_recitator_base_url();
		$show_bismillah = false;
		for ( $ayaNum2 = $from_aya; $ayaNum2 <= $to_aya; $ayaNum2++ ) {
			$aya = $suraText[ $ayaNum2 - 1 ];
			$trans = isset( $transText[ $ayaNum2 - 1 ] ) ? $transText[ $ayaNum2 - 1 ] : '';
			if ( ! $show_bismillah && $ayaNum2 === 1 && $sura !== 1 && $sura !== 9 ) {
				$aya = preg_replace( '/^(([^ ]+ ){4})/u', '', $aya );
			}
			$aya = preg_replace( '/ ([ۖ-۩])/u', '<span class="sign">&nbsp;$1</span>', $aya );
			$badge = "<a class='sm2_link' href='" . esc_url( $cheikh . '/' . $sura . '/' . $ayaNum2 . '.mp3' ) . "' title='Écouter le verset'><span class='quranbadge quranbadge-info' id='kv" . $ayaNum2 . "'><span class='kb-verse-play' aria-hidden='true'><svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='currentColor'><path d='M8 5v14l11-7z'/></svg></span> " . $ayaNum2 . "</span></a>";
			echo "<div class='aya vaya" . $ayaNum2 . "' data-aya='" . $ayaNum2 . "'>";
			echo "<div class='quran reset_quran verset" . $ayaNum2 . "'>" . $badge . " " . $aya . "</div>";
			echo "<div class='trans reset_trans trans" . $ayaNum2 . "'>" . $trans . "</div>";
			echo "</div>";
		}
	}

	/** AJAX: lazy-load next chunk of verses (nonce-protected). */
	function qtm_load_verses_chunk() {
		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! wp_verify_nonce( $nonce, 'qtm_load_verses' ) ) {
			status_header( 403 );
			die();
		}
		$sura = isset( $_POST['sura'] ) ? absint( $_POST['sura'] ) : 0;
		$lang = isset( $_POST['lang'] ) ? sanitize_text_field( wp_unslash( $_POST['lang'] ) ) : '';
		$from_aya = isset( $_POST['from_aya'] ) ? absint( $_POST['from_aya'] ) : 0;
		$to_aya = isset( $_POST['to_aya'] ) ? absint( $_POST['to_aya'] ) : 0;
		if ( $sura < 1 || $sura > 114 || $from_aya < 1 || $to_aya < $from_aya ) {
			status_header( 400 );
			die();
		}
		initSuraData();
		$total_ayas = (int) getSuraData( $sura, 'ayas' );
		if ( $to_aya > $total_ayas ) {
			$to_aya = $total_ayas;
		}
		qtm_render_verses_chunk( $sura, $lang, $from_aya, $to_aya );
		die();
	}

	/** AJAX: previous sura. */
	function qtm_changeprevsura() {

		$sura = sanitize_text_field($_POST['sura']);

		$lang = sanitize_text_field($_POST['lang']);
	
		initSuraData(); 
		if(!isset($_POST['lang'])){
			$lang = get_option('quran_languages');
		}
		
		echo "<div class='tabSura'>";
		showSura($sura,$lang);
		echo "</div>";

		die();
	}

	/** AJAX: next sura. */
	function qtm_changenextsura() {

		$sura = sanitize_text_field($_POST['sura']);

		$lang = sanitize_text_field($_POST['lang']);
	
		initSuraData(); 
		if(!isset($_POST['lang'])){
			$lang = get_option('quran_languages');
		}

		echo "<div class='tabSura'>";
		showSura($sura,$lang);
		echo "</div>";
		die();
	}

	/** AJAX: change sura (dropdown). */
	function qtm_changesura() {

		$sura_post = sanitize_text_field($_POST['sura']);

			
		preg_match("/[0-9]{1,3}$/", $sura_post, $matches);
		$lang = sanitize_text_field($_POST['lang']);
		$sura = $matches[0];	

		initSuraData(); 
		if(!isset($_POST['lang'])){
			$lang = get_option('quran_languages');
		}
		
		echo "<div class='tabSura'>";
		showSura($sura,$lang);
		echo "</div>";

		die();
	}

	function qtm_changelanguage(){
		initSuraData();
		$lang = sanitize_text_field($_POST['lang']);
		$sura = sanitize_text_field($_POST['paramsSura']);	
		preg_match("/[0-9]{1,3}$/", $sura, $matches);
		$sura = $matches[0];
		echo "<div class='tabSura'>";
		showSura($sura,$lang);
		echo "</div>";
		die();
	}

	function init_quran(){

		initSuraData();

	}
	function initSuraData()

	{

	global $suraData, $sura_ayas;

		$metadataFilePath = plugin_dir_path( __FILE__ ) . 'quran/data.xml';
		$dataItems = Array("index", "start", "ayas", "name", "tname", "ename", "type", "rukus");

		$quranData = file_get_contents( $metadataFilePath );
		if ( $quranData === false ) {
			$quranData = '';
		}

		$parser = xml_parser_create();

		xml_parse_into_struct($parser, $quranData, $values, $index);


		xml_parser_free($parser);

		for ($i=1; $i<=114; $i++) 

		{

			$j = $index['SURA'][$i-1];

			foreach ($dataItems as $item)

				$suraData[$i][$item] = $values[$j]['attributes'][strtoupper($item)]; 

		}

	}

	function getSuraData($sura, $property) 

	{

		global $suraData;
		return $suraData[$sura][$property]; 
	}





	function getSuraContents($sura, $file) 

	{

		$text = @file_get_contents( $file );
		if ( $text === false ) {
			return array();
		}
		$a = explode( PHP_EOL, $text );

		$startAya = getSuraData($sura, 'start');

		$endAya = $startAya+ getSuraData($sura, 'ayas');

		$content = array_slice($a, $startAya, $endAya- $startAya); 


		return $content;

	}

	if (@$sura < 1) @$sura = 1; 

	if (@$sura > 114) @$sura = 114; 

	function showSura($sura,$lang)

	{

	if(get_option('quran_recitator') == "Maher_al_me-aqly"){$recitator = "Maheralmeaqly";$nbr = sprintf( "%03d", $sura );}

	if(get_option('quran_recitator') == "ElGhamidi"){$recitator = "ElGhamidi";$nbr = $sura ;}

	if(get_option('quran_recitator') == "Soudais"){$recitator = "Soudais";$nbr = sprintf( "%03d", $sura );}

	if(get_option('quran_recitator') == "Al-Hussary"){$recitator = "Al-Hussary";$nbr = sprintf( "%03d", $sura );}

	if(get_option('quran_recitator') == "Basfar"){$recitator = "Basfar";$nbr = sprintf( "%03d", $sura );}

	if(get_option('quran_recitator') == "Alafasy"){$recitator = "Alafasy";$nbr = sprintf( "%03d", $sura );}

	if(get_option('quran_recitator') == "Al-Ajmy"){$recitator = "Al-Ajmy";$nbr = sprintf( "%03d", $sura );}


		global $quranFile, $transFile, $language;

		$quran_base_path = plugin_dir_path( __FILE__ ) . 'quran/';
		$quranFile = $quran_base_path . 'arabe.txt';

		if($lang != NULL){

			$transFile = $quran_base_path . $lang . '.txt';
			if($lang == 'urdu'  || $lang == 'persian' || $lang == 'kurdish'){
				echo "<style>.trans{direction:rtl;}</style>";
			}
		}

		else{

			$transFile = $quran_base_path . get_option('quran_languages') . '.txt';

		}

		$suraName = getSuraData($sura, 'tname');

		$suraText = getSuraContents($sura, $quranFile);

		$transText = getSuraContents($sura, $transFile);

		$showBismillah = false; 

		$ayaNum = 1;
		$ayaNum2 = 1;
		$cheikh = "https://quran.s3.fr-par.scw.cloud/verset/".$recitator."";
        $donwload = $recitator."-".strtolower($suraName);
?>
<script type="text/javascript">
jQuery(function($) {


	$('span.ayaNum, .sm2_link').replaceWith(function(){

		return "<a class='sm2_link' href='<?=$cheikh;?>/<?=$sura;?>/"+jQuery(this).html().match(/[0-9]+/)+".mp3' title='Écouter le verset'><span class='quranbadge quranbadge-info' id='kv"+jQuery(this).html().match(/[0-9]+/)+"'><span class='kb-verse-play' aria-hidden='true'><svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='currentColor'><path d='M8 5v14l11-7z'/></svg></span> "+jQuery(this).html().match(/[0-9]+/)+"</span></a>";

	});	
 });
</script>
<?php
		echo "<style>.suraName {border-radius: 5px 5px 0 0;border-bottom: 1px solid #".ltrim(get_option('background_quran_title'), '#').";text-align: center; font-size: 20px; padding: 10px 0px; background-color: #".ltrim(get_option('background_quran_title'), '#')."; margin-top: 7px;color:#".ltrim(get_option('text_quran_title'), '#').";}</style>

<div class=suraName>

<div id=\"bloc_top_quran\">
<div class='download_kb' id='click_download_kb'>
<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"22\" height=\"22\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4\"/><polyline points=\"7 10 12 15 17 10\"/><line x1=\"12\" y1=\"15\" x2=\"12\" y2=\"3\"/></svg>
</div>
<div class='playsura_kb' id='click_playsura_kb'>
<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"22\" height=\"22\" viewBox=\"0 0 24 24\" fill=\"currentColor\"><path d=\"M8 5v14l11-7z\"/></svg>
</div>
<div class='setting_kb' id='click_params_kb'>
<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"22\" height=\"22\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"12\" cy=\"12\" r=\"3\"/><path d=\"M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z\"/></svg>
</div>
<div id=\"bloc_name_sura\" class=\"bloc_name_sura\">
<div id='block_prev' style='display: inline;'>
<button type=\"button\" class=\"quran-nav-arrow PrevSourate\" id=\"PrevSourate\" aria-label=\"Previous Sura\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"15 18 9 12 15 6\"/></svg></button></div>
<span id=\"sourateName\" data-sourate=\"".strtolower($suraName)."\">$suraName </span>
<div id='block_next' style='display: inline;'>
<button type=\"button\" class=\"quran-nav-arrow NextSourate\" id=\"NextSourate\" aria-label=\"Next Sura\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><polyline points=\"9 18 15 12 9 6\"/></svg></button></div>
</div>
</div>
<div id=\"audio_sura\">
<div id='suraplayer'>

</div>
<div id='quran_player_sura'>

</div>
";
echo "
<div class='params_download_kb'>";
?>
<script type="text/javascript">
	jQuery(function($) {
$('#select_name_recitator').change(function(){

 var quran_download = $(this).val();

  	$('#name_recitator').hide();
  	$('#dl_count_kb').show();
        var settimmer = 0;
        $(function(){
              var refreshIntervalId =  window.setInterval(function() {
                    var timeCounter = $("b[id=left_time_download]").html();
                    var updateTime = eval(timeCounter)- eval(1);
                    $("b[id=left_time_download]").html(updateTime);

                    if(updateTime == 0){
                        window.location = ("https://krimdev.com/zipquran/"+quran_download+".zip");
                       clearInterval(refreshIntervalId);
                       $('#dl_count_kb').hide();
                       $('.params_download_kb').hide();
                       $("b[id=left_time_download]").html('10');
                    }

                }, 1000);

        });


});	});	
</script>
<?php
echo '
<div id="recitator_download_kb">
<div style="color:#337AB7;font-size:16px" id="dl_count_kb">
the download will begin in <b id="left_time_download" style="color:rgb(101, 101, 101)">10</b> seconds  <b style="font-size:12px;color:rgb(101, 101, 101)">(limit : 500ko/s)</b>      
</div>

<form id="name_recitator">
<span class=\"quran-panel-subtitle\" style=\"font-size:14px;\">All zip Quran</span>
<select name="select_name_recitator" id="select_name_recitator">
<option disabled=\"disabled\"  selected=\"selected\">'.get_option("quran_changerecitatortxt").'</option>
	<option value="shaikh_abubakr_as-shatery"> Abu Bakr Al Shatri</option>
	<option value="abdul_baset_abdul_samad">Abdelbasset Abdessamad</option>
	<option value="abdul_bin_awaz_althubyty">Abdulbari Athobaity</option>
	<option value="abdullah_bin_awad_aljuhany">Abdullah Al Juhany</option>
	<option value="abdullah_bin_mohammad_almatrood_mourattal">Abdullah Al Matrod</option>
	<option value="abdullah_bin_ali_basfar">Abdullah Basfar</option>
	<option value="abul_mohsen_bin_mohammad_alqasim">AbdulMohsin Al Qasim</option>
	<option value="abdul_rahman_alsudais">Abdulrahman Al Sudais</option>
	<option value="adel_bin_salem_alkalbaany">Adel Al Kalbany</option>
	<option value="adel_rayyan">Adel Rayan</option>
	<option value="ahmad_bin_ali_al-ajmy">Ahmed Al Ajmy</option>
	<option value="ali_bin_jaber">Ali Jabber</option>
	<option value="basel_al_rawy">Basal Al Rawy</option>
	<option value="fahd_al-kundury_mourrattal">Fahd Al Kandari</option>
	<option value="faris_abbad">Fares Abbad</option>
	<option value="hani_ar-refai_mourattal">Hani Ar Rifa\'i</option>
	<option value="khalid_al-qahtani">Khalid Al Qahtani</option>
	<option value="mahir_hamad_al-meiqili">Maher Al M\'aqli</option>
	<option value="mahmoud_khalil_husary">Mahmoud Khalil Al Hussary</option>
	<option value="mishary_rashed_alafasy">Mishary Al \'Afasi</option>
	<option value="mohammed_almohaisny">Mohammed Al Muhasny</option>
	<option value="mohammad_ayyoob_bin_mohammad_yousuf">Mohammed Ayyub</option>
	<option value="mohammed_hassan">Mohammed Hassan</option>
	<option value="muhammad_jibreel">Mohammed Jibreel</option>
	<option value="muhammad_sedeeq_al-menshawy_murrattal">Mohammed Siddiq Al Minshawi</option>
	<option value="muhammad_al-tablawy">Mohammed Tablawi</option>
	<option value="nabil_arrifai">Nabil Ar Rifa\'i</option>
	<option value="saad_bin_said_alghamdy">Saad Al Ghamidi</option>
	<option value="salah_al-budair">Salah Al Budair</option>
	<option value="saud_al-shuraim">Saud Al Shuraim</option>
	<option value="tawfeeq_as-saaigh">Tawfeeq As Sayegh</option>
	<option value="Yasser_Al_Dosari">Yasser Al Dosry</option>
</select>
</form>
</div>
</div>';
echo "
<div class='params1_kb'>";
?>
<script type="text/javascript">
jQuery(function($) {
$('#select_name_recitator2').change(function(){

    var sourate  = $.urlParam('sourate');
    var sura = sourate.match( /\d+/ );
    $('#playeraya2').html('<audio id="kb-idaudio2" controls></audio>');

    var quran_home = $(this).val();

    var current_sura = sura;

    $.ajax({
    type: "GET",
    url: "https://krimdev.com/seek_xml_quran.php?quran_xml="+quran_home+"",
	dataType: 'xml',
    success: function(xmlquran) {

    $(xmlquran).find('item').each(function(){


    var checksura = $(this).find("title").text()

    if(checksura == current_sura){

    var urlmp3 = $(this).find("description").text()
    var res = urlmp3.replace(" ", "_");
     //alert(urlmp3);	
	 https://quran.s3.fr-par.scw.cloud/
    url_mp3_quran = 'https://quran.s3.fr-par.scw.cloud/'+res+'';

    $('#playeraya2').html('<audio id="kb-idaudio2" src="'+url_mp3_quran+'" controls autoplay></audio>');

    $('#kb-idaudio2').load(url_mp3_quran);
    $('#kb-idaudio2')[0].play();

    }

    });

    }
    });

    $('.sm2_link').css('pointer-events', 'none');
    $('.sm2_link').css('cursor', 'default');

});
});	
</script>
<?php
echo '
<div id="recitator2_kb">
<form id="name_recitator">
<select name="select_name_recitator" id="select_name_recitator2">
<option disabled=\"disabled\"  selected=\"selected\">'.get_option("quran_changerecitatortxt").'</option>
	<option value="shaikh_abubakr_as-shatery"> Abu Bakr Al Shatri</option>
	<option value="abdul_baset_abdul_samad">Abdelbasset Abdessamad</option>
	<option value="abdul_bin_awaz_althubyty">Abdulbari Athobaity</option>
	<option value="abdullah_bin_awad_aljuhany">Abdullah Al Juhany</option>
	<option value="abdullah_bin_mohammad_almatrood_mourattal">Abdullah Al Matrod</option>
	<option value="abdullah_bin_ali_basfar">Abdullah Basfar</option>
	<option value="abul_mohsen_bin_mohammad_alqasim">AbdulMohsin Al Qasim</option>
	<option value="abdul_rahman_alsudais">Abdulrahman Al Sudais</option>
	<option value="adel_bin_salem_alkalbaany">Adel Al Kalbany</option>
	<option value="adel_rayyan">Adel Rayan</option>
	<option value="ahmad_bin_ali_al-ajmy">Ahmed Al Ajmy</option>
	<option value="ali_bin_jaber">Ali Jabber</option>
	<option value="basel_al_rawy">Basal Al Rawy</option>
	<option value="fahd_al-kundury_mourrattal">Fahd Al Kandari</option>
	<option value="faris_abbad">Fares Abbad</option>
	<option value="hani_ar-refai_mourattal">Hani Ar Rifa\'i</option>
	<option value="khalid_al-qahtani">Khalid Al Qahtani</option>
	<option value="mahir_hamad_al-meiqili">Maher Al M\'aqli</option>
	<option value="mahmoud_khalil_husary">Mahmoud Khalil Al Hussary</option>
	<option value="mishary_rashed_alafasy">Mishary Al \'Afasi</option>
	<option value="mohammed_almohaisny">Mohammed Al Muhasny</option>
	<option value="mohammad_ayyoob_bin_mohammad_yousuf">Mohammed Ayyub</option>
	<option value="mohammed_hassan">Mohammed Hassan</option>
	<option value="muhammad_jibreel">Mohammed Jibreel</option>
	<option value="muhammad_sedeeq_al-menshawy_murrattal">Mohammed Siddiq Al Minshawi</option>
	<option value="muhammad_al-tablawy">Mohammed Tablawi</option>
	<option value="nabil_arrifai">Nabil Ar Rifa\'i</option>
	<option value="saad_bin_said_alghamdy">Saad Al Ghamidi</option>
	<option value="salah_al-budair">Salah Al Budair</option>
	<option value="saud_al-shuraim">Saud Al Shuraim</option>
	<option value="tawfeeq_as-saaigh">Tawfeeq As Sayegh</option>
	<option value="Yasser_Al_Dosari">Yasser Al Dosry</option>
</select>
</form>
</div>
<p id="playeraya2"></p>
</div>';


?>
<script type="text/javascript">
var valeur_debut = 1;
var valeur_fin;
var format_text_kb;


/*************************************************/

jQuery(function($) {

$('#kb-select_text').change( function(){
format_text_kb= $(this).val();
if(format_text_kb == 'arabic-translate_kb'){$('.quran').css('display', 'block', 'important');$('.trans').css('display', 'block', 'important');}
if(format_text_kb == 'arabic_kb'){$('.quran').css('background-color', '#FFFFFF');$('.quran:first').css('background-color', 'rgb(87, 87, 87)');$('.quran').css('display', 'block', 'important');$('.trans').css('display', 'none', 'important');}
if(format_text_kb == 'translate_kb'){$('.quran').css('display', 'none', 'important');$('.trans').css('display', 'block', 'important');}
});

$('#select_name_recitatorkb').change(function(){

  	$('#kb-select_debut').prop( "disabled", false );
  		var recitator_quran = $(this).val();

  		if(recitator_quran == "Maheralmeaqly"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>";}
  		if(recitator_quran == "ElGhamidi"){ var nbr_quran = "<?php echo esc_js(sanitize_text_field($_GET['sourate'] ?? '')); ?>";}
  		if(recitator_quran == "Soudais"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		if(recitator_quran == "Abdelbasset"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		if(recitator_quran == "alafasy"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		if(recitator_quran == "Al-Ajmy"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		if(recitator_quran == "Al-Hussary"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		if(recitator_quran == "Basfar"){var nbr_quran = "<?php echo sprintf( "%03d", $sura );?>"}
  		var src_quran = "https://quran.s3.fr-par.scw.cloud//recitateur/"+recitator_quran+"/"+nbr_quran+".mp3";
		
		jQuery('span.ayaNum, .sm2_link').replaceWith(function(){
		var sura = '<?php echo $sura; ?>';
		return "<a class='sm2_link azk"+jQuery(this).html().match(/[0-9]+/)+"' data-src='https://quran.s3.fr-par.scw.cloud/verset/"+recitator_quran+"/" +sura+ "/"+jQuery(this).html().match(/[0-9]+/)+".mp3' href='https://quran.s3.fr-par.scw.cloud/verset/"+recitator_quran+"/" +sura+ "/"+jQuery(this).html().match(/[0-9]+/)+".mp3' title='Écouter le verset'><span class='quranbadge quranbadge-info' id='kv"+jQuery(this).html().match(/[0-9]+/)+"'><span class='kb-verse-play' aria-hidden='true'><svg xmlns='http://www.w3.org/2000/svg' width='10' height='10' viewBox='0 0 24 24' fill='currentColor'><path d='M8 5v14l11-7z'/></svg></span> "+jQuery(this).html().match(/[0-9]+/)+"</span></a>";

	});

  		changeRecitateur(src_quran);
});});
function changeRecitateur(sourceUrl) {
    var audio = jQuery("#audio_quran");      
    jQuery("#url_sourate").attr("src", sourceUrl);
    jQuery("#dl_sourate").attr("href", sourceUrl);
}    
/*******************************************************/


jQuery(document).ready(function($){
$('#kb-select_debut').change(function(){
   $('playeraya').html("");  
   $('ol#li_quran').empty();
   valeur_debut = $(this).val();
   $('#kb-select_fin option').show();      
  $('#kb-select_fin option').filter(function() { 
   return +this.value <= valeur_debut;  
  }).hide();
 $('.aya').show();

  $('.aya').filter(function(){
  	return $(this).data('aya') < valeur_debut;
  }).hide();

$('#kb-select_fin').prop( "disabled", false );
});


$('#kb-select_fin').change(function(){
$('#kb-select_text').prop( "disabled", false );	
 $('playeraya').html(""); 
  //$('#kb-select_fin option').show();
  valeur_fin = $(this).val();
  $('.aya').filter(function(){
  	return $(this).data('aya') > valeur_fin;
  }).hide();

 	

$.each($('audio'), function () {
    $(this).stop();
});	

$('.params_kb').css('height', 'auto');
$('#suraplayer').html("");

			$('.quran').removeAttr("style");	
			$('.trans').removeAttr("style"); 


    var i = valeur_debut - 1;
    function next_ol() {
        i++;
        if (i <= valeur_fin) {
var srcquran = $(".azk"+i+"").data('src');
$('ol#li_quran').append("<li class='verset"+i+"' ><a href='#' verset-data='"+i+"' data-src='"+srcquran+"'></a></li>");
$(this).css('display', 'none', 'important'); 
 next_ol();
        } 
    }
    next_ol();




$('.aya').removeClass('quran-verse-playing');
$('.vaya'+valeur_debut).addClass('quran-verse-playing');
$('.aya').css('cursor', 'pointer');

/*****************************************************************************************************

*/

var audioquran;
var playlist;
var tracks;
var current;
var trackfirst;
var srcfirst;

init();
function init(){
$('#playeraya').html('<audio id="kb-idaudio" preload="none" tabindex="0" controls="" type="audio/mpeg"><source type="audio/mp3" src="'+$('#li_quran li a').first().attr('data-src')+'"></audio>');	
	$('#kb-idaudio').show();
    current = 0;
    audioquran = $('#kb-idaudio');

    playlist = $('#li_quran');
    tracks = playlist.find('li a');
    trackfirst = $('#li_quran li a').first().attr('data-src');
    audiofirst = $('#kb-idaudio').attr('src', trackfirst);
    //alert(trackfirst);
    len = tracks.length;
    audioquran[0].volume = .50;
    //audioquran[0].play();
    playlist.find('a').click(function(e){
        e.preventDefault();
        link = $(this);
        current = link.parent().index();
        run(link, audio[0]);
    });
    
    audioquran[0].addEventListener('ended',function(e){
    	
    	//alert('terminer');
        current++;


        if(current == len){
            current = 0;
            link = playlist.find('a')[0];
        }else{
            link = playlist.find('a')[current];  
        }
		run($(link),audioquran[0]);

			var qurandata = $('ol li.active a').attr('verset-data');
			$('.aya').removeClass('quran-verse-playing');
			$('.vaya'+qurandata).addClass('quran-verse-playing');
			$('html,body').animate({scrollTop: $(".vaya"+qurandata).offset().top  -250}, 'fast');
    });
}
function run(link, player){
        player.src = link.attr('data-src');
        par = link.parent();
        par.addClass('active').siblings().removeClass('active');

        $('.aya').removeClass('quran-verse-playing');
        $('.vaya'+link.attr('verset-data')).addClass('quran-verse-playing');

        audioquran[0].load();
        audioquran[0].play();
        $('.quran').removeAttr("style");	
		$('.trans').removeAttr("style"); 

if(format_text_kb == 'arabic-translate_kb'){$('.quran').css('display', 'block', 'important');$('.trans').css('display', 'block', 'important');}
if(format_text_kb == 'arabic_kb'){$('.quran').css('background-color', 'white');$('.quran').css('display', 'block', 'important');$('.trans').css('display', 'none', 'important');}
if(format_text_kb == 'translate_kb'){$('.quran').css('display', 'none', 'important');$('.trans').css('display', 'block', 'important');}		
}


$('.aya').on( "click",function(){

  var audioElem = document.getElementById('kb-idaudio');
  if (audioElem.paused)
    audioElem.play();
  else
    audioElem.pause();
});	
});	
});	
	
</script>
<?php
echo "
<div class='params_kb'>
<div class='params_kb-steps'>
	<div class='params_kb-step' id='recitator_kb'>
		<label class='params_kb-step-label'>".esc_html__('Reciter','quran-text-multilanguage')."</label>
		<form id=\"name_recitator\">
		<select name=\"select_name_recitatorkb\" id=\"select_name_recitatorkb\">
		<option disabled=\"disabled\"  selected=\"selected\">".get_option("quran_changerecitatortxt")."</option>
		<option value=\"ElGhamidi\">Saad El Galmidi</option>
		<option value=\"Soudais\">Abderrahman Al Soudais</option>
		<option value=\"Alafasy\">Mishary Rashid Al-Afassy</option>
		<option value=\"Al-Ajmy\">Ahmad Al-Ajmy</option>
		<option value=\"Al-Hussary\">Al-Hussary</option>
		<option value=\"Basfar\">Abdallah Ali Basfar</option>
		</select>
		</form>
	</div>
	<span class='params_kb-arrow' aria-hidden='true'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'><path d='M5 12h14M12 5l7 7-7 7'/></svg></span>
	<div class='params_kb-step' id='select_aya'>
		<label class='params_kb-step-label'>".esc_html__('Verses','quran-text-multilanguage')."</label>
		<div class='params_kb-step-fields'>
		<select id='kb-select_debut'>
		";
echo '<option disabled="disabled"  selected="selected">FROM</option>';
for($i=1;$i<getSuraData($sura, 'ayas')+1;$i++){
echo '<option>'.$i.'</option>';	
}
echo "
		</select>
		<select id='kb-select_fin'>
		";
echo '<option disabled="disabled" selected="selected">TO</option>';
for($i=1;$i<getSuraData($sura, 'ayas')+1;$i++){
echo '<option>'.$i.'</option>';	
}
echo "
		</select>
		</div>
	</div>
	<span class='params_kb-arrow' aria-hidden='true'><svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'><path d='M5 12h14M12 5l7 7-7 7'/></svg></span>
	<div class='params_kb-step params_kb-step-format'>
		<label class='params_kb-step-label'>".esc_html__('Text format','quran-text-multilanguage')."</label>
		<div class='params_kb-step-fields params_kb-step-format-row'>
		<select id='kb-select_text'>
		<option disabled=\"disabled\" selected=\"selected\">Text Format</option>
		<option value='arabic-translate_kb'>Arabic with Translation</option>
		<option value='arabic_kb'>Arabic only</option>
		<option value='translate_kb'>Translation only</option>
		</select>
		<img src='".plugin_dir_url(__FILE__)."/images/play.png' class='params_kb-play-btn' id='play_select_quran' alt='Play' width='25' height='25'>
		</div>
	</div>
</div>
<p id='playeraya'></p>
</div>
</div>
</div>";
		echo "<ol id='li_quran'></ol>";
		$total_ayas = count( $suraText );
		$chunk_size = defined( 'QTM_VERSES_CHUNK_SIZE' ) ? QTM_VERSES_CHUNK_SIZE : 40;
		$first_chunk_end = min( $chunk_size, $total_ayas );
		echo "<div id='quran_verses_wrapper' data-sura='" . esc_attr( $sura ) . "' data-lang='" . esc_attr( $lang ) . "' data-total-ayas='" . esc_attr( $total_ayas ) . "' data-chunk-size='" . esc_attr( $chunk_size ) . "'>";

		for ( ; $ayaNum2 <= $first_chunk_end; $ayaNum2++ ) {
			$aya = $suraText[ $ayaNum2 - 1 ];
			$trans = $transText[ $ayaNum2 - 1 ];
			if ( ! $showBismillah && $ayaNum2 == 1 && $sura != 1 && $sura != 9 ) {
				$aya = preg_replace( '/^(([^ ]+ ){4})/u', '', $aya );
			}
			$aya = preg_replace( '/ ([ۖ-۩])/u', '<span class="sign">&nbsp;$1</span>', $aya );
			echo "<div class='aya vaya" . $ayaNum2 . "' data-aya='" . $ayaNum2 . "'>";
			echo "<div class='quran reset_quran verset" . $ayaNum2 . "'><span class=ayaNum>" . $ayaNum2 . ". </span>" . $aya . "</div>";
			echo "<div class='trans reset_trans trans" . $ayaNum2 . "'>" . $trans . " </div>";
			echo "</div>";
		}

		echo "</div>";

	}	

?>
