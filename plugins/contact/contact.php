<?php
/**
 * @package Contact
 * @version 1.0
 */

/*
Plugin Name: Optimum Contact
Plugin URI: https://www.cci.nc/
Description: A simple contact form
Author: Mikaele Mekenese
Version: 1.0
Author URI: https://www.cci.nc/
*/

// First step : Create the database

function contact_database() {
	global $wpdb; // Connexion à la BDD de Wordpress - Module d'accès aux données

	$table_name = $wpdb->prefix . 'contacts';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		first_name varchar(55) NOT NULL,
		last_name varchar(55) NOT NULL,
		phone VARCHAR(20) NOT NULL,
		comment TEXT NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option('contact_db_version', '1.0');
}

register_activation_hook(__FILE__, 'contact_database');


// Third step : Add plugin to admin

function add_myplugin_to_admin() { // Afficher les données dans l'admin, programmer l'interface de l'admin
	function contact_content() {
		echo "<h1>Contacts</h1>";
		echo "<div style='margin-right:20px'>";

		if(class_exists('WP_List_Table')) { // Si elle existe, c'est que le WP fonctionne, c'est le core de WP
			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
			require_once(plugin_dir_path( __FILE__ ) . 'contact-list-table.php');
			$contactListTable = new ContactListTable();
			$contactListTable->prepare_items();
			$contactListTable->display();
		} else {
			echo "WP_List_Table n'est pas disponible.";
		}
		
		echo "</div>";
	}

	add_menu_page('Contacts', 'Contacts', 'manage_options', 'contact-plugin', 'contact_content');
}

add_action('admin_menu', 'add_myplugin_to_admin');


// Fourth step: Create the form

function contact_form() {
	ob_start();

	if (isset($_POST['contact'])) {
		$first_name = sanitize_text_field($_POST["first_name"]);
		$last_name = sanitize_text_field($_POST["last_name"]);
		$phone = sanitize_text_field($_POST["phone"]);
		$comment = esc_textarea($_POST["comment"]);

		if ($first_name != '' && $last_name != '' && $phone  != '' && $comment  != '') {
			global $wpdb;

			$table_name = $wpdb->prefix . 'contacts';
	
			$wpdb->insert( 
				$table_name,
				array( 
					'first_name' => $first_name,
					'last_name' => $last_name,
					'phone' => $phone,
					'comment' => $comment,
				) 
			);
			echo "<br><div class='notification is-success'>";
				echo "<button class='delete'></button>";
				echo "<h5>Merci ! Nous vous répondrons dans les plus brefs délais.</h5>";
			echo "</div><br>";
		}
	}
	
	echo "<form class='form' method='POST' style='margin:auto;width:500px;'>";
		echo "<div class='field'>";
			echo "<label class='label'>Prénom : </label>";
			echo "<div class='control'>";
				echo "<input class='input' type='text' name='first_name' required>";
			echo "</div>";
		echo "</div>";
		echo "<div class='field'>";
			echo "<label class='label'>Nom de famille : </label>";
			echo "<div class='control'>";
				echo "<input class='input' type='text' name='last_name' required>";
			echo "</div>";
		echo "</div>";
		echo "<div class='field'>";
			echo "<label class='label'>Numéro de téléphone : </label>";
			echo "<div class='control'>";
				echo "<input class='input' type='tel' name='phone' required>";
			echo "</div>";
		echo "</div>";
		echo "<div class='field'>";
			echo "<label class='label'>Commentaire : </label>";
			echo "<div class='control'>";
				echo "<textarea class='textarea' name='comment' placeholder='Ajouter un commentaire' required></textarea>";
			echo "</div>";
		echo "</div><br>";
		echo "<div class='field is-grouped'>";
			echo "<div class='control'>";
				echo "<input class='button is-link' type='submit' name='contact' value='Envoyez'>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

	return ob_get_clean();
}

add_shortcode('contact', 'contact_form');