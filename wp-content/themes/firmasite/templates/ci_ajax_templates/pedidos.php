<?php
/**
 * @package firmasite
 */
// this one letting us translate page template names
?>	
<script>
		<?php
			$traerCarrito=$_GET['traerCarrito'];
		?>
			$.ajax({
					url : '<?php echo get_rcodeigniter_access_url('formSender/loadForm/').$traerCarrito;?>',
					type: 'POST',
					success : function(html)
					{
						$('#form_container').html(html);
                    }           
				});
		</script>
</script>