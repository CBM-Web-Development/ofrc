<?php 
class OFRC_Member_Profiles{
	function __construct(){
		add_action('init', array($this, 'member_profile_admin_page'));
		add_action('init', array($this, 'custom_member_role'));		
		add_action('rest_api_init', array($this,'endpoints_init'));
		//add_action('login_redirect', array($this, 'member_login_redirect'), 10, 3);
		add_action('wp_login_failed', array($this, 'member_failed_login'));
		add_action('wp_ajax_member_login', array($this, 'member_login'));
		add_action('wp_ajax_nopriv_member_login', array($this, 'member_login'));
		add_action('wp_ajax_signout', array($this, 'member_signout'));
		add_action('wp_ajax_nopriv_signout', array($this, 'member_signout'));
		add_action('init', array($this, 'register_member_profile_cpt'));
		
	}
	
	
	
	// Register Custom Post Type
	function register_member_profile_cpt() {
	
		$labels = array(
			'name'                  => _x( 'Members', 'Post Type General Name', OFRC_TEXTDOMAIN ),
			'singular_name'         => _x( 'Member', 'Post Type Singular Name', OFRC_TEXTDOMAIN ),
			'menu_name'             => __( 'Members', OFRC_TEXTDOMAIN ),
			'name_admin_bar'        => __( 'Member', OFRC_TEXTDOMAIN ),
			'archives'              => __( 'Member Archives', OFRC_TEXTDOMAIN ),
			'attributes'            => __( 'Member Attributes', OFRC_TEXTDOMAIN ),
			'parent_item_colon'     => __( 'Parent Profile:', OFRC_TEXTDOMAIN ),
			'all_items'             => __( 'All Profiles', OFRC_TEXTDOMAIN ),
			'add_new_item'          => __( 'Add New Profile', OFRC_TEXTDOMAIN ),
			'add_new'               => __( 'Add New', OFRC_TEXTDOMAIN ),
			'new_item'              => __( 'New Profile', OFRC_TEXTDOMAIN ),
			'edit_item'             => __( 'Edit Profile', OFRC_TEXTDOMAIN ),
			'update_item'           => __( 'Update Profile', OFRC_TEXTDOMAIN ),
			'view_item'             => __( 'View Profile', OFRC_TEXTDOMAIN ),
			'view_items'            => __( 'View Profiles', OFRC_TEXTDOMAIN ),
			'search_items'          => __( 'Search Profile', OFRC_TEXTDOMAIN ),
			'not_found'             => __( 'Not found', OFRC_TEXTDOMAIN ),
			'not_found_in_trash'    => __( 'Not found in Trash', OFRC_TEXTDOMAIN ),
			'featured_image'        => __( 'Featured Image', OFRC_TEXTDOMAIN ),
			'set_featured_image'    => __( 'Set featured image', OFRC_TEXTDOMAIN ),
			'remove_featured_image' => __( 'Remove featured image', OFRC_TEXTDOMAIN ),
			'use_featured_image'    => __( 'Use as featured image', OFRC_TEXTDOMAIN ),
			'insert_into_item'      => __( 'Insert into profile', OFRC_TEXTDOMAIN ),
			'uploaded_to_this_item' => __( 'Uploaded to this profile', OFRC_TEXTDOMAIN ),
			'items_list'            => __( 'Profiles list', OFRC_TEXTDOMAIN ),
			'items_list_navigation' => __( 'Profiles list navigation', OFRC_TEXTDOMAIN ),
			'filter_items_list'     => __( 'Filter profiles list', OFRC_TEXTDOMAIN ),
		);
		$rewrite = array(
			'slug'                  => 'member',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
		);
		$args = array(
			'label'                 => __( 'Member', OFRC_TEXTDOMAIN ),
			'description'           => __( 'Post Type Description', OFRC_TEXTDOMAIN ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', 'page-attributes' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-groups',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'page',
			'show_in_rest'          => false,
		);
		register_post_type( 'member', $args );
	
	}
	
		
	public function endpoints_init(){
				
		register_rest_route('ofrc/v1', '/member-directory/members', array(
			'methods'	=> array('GET', 'POST'),
			'callback'	=> array($this, 'get_member_directory'),
			'permission_callback'	=> '__return_true'
		));
		
		register_rest_route('ofrc/v1', '/member-directory/members/member-profile/image-upload', array(
			'methods' 	=> array('GET', 'POST'),
			'callback'	=> array($this, 'upload_member_profile_picture'),
			'permission_callback'	=> '__return_true',
		));
		
		register_rest_route('ofrc/v1', '/member-directory/members/member-profile/save-profile', array(
			'methods' 	=> array('GET', 'POST'),
			'callback'	=> array($this, 'save_member_profile'),
			'permission_callback'	=> '__return_true',
		));
		
		
	}
	
	/**
	 * Sign the current user out 
	 */ 
	public function member_signout(){
		wp_logout();
		
		return wp_send_json_success();
	}
	
	
	/**
	 * Handle the member login request 
	 * 
	 * @params void 
	 * @returns boolean 
	 */
	public function member_login(){
		$user_login = filter_input(INPUT_POST, 'user_login');
		$user_password = filter_input(INPUT_POST, 'user_password');
		$remember = filter_input(INPUT_POST, 'rememberme');
		
		$is_logged_in = array('success' => false);
		
		if($user_login && $user_password){
			
			$user = get_user_by('login', $user_login);
						
			if($user && wp_check_password( $user_password, $user->data->user_pass, $user->ID )){ // If the user and password are both correct 
				// Authenticate the user
				$is_logged_in['success'] = $this->authenticate_user($user_login, $user_password, $remember);
			}elseif(!$user){ // If the user doesn't exist 
				$is_logged_in['error'] = 'user';
			}else{ // If the password is wrong 
				$is_logged_in['error'] = 'password';
			}
		}
		
		wp_send_json_success( $is_logged_in );
	}
	
	private function authenticate_user($username, $password, $remember){
		$user = wp_signon( array(
			'user_login' 	=> $username, 
			'user_password'	=> $password, 
			'remember'		=> $remember, 
		) );
		
		return set_current_user($user->ID);
	}
	
	
	public function member_failed_login($username){
		$referrer = $_SERVER['HTTP_REFERER'];
		if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin')     ) {
			wp_redirect( $referrer . '?login=failed&username=' . $username );
			exit;
		}
	}
	
	public function member_login_redirect($redirect_to, $request,$user){	
		if(isset($user->roles) && is_array($user->roles)){
			if(in_array('member', $user->roles)){
				//die($redirect_to);
				return $redirect_to;
				//return 'https://www.google.com';
			}
		}
		
		return $redirect_to;
	}

	/*
	 * Save the member profile fields 
	 * 
	 * @params WP_Rest_Request
	 * 
	 * @returns json
	 */
	public function save_member_profile(WP_REST_Request $request){
		
		if(!$request->get_params()){
			return wp_send_json_error();
		}
		
		$prefix = $request->get_param('prefix');
		$first_name = $request->get_param('first_name');
		$last_name = $request->get_param('last_name');
		$suffix = $request->get_param('suffix');
		$birthday = $request->get_param('birthday');
		$gender = $request->get_param('gender');
		$mobile_phone = $request->get_param('mobile_phone');
		$home_phone = $request->get_param('home_phone');
		$work_phone = $request->get_param('work_phone');
		$email_address = $request->get_param('email');
		$biography = $request->get_param('biography');
		$user_id = $request->get_param('current_user');
		
		$response = array();
		
		$has_error = false;
		
		update_field('prefix', $prefix, 'user_' . $user_id);
		update_field('first_name', $first_name, 'user_' . $user_id);
		update_field('last_name', $last_name, 'user_' . $user_id);
		update_field('suffix', $suffix, 'user_' . $user_id);
		update_field('birthday', $birthday, 'user_' . $user_id);
		update_field('gender', $gender, 'user_' . $user_id);
		update_field('mobile_phone', $mobile_phone, 'user_' . $user_id);
		update_field('home_phone', $home_phone, 'user_' . $user_id);
		update_field('work_phone', $work_phone, 'user_' . $user_id);
		update_field('email_address', $email_address, 'user_' . $user_id);
		update_field('biography', $biography, 'user_' . $user_id);
		
		
		return wp_send_json_success();	
	}
	
	/**
	 * Upload the member profile image 
	 */
	public function upload_member_profile_picture(){
		$img = $_FILES['profile_image'];
		$user_id = filter_input(INPUT_POST, 'user_id');
		$attach_id = $this->upload_image($img);


		if(!$attach_id){
			return false;
		}
		
		$update_profile_image = update_field('profile_picture', $attach_id, 'user_' . $user_id);	
		
		return $update_profile_image;
	}
	
	private function upload_image($img){
		if(!function_exists('wp_handle_uploade')){
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			require_once( ABSPATH . 'wp-admin/includes/media.php' ); 
		}
				
		
		$upload_overrides = array('test_form'	=> false);
		
		$move_file = wp_handle_upload($img, $upload_overrides);
		
		if($move_file){
			$img_url = $move_file['url'];
			
			$upload_dir = wp_upload_dir();
			
			$image_data = file_get_contents($img_url);
			
			$filename = basename($img_url);
			
			if(wp_mkdir_p( $upload_dir['path'] )){
				$file = $upload_dir['path'] . '/' . $filename;
			}else{
				$file = $upload_dir['basedir'] . '/' . $filename;
			}
			
			file_put_contents($file, $image_data);
			
			$wp_filetype = wp_check_filetype($filename, null);
			
			$attachment = array(
				'post_mime_type'=> $wp_filetype['type'],
				'post_title'	=> sanitize_file_name($filename),
				'post_content'	=> '', 
				'post_status'	=> 'inherit',
			);
			
			$attach_id = wp_insert_attachment($attachment, $file);
			
			$attach_data = wp_generate_attachment_metadata($attach_id, $file);
			
			wp_update_attachment_metadata($attach_id, $attach_data);
			
			return $attach_id;
		}
		
		return false;
	}
	
	
	public function get_member_directory(){
		$users_args = array(
			'role' => 'Member',
		);
		$members = get_users( $users_args );
				
		$directory = array();
		
		
		if($members){
	
			foreach($members as $member){
	
	
				'user_' . $ID = $member->ID;
				
				$name = "";
				
				if(get_field('prefix', 'user_' . $ID)){
					$name .= get_field('prefix', 'user_' . $ID) . ' ';
				}
				
				$name .= get_field('first_name', 'user_' . $ID) . ' ' . get_field('last_name', 'user_' . $ID);
				
				if(get_field('suffix', 'user_' . $ID)){
					$name .= ', ' . get_field('suffix', 'user_' . $ID);
				}
				
				$phone_number = null;
				
				if(get_field('mobile_phone', 'user_' . $ID)){
					$phone_number = get_field('mobile_phone', 'user_' . $ID);
				}elseif(get_field('home_phone', 'user_' . $ID)){
					$phone_number = get_field('home_phone', 'user_' . $ID);
				}elseif(get_field('work_phone', 'user_' . $ID)){
					$phone_number = get_field('work_phone', 'user_' . $ID);
				}
				
				$phone_number_display = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $phone_number);
				
				$directory[] = array(
					'post_id'	=> $ID,
					'name'		=> $name,
					'profile_picture'	=> get_field('profile_picture',  'user_' . $ID )['url'],
					'phone_number'	=> $phone_number,
					'phone_number_display'	=> $phone_number_display,
					'phone_number_link'	=> 'tel:' . $phone_number,
					'email_link'	=> 'mailto:' . get_field('email_address', 'user_' . $ID),
					'email'		=> get_field('email_address', 'user_' . $ID),
					'biography'	=> get_field('biography', 'user_' . $ID),
				);
			}
		}
		
		return $directory;
	}
	
	
	public function custom_member_role(){
		if(get_option('ofrc_custom_roles_version') < 1){
			add_role('member', 'Member', array('read'	=> true, 'level_0' => true));
			update_option('ofrc_custom_roles_version', 1);
		}
	}
	
	public function member_profile_admin_page(){
		if(function_exists('acf_add_options_page')){
			acf_add_options_sub_page(array(
				'page_title'	=> 'Member Dashboard Settings', 
				'menu_title'	=> 'Settings', 
				'parent_slug'	=> 'edit.php?post_type=member_profile',
			));
		}
	}
	
}

new OFRC_Member_Profiles();