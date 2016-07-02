<div >
<form id="catFinder" name="catFinder">
<?php echo $dataUniverse;
/*
<table class="table table-bordered table-striped table-responsive table-hover">
	<tr >
		<td colspan="3">
			<b>Busqueda simple: <label style="color:#772953;" ><?php echo $this->input->post('grid_searsh');?> </label></b>
		</td>
		<td colspan="3">
			<b><input class="form-control input-lg" id="grid_searsh" name="grid_searsh"  type="text"></b>
		</td>
		<td colspan="3">
			<div id="boton_buscar" class="btn btn-primary btn-lg btn-block"   name="boton_buscar">Buscar</div>
		</td>
	</tr>

	<tr class="success">
		<td>
			<b>CODIGO INJEKTION</b>
		</td>
		<td>
			<b>REF 1</b>
		</td>
		<td>
			<b>REF 2</b>
		</td>
		<td>
			<b>REF 3</b>
		</td>
		<td>
			<b>MARCA</b>
		</td>
		<td>
			<b>DESCRIPCION</b>
		</td>
		<td>
			<b>PRECIO INJEKTION 1</b>
		</td>
		<td>
			<b>PRECIO INJEKTION 2</b>
		</td>
		<td>
			<b>PRECIO INJEKTION 3</b>
		</td>
	</tr>
<?php
	foreach($cat_injektion AS $injektion)
	{
		$temp=
		'<tr >
			<td>
				<b>'.$injektion['codigo'].'</b>
			</td>
			<td>
				<b>'.$injektion['ref1'].'</b>
			</td>
			<td>
				<b>'.$injektion['ref2'].'</b>
			</td>
			<td>
				<b>'.$injektion['ref3'].'</b>
			</td>
			<td>
				<b>'.$injektion['marca'].'</b>
			</td>
			<td>
				<b>'.$injektion['descripcion'].'</b>
			</td>
			<td>
				<b>'.$injektion['precio1'].'</b>
			</td>
			<td>
				<b>'.$injektion['precio2'].'</b>
			</td>
			<td>
				<b>'.$injektion['precio3'].'</b>
			</td>
		</tr>';
		echo str_ireplace( $this->input->post('grid_searsh') , '<label style="color:#772953;" >'.$this->input->post('grid_searsh').'</label>' , $temp );
	}
?>
</table>
*/?>
</form>
</div>
<br>
<br>
<script>
$(document).ready(function()
{
		$('#boton_buscar').click(function()
		{
			$.ajax(
			{
						url : '<?php echo site_url();?>/gridManajer/cat_injektion',
						type: 'POST',
						data: $('#catFinder').serialize(),
						success : function(html)
						{
								$('#form_container').html(html);
						}           
			});	
		});
		
});
</script>