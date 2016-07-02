<div id="container">
	<form id="formularioPedido">
	<input type="hidden" name="numeroFilas" id="numeroFilas" value="<?php echo set_value('numeroFilas',$filasDefault); ?>">
	<table class="table" id="formSeccion1">
		<tr>
			<td >
				Nombre del Cliente:
			</td>
			<td colspan="2">
				<?php echo $nombreUsuario;?>
			</td>
		</tr>
		<tr>
			<td >
				Fecha:
			</td>
			<td colspan="2">
				<input type="text" name="fecha" id="fecha" class="form-control">
			</td>
		</tr>
		<tr>
			<td>
				Tipo de Pedido
			</td>
			<td colspan="2">
				<?php
					echo form_dropdown(	"envio",
										array("1"=>"Normal", "2"=>"Urgente"),
										"1",
										" id='envio' class='test' "
										);
				?>
			</td>
		</tr>
		<tr>
			<td>
				Tipo de Negocio
			</td>
			<td colspan="2">
				<select class="form-control" name="Tipo de Negocio">
					<option value="1">Mayorista</option>
					<option selected="selected" value="2">Refaccionaria</option>
					<option value="3">Taller</option>
					<option value="4">Dueño del Vehiculo</option>
					<option value="otro">Otro</option>
				</select>
			</td>
		</tr>
	</table>
	<table class="table" id="formSeccion2">
		<tr style="text-align:center;">
			<td >
				<h4>CODIGO</h4>
			</td>
			<td>
				<h4>DESCRIPCION</h4>
			</td>
			<td>
				<h4>CANTIDAD</h4>
			</td>
		</tr>
		<tr id="numeroFila1">
			<td >
				<input class="form-control" id="npc1" name="NPC1" size="10" type="text">
			</td>
			<td>
				<input class="form-control" id="descripcion1" name="Descripcion1" size="50" type="text">
			</td>
			<td>
				<input class="form-control" id="cantidad1" name="Cantidad1" size="6" type="text">
			</td>
		</tr>
		<tr id="numeroFila2">
			<td>
				<input class="form-control" id="npc2" name="NPC2" size="10" type="text">
			</td>
			<td>
				<input class="form-control" id="descripcion2" name="Descripcion2" size="50" type="text">
			</td>
			<td>
				<input class="form-control" id="cantidad2" name="Cantidad2" size="6" type="text">
			</td>
		</tr>
		<tr id="numeroFila3">
			<td>
				<input class="form-control" id="npc2" name="NPC3" size="10" type="text">
			</td>
			<td>
				<input class="form-control" id="descripcion3" name="Descripcion3" size="50" type="text">
			</td>
			<td>
				<input class="form-control" id="cantidad3" name="Cantidad3" size="6" type="text">
			</td>
		</tr>
	</table>
	<table class="table" id="formSeccion3">
		<tr>
			<td style="text-align:center;">
				<div id="quitar" class="btn btn-default"  name="boton_quitar">-</div>
			</td>
			<td>
				<label id="marcadorCampos">Campos habilitados:</label>
			</td>
			<td style="text-align:center;" >
				<div id="aniadir" class="btn btn-default"   name="boton_aniadir">+</div>
			</td>
		</tr>
	</table>
	<table class="table" id="formSeccion4">
		<tr>
			<td>
				Observaciones
			</td>
			<td colspan="2">
				<textarea class="form-control" name="Observaciones" rows="3"></textarea>
			</td>
		</tr>
	</table>
	</form>
	<div>
		<div id="boton_limpiar" class="btn btn-default"  name="boton_limpiar">Borrar</div>
		<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Enviar </div>
	</div>
</div>
<script>
$(document).ready(function()
{
	var temp=$('#numeroFilas').val();
	var limit=<?php echo $filasDefault;?>;
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
	$('#boton_enviar').click(function()
	{
				
		$.ajax(
		{
					url : '<?php echo base_url();?>formSender/getTest',
					type: 'POST',
					data: $('#formularioPedido').serialize(),
					success : function(html)
					{
							$('#form_container').html(html);
					}           
		});
	});
	$('#aniadir').click(function()
	{
		temp=$('#numeroFilas').val();
		temp++;
		$('#numeroFilas').val(temp);
		newLine='<tr id="numeroFila'+ temp + '"><td><input class="form-control" id=npc'+ temp + ' name="NPC'+ temp + '" size="10" type="text"></td>';
		newLine+='<td><input class="form-control" id=descripcion'+ temp + ' name="Descripcion'+ temp + '" size="50" type="text"></td>';
		newLine+='<td><input class="form-control" id=cantidad' + temp + ' name="Cantidad'+ temp + '" size="6" type="text"></td></tr>';
		$('#formSeccion2').append(newLine);
		$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
	});
	
	
	$('#quitar').click(function()
	{
		temp=$('#numeroFilas').val();
		if(temp > limit)
		{
			$('#numeroFila' + temp).remove();
			temp--;
			$('#numeroFilas').val(temp);
		}
		$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
	});
});
</script>