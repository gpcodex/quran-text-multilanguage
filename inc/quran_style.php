<?php
defined( 'ABSPATH' ) || die( 'Salem aleykoum!' );
if ( ! defined( 'REST_REQUEST' ) ) {
?>
<style>
/* Quran plugin – scoped under #template_quran to avoid theme overrides */
#template_quran {
	--quran-radius: 10px;
	--quran-shadow: 0 2px 12px rgba(0,0,0,0.08);
	--quran-transition: 0.2s ease;
}
/* Cadre décoratif désactivé - design épuré */
#template_quran .top_template, #template_quran .bottom_template, #template_quran .left_template, #template_quran .right_template,
#template_quran .h-g_template, #template_quran .h-d_template, #template_quran .b-g_template, #template_quran .b-d_template {
	display: none !important;
}
#template_quran { margin-top: 0 !important; }

@media only screen and (max-width: 768px) {
/* ========== MOBILE RESPONSIVE - Refonte complète ========== */
#template_quran { padding: 24px 8px 30px !important; width: 100% !important; box-sizing: border-box !important; }
#template_quran #quran_main { width: 100% !important; padding: 0 4px !important; margin-top: 0 !important; box-sizing: border-box !important; }
#template_quran #result { margin-top: 12px !important; }

/* Selects principaux - responsive, pleine largeur, empilés */
#template_quran #quran_main { flex-direction: column !important; align-items: stretch !important; }
#template_quran #kb_select_quran, #template_quran #kb_select_language { flex: 0 0 100% !important; width: 100% !important; max-width: 100% !important; float: none !important; display: block !important; margin-bottom: 14px !important; box-sizing: border-box !important; }
#template_quran #kb_select_quran { margin-top: 24px !important; }
#template_quran #kb_select_language { margin-top: 4px !important; }
#template_quran #kb_select_quran form, #template_quran #kb_select_language form { width: 100% !important; max-width: 100% !important; }
#template_quran .quran-select { max-width: 100% !important; width: 100% !important; margin-bottom: 8px !important; box-sizing: border-box !important; font-size: 16px !important; }
#template_quran .aya1 { width: 100% !important; margin-bottom: 12px !important; background: transparent !important; font-size: 15px !important; }
#template_quran #select_languages { width: 100% !important; max-width: 100% !important; margin: 0 0 16px !important; float: none !important; }

/* Bloc sourate + flèches - responsive, centré (titre + flèches en bloc au centre) */
/* Même espace à gauche qu'à droite (place du bouton) pour que le titre reste au centre de l'écran */
#template_quran #bloc_top_quran { position: relative !important; display: flex !important; flex-wrap: wrap !important; justify-content: center !important; align-items: center !important; align-content: center !important; gap: 10px !important; padding: 10px 44px !important; width: 100% !important; box-sizing: border-box !important; }
#template_quran #bloc_name_sura { width: auto !important; max-width: 100% !important; display: flex !important; flex-wrap: nowrap !important; justify-content: center !important; align-items: center !important; gap: 8px !important; min-width: 0 !important; box-sizing: border-box !important; margin: 0 auto !important; }
#template_quran #block_prev, #template_quran #block_next { display: inline-flex !important; align-items: center !important; flex-shrink: 0 !important; }
#template_quran #PrevSourate, #template_quran #NextSourate { width: 28px !important; height: 28px !important; min-width: 28px !important; min-height: 28px !important; opacity: 1 !important; font-size: 0.6rem !important; }
#template_quran #sourateName { font-size: clamp(16px, 5vw, 20px) !important; font-weight: 600 !important; padding: 6px 8px !important; flex: 0 1 auto !important; min-width: 0 !important; text-align: center !important; word-break: break-word !important; line-height: 1.3 !important; }
#template_quran .suraName { padding: 10px 6px !important; }
#template_quran .download_kb, #template_quran .setting_kb { display: none !important; }
/* Bouton lecture hors flux : à droite, plus petit, titre + flèches restent centrés */
#template_quran .playsura_kb { position: absolute !important; right: 8px !important; top: 50% !important; transform: translateY(-50%) !important; left: auto !important; margin: 0 !important; width: 28px !important; height: 28px !important; }
#template_quran .playsura_kb svg { width: 14px !important; height: 14px !important; }

/* Panneaux params - empilage vertical quand ouverts (ne pas forcer display: block, ils restent display:none par défaut) */
#template_quran .params_kb, #template_quran .params1_kb, #template_quran .params_download_kb {
	width: 100% !important; max-width: 100% !important;
	padding: 16px !important; margin: 12px 0 !important; box-sizing: border-box !important;
	min-height: auto !important; height: auto !important; overflow: visible !important;
}
#template_quran .params_kb { clear: both !important; }
#template_quran .params_kb-steps { flex-direction: column !important; align-items: stretch !important; gap: 12px !important; }
#template_quran .params_kb-step { width: 100% !important; }
#template_quran .params_kb-arrow { transform: rotate(90deg); align-self: center !important; }
#template_quran #recitator_kb, #template_quran #recitator2_kb, #template_quran #select_aya { width: 100% !important; position: static !important; float: none !important; margin: 0 !important; }
#template_quran .params_kb form, #template_quran .params1_kb form { width: 100% !important; }
#template_quran .params_kb select, #template_quran .params1_kb select, #template_quran .params_download_kb select {
	width: 100% !important; max-width: 100% !important;
	display: block !important; margin-bottom: 10px !important; box-sizing: border-box !important;
	min-height: 44px !important; font-size: 15px !important;
}
#template_quran .params_kb-step-fields { flex-direction: column !important; }
#template_quran .params_kb-step-format-row { flex-direction: row !important; flex-wrap: wrap !important; }
#template_quran .params_kb #kb-select_debut, #template_quran .params_kb #kb-select_fin { width: 100% !important; min-width: 0 !important; }
#template_quran .params_kb #kb-select_text { flex: 1 1 auto !important; min-width: 0 !important; }
#template_quran .params_kb-play-btn, #template_quran .params_kb #play_select_quran { margin-left: 0 !important; margin-top: 8px !important; }
#template_quran #play_select_quran { display: inline-block !important; width: 40px !important; height: 40px !important; margin-left: 0 !important; margin-top: 8px !important; }
#template_quran #playeraya, #template_quran #playeraya2 { margin-top: 12px !important; }
#template_quran #playeraya audio, #template_quran #playeraya2 audio { width: 100% !important; max-width: 100% !important; }
#template_quran .params1_kb { min-height: auto !important; height: auto !important; padding: 16px !important; }
#template_quran #recitator_download_kb { width: 100% !important; }
#template_quran #recitator_download_kb select { width: 100% !important; }
#template_quran #name_recitator, #template_quran #dl_count_kb { width: 100% !important; }

/* Séparation panneau / versets - évite tout chevauchement */
#template_quran .suraName { overflow: visible !important; margin-bottom: 20px !important; }
#template_quran .params_kb + ol, #template_quran .params1_kb + ol { margin-top: 8px !important; }

/* Versets - lisibilité */
#template_quran .aya { margin-bottom: 2px !important; }
/* Indicateur lecture params : trait vert en bas du verset en cours uniquement */
#template_quran .aya.quran-verse-playing { border-bottom: 3px solid #22c55e !important; }
#template_quran .quran, #template_quran .trans { padding: 14px 12px !important; font-size: 1.05rem !important; line-height: 1.6 !important; }
#template_quran .quran { font-size: clamp(18px, 5vw, 24px) !important; }
#template_quran .kb-verse-play { margin-right: 3px !important; }
#template_quran .kb-verse-play svg { width: 9px !important; height: 9px !important; }
#template_quran .suraName { padding: 10px 6px !important; overflow: visible !important; margin-bottom: 20px !important; }
/* Espace net entre panneau params et premier verset */
#template_quran #result .suraName + ol,
#template_quran #result .suraName + * + .aya { margin-top: 4px !important; }

/* Utilitaires */
#template_quran #recitator_quran { margin-top: 0 !important; }
#template_quran .lcs_label { display: none !important; }
#template_quran .lcs_cursor { height: 18px !important; }
#template_quran #dl_sura { display: none !important; }
#template_quran #autoplay_quran { display: none !important; }
#template_quran #pause_quran, #template_quran #play_quran { display: none !important; }
/*FIN CSS MOBILE */
}
/* Petit indicateur play sur le badge verset (remplace l’icône speaker) */
#template_quran .kb-verse-play { display: inline-flex !important; align-items: center !important; margin-right: 4px !important; vertical-align: middle !important; opacity: 0.85; }
#template_quran .kb-verse-play svg { width: 10px !important; height: 10px !important; fill: currentColor !important; flex-shrink: 0 !important; }
#template_quran .sm2_link { cursor: pointer !important; text-decoration: none !important; }
#template_quran .sm2_link .quranbadge { display: inline-flex !important; align-items: center !important; padding: 3px 5px !important; font-size: 12px !important; }
#template_quran .sm2_link:hover .kb-verse-play { opacity: 1; }
#template_quran #pause_quran{display:none;position:absolute;margin-left: auto;margin-right: auto;left: 0;right: 0;width: 30px;margin-top: 25px;cursor:pointer;}
#template_quran #play_quran{display:none;position:absolute;margin-left: auto;margin-right: auto;left: 0;right: 0;width: 30px;margin-top: 25px;cursor:pointer;}

#template_quran #bloc_top_quran{width: 100%;display:flex;align-items:center;}
#template_quran #bloc_name_sura{display:flex;align-items:center;justify-content:center;gap:10px;}
#template_quran #sourateName{line-height:1.25;display:inline-flex;align-items:center;}
#template_quran #block_prev,#template_quran #block_next{align-self:center;}
#template_quran #li_quran{
	list-style-type: none;
}

#template_quran #select_name_recitator{
color:#000 !important;
width:70%;
}

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

#template_quran .quran {font-family:<?=get_option('quran_arabicfont');?> !important;word-spacing:<?=get_option('quran_wordspacing');?>px;}

<?php echo get_option('quran_custum_css'); ?>

#template_quran #change_sura_child ul{ margin:0 !important;}
#template_quran #select_language_child ul{ margin:0 !important;}
	#template_quran .suraName {
		border-bottom: 1px solid #<?php echo ltrim(get_option('background_quran_title'), '#'); ?>;text-align: center; font-size: 20px; font-weight: 600; letter-spacing: 0.02em; padding: 14px 16px; background-color: #<?php echo ltrim(get_option('background_quran_title'), '#'); ?>; margin-top: 10px; color:#<?php echo ltrim(get_option('text_quran_title'), '#'); ?>; border-radius: 8px 8px 0 0; box-shadow: 0 1px 3px rgba(0,0,0,0.06); transition: box-shadow 0.2s ease;}


#template_quran #li_quran {
    display:none;
}
	#template_quran .aya {margin:auto;border: 0; transition: background-color 0.2s ease, border-color 0.2s ease;}
	/* Couleur de fond du bloc verset en mode clair : suit la couleur de traduction choisie dans l’admin */
	#template_quran:not(.quran-dark-mode) .aya {
		background-color: #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;
		border: 1px solid #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;
	}
	#template_quran .aya:hover { background-color: #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>; }



	#template_quran .aya2 {font-size:16px;color:#797979;}



	#template_quran .aya1 {margin-top:20px;font-size:1.27em;}	

	#template_quran #change_sura_msdd{width:100% !important;}

	#template_quran #select_language_msdd{width:100% !important;}
    

	#template_quran .quran {line-height: 1.7em; padding: 10px;color:#<?php echo ltrim(get_option('text_quran_arabic'), '#'); ?>;border-right: 1px solid #<?php echo ltrim(get_option('background_quran_arabic'), '#'); ?>;border-left: 1px solid #<?php echo ltrim(get_option('background_quran_arabic'), '#'); ?>; font-size: 28px; direction: rtl;background-color:#<?php  echo ltrim(get_option('background_quran_arabic'), '#'); ?>}



	#template_quran .trans { padding:10px;font-family: Calibri;text-align:justify;border-right: 1px solid #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;border-left: 1px solid #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;border-bottom: 1px solid #<?php echo ltrim(get_option('background_quran_trans'), '#');?>;border-top: 1px solid #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>; color:#<?php echo ltrim(get_option('text_quran_trans'), '#'); ?>;font-size: 16px; background-color: #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;}



	#template_quran .tabSura{position:relative;width:auto;}



	#template_quran .ayaNum{color:#<?php echo ltrim(get_option('color_quran_number'), '#'); ?>;background-color:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?>}

	/* Indicateur lecture params : trait vert en bas du verset en cours (tous écrans) */
	#template_quran .aya.quran-verse-playing {
		border-bottom-width: 4px !important;
		border-bottom-style: solid !important;
		border-bottom-color: #22c55e !important;
	}

	#template_quran{
		position:relative;
		padding:0 12px 50px;
		width:100%;
		max-width:100%;
		margin:0 0 50px;
		box-sizing:border-box;
	}

	/* Contour décoratif masqué pour un rendu moderne sans bordure */
	#template_quran .h-g_template, #template_quran .h-d_template, #template_quran .top_template, #template_quran .bottom_template,
	#template_quran .left_template, #template_quran .right_template, #template_quran .b-g_template, #template_quran .b-d_template {
		display:none !important;
	}



	#template_quran .top_template{


		position:absolute;top:0;left:0;width:100%;height:50px;



		margin-top:-50px;



		background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/top.png) repeat-x center top;



		background-size: 50px 50px;



	}	



	#template_quran .bottom_template{



		position:absolute;bottom:0;left:0;width:100%;height:50px;



		margin-bottom:-50px;



		background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/bottom.png) repeat-x center top;



		background-size: 50px 50px;



	}



	#template_quran .h-g_template{position:absolute;top:0;left:0;width:50px;height:50px;


				margin-top:-50px;

				margin-left:-50px;

				background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/h-g.png) repeat-x left top;

				background-size: 50px 50px;


				}



	#template_quran .h-d_template{position:absolute;top:0;right:0;width:50px;height:50px;



				margin-top:-50px;



				margin-right:-50px;



				background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/h-d.png) repeat-x right top;



				background-size: 50px 50px;



				}	



	#template_quran .b-g_template{position:absolute;bottom:0;left:0;width:50px;height:50px;



				margin-bottom:-50px;



				margin-left:-50px;



				background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/b-g.png) repeat-x left top;



				background-size: 50px 50px;



				}



	#template_quran .b-d_template{position:absolute;bottom:0;right:0;width:50px;height:50px;



				margin-bottom:-50px;



				margin-right:-50px;



				background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/b-d.png) repeat-x right top;



				background-size: 50px 50px;



				}	



		



	#template_quran .left_template{position:absolute;top:0;left:0;width:50px;height:100%;margin-left:-50px;


					background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/left.png) repeat-y left top;

					background-size: 50px 50px;



	}



	#template_quran .right_template{position:absolute;top:0;right:0;width:50px;height:100%;margin-right:-50px;
					background:url(<?php echo plugin_dir_url(__FILE__); ?>templates/<?php echo get_option('template_quran');?>/right.png) repeat-y right top;
					background-size: 50px 50px;

	}



	#template_quran #quran_main{width:100%;max-width:100%;position:relative;margin:0;padding:12px;box-sizing:border-box;}



	#template_quran #select_languages{font-size:1.27em;margin-top: 20px;color:#797979;float:right;width:100%;}


	#template_quran #audio_sura { width: 100%;margin-top:10px;margin:5px auto;}

	#template_quran #audio_sura #kb-idaudio{
		width: 80%;
		margin-top: 15px;
		-webkit-transition:all 0.5s linear;
		-moz-transition:all 0.5s linear;
		-o-transition:all 0.5s linear;
		transition:all 0.5s linear;
		-moz-border-radius:7px 7px 7px 7px ;
		-webkit-border-radius:7px 7px 7px 7px ;
		border-radius:7px 7px 7px 7px ;	
		
	}
	#template_quran #audio_sura #kb-idaudio2{
		width: 80%;
		-webkit-transition:all 0.5s linear;
		-moz-transition:all 0.5s linear;
		-o-transition:all 0.5s linear;
		transition:all 0.5s linear;
		-moz-border-radius:7px 7px 7px 7px ;
		-webkit-border-radius:7px 7px 7px 7px ;
		border-radius:7px 7px 7px 7px ;	
		
	}


	/* Badges versets - style pro neutre */
	#template_quran .quranbadge{font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,sans-serif;float:right;margin-left:8px;padding:4px 6px;font-size:13px;font-weight:600;white-space:nowrap;border-radius:6px;transition:transform 0.2s ease,box-shadow 0.2s ease;border:1px solid rgba(0,0,0,0.08);}
	#template_quran .quranbadge:hover{transform:scale(1.02);}
	/* Badge numéro de verset – suit les couleurs de numéro choisies dans l’admin */
	#template_quran .quranbadge-info{
		background:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?> !important;
		color:#<?php echo ltrim(get_option('color_quran_number'), '#'); ?> !important;
		border-color:rgba(0,0,0,0.08) !important;
		box-shadow:0 1px 2px rgba(0,0,0,0.04) !important;
	}


/* Choose Sura + Choose Language : même largeur, alignés */
/* Ligne unique Choose Sura + Choose Language : 50/50, alignés */
#template_quran #quran_main{display:flex;flex-wrap:wrap;gap:12px;align-items:stretch;}
#template_quran #kb_select_quran,#template_quran #kb_select_language{
	flex:0 0 calc(50% - 6px);
	box-sizing:border-box;
	display:flex;
	flex-direction:column;
	min-width:0;
}
#template_quran #kb_select_quran form.aya1,#template_quran #kb_select_quran .aya1,
#template_quran #kb_select_language #select_languages{
	margin:0 !important;
	padding:0 !important;
	float:none !important;
	flex:1;
	display:flex;
	flex-direction:column;
	min-width:0;
}
#template_quran #kb_select_quran .quran-select,#template_quran #kb_select_language .quran-select{width:100% !important;max-width:none !important;box-sizing:border-box;}
#template_quran #result{flex-basis:100%;width:100%;min-width:0;}
/* === Selects natifs - design moderne 2025 === */
#template_quran .quran-select {
	width: 100%;
	max-width: 280px;
	padding: 12px 40px 12px 16px;
	font-size: 15px;
	font-weight: 500;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
	color: #<?php echo ltrim(get_option('text_quran_trans'), '#'); ?>;
	background: #<?php echo ltrim(get_option('background_quran_trans'), '#'); ?>;
	border: 1px solid #<?php echo ltrim(get_option('background_quran_number'), '#'); ?>;
	border-radius: 12px;
	box-shadow: 0 1px 3px rgba(0,0,0,0.04);
	transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease, color 0.2s ease;
	appearance: none;
	background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23666' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
	background-repeat: no-repeat;
	background-position: right 14px center;
	cursor: pointer;
}
#template_quran .quran-select:hover {
	border-color: #<?php echo ltrim(get_option('background_quran_title'), '#'); ?>;
	box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
#template_quran .quran-select:focus {
	outline: none;
	border-color: #<?php echo ltrim(get_option('background_quran_title'), '#'); ?>;
	box-shadow: 0 0 0 3px rgba(0,0,0,0.08);
}
#template_quran.quran-dark-mode .quran-select {
	background-color: #252830;
	color: #e8eaed;
	border-color: rgba(255,255,255,0.15);
	background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239aa0a6' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
}

/* Ancien msdropdown - gardé pour compatibilité si chargé */
#template_quran .ddcommon,
#template_quran .dd {
	border: 1px solid rgba(0,0,0,0.12) !important;
	border-radius: 12px !important;
	background: rgba(255,255,255,0.9) !important;
	box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
	transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
}
#template_quran .ddcommon:hover,
#template_quran .dd:hover {
	border-color: rgba(0,0,0,0.2) !important;
	box-shadow: 0 2px 8px rgba(0,0,0,0.06) !important;
}
#template_quran .dd .ddTitle,
#template_quran .ddcommon .ddTitle {
	background: transparent !important;
	color: #1a1a1a !important;
	border-radius: 12px !important;
	padding: 12px 40px 12px 16px !important;
	font-size: 15px !important;
	font-weight: 500 !important;
	font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
}
#template_quran .dd .ddChild,
#template_quran .ddcommon .ddChild {
	border: 1px solid rgba(0,0,0,0.1) !important;
	border-radius: 12px !important;
	box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
	margin-top: 4px !important;
	overflow: hidden !important;
}
#template_quran .dd .ddChild li,
#template_quran .ddcommon .ddChild li {
	padding: 12px 16px !important;
	border: none !important;
	transition: background 0.15s ease !important;
}
#template_quran .dd .ddChild li.hover,
#template_quran .ddcommon .ddChild li:hover {
	background: rgba(0,0,0,0.04) !important;
}
#template_quran.quran-dark-mode .ddcommon,
#template_quran.quran-dark-mode .dd { border-color: rgba(255,255,255,0.15) !important; background: rgba(255,255,255,0.06) !important; }
#template_quran.quran-dark-mode .dd .ddTitle { color: #e8eaed !important; }
#template_quran.quran-dark-mode .dd .ddChild { background: #252830 !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .dd .ddChild li { border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .dd .ddChild li:hover { background: rgba(255,255,255,0.06) !important; }
/* Flèche moderne CSS - remplace le gif */
#template_quran .dd .ddArrow,
#template_quran .ddcommon .ddArrow {
	width: 10px !important; height: 10px !important;
	margin-top: -5px !important;
	background: none !important;
	border: none !important;
	border-right: 2px solid rgba(0,0,0,0.5) !important;
	border-bottom: 2px solid rgba(0,0,0,0.5) !important;
	transform: rotate(45deg) !important;
	right: 16px !important;
}
#template_quran.quran-dark-mode .dd .ddArrow,
#template_quran.quran-dark-mode .ddcommon .ddArrow {
	border-color: rgba(255,255,255,0.6) !important;
}
#template_quran .dd .ddArrow{width:16px;height:16px; margin-top:-8px; background:url(<?php echo plugin_dir_url(__FILE__); ?>skin1/dd_arrow.gif) no-repeat;}


#template_quran #autoplay_quran{width: 25%;float:left;}
/*fixed width: 30%;*/
#template_quran #bloc_name_sura{width:55%;margin:0 auto;min-height:36px;}
/*fixed width: 30%;*/
#template_quran #dl_sura{cursor:pointer;}
#template_quran .dl_sourate{width:20%;float:left;}
#template_quran .ddlabel{font-size:18px}

/* === Boutons style 2025 - design moderne (taille réduite) === */
#template_quran .download_kb,#template_quran .setting_kb,#template_quran .playsura_kb{
display:flex;align-items:center;justify-content:center;
padding:0;border:none;border-radius:10px;width:36px;height:36px;
position:absolute;cursor:pointer;
transition:transform 0.15s ease,background 0.15s ease,box-shadow 0.15s ease;
box-shadow:0 1px 2px rgba(0,0,0,0.06);
}
#template_quran .download_kb svg,#template_quran .playsura_kb svg,#template_quran .setting_kb svg{
width:18px;height:18px;flex-shrink:0;
}
#template_quran .setting_kb svg{width:18px;height:18px;}
/* Boutons principaux – suivent les couleurs de numéro (thème) en mode clair */
#template_quran .download_kb,#template_quran .playsura_kb,#template_quran .setting_kb{
	color:#<?php echo ltrim(get_option('color_quran_number'), '#'); ?>;
	background:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?>;
}
#template_quran .download_kb{right:110px;}
#template_quran .playsura_kb{right:62px;}
#template_quran .setting_kb{right:18px;}
#template_quran .download_kb:hover,
#template_quran .playsura_kb:hover,
#template_quran .setting_kb:hover{
	background:#<?php echo ltrim(get_option('background_quran_title'), '#'); ?>;
	box-shadow:0 2px 6px rgba(0,0,0,0.1);
	transform:translateY(-1px);
}
#template_quran .params_kb,#template_quran .params1_kb,#template_quran .params_download_kb{
display:none;width:95%;margin:20px auto;border-radius:14px;
box-shadow:0 4px 20px rgba(0,0,0,0.08);
transition:opacity 0.25s ease;
background:#<?php echo ltrim(get_option('background_quran_title'), '#'); ?>;
}
#template_quran .params_kb{height:auto;min-height:88px;}
#template_quran .params1_kb{width:90%;min-height:72px;}
#template_quran .params_download_kb{min-height:72px;}
#template_quran .params_kb .quran-panel-title,#template_quran .params1_kb .quran-panel-title,#template_quran .params_download_kb .quran-panel-title{
font-size:13px;font-weight:600;color:#<?php echo ltrim(get_option('text_quran_title'), '#'); ?>;margin-bottom:12px;text-transform:uppercase;letter-spacing:0.05em;
}
#template_quran .quran-panel-subtitle{
	font-size:13px;
	color:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?>;
}
/* Panneau params – flux en étapes avec flèches */
#template_quran .params_kb-steps{display:flex;flex-wrap:wrap;align-items:flex-end;justify-content:space-between;gap:8px 8px;width:100%;}
#template_quran .params_kb-step{display:flex;flex-direction:column;gap:6px;min-width:0;flex:1 1 0;}
#template_quran .params_kb-step-label{font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?>;}
#template_quran .params_kb-arrow{display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;color:#<?php echo ltrim(get_option('background_quran_number'), '#'); ?>;}
#template_quran .params_kb-arrow svg{width:18px;height:18px;}
#template_quran .params_kb-step-fields{display:flex;flex-wrap:wrap;align-items:center;gap:8px;}
#template_quran .params_kb-step-fields select{flex:1 1 0;min-width:0;}
#template_quran .params_kb #kb-select_debut,#template_quran .params_kb #kb-select_fin{flex:1 1 0;min-width:60px;}
#template_quran .params_kb #kb-select_text{flex:1 1 0;min-width:120px;}
#template_quran .params_kb-step-format-row{flex-wrap:nowrap;}
#template_quran .params_kb-play-btn{width:25px;height:25px;margin-left:4px;cursor:pointer;vertical-align:middle;flex-shrink:0;}
#template_quran #recitator_kb form,#template_quran .params_kb-step-format .params_kb-step-fields{display:flex;width:100%;}
#template_quran #recitator_kb select{width:100%;}
#template_quran .params_kb-step-format .params_kb-step-fields select{flex:1 1 0;min-width:0;}
#template_quran .params_kb select,#template_quran .params1_kb select,#template_quran .params_download_kb select{
appearance:none;-webkit-appearance:none;-moz-appearance:none;
padding:10px 36px 10px 14px;border-radius:10px;border:1px solid #d1d5db;
background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236b7280' d='M6 8L1 3h10z'/%3E%3C/svg%3E") no-repeat right 12px center;
font-size:14px;font-weight:500;color:#1f2937;cursor:pointer;transition:border-color 0.2s,box-shadow 0.2s;
}
#template_quran .params_kb select:hover,#template_quran .params1_kb select:hover,#template_quran .params_download_kb select:hover{
border-color:#9ca3af;
}
#template_quran .params_kb select:focus,#template_quran .params1_kb select:focus,#template_quran .params_download_kb select:focus{
outline:none;border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,0.2);
}
#template_quran #recitator2_kb{float:left;width:50%;}
#template_quran #play_select_quran,#template_quran .params_kb-play-btn{cursor:pointer;}
#template_quran #play_select_quran{display:none;}
#template_quran #quran_player_sura{width:90%;margin: 0 auto;}
#template_quran #playeraya{display:block;}
#template_quran #suraplayer{display:none !important;}
#template_quran #saveposition_kb{
color: #fff;
background-color: #337ab7;
border-color: #2e6da4;
padding: 4px 12px;
margin-bottom: 0;
font-size: 14px;
font-weight: 400;
line-height: 1.42857143;
text-align: center;
white-space: nowrap;
vertical-align: middle;
-ms-touch-action: manipulation;
touch-action: manipulation;
cursor: pointer;
-webkit-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
background-image: none;
border: 1px solid transparent;
border-radius: 4px;
}
#template_quran #savemail_kb{width:37%;}
#template_quran #savemail_kb input[type="text"]{width:63%;}
#template_quran #formsave_kb{margin-bottom: 10px;}
#template_quran #kb-idaudio2{width:40% !important;}
#template_quran .params_download_kb{width:90%;height:50px;}
#template_quran #dl_count_kb{display:none;}
#template_quran #kb-select_debut, #template_quran #kb-select_fin, #template_quran #kb-select_text, #template_quran #select_name_recitator{min-height:44px !important;height:44px !important;display:inline-block;font-size:16px !important;padding:8px 36px 8px 14px !important;box-sizing:border-box !important;}
#template_quran #kb-select_debut{min-width:80px;width:auto;}
#template_quran #kb-select_fin{min-width:70px;width:auto;}
#template_quran #kb-select_text{min-width:160px;width:auto;}
#template_quran #click_download_kb{width:36px;height:36px;}
#template_quran #click_playsura_kb{width:36px;height:36px;}
#template_quran #click_params_kb{width:36px;height:36px;}
/* Flèches Prev/Next - style light mode (bouton discret, pas carré blanc) */
#template_quran .quran-nav-arrow,
#template_quran #PrevSourate,
#template_quran #NextSourate {
	display: inline-flex !important; align-items: center !important; justify-content: center !important;
	font-size: 0.6rem !important;
	background: #<?php echo ltrim(get_option('background_quran_number'), '#'); ?> !important;
	color: #<?php echo ltrim(get_option('color_quran_number'), '#'); ?> !important;
	fill: currentColor !important;
	border: 1px solid rgba(0,0,0,0.1) !important; border-radius: 10px !important;
	box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
	transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease !important;
}
#template_quran .quran-nav-arrow:hover,
#template_quran #PrevSourate:hover,
#template_quran #NextSourate:hover {
	background: #<?php echo ltrim(get_option('background_quran_title'), '#'); ?> !important;
	color: #<?php echo ltrim(get_option('text_quran_title'), '#'); ?> !important;
	border-color: rgba(0,0,0,0.15) !important;
}
#template_quran .sm2_link{line-height: 1em;}
#template_quran #select_name_recitatorkb{width:155px;min-height:44px;height:44px;padding:10px 36px 10px 14px;box-sizing:border-box;}
#template_quran #select_name_recitator2{
	min-height:44px;height:44px;padding:10px 36px 10px 14px;box-sizing:border-box;
}

<?php if ( get_option('quran_dark_mode') === 'yes' ) : ?>
/* Dark mode overrides */
#template_quran.quran-dark-mode { background: #1a1d24; padding: 12px; border-radius: var(--quran-radius); }
#template_quran.quran-dark-mode .suraName { background-color: #252830 !important; color: #e8eaed !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .aya { background-color: #252830 !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .aya.quran-verse-playing { border-bottom: 3px solid #4ade80 !important; }
#template_quran.quran-dark-mode .quran { background-color: #2d3139 !important; color: #e8eaed !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .trans { background-color: #252830 !important; color: #c4c8cc !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .quranbadge-info { background: #334155 !important; color: #e2e8f0 !important; border-color: rgba(255,255,255,0.15) !important; }
#template_quran.quran-dark-mode .params_kb,
#template_quran.quran-dark-mode .params1_kb,
#template_quran.quran-dark-mode .params_download_kb { background: #252830 !important; border-color: #3a3f4a !important; }
#template_quran.quran-dark-mode .aya1 { background: #252830 !important; }
#template_quran.quran-dark-mode .aya2 { color: #9aa0a6 !important; }
#template_quran.quran-dark-mode .download_kb,
#template_quran.quran-dark-mode .playsura_kb,
#template_quran.quran-dark-mode .setting_kb { background: rgba(255,255,255,0.15) !important; border: 1px solid rgba(255,255,255,0.3) !important; color: #e8eaed !important; }
#template_quran.quran-dark-mode .download_kb:hover,
#template_quran.quran-dark-mode .playsura_kb:hover,
#template_quran.quran-dark-mode .setting_kb:hover { background: rgba(255,255,255,0.25) !important; }
#template_quran.quran-dark-mode #select_name_recitator,
#template_quran.quran-dark-mode #select_name_recitator2 { color: #fff !important; }
#template_quran.quran-dark-mode select { background: #2d3139 !important; color: #e8eaed !important; border: 1px solid rgba(255,255,255,0.2) !important; }
#template_quran.quran-dark-mode .params_kb select,
#template_quran.quran-dark-mode .params1_kb select,
#template_quran.quran-dark-mode .params_download_kb select { background: #2d3139 !important; color: #fff !important; border-color: rgba(255,255,255,0.25) !important; }
#template_quran.quran-dark-mode .params_kb-step-label { color: #94a3b8 !important; }
#template_quran.quran-dark-mode .params_kb-arrow { color: #64748b !important; }
/* Flèches Prev/Next - dark mode (plus de carré blanc) */
#template_quran.quran-dark-mode .quran-nav-arrow,
#template_quran.quran-dark-mode #PrevSourate,
#template_quran.quran-dark-mode #NextSourate {
	font-size: 0.6rem !important;
	background: #2d3139 !important; color: #e8eaed !important; fill: currentColor !important;
	border: 1px solid rgba(255,255,255,0.2) !important;
	box-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
}
#template_quran.quran-dark-mode .quran-nav-arrow:hover,
#template_quran.quran-dark-mode #PrevSourate:hover,
#template_quran.quran-dark-mode #NextSourate:hover { background: #3a3f4a !important; color: #fff !important; border-color: rgba(255,255,255,0.3) !important; }

/* Lecteur audio - dark mode (barre et contrôles intégrés au thème, sans arrondi) */
#template_quran.quran-dark-mode #audio_sura audio,
#template_quran.quran-dark-mode #playeraya audio,
#template_quran.quran-dark-mode #playeraya2 audio,
#template_quran.quran-dark-mode #audio_sura #kb-idaudio,
#template_quran.quran-dark-mode #audio_sura #kb-idaudio2,
#template_quran.quran-dark-mode #kb-idaudio,
#template_quran.quran-dark-mode #kb-idaudio2 {
	background: #2d3139 !important; border: 1px solid rgba(255,255,255,0.2) !important;
	border-radius: 0 !important; -webkit-border-radius: 0 !important; -moz-border-radius: 0 !important;
	box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
	-moz-box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
	-webkit-box-shadow: 0 2px 8px rgba(0,0,0,0.2) !important;
}
#template_quran.quran-dark-mode #audio_sura audio::-webkit-media-controls-panel,
#template_quran.quran-dark-mode #playeraya audio::-webkit-media-controls-panel,
#template_quran.quran-dark-mode #playeraya2 audio::-webkit-media-controls-panel {
	background: #2d3139 !important; border-radius: 0 !important; -webkit-border-radius: 0 !important;
}
/* Timer et barre de progression en blanc en dark mode */
#template_quran.quran-dark-mode #audio_sura audio::-webkit-media-controls-current-time-display,
#template_quran.quran-dark-mode #audio_sura audio::-webkit-media-controls-time-remaining-display,
#template_quran.quran-dark-mode #playeraya audio::-webkit-media-controls-current-time-display,
#template_quran.quran-dark-mode #playeraya audio::-webkit-media-controls-time-remaining-display,
#template_quran.quran-dark-mode #playeraya2 audio::-webkit-media-controls-current-time-display,
#template_quran.quran-dark-mode #playeraya2 audio::-webkit-media-controls-time-remaining-display { color: #fff !important; }
#template_quran.quran-dark-mode #audio_sura audio,
#template_quran.quran-dark-mode #playeraya audio,
#template_quran.quran-dark-mode #playeraya2 audio { accent-color: #fff; }
<?php endif; ?>
</style>
<?php
}
?>


