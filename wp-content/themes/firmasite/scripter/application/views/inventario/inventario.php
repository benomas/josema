<style>
	.shadow_marco
	{
		background-color: #FFFFFF;
		border: 3px solid #CCCCCC;
		border-radius: 5px;
		box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.1);
		width:100%;
		margin-bottom: 21px;
		margin-left:1%;
		margin-right:1%;
	}
	
	
	.shadow_marco:hover
	{	
		/*border: 2px solid #DD4814;*/
		box-shadow: 15px 15px 0 rgba(0, 0, 0, 0.1);
		margin-top: -20px;
		margin-left: -20px;
	}
	
	.tittle_marco
	{
		color:#FFFFFF;
		background-color:#AE3910;
		font-size:20px;
		text-transform:uppercase;
		text-align:center;
		border-bottom:3px solid #772953;
		border-top:3px solid #772953;
		margin-top:-11px;
		/*margin-left:-16px;*/
		/*margin-right:-16px;*/
		border-top-left-radius:5px;
		border-top-right-radius:5px;
	}
</style>
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