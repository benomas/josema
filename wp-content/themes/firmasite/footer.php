<?php
/**
 * @package firmasite
 */
global $firmasite_settings;
?>
		<p style="border: 1px solid #cccccc;
				    border-radius: 4px;
				    height: 50px;
				    margin: 0 15px;
				    padding: 10px;
				    width: auto;"
		>
		<b>Lee nuestro <a href="http://josema.com.mx/?page_id=478">aviso de privacidad</a></b>
		</p>
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

jQuery('#grid_searsh_g').keydown(function (e)
{
    if(e.keyCode == 13)
		searsh_redirect();
});

jQuery(document).ready(function()
{
	jQuery( '.tooltip_panel' ).tooltip(
	{
			position:
			{
				my: "center bottom-20",
				at: "center top",
				using: function( position, feedback )
				{
					jQuery( this ).css( position );
					jQuery( "<div>" )
					.addClass( "arrow" )
					.addClass( feedback.vertical )
					.addClass( feedback.horizontal )
					.appendTo( this );
				}
			}
	});

	if(typeof alertify!=='undefined')
	{
		alertify.set({ labels:
		{
		    ok     : "Correcto",
		    cancel : "Cancelar"
		} });
	}


});
</script>