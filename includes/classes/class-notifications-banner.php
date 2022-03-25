<?php 

class OFRCNotificationsBanner{
	function __construct(){
		add_action('init', array($this, 'notifications_acf_options_page'));
	}
	
	public function notifications_acf_options_page(){
		if(function_exists('acf_add_options_page')){
			acf_add_options_sub_page( array(
				'page_title'	=> 'Notification Banner', 
				'menu_title'	=> 'Notification Banner', 
				'parent_slug'	=> 'ofrc-site-options'
			) );
		}
	}
}

new OFRCNotificationsBanner();