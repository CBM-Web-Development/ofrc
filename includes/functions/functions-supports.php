<?php 

add_theme_support('title-tag');
add_theme_support('custom-logo');
add_theme_support('post-thumbnails');
add_theme_support('woocommerce');

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

add_action('after_setup_theme', 'ofrc_disable_admin_bar');
function ofrc_disable_admin_bar(){
	if(current_user_can('edit_posts')){
		show_admin_bar(true);
	}else{
		show_admin_bar(false);
	}
}