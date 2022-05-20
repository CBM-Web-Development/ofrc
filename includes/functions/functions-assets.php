<?php 

add_action('wp_enqueue_scripts', 'ofrc_styles');
function ofrc_styles(){
	wp_enqueue_style('allstyles', OFRC_URI . '/assets/styles/dist/allstyles.css', array(), OFRC_VERSION);
}

add_action('wp_enqueue_scripts', 'ofrc_scripts');
function ofrc_scripts(){
	wp_enqueue_script('allscripts', OFRC_URI . '/assets/js/dist/bundle.js', array(), OFRC_VERSION, true);
}
