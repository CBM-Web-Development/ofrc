<?php 

add_action('wp_enqueue_scripts', 'ofrc_localize_scripts');
function ofrc_localize_scripts(){
	wp_localize_script('allscripts', 'localize', array(
		'ajax_url'	=> admin_url( 'admin-ajax.php' ),
		'rest'	=> get_rest_url(),
		'rest_archives'	=> get_rest_url(get_current_blog_id(), 'ofrc/v1/archives'),
		'rest_member_directory'	=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members'),
		'rest_member_upload_profile_image'	=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members/member-profile/image-upload'),
		'rest_member_save_profile'	=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members/member-profile/save-profile'),
		'current_user_id'	=> get_current_user_id(),
	));
}