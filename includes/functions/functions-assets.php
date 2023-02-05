<?php 

add_action('wp_enqueue_scripts', 'ofrc_styles');
function ofrc_styles(){
	wp_enqueue_style('allstyles', OFRC_URI . '/assets/styles/dist/allstyles.css', array(), OFRC_VERSION);
}

add_action('wp_enqueue_scripts', 'ofrc_scripts');
function ofrc_scripts(){
	wp_enqueue_script('allscripts', OFRC_URI . '/assets/js/dist/bundle.js', array(), OFRC_VERSION, true);
}

//add_action('admin_enqueue_scripts', 'ofrc_admin_scripts');
function ofrc_admin_scripts(){
	wp_enqueue_script('ofrc-admin-scripts', OFRC_URI . '/assets/admin/js/dist/bundle.js', array(), OFRC_VERSION, true);
	
	wp_localize_script('ofrc-admin-scripts', 'localize', array(
		
		'upload_memberships'					=> get_rest_url (get_current_blog_id(), 'ofrc/v1/members/upload-memberships')
	) ); 
}
