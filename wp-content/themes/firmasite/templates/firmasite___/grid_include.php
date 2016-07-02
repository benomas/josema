<?php
/*
Template Name: grid_include
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
$user_info= wp_get_current_user(); 
session_start();
$_SESSION['wp_user_info']=$user_info->data->ID;
global $firmasite_settings;

get_header(); 
 ?>
 <script src="scripter/js/jquery-1.11.0.min.js" type="text/javascript" style=""></script>

<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		
		<div id="form_container">
		</div>
		<script>
			temp="<?php echo urlencode($_GET['grid_searsh']);?>";
			$.ajax({
					url : 'scripter/index.php/gridManajer/cat_Injektion/',
					type: 'POST',
					data: 'grid_searsh=' + temp,
					success : function(html)
					{
							$('#form_container').html(html);
                    }           
				});
		</script>
			

			
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>