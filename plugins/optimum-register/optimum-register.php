<?php
/**
 * @package Optimum
 * @version 1.0
 */

/*
Plugin Name: Optimum Register
Plugin URI: https://www.cci.nc/
Description: A plugin to allow people to register to Optimum's various sports courses and sessions
Author: Mikaele Mekenese
Version: 1.0
Author URI: https://www.cci.nc/
*/

// First step : Create the database

function register_database() {
	global $wpdb; // Connexion à la BDD de Wordpress - Module d'accès aux données

	$table_name = $wpdb->prefix . 'registrations';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		first_name varchar(55) NOT NULL,
		last_name varchar(55) NOT NULL,
		phone VARCHAR(20) NOT NULL,
		course varchar(100) NOT NULL,
		subscription varchar(100) DEFAULT 'Non',
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	add_option('registration_db_version', '1.0');
}

register_activation_hook(__FILE__, 'register_database');


// Second step : Create default data

/* function registration_default_data() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . 'registrations';
	
	$wpdb->insert( // Création d'un jeu de données pour vérifier que ce que l'on fait marche
		$table_name,
		array( 
			'first_name' => 'Joe',
			'last_name' => 'Doe',
			'phone' => '988888',
			'comment' => 'lol',
		) 
	);
}

register_activation_hook(__FILE__, 'registration_default_data'); */


// Third step : Add plugin to admin

function add_plugin_to_admin() { // Afficher les données dans l'admin, programmer l'interface de l'admin
	function register_content() {
		echo "<h1>Registrations</h1>";
		echo "<div style='margin-right:20px'>";

		if(class_exists('WP_List_Table')) { // Si elle existe, c'est que le WP fonctionne, c'est le core de WP
			require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
			require_once(plugin_dir_path( __FILE__ ) . 'optimum-register-list-table.php');
			$registerListTable = new RegisterListTable();
			$registerListTable->prepare_items();
			$registerListTable->display();
		} else {
			echo "WP_List_Table n'est pas disponible.";
		}
		
		echo "</div>";
	}

	add_menu_page('Registrations', 'Registrations', 'manage_options', 'register-plugin', 'register_content');
}

add_action('admin_menu', 'add_plugin_to_admin');


// Fourth step: Create the form

function register_form() {
	ob_start();

	if (isset($_POST['register'])) {
		$first_name = sanitize_text_field($_POST["first_name"]);
		$last_name = sanitize_text_field($_POST["last_name"]);
		$phone = sanitize_text_field($_POST["phone"]);
		$course = esc_textarea($_POST["course"]);
		$subscription = esc_textarea($_POST["subscription"]);

		if ($first_name != '' && $last_name != '' && $phone  != '') {
			global $wpdb;

			$table_name = $wpdb->prefix . 'registrations';
	
			$wpdb->insert( 
				$table_name,
				array( 
					'first_name' => $first_name,
					'last_name' => $last_name,
					'phone' => $phone,
					'course' => $course,
					'subscription' => $subscription,
				) 
			);
			echo "<br><div class='notification is-success'>";
				echo "<button class='delete'></button>";
				echo "<h5>Merci! Votre inscription a bien été prise en compte.</h5>";
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
			echo "<label class='label'>Nos offres : </label>";
			echo "<div class='control'>";
				echo "<div class='select'>";
					echo "<div class='select'>";
						echo "<select name='course' style='width:500px;'>";
							echo "<option name='course' value='Accès à la salle de musculation'>Accès à la salle de musculation</option>";
							echo "<option name='course' value='Renforcement musculaire'>Cours particulier : Renforcement musculaire</option>";
							echo "<option name='course' value='Préparation physique'>Cours particulier : Préparation physique</option>";
							echo "<option name='course' value='Cross training'>Cours collectif : Cross training</option>";
							echo "<option name='course' value='Cardio training'>Cours collectif : Cardio training</option>";
							echo "<option name='course' value='Séance de yoga'>Séance de yoga</option>";
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";
		echo "<div class='field'>";
			echo "<label class='label'>Souhaiteriez-vous vous abonner à nos salles ?</label>";
			echo "<div class='control'>";
				echo "<div class='select'>";
					echo "<div class='select'>";
						echo "<select name='subscription' style='width:500px;'>";
							echo "<option name='subscription' value='Non'></option>";
							echo "<option name='subscription' value='Mensuel'>Abonnement mensuel</option>";
							echo "<option name='subscription' value='Annuel'>Abonnement annuel</option>";
						echo "</select>";
					echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div><br>";
		echo "<div class='field is-grouped'>";
			echo "<div class='control'>";
				echo "<input class='button is-link' type='submit' name='register' value='Envoyez'>";
			echo "</div>";
		echo "</div>";
	echo "</form>";

	return ob_get_clean();
}

add_shortcode('register', 'register_form');