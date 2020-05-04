<?php
/*
Plugin Name: Post Meta Data
Plugin URI: https://github.com/mohdalam392/WP_List_Table-of-wp_postmeta-wordpress-table
Description: Post Meta Data List (Insert,Update,Delete)
Author: Mohd Alam
Version: 1.0
Author URI: http://www.facebook.com/alamdeveloper
*/

?>
<?php 
add_action('init',function(){

	/** Post Meta Deta **/
	require_once('includes/posts/class-postsmetadata-menu.php');
	require_once('includes/posts/class-postmeta-list-table.php');
	require_once('includes/posts/class-postmeta-form-handler.php');	
	require_once('includes/posts/postmeta-functions.php');
	new PostsMetaData_Menu();
	/** Post Meta Deta **/
});

