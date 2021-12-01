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

// Création de la page du plugin dans le menu lattéral

add_action('admin_menu','lienDeMenu');

 function lienDeMenu(){
     add_menu_page(
         'La page de mon plugin', //Titre de ma page
         'NeedWeather', //Lien dans le add_menu_page
         'manage_options',
         plugin_dir_path(__FILE__).'includes/plugin-page.php'// L'adresse ou l'on doit attérir quand on clique sur le lien de menu

     );
 }


// Création des tables dans la base de données a l'activation du plugin
function create_database_table(){

    global $wpdb;
    $servername = $wpdb->dbhost;
    $username = $wpdb->dbuser;
    $password = $wpdb->dbpassword;
    $dbname = $wpdb->dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $request = $conn->prepare("CREATE TABLE IF NOT EXISTS " .$wpdb->prefix. "communes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        code INT(6) NOT NULL,
        nom VARCHAR(30) NOT NULL
    )");

    $request->execute();

    //Hydratation des communes

    $supprimer = $conn->prepare('Delete from '.$wpdb->prefix.'communes');
    $supprimer->execute();
    $curl = curl_init("https://geo.api.gouv.fr/communes");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $communes = curl_exec($curl);
    $communes = json_decode($communes, true);
    foreach ($communes as $commune) {
        $cp = implode(",", $commune['codesPostaux']);
        $ajouter = $conn->prepare('INSERT INTO ' .$wpdb->prefix. 'communes (code, nom) VALUES (:code, :nom)');
        $ajouter->bindParam(':code', $cp);
        $ajouter->bindParam(':nom', $commune['nom']);
        $ajouter->execute();
        $ajouter->debugDumpParams();
    }
    curl_close($curl);



    // $supprimer = $conn->prepare("DELETE FROM ".$wpdb->prefix."communes");
    // $supprimer->execute();
    // $curl = curl_init("https://geo.api.gouv.fr/communes");
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // $communes = curl_exec($curl);
    // $communes = json_decode($comunes, true);
    
    // global $wpdb;
    // $query = "INSERT INTO ".$wpdb->prefix."communes (code, nom) VALUES ";
    // $params = array();
    // $values = array();

    // foreach ($communes as $commune){
    //     $cp = implode(",", $commune['codesPostaux']);
    //     array_push($params,"(%d, %s)");
    //     array_push($values, $cp, $commune['nom']);
    //     }
    //     $query .= implode(",",$params);
    //     $wpdb->query( $wpdb->prepare("$query" , $values));

    //     curl_close($curl);




    $page_array = array(
        'post_title' => 'Page du plugin',
        'post_content' => 'Voici ce qu\'il y a dans la page du plugin',
        'post_status' => 'publish',
        'post_type'  => 'page',
        'post_author' => get_current_user_id(),
    );
    wp_insert_post($page_array);
    };

// Hook qui lance la fonction au moment de l'activation du plugin
register_activation_hook(__FILE__, 'create_database_table');


// Hook qui lance la fonction lorsque le plugin est désactivé
function deletetout(){
    $toutsupprimer = get_page_by_title('Page du plugin');
    wp_delete_post($toutsupprimer->ID, true);
}
register_deactivation_hook(__FILE__, 'deletetout');

// Suppression des tables seulement quand le plugin sera désinstaller
function delete_database_table(){

    global $wpdb;
    $servername = $wpdb->dbhost;
    $username = $wpdb->dbuser;
    $password = $wpdb->dbpassword;
    $dbname = $wpdb->dbname;
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $request = $conn->prepare("DROP TABLE IF EXISTS " . $wpdb->prefix . "communes"); 

    $request->execute();
}

register_uninstall_hook(__FILE__, 'delete_database_table');







