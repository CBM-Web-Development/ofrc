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
	}
	
	public function get_archives(WP_Rest_Request $request){
		
		if( empty($request->get_params()) ){
			wp_send_json_error( 'no parameters' );
		}
		
		
		$category = $request->get_param('category');
		
		$page = $request->get_param('page');
				
		$archives_args = array(
			'post_type'			=> 'post',
			'post_status'		=> 'publish', 
			'posts_per_page' 	=> 12, 
			'paged'				=> $page,
		);
		
		if($category){
			$archives_args['cat'] = $category;
		}
		
		
				
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