<?php 

add_action('after_setup_theme', 'ofrc_menus');
function ofrc_menus(){
	register_nav_menu('primary-navigation', __('Primary Navigation Menu', OFRC_TEXTDOMAIN));
	register_nav_menu('member-menu', __('Member Menu', OFRC_TEXTDOMAIN));
}
