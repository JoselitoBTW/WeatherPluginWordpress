<?php
/**
 * @package Meteo
 * @version 1.0.0
 */
/*
Plugin Name: NeedWeather
Plugin URI: https://joselitop.promo-93.codeur.online
Description: Plugin pour connaitre la meteo
Author: ACS
Version: 1.0
Author URI: https://joselitop.promo-93.codeur.online
*/

add_action('admin_menu','lienDeMenu');

 function lienDeMenu(){
     add_menu_page(
         'La page de mon plugin', //Titre de ma page
         'NeedWeather', //Lien dans le add_menu_page
         'manage_options',
         plugin_dir_path(__FILE__).'includes/plugin-page.php'// L'adresse ou l'on doit attérir quand on clique sur le lien de menu

     );
 }

?>