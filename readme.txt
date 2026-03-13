=== Quran multilanguage Text & Audio ===

Contributors: karim42
Donate link: https://www.paypal.com/paypalme/gpcodex
Tags: quran, islam, muslim, audio, multilanguage
Requires at least: 3.0.1
Tested up to: 6.9.4

Stable tag: 3.0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Quran plugin with 30 languages, 32 reciters, and customizable interface.

== Description ==

- Quran Text Multilanguage translated into 30 languages. 
- Full ajax version and responsive. 
- Fully customizable from the admin area. 
- Multi recitators : 32 cheikhs 
- Download full Quran (32 cheikhs)
- Add an area for personal css
- Select verses to listen

You just have to write the shortcode [quran] on your new page.

The plugin uses mp3 files that come from https://quran.s3.fr-par.scw.cloud
These site are mine

- <a target ="_blank" href="https://gpcodex.fr">demo page</a>


Languages :

- Arabic
- English
- French
- German
- Dutch
- Russian
- Albanian
- Azerbaijani
- Bengali
- Bulgarian
- Bosnian
- Chinese
- Czech
- Indonesian
- Italian
- Kurdish
- Malay
- Norwegian
- Portuguese
- Romanian
- Somali
- Spanish
- Swedish
- Turkish
- Urdu	
- Hindi
- Persian
- Thai
- Uzbek



== Installation ==



1. (Recommanded) install the plugin from the administration.
plugin-> add new-> in "Search Plugins" tape: Quran Text and Audio Plugin
(if you manually install consider changing chmod on the ftp, otherwise you risk having errors.)

2. Activate the plugin through the 'Plugins' menu in WordPress

3. use shortcode [quran] on your new page



== Screenshots ==



1. setting quran plugin http://gp-codex.fr/admin_quran_multi.jpg

2. front http://gp-codex.fr/quran_multilanguage.jpg


== Changelog ==



= 1.0 =

* initial plugin



= 1.1.0 = 

* fix url change sura



= 1.1.1 =

* fix change css option



= 1.1.2 =

* add option admin



= 1.1.3 =

* add defaut options (languages, color)



= 1.1.4 =

add audio for all the verses with multi recitator



= 1.1.5 =

fix css quran aya



= 1.2 =

Add full sura audio



= 1.2.1 =

Fix jquery



= 1.2.2 =

* this plugin can be associated with Holy Quran random verse Multilanguage



= 1.2.3 =

Add more languages



- albanian

- azerbaijani

- bengali

- bulgarian

- chinese

- czech

- indonesian

- italian

- kurdish

- malay

- norwegian

- portuguese

- romanian

- somali

- spanish

- swedish

- turkish



= 1.2.4 =



Correction bug with default url and permalink



= 1.2.5 =



Fix error with jquery



= 1.2.6 =



Fix error with last version php



= 1.2.7 =



visitors can choose the language.

Fix background and color the number of the verse



= 1.2.8 =



Add urdu & hindi language



= 1.2.9 =


Add dutch language

1.3.0


fix css mobile Responsive


= 2.0 =


- template selection
- autoplay on pc / mac (not mobile)
- more reciter
- Fully customizable from the admin area
- Full ajax
- responsive
- news languages (Persian,Thai,Uzbek)

= 2.1 =

-add an area for personal css

= 2.2 =

- Multi recitators : 32 cheikhs 
- Download full Quran (32 cheikhs)
- Select verses to listen

= 2.2.1 =

 - Add font arabic UthmanicHafs1Ver08
 - fix style css

= 2.2.2 =

Fix error JS msdropdown

= 2.2.3 =

Fix error JS soudmanager

= 2.2.4 =

Fix conflit msdropdown with jquery

= 2.2.5 =

Update version jquery 2.2.4

= 2.3.1 =
 
 - Adaptation wordpress plugin for ajax request
 - Url for the sura with parameters
 
= 2.3.2 =

 - Adaptation wordpress plugin for curl php
 
= 2.3.3 =

 - fix click params (remplace function "live" by "on") 
 
= 2.3.4 =

 - fix css,div
 
= 2.3.5 =

 - fix url for mp3
 
= 2.3.6 =

 - fix some errors for last version wordpress

= 2.3.7 =

 - fix direction text for language urdu

 = 2.3.8 =

 - fix player audio for the latest version of wordpress
 
= 2.3.9 =

 - Mp3 on cloud
 
   = 2.3.10 =

 - Mp3 on cloud

= 2.3.11 =

 - Fix change sura after loading audio

= 2.3.12 =

 - added the possibility of changing the font for the arabic text in the admin part 
 - added the possibility to change word spacing in the admin part 

= 2.3.13 =

 - fix quran badge number

= 2.3.14 =

 - add Tamil language

= 2.3.15 =

 - add Amharic language

= 2.3.16 =

 - fix js sura

= 2.3.18 =
 
 - add icon speaker in number verse

= 2.3.20 =
 
 - add Tajik language

= 2.3.21
 - fix json error api rest

= 2.3.22 =
* Security: Critical security fix for XSS vulnerability in sourate parameter
* IMPORTANT: All users should update immediately

= 2.3.23 =
 - fix preg_match sourate parameter

= 2.3.24 =
* Security: Fixed XSS vulnerabilities in admin settings fields
* Security: Added proper escaping for text input fields using esc_attr()

= 2.3.25 =
* Fixed change sura error

= 2.3.26 =
* Replaced cURL with file_get_contents for local file reading (data.xml, translation files)
* Uses plugin_dir_path() for better compatibility on hosts where allow_url_fopen is disabled
* Improved performance by reading files directly from filesystem instead of HTTP requests

= 2.3.27 =
* Design refresh: improved typography, spacing, and visual hierarchy
* Softer borders, subtle shadows, and smooth transitions
* Refined verse badges and control buttons (download, settings, play)
* Better mobile responsiveness with improved touch targets
* New option: Dark mode for comfortable reading at night (Admin > Quran)

= 2.3.28 =
* Removed decorative border/frame around Quran for a cleaner, modern look

= 2.3.29 =
* Full width: content now uses 100% of available space
* Modern 2025 design for select dropdowns (sura, language): clean borders, rounded corners, soft shadows
* Redesigned action buttons (download, play, settings): flat style, semantic colors, refined hover states
* CSS chevron replaces old GIF arrow in dropdowns

= 2.3.30 =
* Replaced msdropdown plugin with native HTML5 selects (lighter, faster, more modern)
* Button icons: switched to inline SVG (download, play, settings) - always visible, no image dependency
* Panels redesign: params_kb, params1_kb, params_download_kb with improved layout and modern select styling

= 2.3.31 =
* Mobile: fixed panels (params, play, download) no longer forced open on load; they stay hidden until the user taps the corresponding button
* Mobile: increased top spacing so selects (Choose Sura, Choose Language) are not stuck to the top (padding-top and margin-top adjusted)
* Prev/Next sura arrows: styled for both light and dark mode (no more white squares; subtle background and border in both themes)
* Audio player: dark mode styling (dark background, border, and controls area when dark mode is enabled)

= 2.3.32 =
* Dark mode audio player: timer text and progress bar in white; border-radius removed (square corners)
* Verse badge: replaced large black speaker icon with a small play triangle (▶) inside the badge, same color as badge text, discrete and clear that the verse is clickable for audio

= 3.0.0 =
* Full design refresh: improved typography, spacing, and visual hierarchy for a more readable and modern Quran reading experience.
* New color theme system with multiple presets (Default, Green, Maroon, Sand, Ocean, Olive) that automatically adapts titles, verses, translations, badges, buttons, navigation arrows and panels.
* Dark mode refined to work consistently with the new design while remaining independent from the light color themes.
* Added progressive loading for long surahs (lazy loading verses by chunks) to keep pages fast and responsive, especially for very long surahs such as Al-Baqarah.
* Simplified and modernized the admin settings page: removed old visual templates and added a visual theme picker with live color previews.
* Updated parameters panels (play, download, text format) to better match the selected theme and improve usability on both desktop and mobile.
* Numerous small visual and UX refinements across mobile and desktop to make the extension feel fresh, clean and consistent.

= 3.0.1 =
* Fixed an extra closing div in the frontend template that could break some themes’ layout and push sidebars below the comments area.

= 3.0.2 =
* Scoped all plugin CSS under the #template_quran wrapper so that theme styles no longer override the plugin design; the plugin appearance is now consistent across different WordPress themes.

= 3.0.3 =
* Fixed arrow buttons (prev/next sura) font-size overridden by theme: set explicit font-size (0.6rem) so it stays consistent in all themes and breakpoints.