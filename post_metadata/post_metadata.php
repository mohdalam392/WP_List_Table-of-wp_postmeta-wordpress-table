<?php
/*
Plugin Name: Post Meta Data
Plugin URI: 
Description: 
Author: Mohd Alam
Version: 1.7.2
Author URI: 
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