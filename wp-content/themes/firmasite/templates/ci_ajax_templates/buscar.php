<?php
/**
 * @package firmasite
 */
// this one letting us translate page template names
?>
<script>
	var url = '<?php echo get_rcodeigniter_access_url('inventario/buscar/');?>'
	<?php
		if(!empty($_GET["basic_filter_name"]) && !empty($_GET["basic_filter_value"]))
		{
	?>
		url += '0?basic_filter_name=<?php echo $_GET["basic_filter_name"];?>&basic_filter_value=<?php echo $_GET["basic_filter_value"];?>'
	<?php
		}
	?>
	$.ajax({
			url,
			type: 'POST',
			success : function(html)
			{
					$('#form_container').html(html);
			}           
		});
</script>