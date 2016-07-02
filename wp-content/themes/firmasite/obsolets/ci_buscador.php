<?php
/*
Template Name: buscador
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
global $firmasite_settings;

get_header(); 
 ?>
 <script src="<?php echo get_rcodeigniter_url();?>js/jquery-1.11.0.min.js" type="text/javascript" style=""></script>
<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		
		<div id="form_container">
		</div>
		<script>
			temp="<?php echo urlencode($_GET['grid_searsh']);?>";
			$.ajax({
					url : '<?php echo get_rcodeigniter_access_url('inventario/buscar/');?>',
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