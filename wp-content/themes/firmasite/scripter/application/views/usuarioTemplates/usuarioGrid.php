<div >
<form id="userGridForm" name="userGridForm">

<table class="table table-responsive table-hover">
	<tr class="success">
		<td class="no_essencial">
		</td>
		<td class="no_essencial">
		</td>
		<td class="no_essencial">
		</td>
		<td >
		</td>
		<td class="no_essencial2">
		</td>
		<td class="no_essencial2">
		</td>
		<td >
		</td>
		<td class="no_essencial2">
		</td>
		<td >
		</td>
		<td style="text-align:center;">
			<div class="bno-accions acciones">
				<div class="icon- bno-button tooltip_class_accion" title="Añadir usuario" id="ci_add_button">
				&#xe702
				</div>
			</div>
		</td>
	</tr>
	<tr class="success">
		<td class="no_essencial"><b>Nombre:</b>
		</td>
		<td class="no_essencial"><b>Apellido paterno:</b>
		</td>
		<td class="no_essencial"><b>Apellido materno:</b>
		</td>
		<td><b>Nick:</b>
		</td>
		<td class="no_essencial2"><b>Telefono:</b>
		</td>
		<td class="no_essencial2"><b>correo:</b>
		</td>
		<td><b>Rol usuario:</b>
		</td>
		<td class="no_essencial2"><b>Tipo cliente:</b>
		</td>
		<td ><b>Activo:</b>
		</td>
		<td class="col-md-2" style="text-align:center;"><b>ACCIONES:</b>
		</td>
	</tr>
	<?php
		foreach($usuarios AS $usuario)
		{
	?>
		<tr>
			<td class="no_essencial">
				<?php echo $usuario['nombre'];?>
			</td>
			<td class="no_essencial">
				<?php echo $usuario['apellido_paterno'];?>
			</td>
			<td class="no_essencial">
				<?php echo $usuario['apellido_materno'];?>
			</td>
			<td>
				<?php echo $usuario['nick'];?>
			</td>
			<td class="no_essencial2">
				<?php echo $usuario['telefono'];?>
			</td>
			<td class="no_essencial2">
				<?php echo $usuario['email'];?>
			</td>
			<td>
				<?php echo $usuario['rol'];?>
			</td>
			<td class="no_essencial2">
				<?php echo $usuario['tipo_negocio'];?>
			</td>
			<td>
				<?php echo $usuario['activo'];?>
			</td>
			<td class="success" style="text-align:center;">
				<div class="bno-accions acciones">
					<?php
					if($usuario['activo']=='No')
					{
					?>
					<div class="icon- bno-button  tooltip_class_accion " title="Activar usuario" id="activar_usuario" onclick="activar_usuario('<?php echo $usuario['id_usuario']; ?>');">
							&#xe689
					</div>
					<?php
					}
					else
					{
					?>
					<div class="icon- bno-button  tooltip_class_accion " title="Desactivar usuario" id="desactivar_usuario" onclick="desactivar_usuario('<?php echo $usuario['id_usuario']; ?>');">
							&#xe68a
					</div>
					<?php
					}
					?>
					<div class="icon- bno-button  tooltip_class_accion " title="Editar usuario" id="ci_add_button" onclick="editar_usuario('<?php echo $usuario['id_usuario']; ?>');">
							&#xe605
					</div>
				</div>
			</td>
		<?php
		}
		?>
	</tr>
</table>
</form>
</div>
<br>
<br>
<script>
$(document).ready(function()
{
		$('#ci_add_button').click(function()
		{
			$.ajax(
			{
						url : '<?php echo site_url();?>/usuario/addUser',
						type: 'POST',
						success : function(html)
						{
								$('#form_container').html(html);
						}
			});
		});

	jQuery( '.tooltip_class_accion' ).tooltip(
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
});

function desactivar_usuario(id_usuario)
{

	$.ajax(
	{
		url : '<?php echo site_url();?>/usuario/deactivateUser/' + id_usuario,
		type: 'POST',
		success : function(html)
		{
				$('#form_container').html(html);
				alertify.success('Usuario desactivado');
		}
	});
}

function activar_usuario(id_usuario)
{

	$.ajax(
	{
		url : '<?php echo site_url();?>/usuario/activateUser/' + id_usuario,
		type: 'POST',
		success : function(html)
		{
				$('#form_container').html(html);
				alertify.success('Usuario activado');
		}
	});
}

function editar_usuario(id_usuario)
{

	$.ajax(
	{
		url : '<?php echo site_url();?>/usuario/updateUser/' + id_usuario,
		type: 'POST',
		success : function(html)
		{
				$('#form_container').html(html);
		}
	});
}
</script>