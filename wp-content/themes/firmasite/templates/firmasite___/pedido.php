<?php
/*
Template Name: Pedido template
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
session_start();
global $firmasite_settings; 
if(!$_SESSION['josema'])
	login_redirect();
get_header(); 
 ?>
 <script src="scripter/js/jquery-1.11.0.min.js" type="text/javascript" style=""></script>
<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		
		<div id="form_container">
		</div>
		<script>
			$.ajax({
					url : 'scripter/index.php/formSender/loadForm',
					type: 'POST',
					success : function(html)
					{
							$('#form_container').html(html);
                    }           
				});
		</script>
			

			
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>