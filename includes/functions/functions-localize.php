<?php 

add_action('wp_enqueue_scripts', 'ofrc_localize_scripts');
function ofrc_localize_scripts(){
	wp_localize_script('allscripts', 'localize', array(
		'ajax_url'	=> admin_url( 'admin-ajax.php' ),
		'rest'	=> get_rest_url(),
		'rest_archives'	=> get_rest_url(get_bloginfo('ID'), 'ofrc/v1/archives'),
	));
}