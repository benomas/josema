<?php
/**
 * @package firmasite
 */
// this one letting us translate page template names
?>
<script>
	$.ajax({
			url : '<?php echo get_rcodeigniter_access_url('carrito/vistaCarrito');?>',
			type: 'POST',
			success : function(html)
			{
					$('#form_container').html(html);
			}           
		});
</script>