<?php 

add_action('after_setup_theme', 'ofrc_menus');
function ofrc_menus(){
	register_nav_menu('primary-right', __('Primary Menu (Right)', 'OFRC_TEXTDOMAIN'));
	register_nav_menu('primary-left', __('Primary Menu (Left)', 'OFRC_TEXTDOMAIN'));
}
