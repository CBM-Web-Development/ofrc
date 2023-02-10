<?php 

add_action('wp_enqueue_scripts', 'ofrc_localize_scripts');
function ofrc_localize_scripts(){
	wp_localize_script('allscripts', 'localize', array(
		'ajax_url'								=> admin_url( 'admin-ajax.php' ),
		'rest'									=> get_rest_url(),
		'rest_archives'							=> get_rest_url(get_current_blog_id(), 'ofrc/v1/archives'),
		'rest_member_directory'					=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members'),
		'rest_member_upload_profile_image'		=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members/member-profile/image-upload'),
		'rest_member_signup'					=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/sign-up'),
		'rest_member_save_profile'				=> get_rest_url(get_current_blog_id(), 'ofrc/v1/member-directory/members/member-profile/save-profile'),
		'current_user_id'						=> get_current_user_id(),
		'rest_member_login'						=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/log-in'),
		'rest_password_reset_request'			=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/password-reset-request'),
		'rest_reset_password'					=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/password-reset'),
		'rest_get_member'						=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/member-profile/get-member'),
		'rest_get_member_group'					=> get_rest_url(get_current_blog_id(), 'ofrc/v1/members/member-profile/get-member-group'),
		'current_member_group_id'				=> get_user_meta(get_current_user_id(), 'membership_id', true),
		'current_user_id'						=> get_current_user_id(),
		'upload_memberships'					=> get_rest_url (get_current_blog_id(), 'ofrc/v1/members/upload-memberships'),
		'rest_nonce'							=> wp_create_nonce('wp_rest'),
		
		
	) );
	
}