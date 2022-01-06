<?php 
/**
 * Template Name: Member Directory
 */
get_header();

if(!is_user_logged_in()){
	get_template_part( 'template-parts/template', 'member-login' );
}else{
	get_template_part('template-parts/template', 'member-profile-archive');
}

get_footer();