<?php 

class OFRC_REST{
	function __construct(){
		add_action('rest_api_init', array($this,'endpoints_init'));
	}
	
	/**
	 * Register each rest route in this function 
	 */
	public function endpoints_init(){
		register_rest_route('ofrc/v1', '/archives', array(
			'methods'	=> array('GET', 'POST'),
			'callback'	=> array($this, 'get_archives'),
			'permission_callback'	=> '__return_true'
		));	
		
		register_rest_route('ofrc/v1', '/mobile-sign-in', array(
			'methods'	=> array('GET', 'POST'),
			'callback'	=> array($this, 'mobile_sign_in'),
			'permission_callback'	=> '__return_true'
		));	
		
		register_rest_route('ofrc/v1', 'directory-feed', array(
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'get_directory_feed'), 
			'permission_callback'	=> function(WP_REST_Request $request){				
				return user_can($request->get_param('user_id'), 'level_0');
			}
		) );
		
		register_rest_route('ofrc/v1', 'directory-feed/get-member', array(
			'methods'	=> array('GET', 'POST'), 
			'callback'	=> array($this, 'get_member_from_directory'), 
			'permission_callback'	=> function(WP_REST_Request $request){				
				return user_can($request->get_param('user_id'), 'level_0');
			}
		) );
	}
	
	/**
	 * Get an individual member from the directory 
	 * 
	 * @params WP_REST_Request 
	 * @returns json - member profile
	 */
	public function get_member_from_directory(WP_REST_Request $request){
		
		if(!$request->get_params() || !$request->get_param('member_id')){
			return wp_send_json_error( array('response' => 'invalid_member_id') );
		}
		
		$member_id = $request->get_param('member_id');
		
		
		$name = '';
		
		if(get_field('prefix', 'user_' . $member_id)){
			$name .= get_field('prefix', 'user_' . $member_id) . ' ';
		}
		
		if(get_field('first_name', 'user_' . $member_id)){
			$name .= get_field('first_name', 'user_' . $member_id);
		}
		
		if(get_field('last_name', 'user_' . $member_id)){
			$name .= ' ' . get_field('last_name', 'user_' . $member_id);
		}
		
		if(get_field('suffix', 'user_' . $member_id)){
			$name .= ' ' . get_field('suffix', 'user_' . $member_id);
		}
		$member_profile = array(
			'member_name'	=> $name,
			'mobile_phone'	=> get_field('mobile_phone', 'user_' . $member_id),
			'home_phone'	=> get_field('home_phone', 'user_' . $member_id),
			'work_phone'	=> get_field('work_phone', 'user_' . $member_id),
			'birthday'		=> date_format(date_create(get_field('birthday', 'user_' . $member_id)), 'F d, Y'),
			'is_birthday'	=> date('Y-m-d') == get_field('birthday', 'user_' . $member_id),
			'gender'		=> get_field('gender', 'user_' . $member_id), 
			'email_address'	=> get_field('email_address', 'user_' . $member_id), 
			'profile_picture'	=> get_field('profile_picture', 'user_' . $member_id) ?  get_field('profile_picture', 'user_' . $member_id)['url'] : false,
			'biography'		=> get_field('biography', 'user_' . $member_id)
		);
		
		return wp_send_json_success($member_profile);
	}
	
	public function mobile_sign_in(WP_REST_Request $request){
		$username = $request->get_param('username');
		$password = $request->get_param('password');
		
		$user = wp_authenticate( $username, $password );

		return !is_wp_error($user) ? wp_send_json_success( $user->ID ) : wp_send_json_error( false );
	}
	
	/**
	 * Get the directory feed 
	 * 
	 * @params WP_REST_Request 
	 * 
	 * @returns json 
	 */
	public function get_directory_feed(WP_REST_Request $request){
		
		$user_query_args = array(
			'role' => 'member',
			'orderby'	=> 'meta_value', 
			'meta_key'	=> 'last_name',
			'order'	=> 'ASC'
		);
		
		// Get any search parameters 
		if($request->get_param('search_terms')){
			
		}
		
		$user_query = new WP_User_Query($user_query_args);
		
		$users = array();
		
		if($user_query->get_results()){
			foreach($user_query->get_results() as $user){
				$user_id = $user->ID;
				
				
				$users[] = $u = array(
					'user_id'	=> $user_id,
					'first_name' => get_field('first_name', 'user_' . $user_id),
					'last_name' => get_field('last_name', 'user_' . $user_id),
					'profile_picture' => get_field('profile_picture', 'user_' . $user_id)['url'],
				);
			}
		}
		
		// Get the directory 
		
		return wp_send_json_success($users);
	}
	
	public function get_archives(){
		
		
		$category = isset($_GET['category']) ? $_GET['category'] : filter_input(INPUT_POST, 'category');
		
		$page = isset($_GET['page']) ? $_GET['page'] : filter_input(INPUT_POST, 'page');
				
		$archives_args = array(
			'post_type'			=> 'post',
			'cat'				=> $category, 
			'post_status'		=> 'publish', 
			'posts_per_page' 	=> 2, 
			'paged'				=> isset($page) ? $page : 1,
		);
				
		$archives_query = new WP_Query($archives_args);
		
		$all_posts = array();
		
		if($archives_query->have_posts()){
			while($archives_query->have_posts()){
				$archives_query->the_post();
				
				$post = array(
					'post_id'	=> get_the_ID(),
					'title'	=> get_the_title(),
					'excerpt'	=> get_the_excerpt(),
					'permalink'	=> get_the_permalink(),
					'thumbnail'	=> get_the_post_thumbnail_url(),
					'post_date'	=> get_the_date()
				);
				
				
				$all_posts[] = $post;
			}
		}
		
		$num_pages = $archives_query->max_num_pages;
		
		wp_reset_postdata();
		
		return array('posts' => $all_posts, 'num_pages' => $num_pages);
	}
}

new OFRC_REST();