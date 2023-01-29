<?php 
/**
 * Template Name: Member Account 
 */ 
 get_header(); 
 ?>
 
 <?php 
    var_dump(current_user_can('read'));
    var_dump(get_role('member')->capabilities)
 ?>
 
 <div class="member-profile-container">
 
     <?php 
     if(!is_user_logged_in()){
    	 get_template_part( 'template-parts/template', 'member-login' );
     }else{
        get_template_part('template-parts/template', 'member-edit-profile');
     }
     
     ?>
     
 </div>
 <div class="loading-indicator">
      <i class="fas fa-spinner fa-3x fa-pulse"></i>
 </div>
 <?php 
get_footer(); 