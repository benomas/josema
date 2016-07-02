<?php
/*
Template Name: custom_login
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
$user_info= wp_get_current_user(); 
session_start();
$_SESSION['wp_user_info']=$user_info->data->ID;

get_header();
 ?>
<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		
		<?php if($user_info->data->ID==0) 
				 wp_login_form( $args ); 
			  else
				  echo "Ya te has logueado previamente";
		?> 
		

			
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>