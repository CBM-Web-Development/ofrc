<?php 
class OFRC_Member_Profiles{
	function __construct(){
		//add_action('init', array($this, 'member_profile_admin_page'));
		add_action('init', array($this, 'custom_member_role'));		
		add_action('rest_api_init', array($this,'endpoints_init'));
		add_action('wp_ajax_signout', array($this, 'member_signout'));
		add_action('wp_ajax_nopriv_signout', array($this, 'member_signout'));
		add_action('init', array($this, 'register_member_profile_cpt'));
		add_action('init', array($this, 'memberships_options_page'));
		add_action('admin_menu', array($this, 'register_menu_pages'));
		
		// Filters 
		//add_filter('display_post_states', array($this, 'add_display_post_states'), 10, 2);
	}
	
	public function register_menu_pages(){
		add_submenu_page( 'edit.php?post_type=member', 'Uploader', 'Uploader', 'manage_options', 'memberhips-uploader', array($this, 'memberships_uploader_cb') );
	}
	
	public function memberships_uploader_cb(){
		?>
		
		<h1>Memberships Uploader</h1>
		<div class="memberships-uploader" id="memberships-uploader"></div>
		<?php
	}
	
	public function memberships_options_page(){
		acf_add_options_sub_page( array( 
			'page_title'	=> 'Memberships', 
			'menu_title'	=> 'Memberships', 
			'parent_slug'	=> 'edit.php?post_type=member'
		 ) );
		 
		 acf_add_options_sub_page( array(
			 'page_title'	=> 'Member Dashboard Settings', 
			 'menu_title'	=> 'Settings', 
			 'parent_slug'	=> 'edit.php?post_type=member',
		 ) );
		 
		 acf_add_options_sub_page( array(
			 'page_title'	=> 'Uploader', 
			 'menu_title'	=> 'Uploader', 
			 'parent_slug'	=> 'edit.php?post_type=member',
		 ) );
	}
	
	
	// Register Custom Post Type
	public function register_member_profile_cpt() {
	
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
			'supports'              => array( 'title', 'editor', 'revisions', 'custom-fields', 'page-attributes', 'thumbnail' ),
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
			'permission_callback'	=> function(){
				return current_user_can('read');
			}
		));
		
		register_rest_route('ofrc/v1', '/members/member-profile/get-member-group', array( 
			'methods'	=> array('GET','POST'), 
			'callback'	=> array($this, 'get_member_group'), 
			'permission_callback'	=> '__return_true',
		) );
	
		register_rest_route('ofrc/v1', '/members/member-profile/get-member', array( 
			'methods'	=> array('GET','POST'), 
			'callback'	=> array($this, 'get_member'), 
			'permission_callback'	=> '__return_true',
		) );
		
		register_rest_route('ofrc/v1', '/members/sign-up', array(
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'member_sign_up'), 
			'permission_callback'	=> '__return_true'
		));
		
		register_rest_route('ofrc/v1', 'members/log-in', array(
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'member_log_in'), 
			'permission_callback'	=> '__return_true',
		));
		
		register_rest_route('ofrc/v1', 'members/password-reset', array( 
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'password_reset'), 
			'permission_callback'	=> '__return_true'
		) );
		
		register_rest_route('ofrc/v1', 'members/password-reset-request', array(
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'user_password_reset_request'), 
			'permission_callback'	=> '__return_true',
		) );
		
		register_rest_route('ofrc/v1', 'members/upload-memberships', array(
			'methods'				=> 'POST', 
			'callback'				=> array($this, 'upload_memberships'),
			'permission_callback'	=> '__return_true',
		));
		
		register_rest_route('ofrc/v1', 'members/logout', array(
			'methods'				=> 'GET', 
			'callback'				=> array($this, 'wp_oauth_server_logout'),
			'permission_callback'	=> '__return_true',
		));
		
	}
	
	public function wp_oauth_server_logout(){
		wp_logout();
		wp_redirect(bloginfo('url'));
		exit;
	}
	
	/**
	*
	*/
	public function upload_memberships(WP_REST_Request $request) {
		if(!$request->get_params() && !$request->get_param('memberships')){
			wp_send_json_error();
		}
		
		
		$memberships = $request->get_param('memberships');
		
		foreach($memberships as $membership){
			$row = array(
				'membership_id' 	=> $membership['account_number'], 
				'membership_name'	=> $membership['membership_name'], 
				'telephone'			=> $membership['phone'], 
				'email'				=> $membership['email']
			);
			
			add_row('memberships', $row, 'option');
		}
		
		$memberships = get_field('memberships', 'option');
		
		$total_items = count($memberships);
		
		wp_send_json_success($total_items);
		
	
	}
	
	/**
	 * Get the member post type by the user ID
	 * 
	 * @params int: membership_id 
	 * @returns object: member 
	 */
	public function get_member(WP_REST_Request $request){	
		$user_id = $request->get_param('user_id');
		
		$member_args = array(
			'post_type'			=> 'member', 
			'meta_key'			=> 'user_id',
			'meta_value'		=> $user_id, 
			'posts_per_page'	=> 1,
		);
		
		$member = get_posts($member_args)[0];
	
		$member_id = $member->ID;
		
		$response = array(
			'membership_id'	=> get_field('membership_id', $member_id),
			'user_id'		=> get_field('user_id', $member_id),
			'email_address'	=> get_field('email_address', $member_id),
			'first_name'	=> get_field('first_name', $member_id), 
			'last_name'		=> get_field('last_name', $member_id), 
			'birthday'		=> get_field('birthday', $member_id), 
			'home_phone'	=> get_field('home_phone', $member_id), 
			'cell_phone'	=> get_field('cell_phone', $member_id), 
			'work_phone'	=> get_field('work_phone', $member_id),
			'profile_picture'	=> get_the_post_thumbnail_url( $member_id ) ? get_the_post_thumbnail_url : OFRC_URI . '/assets/static/img/profile_placeholder.png',
		);
		
		return $response;
		
	}
	
	
	/**
	 * Get the member groups 
	 * 
	 * @params 
	 * @returns json_array 
	 */	
	public function get_member_group(WP_REST_Request $request){

		if(!$request->get_params() || !$request->get_param('membership_id')){
			wp_send_json_error();
		}
		
		// Get the member by the membership id 
		$membership_id = $request->get_param('membership_id');
		
		//$member = $this->get_member($membership_id);
		
		if($member){ // We only want the first result
			
			$member_groups = get_field('member_group_authorized_users', $member->ID);
			
			
			$authorized_users = array();
			
			if($member_groups){
				foreach($member_groups as $group){
					$user = array(
						array(
							'data_type'	=> 'image', 
							'name'	=> 'profile_picture', 
							'value'	=> $group['profile_picture']['url'],
							'attachment_id'	=> $group['profile_picture']['id']
						),
						array(
							'data_type'	=> 'text', 
							'name'	=> 'first_name',
							'value'	=> $group['first_name']
						),
						array(
							'data_type'	=> 'text', 
							'name'	=> 'last_name',
							'value'	=> $group['last_name']
						),
						array(
							'data_type'	=> 'email', 
							'name'	=> 'email_address',
							'value'	=> $group['email_address']
						),
						array(
							'data_type'	=> 'text', 
							'name'	=> 'phone_number',
							'value'	=> $group['phone_number']
						),
						array(
							'data_type'	=> 'date', 
							'name'	=> 'birthday',
							'value'	=> $group['birthday']
						),
						array(
							'data_type'	=> 'switch', 
							'name'	=> 'show_in_directory',
							'value'	=> $group['show_in_directory']
						),
						
					);
					
					array_push($authorized_users, $user);
				}
			}
			
			
			wp_send_json_success($authorized_users);	
		}
	wp_send_json_error();		
}
	
	public function password_reset(WP_REST_Request $request){
		if(!$request->get_params()){
			return wp_send_json_error();
		}
		
		$key = $request->get_param('reset_key');
		$login = $request->get_param('login');
		$password = $request->get_param('password');
		
		$user = check_password_reset_key( $key, $login );
		
		if(is_wp_error( $user )){
			return wp_send_json_error($user);
		}
				
		wp_set_password($password, $user->ID);
		
		wp_send_json_success();
	}
	
	/** 
	 * Generate a password reset 
	 */
	public function user_password_reset_request(WP_REST_Request $request){
		if(! $request->get_params()){
			return wp_send_json_error();
		}
		
		$username = $request->get_param('username');

		// Check the username 
		if(!email_exists( $username )){
			return wp_send_json_error();
		}
		$user = get_user_by_email( $username );
		
		$password_reset_key = get_password_reset_key( $user );
		
		if( !is_wp_error($password_reset_key) ){
			$this->send_password_reset_key($user, $password_reset_key);		
		}
		
		
				
		wp_send_json_success($password_reset_key);
	}
	
	/** 
	 * Send the user a password reset email 
	 */
	private function send_password_reset_key($user, $key){
		
		$to = $user->user_email;
		
		$message = 'Your password reset key is: <strong>' . $key . '</strong>';
		
		$headers = array('Content-Type: text/html; charset=UTF-8');
		
		wp_mail( $to, 'Olde Forest Member Password Reset', $message, $headers );
	}
	
	/** 
	 * Log the member in 
	 * 
	 * @params WP_REST_Reqeust 
	 * @returns JSON(boolean)
	 */
	public function member_log_in(WP_REST_Request $request){
		if(! $request->get_params()){
			return wp_send_json_error();
		}
		
		$log_in = wp_authenticate($request->get_param('username'), $request->get_param('password'));
		
		if(is_wp_error( $log_in )){
			return wp_send_json_error($log_in);
		}
				
		$creds = array( 
			'user_login'	=> $log_in->user_login, 
			'user_password' => $request->get_param('password'),
			'remember'		=> $request->get_param('remember_me')
		);
		
		$sign_on = wp_signon($creds, true);
		
		wp_set_current_user( $sign_on->ID );
		
		return wp_send_json_success();
	}
	
	/** 
	 * Member sign up function 
	 * 
	 * @param WP_REST_Request object 
	 * @return JSON  
	 */
	public function member_sign_up(WP_REST_Request $request){
		
		$response = array(
			'response'	=> false,
		);
		
		if(!$request->get_params()){
			$response['reason'] = 'No Data';
			return wp_send_json_error($response);
		}
		
		$username = $request->get_param('email');
		$first_name = $request->get_param('first_name');
		$last_name = $request->get_param('last_name');
		$password = $request->get_param('password');
		$membership_id = $request->get_param('membership_id');
		
		if(get_user_by_email( $username )){
			
			$response['reason'] = 'Username already exists';
			return wp_send_json_error($response);

		}
								
		if(!$this->check_membership_id($request->get_param('membership_id'))){
			$response['reason'] = 'Invalid membership ID';
			return wp_send_json_error($response);	
		}
		
		if($this->check_member_exists($membership_id, $username)){
			$response['reason'] = 'Member profile already exists';
			return wp_send_json_error($response);
		}
		
		
		// Create the post 
		$member_args = array(
			'post_title' 	=> $last_name . ', ' . $first_name . ' - ' . $request->get_param('membership_id'), 
			'post_content'	=> '', 
			'post_status'	=> 'publish', 
			'post_type'		=> 'member',
			'ID'			=> 0,
		);
		
		$member = wp_insert_post($member_args);
		
		if(is_wp_error( $member )){
			$response['reason'] = 'Failed to create member';
			return wp_send_json_error($response);
		}
		
		
		$member_user = wp_insert_user( array(
			'user_pass'		=> $password,
			'user_login'	=> $username,
			'user_email'	=> $username,
			'role'			=> 'member',
			'first_name'	=> $first_name, 
			'last_name'		=> $last_name,
			'meta_input'	=> array(
				'membership_id'	=> $membership_id
			)
		) ); 
		
		$this->insertNewMember($username, $first_name, $last_name, $membership_id, $member, $member_user);
		
		$response['member_id'] = $member_user;
		
		$this->send_confirmation_email($username, $first_name, $last_name);
		
		return wp_send_json_success($response);	
	}
	
	private function insertNewMember($username, $first_name, $last_name, $membership_id, $member, $member_user){
		update_field('membership_id', $membership_id, $member);
		update_field('user_id', $member_user, $member);
		update_field('username', $username, $member);
		update_field('email_address', $username, $member);
		update_field('first_name', $first_name, $member);
		update_field('last_name', $last_name, $member);
	}
	
	/** 
	 * Send a confirmation email after signing up 
	 * 
	 * @param String: email
	 * @param String: first_name
	* @param String: last_name
	 */ 
	private function send_confirmation_email($email, $first_name, $last_name){
		$subject = "New User Registration - Olde Forest Racquet Club";
		
		$message = $first_name . ' ' . $last_name . ', <br/><br/>Thank you for registering. Your username is: ' . $email .'. You can access your account <a href="https://www.oldeforest.com/account">here</a><br/><br/>Sincerely,<br/>The Olde Forest Team' ;
		
		$headers = array('Content-Type: text/html; charset=UTF-8; From: Olde Forest Racquet Club <connor.meehan@cbmwebdevelopment.com>');
		
		wp_mail($email, $subject, $message, $headers);
	}
	
	/**
	 * Check to see if a member already exists with that ID 
	 * 
	 * @params String: membership_id 
	 * @returns boolean 
	 */ 
	private function check_member_exists($membership_id, $username){
		$members = get_posts( array(
			'post_type'		=> 'member', 
			'post_status'	=> 'publish', 
			'meta_key'		=> 'member_access_membership_id', 
			'meta_value'	=> $membership_id
		 ) );
		 
		return $members; 
	}
	
	/**
	 * Check the membership ID is valid
	 * 
	 * @params String: membership_id
	 */ 
	private function check_membership_id($membership_id){
		$memberships = get_field('memberships', 'option');
		
		if($memberships){
			foreach($memberships as $membership){
				if($membership['membership_id'] == $membership_id){
					return true;
				}

			}
		}
				
		return false;
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

	/** 
	 * 
	 */
	private function member_group_key($key){
		switch($key){
			case str_contains($key, 'first_name'): 
				$key = 'first_name'; 
				break;
			case str_contains($key, 'last_name'): 
				$key = 'last_name';
				break;
			case str_contains($key, 'relationship'): 
				$key = 'relationship';
				break;
			case str_contains($key, 'show_in_directory'): 
				$key = 'show_in_directory';
				break;
			case str_contains($key, 'member_groups_profile_picture'): 
				$key = 'profile_picture';
				break;
			case str_contains($key, 'remove_profile_picture'): 
				$key = 'profile_picture';
				break;
			case str_contains($key, 'profile_picture_aid'): 
				$key = 'profile_picture';
				break;
			case str_contains($key, 'email_address'): 
				$key = 'email_address';
				break;
			case str_contains($key, 'phone_number'): 
				$key = 'phone_number';
				break;
			case str_contains($key, 'birthday'):
				$key = 'birthday'; 
				break;
			default: break;
		}
		return $key;
	}

	/*
	 * Save the member profile fields 
	 * 
	 * @params WP_Rest_Request
	 * 
	 * @returns json
	 */
	public function save_member_profile(WP_REST_Request $request){

		if(!$request->get_params()) {
			wp_send_json_error();
		}
		
		wp_send_json_success($request->get_params());
		
		$member_groups = array();
		
		
		
		if($_POST){
			foreach($_POST as $key => $value){
				if(str_contains($key, 'member_groups')){
					preg_match('/\d/', $key, $group_number); 
					$key = $this->member_group_key($key);
					
					if($key == 'show_in_directory'){
						$value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
					}
					
					$member_groups[$group_number[0]][$key] = $value;	
				}
			}
		}
		
		if($_FILES){
			foreach($_FILES as $key => $value){
				if(str_contains($key, 'member_groups')){
					preg_match('/\d/', $key, $group_number); 
					$key = $this->member_group_key($key);
					
					$member_groups[$group_number[0]][$key] = $this->upload_image($value);
				}
			}
		}	
		
		$membership_id = filter_input(INPUT_POST, 'membership_id');
		
		if(!$membership_id){
			wp_send_json_error();
		}
		
		$user_id = filter_input(INPUT_POST, 'current_user');						
		$post_id = $this->get_member($membership_id)->ID;

		update_field('member_group_authorized_users', $member_groups, $post_id);		
		update_user_meta( $user_id, 'membership_id', $membership_id );
		
		wp_send_json_success($member_groups);	
	}
	
	
	
	/**
	 * Upload the member profile image 
	 */
	public function upload_member_profile_picture(){
		$img = $_FILES['profile_image'];
		$user_id = filter_input(INPUT_POST, 'user_id');
		$membership_id = get_user_meta($user_id, 'membership_id');
		$member_post_id = $this->get_member($membership_id)->ID;
		$attach_id = $this->upload_image($img);

		if(!$attach_id){
			return false;
		}
		
		$update_profile_image = update_field('profile_picture', $attach_id, 'user_' . $user_id);	
		update_field('profile_picture', $attach_id, $member_post_id);
		
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
		
		$directory_args = array(
			'post_type'		=> 'member', 
			'post_status'	=> 'publish', 
			'posts_per_page'	=> -1, 
		);
		
		$members = get_posts($directory_args);
		
		$directory = array();
		
		
		if($members){
			
			foreach($members as $member){
			
				$id = $member->ID;
				$name = "";
				$name = implode( ' ', array(
					get_field('first_name', $id), 
					get_field('last_name', $id), 
				) );
				
				$authorized_users = get_field('member_group_authorized_users', $id);
				
				if($authorized_users){
					foreach($authorized_users as $user){
												
						if($user['show_in_directory'] == true){
							$directory[] = array(
								'post_id'			=> $id, 
								'last_name'			=> $user['last_name'],
								'first_name'		=> $user['first_name'],
								'name' 				=> implode(' ', array($user['first_name'], $user['last_name'])),
								'profile_picture' 	=> $user['profile_picture'] ? $user['profile_picture']['url'] : OFRC_URI . '/assets/static/img/profile_placeholder.png',
								'permalink'			=> get_permalink($id),
							);
						}
					}
				}
				
				$directory[] = array(
					'post_id'			=> $id,
					'last_name'			=> get_field('member_profile_last_name', $id), 
					'first_name'		=> get_field('member_profile_first_name', $id),
					'name'				=> $name,
					'profile_picture'	=> get_field('profile_picture',  $id ) ? get_field('profile_picture', $id)['url'] : OFRC_URI . '/assets/static/img/profile_placeholder.png',
					'permalink'			=> get_permalink($id),
				);
			}
		}
		usort($directory, array($this, 'organize_directory'));
		wp_send_json($directory);
	}
	
	private function organize_directory($a, $b){
		if($a['last_name'] === $b['last_name']){
			return strcmp($a['first_name'], $b['first_name']);
		}else{
			return strcmp($a['last_name'], $b['last_name']);
		}
	}
	
	public function custom_member_role(){
		if(get_option('ofrc_custom_roles_version') < 1){
			add_role('member', 'Member', array('read'	=> true, 'level_0' => true));
			update_option('ofrc_custom_roles_version', 1);
		}
	}
	
	public function member_profile_admin_page(){
		if(function_exists('acf_add_options_page')){
			acf_add_options_sub_page( array(
				'page_title'	=> 'Member Dashboard Settings', 
				'menu_title'	=> 'Settings', 
				'parent_slug'	=> 'edit.php?post_type=member',
			) );
			
			acf_add_options_sub_page( array(
				'page_title'	=> 'Memberships Updater', 
				'menu_title'	=> 'Memberships Updater', 
				'parent_slug'	=> 'edit.php?post_type=member',
			) );
		}
	}
	
}

new OFRC_Member_Profiles();