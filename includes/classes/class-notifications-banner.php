<?php 

class OFRCNotificationsBanner{
	function __construct(){
		add_action('init', array($this, 'notifications_acf_options_page'));
	}
	
	public function notifications_acf_options_page(){
		if(function_exists('acf_add_options_page')){
			acf_add_options_page( array(
				'page_title'	=> 'Notification Banner', 
				'menu_title'	=> 'Site Options', 
				'menu_slug'		=> 'notification-banner', 
				'capability'	=> 'edit_posts', 
				'redirect'		=> false,
			) );
		}
	}
}

new OFRCNotificationsBanner();