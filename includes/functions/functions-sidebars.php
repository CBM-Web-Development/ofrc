<?php 

add_action('widgets_init', 'ofrc_theme_widgets');
function ofrc_theme_widgets(){
	register_sidebar(array(
		'name'          => __( 'Secondary Navigation - Left', OFRC_TEXTDOMAIN ),
		'id'            => 'secondary-navigation--left',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	
	register_sidebar(array(
		'name'          => __( 'Secondary Navigation - Center', OFRC_TEXTDOMAIN ),
		'id'            => 'secondary-navigation--center',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Secondary Navigation - Right', OFRC_TEXTDOMAIN ),
		'id'            => 'secondary-navigation--right',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Left Footer', OFRC_TEXTDOMAIN ),
		'id'            => 'left-footer-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Middle Footer', OFRC_TEXTDOMAIN ),
		'id'            => 'middle-footer-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Right Footer', OFRC_TEXTDOMAIN ),
		'id'            => 'right-footer-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Left Shop Sidebar', OFRC_TEXTDOMAIN ),
		'id'            => 'left-shop-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
	register_sidebar(array(
		'name'          => __( 'Right Shop Sidebar', OFRC_TEXTDOMAIN ),
		'id'            => 'right-shop-sidebar',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', OFRC_TEXTDOMAIN ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	));
}