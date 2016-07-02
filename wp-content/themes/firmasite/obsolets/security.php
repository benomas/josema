<?php
/*
Template Name: security
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
global $firmasite_settings;

get_header();
 ?>
 <script src="scripter/js/jquery-1.11.0.min.js" type="text/javascript" style=""></script>

<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		
		<div id="form_container">
		</div>
		<script>
			$.ajax({
					url : 'scripter/index.php/seguridad/',
					type: 'POST',
					success : function(html)
					{
							if(html!='correcto')
								$('#form_container').html(html);
							else
								window.location = ''
                    }           
				});
		</script>
			

			
		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>