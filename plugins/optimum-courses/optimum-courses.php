<?php
/*


Plugin Name: Optimum Courses
Plugin URI: https://www.cci.nc/
Description: A plugin to create Optimum's courses
Author: Mikaele Mekenese
Version: 1.0
Author URI: https://www.cci.nc/

 
*/

// Add post type 'courses'

function courses_init() {
	$args = array(
		'labels' => array(
			'name' => __('Courses'),
			'singular_name' => __('Course'),
		),
		'public' => true,
		'has_archive' => true,
		'show_in_rest' => true,
		'rewrite' => array("slug" => "courses"), 
		'has_archive' => 'courses',
		'supports' => array('thumbnail', 'editor', 'title'),
	);

	register_post_type('courses', $args);
}

add_action('init', 'courses_init');

// Add meta box date to courses
 
function add_course_date_meta_box() {
	function course_date($post) {
		$date = get_post_meta($post->ID, 'course_date', true);
	
		if (empty($date)) $date = the_date();
	
		echo '<input type="date" name="course_date" value="' . $date  . '" />';
	}

	add_meta_box('course_date_meta_boxes', 'Date', 'course_date', 'courses', 'side', 'default');
}

add_action('add_meta_boxes', 'add_course_date_meta_box');

// Update meta on course post save

function courses_post_save_meta($post_id) {
    if(isset($_POST['course_date']) && $_POST['course_date'] !== "") {
		update_post_meta($post_id, 'course_date', $_POST['course_date']);
	}
}

add_action('save_post', 'courses_post_save_meta');

// Add course post type to home and main query

function add_course_post_type($query) {
	if (is_home() && $query->is_main_query()) {
		$query->set('post_type', array('post', 'courses'));
		return $query;
	}
}

add_action('pre_get_posts', 'add_course_post_type');

function show_course_date() {
	ob_start();
	$date = get_post_meta(get_the_ID(), 'course_date', true);
	echo "<date>$date</date>";
	return ob_get_clean();
}

add_shortcode('show_course_date', 'show_course_date');
