<?php
/**
 * @package firmasite
 */
global $firmasite_settings;
?>
		</div><!--  .row -->
        <?php do_action( 'after_content' ); ?>    
	</div><!-- #main .site-main -->

	<?php //get_template_part( 'templates/footer', $firmasite_settings["footer-style"] ); ?>
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

</body>
</html>
	
<script>
function searsh_redirect()
{
	searsh_value=document.getElementById('grid_searsh_g').value;
	searsh_value=encodeURIComponent(searsh_value);
	window.location = '<?php echo home_url().'/?page_id=23';?>&grid_searsh=' + searsh_value;
}
</script>