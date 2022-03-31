<?php 
if( function_exists('acf_add_local_field_group') ):
	
	acf_add_local_field_group(array(
		'key' => 'group_623e066805806',
		'title' => 'Member Menu Logo',
		'fields' => array(
			array(
				'key' => 'field_623e0684f8aed',
				'label' => 'Icon',
				'name' => 'icon',
				'type' => 'font-awesome',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'icon_sets' => array(
					0 => 'solid',
					1 => 'regular',
					2 => 'brands',
				),
				'custom_icon_set' => '',
				'default_label' => '',
				'default_value' => '',
				'save_format' => 'element',
				'allow_null' => 0,
				'show_preview' => 0,
				'enqueue_fa' => 1,
				'fa_live_preview' => '',
				'choices' => array(
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'nav_menu_item',
					'operator' => '==',
					'value' => 'location/member-menu',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
	
	endif;		