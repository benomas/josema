<?php
$username = array(
	'name'	=> 'username',
	'id'	=> 'username',
	'size'	=> 30,
	'value' => set_value('username')
);

$password = array(
	'name'	=> 'password',
	'id'	=> 'password',
	'size'	=> 30
);

$entrar = array(
	'name' => 'login',
	'value' => 'Acceder',
	'class' => 'controles'
);	

?>

<div id="container">
	<form id="formularioLogin">
	<table summary="" border="0" class="logon">
<tbody>
	<tr>
	<td class="title"><label for="username">Usuario</label></td>
	<td><input type="text" name="username" value="" id="username" size="30"/></td>
	</tr>

	<tr>
	<td class="title"><label for="rcmloginpwd"><label for="password">Contraseña</label></label></td>
	<td><input type="password" name="password" value="" id="password" size="30"  /></td>
	</tr>
	<tr>
		<td></td>
		<!--
		<td><input type="checkbox" name="remember" value="1" id="remember" style="margin:0;padding:0"  /> <label for="remember">Recordar</label></td>
		-->
	</tr>

</tbody>
</table>
<p align="center"><input type="submit" name="login" value="Iniciar Sesión" class="mainaction" onclick="javascript:cargando();" /></p>
</form>
</div>
<script>
$(document).ready(function()
{
	/*var temp=$('#numeroFilas').val();
	var limit=<?php echo $filasDefault;?>;
	$('#marcadorCampos').html('Campos habilitados:' + $('#numeroFilas').val());
	$('#boton_enviar').click(function()
	{
				
		$.ajax(
		{
					url : '<?php echo site_url();?>/formSender/getTest',
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
	});*/
});
</script>