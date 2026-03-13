<?php
/**
 * Admin page: options (labels, reciter, language), color theme picker, custom colors, custom CSS, donation block.
 */
if ( ! current_user_can( 'activate_plugins' ) ) {
	return;
}
defined( 'ABSPATH' ) || die( 'Salem aleykoum!' );

wp_register_script( 'quran_admin_color', plugin_dir_url( __FILE__ ) . 'js/jscolor/jscolor.js' );
wp_enqueue_script( 'quran_admin_color' );

if ( isset( $_POST['template_quran_update'] ) ) {

		if(!wp_verify_nonce($_POST['template_quran_noncename'], 'tplquran')){
			die('token non valide');
		}

		// Vérification du nonce pour les options
		if(!wp_verify_nonce($_POST['quran_options_nonce'], 'quran_options')){
			die('token non valide');
		}

		foreach ( $_POST['option'] as $name => $val ) {
			$value = sanitize_text_field( $val );
			// Normalise hex colors (strip #, validate 6 hex digits, re-add #).
			if ( strpos( $name, 'color' ) !== false || strpos( $name, 'background' ) !== false ) {
				$hex = ltrim($value, "#");
				if(!preg_match('/^[a-f0-9]{6}$/i', $hex)) {
					$hex = '000000'; // Valeur par défaut si invalide
				}
				$value = '#' . strtolower($hex);
			}
			
			if(empty($value)){
				delete_option($name);
			}else{
				update_option($name, $value);
			}
		}

			?>

			<div id="message" class="updated fade">

			<p>Thème sauvegardé!</p>

			</div>

			<?php

	}

?>

<style>

#thadminquran{width: auto !important;}
#bloc_admin_quran{background:#ffffff;padding:20px;color:#7a7a7a;}
#bloc_admin_quran th{color:#7a7a7a;padding:20px;}
#bloc_admin_quran tr:nth-child(even) {background: #F8F8F8}
#bloc_admin_qurantr:nth-child(odd) {background: #FFF}
.viewfont{font-size:30px;font-weight:400;color:#000000;font-family:<?php echo get_option('quran_arabicfont');?>}
.wordspacing{word-spacing:<?php echo get_option('quran_wordspacing');?>px;}
.qtm-theme-grid{display:flex;flex-wrap:wrap;gap:16px;margin-top:8px;}
.qtm-theme-card{position:relative;display:inline-flex;flex-direction:column;gap:4px;padding:8px 10px;border-radius:8px;border:1px solid #d4d4d8;background:#fff;cursor:pointer;min-width:120px;box-shadow:0 1px 2px rgba(0,0,0,0.03);transition:border-color 0.15s ease,box-shadow 0.15s ease,transform 0.1s ease;}
.qtm-theme-card:hover{border-color:#0ea5e9;box-shadow:0 2px 6px rgba(15,23,42,0.08);transform:translateY(-1px);}
.qtm-theme-card input[type="radio"]{position:absolute;opacity:0;pointer-events:none;}
.qtm-theme-card-selected{border-color:#0ea5e9 !important;box-shadow:0 0 0 2px rgba(14,165,233,0.35) !important;}
.qtm-theme-title{font-size:13px;font-weight:600;color:#111827;margin-bottom:4px;}
.qtm-theme-row{display:flex;align-items:stretch;gap:4px;}
.qtm-theme-swatch{flex:1 1 0;border-radius:6px;height:20px;}
.qtm-theme-swatch-title{height:16px;}
@font-face {
    font-family: "noorehira";
    src: url('<?php echo plugin_dir_url(__FILE__); ?>/font/noorehira.ttf');
}
@font-face {
    font-family: "uthmanic";
    src: url('<?php echo plugin_dir_url(__FILE__); ?>/font/uthmanic.otf');
}
@font-face {
    font-family: "goldenlotus";
    src: url('<?php echo plugin_dir_url(__FILE__); ?>/font/goldenlotus.ttf');
}
@font-face {
    font-family: "swer_quran";
    src: url('<?php echo plugin_dir_url(__FILE__); ?>/font/swer_quran.ttf');
}
@font-face {
    font-family: 'quran';
    src: url('<?php echo plugin_dir_url(__FILE__); ?>/font/quran.woff2') format('woff2');
    font-display: swap;
  }
</style>
<script>
	function viewfont(font)
		{
			jQuery('.viewfont').css("font-family", font.value);

		}
		function wordspacing(px)
		{
			jQuery('.wordspacing').css("word-spacing", px.value+"px");

		}		
</script>
<div class="wrap" id="bloc_admin_quran">

<h3>Quran Text Multilanguage Options</h3>



<form method="post" action="">
<?php wp_nonce_field('quran_options', 'quran_options_nonce'); ?>
<?php settings_fields( 'quran-options' ); ?>


<table class="form-table">

<tr valign="top">

<th scope="row" id="thadminquran">Dark mode</th>

<td>
   <input type="hidden" name="option[quran_dark_mode]" value="no" />
   <label><input type="checkbox" name="option[quran_dark_mode]" value="yes" <?php checked( get_option('quran_dark_mode'), 'yes' ); ?> /> Enable dark mode for reading</label>
</td>

</tr>

<tr valign="top">

<th scope="row" id="thadminquran">Choose the cheikh for the versets</th>

<td>

<select name="option[quran_recitator]" id="quran_recitator">

<option disabled="disabled">Choose the cheikh for the versets</option>

<option value="ElGhamidi" <?php if (get_option('quran_recitator') == "ElGhamidi") {echo 'selected="selected"';} ?>>Saad El Galmidi</option>

<option value="Soudais" <?php if (get_option('quran_recitator') == "Soudais") {echo 'selected="selected"';} ?>>Abderrahman Al Soudais</option>

<option value="Basfar" <?php if (get_option('quran_recitator') == "Basfar") {echo 'selected="selected"';} ?>>Abdallah Ali Basfar</option>

<option value="Alafasy" <?php if (get_option('quran_recitator') == "Alafasy") {echo 'selected="selected"';} ?>>Alafasy</option>

<option value="Al-Hussary" <?php if (get_option('quran_recitator') == "Al-Hussary") {echo 'selected="selected"';} ?>>Al-Hussary</option>

<option value="Al-Ajmy" <?php if (get_option('quran_recitator') == "Al-Ajmy") {echo 'selected="selected"';} ?>>Al-Ajmy</option>
</select>
</td>

</tr>

<tr valign="top">

<th scope="row" id="thadminquran">Choose font for arabic text</th>

<td>

<select name="option[quran_arabicfont]" id="quran_arabicfont" onchange="viewfont(this);">

<option disabled="disabled">Choose font for arabic text</option>

<option value="noorehira" <?php if (get_option('quran_arabicfont') == "noorehira") {echo 'selected="selected"';} ?>>noorehira Regular</option>

<option value="uthmanic" <?php if (get_option('quran_arabicfont') == "uthmanic") {echo 'selected="selected"';} ?>>Uthmanic Hafs</option>

<option value="goldenlotus" <?php if (get_option('quran_arabicfont') == "goldenlotus") {echo 'selected="selected"';} ?>>Golden Lotus</option>

<option value="swer_quran" <?php if (get_option('quran_arabicfont') == "swer_quran") {echo 'selected="selected"';} ?>>Mcs Swer Al_Quran 2</option>

<option value="quran" <?php if (get_option('quran_arabicfont') == "quran") {echo 'selected="selected"';} ?>>Quran v3</option>
</select>
<span class="viewfont">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</span>
</td>

</tr>
<tr valign="top">

<th scope="row" id="thadminquran">Word Spacing for arabic text</th>

<td>

<select name="option[quran_wordspacing]" id="quran_wordspacing" onchange="wordspacing(this);">

<option disabled="disabled">Word Spacing for arabic text</option>
<option value="0" <?php if (get_option('quran_wordspacing') == "0") {echo 'selected="selected"';} ?>>0 px</option>
<option value="1" <?php if (get_option('quran_wordspacing') == "1") {echo 'selected="selected"';} ?>>1 px</option>
<option value="2" <?php if (get_option('quran_wordspacing') == "2") {echo 'selected="selected"';} ?>>2 px</option>
<option value="3" <?php if (get_option('quran_wordspacing') == "3") {echo 'selected="selected"';} ?>>3 px</option>
<option value="4" <?php if (get_option('quran_wordspacing') == "4") {echo 'selected="selected"';} ?>>4 px</option>
<option value="5" <?php if (get_option('quran_wordspacing') == "5") {echo 'selected="selected"';} ?>>5 px</option>
<option value="6" <?php if (get_option('quran_wordspacing') == "6") {echo 'selected="selected"';} ?>>6 px</option>
<option value="7" <?php if (get_option('quran_wordspacing') == "7") {echo 'selected="selected"';} ?>>7 px</option>
<option value="8" <?php if (get_option('quran_wordspacing') == "8") {echo 'selected="selected"';} ?>>8 px</option>
<option value="9" <?php if (get_option('quran_wordspacing') == "9") {echo 'selected="selected"';} ?>>9 px</option>
<option value="10" <?php if (get_option('quran_wordspacing') == "10") {echo 'selected="selected"';} ?>>10 px</option>

</select>
<span class="viewfont wordspacing">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</span>
</td>

</tr>
<tr valign="top">



<th scope="row" id="thadminquran">language default</th>



<td>

			<select name="option[quran_languages]" id="quran_languages">

			<option value="arabe"<?php if (get_option('quran_languages') == "arabe"){echo 'selected="selected"';}?>>Arabe</option>				

			<option value="english"<?php if (get_option('quran_languages') == "english"){echo 'selected="selected"';}?>>English</option>			

			<option value="francais"<?php if (get_option('quran_languages') == "francais"){echo 'selected="selected"';}?>>Français</option>

			<option value="german"<?php if (get_option('quran_languages') == "german"){echo 'selected="selected"';}?>>German</option>

			<option value="dutch"<?php if (get_option('quran_languages') == "dutch"){echo 'selected="selected"';}?>>Dutch</option>

			<option value="russian"<?php if (get_option('quran_languages') == "russian"){echo 'selected="selected"';}?>>Russian</option>	

			<option value="albanian"<?php if (get_option('quran_languages') == "albanian"){echo 'selected="selected"';}?>>Albanian</option>

			<option value="azerbaijani"<?php if (get_option('quran_languages') == "azerbaijani"){echo 'selected="selected"';}?>>Azerbaijani</option>

			<option value="bengali"<?php if (get_option('quran_languages') == "bengali"){echo 'selected="selected"';}?>>Bengali</option>			

			<option value="bulgarian"<?php if (get_option('quran_languages') == "bulgarian"){echo 'selected="selected"';}?>>Bulgarian</option>	

			<option value="bosnian"<?php if (get_option('quran_languages') == "bosnian"){echo 'selected="selected"';}?>>Bosnian</option>		

			<option value="chinese"<?php if (get_option('quran_languages') == "chinese"){echo 'selected="selected"';}?>>Chinese</option>

			<option value="czech"<?php if (get_option('quran_languages') == "czech"){echo 'selected="selected"';}?>>Czech</option>

			<option value="indonesian"<?php if (get_option('quran_languages') == "indonesian"){echo 'selected="selected"';}?>>Indonesian</option>

			<option value="italian"<?php if (get_option('quran_languages') == "italian"){echo 'selected="selected"';}?>>Italian</option>

			<option value="kurdish"<?php if (get_option('quran_languages') == "kurdish"){echo 'selected="selected"';}?>>Kurdish</option>

			<option value="malay"<?php if (get_option('quran_languages') == "malay"){echo 'selected="selected"';}?>>Malay</option>

			<option value="norwegian"<?php if (get_option('quran_languages') == "norwegian"){echo 'selected="selected"';}?>>Norwegian</option>

			<option value="portuguese"<?php if (get_option('quran_languages') == "portuguese"){echo 'selected="selected"';}?>>Portuguese</option>

			<option value="romanian"<?php if (get_option('quran_languages') == "romanian"){echo 'selected="selected"';}?>>Romanian</option>

			<option value="somali"<?php if (get_option('quran_languages') == "somali"){echo 'selected="selected"';}?>>Somali</option>

			<option value="spanish"<?php if (get_option('quran_languages') == "spanish"){echo 'selected="selected"';}?>>Spanish</option>	

			<option value="swedish"<?php if (get_option('quran_languages') == "swedish"){echo 'selected="selected"';}?>>Swedish</option>	

			<option value="turkish"<?php if (get_option('quran_languages') == "turkish"){echo 'selected="selected"';}?>>Turkish</option>				
			
			<option value="urdu"<?php if (get_option('quran_languages') == "urdu"){echo 'selected="selected"';}?>>Urdu</option>				
			
			<option value="hindi"<?php if (get_option('quran_languages') == "hindi"){echo 'selected="selected"';}?>>Hindi</option>				
				
			<option value="persian"<?php if (get_option('quran_languages') == "persian"){echo 'selected="selected"';}?>>Persian</option>				
			
			<option value="thai"<?php if (get_option('quran_languages') == "thai"){echo 'selected="selected"';}?>>Thai</option>				

			<option value="uzbek"<?php if (get_option('quran_languages') == "uzbek"){echo 'selected="selected"';}?>>Uzbek</option>				

			</select>

</td>

</tr>

<tr valign="top">
<th scope="row" id="thadminquran">Change sura text </th>
<td>
   <label><input type="text" name="option[quran_changesuratxt]" value="<?php echo esc_attr(get_option('quran_changesuratxt')); ?>"></label>
</td>
</tr>

<tr valign="top">
<th scope="row" id="thadminquran">Change language text </th>
<td>
   <label><input type="text" name="option[quran_changelangtxt]" value="<?php echo esc_attr(get_option('quran_changelangtxt')); ?>"></label>
</td>
</tr>

<tr valign="top">
<th scope="row" id="thadminquran">Change recitator text </th>
<td>
   <label><input type="text" name="option[quran_changerecitatortxt]" value="<?php echo esc_attr(get_option('quran_changerecitatortxt')); ?>"></label>
</td>
</tr>


<tr valign="top">

<th scope="row" id="thadminquran">Color theme</th>
<td>
<?php
	$current_theme = get_option('quran_color_theme', 'default');
	$themes = array(
		'default' => array(
			'label' => 'Default (gray/blue)',
			'title_bg' => '#374151',
			'title_text' => '#f3f4f6',
			'arabic_bg' => '#ffffff',
			'arabic_text' => '#111827',
			'trans_bg' => '#f1f5f9',
			'trans_text' => '#475569',
			'badge_bg' => '#e2e8f0',
			'badge_text' => '#1f2937',
		),
		'green' => array(
			'label' => 'Green',
			'title_bg' => '#15803d',
			'title_text' => '#f0fdf4',
			'arabic_bg' => '#ecfdf3',
			'arabic_text' => '#064e3b',
			'trans_bg' => '#dcfce7',
			'trans_text' => '#166534',
			'badge_bg' => '#bbf7d0',
			'badge_text' => '#166534',
		),
		'maroon' => array(
			'label' => 'Maroon',
			'title_bg' => '#7f1d1d',
			'title_text' => '#fef2f2',
			'arabic_bg' => '#fef2f2',
			'arabic_text' => '#450a0a',
			'trans_bg' => '#fee2e2',
			'trans_text' => '#7f1d1d',
			'badge_bg' => '#fecaca',
			'badge_text' => '#7f1d1d',
		),
		'sand' => array(
			'label' => 'Sand',
			'title_bg' => '#854d0e',
			'title_text' => '#fffbeb',
			'arabic_bg' => '#fffbeb',
			'arabic_text' => '#451a03',
			'trans_bg' => '#fef3c7',
			'trans_text' => '#92400e',
			'badge_bg' => '#fde68a',
			'badge_text' => '#78350f',
		),
		'ocean' => array(
			'label' => 'Ocean',
			'title_bg' => '#0f172a',
			'title_text' => '#e0f2fe',
			'arabic_bg' => '#eff6ff',
			'arabic_text' => '#0f172a',
			'trans_bg' => '#dbeafe',
			'trans_text' => '#1d4ed8',
			'badge_bg' => '#bfdbfe',
			'badge_text' => '#1d4ed8',
		),
		'olive' => array(
			'label' => 'Olive',
			'title_bg' => '#365314',
			'title_text' => '#ecfccb',
			'arabic_bg' => '#f7fee7',
			'arabic_text' => '#365314',
			'trans_bg' => '#e4ffc7',
			'trans_text' => '#3f6212',
			'badge_bg' => '#bef264',
			'badge_text' => '#3f6212',
		),
	);
?>
	<input type="hidden" name="option[quran_color_theme]" id="quran_color_theme" value="<?php echo esc_attr( $current_theme ); ?>" />
	<div class="qtm-theme-grid">
	<?php foreach ( $themes as $key => $t ) : ?>
		<label class="qtm-theme-card<?php echo ( $current_theme === $key ) ? ' qtm-theme-card-selected' : ''; ?>"
			data-theme-key="<?php echo esc_attr( $key ); ?>"
			data-title-bg="<?php echo esc_attr( $t['title_bg'] ); ?>"
			data-title-text="<?php echo esc_attr( $t['title_text'] ); ?>"
			data-arabic-bg="<?php echo esc_attr( $t['arabic_bg'] ); ?>"
			data-arabic-text="<?php echo esc_attr( $t['arabic_text'] ); ?>"
			data-trans-bg="<?php echo esc_attr( $t['trans_bg'] ); ?>"
			data-trans-text="<?php echo esc_attr( $t['trans_text'] ); ?>"
			data-badge-bg="<?php echo esc_attr( $t['badge_bg'] ); ?>"
			data-badge-text="<?php echo esc_attr( $t['badge_text'] ); ?>"
		>
			<input type="radio" name="qtm_theme_choice" value="<?php echo esc_attr( $key ); ?>" <?php checked( $current_theme, $key ); ?> />
			<div class="qtm-theme-title"><?php echo esc_html( $t['label'] ); ?></div>
			<div class="qtm-theme-row">
				<div class="qtm-theme-swatch qtm-theme-swatch-title" style="background: <?php echo esc_attr( $t['title_bg'] ); ?>;"></div>
			</div>
			<div class="qtm-theme-row" style="margin-top:4px;">
				<div class="qtm-theme-swatch" style="background: <?php echo esc_attr( $t['arabic_bg'] ); ?>;"></div>
				<div class="qtm-theme-swatch" style="background: <?php echo esc_attr( $t['trans_bg'] ); ?>;"></div>
			</div>
		</label>
	<?php endforeach; ?>
	</div>
	<p style="margin-top:8px;font-size:12px;color:#6b7280;">Choisir un thème applique automatiquement ses couleurs dans les champs ci‑dessous (modifiables ensuite manuellement).</p>
</td>

</tr>

<tr valign="top">

<th scope="row" id="thadminquran">Color title</th>
<td>
Text : <input name="option[text_quran_title]" id="text_quran_title" class="color" value="<?php echo get_option('text_quran_title'); ?>" />
Background : <input name="option[background_quran_title]" id="background_quran_title" class="color" value="<?php echo get_option('background_quran_title'); ?>" />

</td>

</tr>



<tr valign="top">

<th scope="row" id="thadminquran">Color number</th>

<td>Num :<input name="option[color_quran_number]" id="color_quran_number" class="color" value="<?php echo get_option('color_quran_number'); ?>" />

Background : <input name="option[background_quran_number]" id="background_quran_number" class="color" value="<?php echo get_option('background_quran_number'); ?>" />

</td>

</tr>



<tr valign="top">

<th scope="row" id="thadminquran">Color translate</th>

<td>Text : <input name="option[text_quran_trans]" id="text_quran_trans" class="color" value="<?php echo get_option('text_quran_trans'); ?>" />

Background : <input name="option[background_quran_trans]" id="background_quran_trans" class="color" value="<?php echo get_option('background_quran_trans'); ?>" />

</td>

</tr>



<tr valign="top">

<th scope="row" id="thadminquran">Color arabic</th>

<td>Text : <input name="option[text_quran_arabic]" id="text_quran_arabic" class="color" value="<?php echo get_option('text_quran_arabic'); ?>" />

Background : <input name="option[background_quran_arabic]" id="background_quran_arabic" class="color" value="<?php echo get_option('background_quran_arabic'); ?>" />

</td>

</tr>

<tr valign="top">

<th scope="row" id="thadminquran">Custum CSS</th>

<td>without the tag &lt;style&gt;...&lt;/style&gt;<button id="quran_custum_css"> Click Here</button>
<p><textarea  name="option[quran_custum_css]" id="areacsscustum" style="width: 500px; height: 150px;display:none">
<?php echo get_option('quran_custum_css'); ?>
</textarea></p>

</td>

</tr>

</table>

<script>
jQuery(document).ready(function($){
	$("#quran_custum_css").click(function(){
		$("#areacsscustum").toggle();
		return false;
	});

	$( "input[name='submit']").val("Save");

	$('.qtm-theme-card').on('click', function(e){
		e.preventDefault();
		var $card = $(this);
		var key = $card.data('theme-key');
		$('.qtm-theme-card').removeClass('qtm-theme-card-selected');
		$card.addClass('qtm-theme-card-selected');
		$('#quran_color_theme').val(key);
		$('#background_quran_title').val($card.data('title-bg') || '');
		$('#text_quran_title').val($card.data('title-text') || '');
		$('#background_quran_arabic').val($card.data('arabic-bg') || '');
		$('#text_quran_arabic').val($card.data('arabic-text') || '');
		$('#background_quran_trans').val($card.data('trans-bg') || '');
		$('#text_quran_trans').val($card.data('trans-text') || '');
		$('#background_quran_number').val($card.data('badge-bg') || '');
		$('#color_quran_number').val($card.data('badge-text') || '');
		if (typeof jscolor !== 'undefined') {
			jscolor.installByClassName('color');
		}
	});
});
</script>


<div id="button_quran_submit">

<div style="float:right">

</div>


		<input  type="hidden" name="template_quran_noncename" value="<?= wp_create_nonce('tplquran');?>">

		<p class="submit"> 

		<input type="submit" name="template_quran_update" class="button-primary autowidth" value="Save">

		</p>

</form>
 <fieldset style="border: 1px solid #e5e7eb;padding: 18px 20px;border-radius:10px;background:#f9fafb;margin-top:10px;" id="button_quran_submit">
  <legend style="font-weight:600;color:#111827;">Support this Quran extension</legend>
  <p style="margin:6px 0;color:#374151;font-size:13px;">
    If this extension benefits you, please remember <strong>Bahmed K.</strong> in your du&#39;as and consider supporting its maintenance and future improvements.
  </p>
  <p style="margin:6px 0 10px;color:#4b5563;font-size:13px;">
    You can send a donation to the following wallet address:
  </p>
  <div style="margin:8px 0;display:flex;align-items:center;gap:8px;">
    <div id="qtm_donate_address" style="flex:0 0 auto;max-width:420px;padding:10px 12px;border-radius:8px;background:#0f172a;color:#e5f2ff;font-family:monospace;font-size:12px;word-break:break-all;">
      0x2D7e90f0f8825e82278Fb0Fbe6D616DED86B43C6
    </div>
    <button type="button" id="qtm_copy_donate_address" class="button button-secondary" style="flex-shrink:0;display:inline-flex;align-items:center;gap:4px;">
      <span class="dashicons dashicons-admin-page"></span>
      Copy
    </button>
  </div>
  <p style="margin:6px 0;color:#6b7280;font-size:12px;">
    May Allah accept your du&#39;as and make this project a continuous charity (sadaqah jariyah) for all who benefit from it.
  </p>
 </fieldset>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var btn = document.getElementById('qtm_copy_donate_address');
  var box = document.getElementById('qtm_donate_address');
  if (!btn || !box) return;
  btn.addEventListener('click', function () {
    var text = box.textContent.trim();
    if (!text) return;
    if (navigator.clipboard && navigator.clipboard.writeText) {
      navigator.clipboard.writeText(text).then(function () {
        btn.textContent = 'Copied!';
        setTimeout(function () { btn.textContent = 'Copy'; }, 1500);
      });
    } else {
      var tmp = document.createElement('textarea');
      tmp.value = text;
      document.body.appendChild(tmp);
      tmp.select();
      try { document.execCommand('copy'); } catch (e) {}
      document.body.removeChild(tmp);
      btn.textContent = 'Copied!';
      setTimeout(function () { btn.textContent = 'Copy'; }, 1500);
    }
  });
});
</script>
<?php
