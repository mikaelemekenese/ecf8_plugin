<?php

    // Ajouter la prise en charge des images mises en avant
    add_theme_support('post-thumbnails');


    // Ajouter automatiquement le titre du site dans l'en-tête du site
    add_theme_support('title-tag');


    // Affichage des dates
    the_date();
    the_time(get_option('date_format'));
    the_time('j F Y à H:i');


    // Ajouter la prise en charge des scripts
    function custom_scripts()
    {
        wp_enqueue_style('bulma-style', 'https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css');
        wp_enqueue_style('bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css');
        wp_enqueue_script('custom-script', 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js', array('jquery'), false, true);
        wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/styles.css?v=' . time(), array(), false, 'all');
    }
    add_action('wp_enqueue_scripts', 'custom_scripts');


    // Menus
    register_nav_menus(
        array(
            'main'      => 'Menu Principal',
            'footer'    => 'Bas de page',
        )
    );


    // Masquer la version de Wordpress
    remove_action("wp_head", "wp_generator");


    // Cacher les erreurs de connexion
    add_filter('login_errors',create_function('$a', "return null;"));