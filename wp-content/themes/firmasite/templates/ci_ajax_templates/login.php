<?php
/**
 * @package firmasite
 */
// this one letting us translate page template names
?>	
<script>
	$.ajax({
			url : '<?php echo get_rcodeigniter_access_url('seguridad');?>',
			type: 'POST',
			success : function(html)
			{
					if(html!='correcto')
						$('#form_container').html(html);
					else
						window.location = '<?php echo home_url(); ?>';
			}           
		});
</script>