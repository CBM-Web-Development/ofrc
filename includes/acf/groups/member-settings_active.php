<?php
if( function_exists('acf_add_local_field_group') ):
	
	acf_add_local_field_group(array(
		'key' => 'group_61ccc68e7eeaf',
		'title' => 'Member Settings',
		'fields' => array(
			array(
				'key' => 'field_61ccc6e0071c1',
				'label' => 'Endpoints',
				'name' => 'endpoints',
				'type' => 'group',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'layout' => 'row',
				'sub_fields' => array(
					array(
						'key' => 'field_61ccc72c071c2',
						'label' => 'Member Login Page',
						'name' => 'member_login_page',
						'type' => 'page_link',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => array(
							0 => 'page',
						),
						'taxonomy' => '',
						'allow_null' => 0,
						'allow_archives' => 0,
						'multiple' => 0,
					),
					array(
						'key' => 'field_61ccd753b8b79',
						'label' => 'Directory Page',
						'name' => 'directory_page',
						'type' => 'page_link',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'post_type' => '',
						'taxonomy' => '',
						'allow_null' => 0,
						'allow_archives' => 1,
						'multiple' => 0,
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'seamless',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => array(
			0 => 'permalink',
			1 => 'the_content',
			2 => 'excerpt',
			3 => 'discussion',
			4 => 'comments',
			5 => 'revisions',
			6 => 'slug',
			7 => 'author',
			8 => 'format',
			9 => 'page_attributes',
			10 => 'featured_image',
			11 => 'categories',
			12 => 'tags',
			13 => 'send-trackbacks',
		),
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	));
	
	endif;		