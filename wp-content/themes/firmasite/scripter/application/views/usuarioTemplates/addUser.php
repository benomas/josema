<div id="container">
	<form id="addUserForm">
	<table class="table" id="formSeccion1">
		<tr>
			<td >
				Nombre:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'nombre',
												'name' 	=> 'nombre',
												'class' => 'form-control',
												'value' => set_value('nombre'),
												'size' 	=> '50'
											) 
								) ;
				?>
				
			</td>
		</tr>
		<?php echo form_error('nombre');?>
		<tr>
			<td >
				Apellido paterno:
			</td>
			<td >			
				<?php echo form_input( 
									array	(	'id' 	=> 'apellido_paterno',
												'name' 	=> 'apellido_paterno',
												'class' => 'form-control',
												'value' => set_value('apellido_paterno'),
												'size' 	=> '50'
											) 
								) ;
				?>
				
			</td>
		</tr>
		<?php echo form_error('apellido_paterno');?>
		<tr>
			<td >
				Apellido materno:
			</td>
			<td >								
				<?php echo form_input( 
									array	(	'id' 	=> 'apellido_materno',
												'name' 	=> 'apellido_materno',
												'class' => 'form-control',
												'value' => set_value('apellido_materno'),
												'size' 	=> '50'
											) 
								) ;
				?>
				
			</td>
		</tr>
		<?php echo form_error('apellido_materno');?>
		<tr>
			<td >
				Nick:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'nick',
												'name' 	=> 'nick',
												'class' => 'form-control',
												'value' => set_value('nick'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('nick');?>
		<tr>
			<td >
				Clave:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'clave',
												'name' 	=> 'clave',
												'class' => 'form-control',
												'value' => set_value('clave'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('clave');?>
		<tr>
			<td >
				Domicilio:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'domicilio',
												'name' 	=> 'domicilio',
												'class' => 'form-control',
												'value' => set_value('domicilio'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('domicilio');?>
		<tr>
			<td >
				Telefono:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'telefono',
												'name' 	=> 'telefono',
												'class' => 'form-control',
												'value' => set_value('telefono'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('telefono');?>
		<tr>
			<td >
				RFC:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'rfc',
												'name' 	=> 'rfc',
												'class' => 'form-control',
												'value' => set_value('rfc'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('rfc');?>
		<tr>
			<td >
				Email:
			</td>
			<td >
				<?php echo form_input( 
									array	(	'id' 	=> 'email',
												'name' 	=> 'email',
												'class' => 'form-control',
												'value' => set_value('email'),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('email');?>
		<tr>
			<td >
				Rol usuario:
			</td>
			<td >
				<?php echo form_dropdown(	"id_rol",
											$roles,
											set_value('id_rol','-'),
											" id='id_rol'"
										);
				?>
			</td>
		</tr>
		<?php echo form_error('id_rol');?>
		<tr>
			<td >
				Tipo cliente:
			</td>
			<td >
				<?php
				echo form_dropdown(	"id_tipo_cliente",
									$tipos_clientes,
									set_value('id_tipo_cliente','-'),
									" id='id_tipo_cliente'"
									);
				?>
			</td>
		</tr>
		<?php echo form_error('id_tipo_cliente');?>
		
		
	</table>
	</form>
	<div>
		<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Registrar</div>
	</div>
</div>
<script>
$(document).ready(function()
{
	
	$('#boton_enviar').click(function()
	{
				
		$.ajax(
		{
					url : '<?php echo site_url();?>/usuario/saveUser',
					type: 'POST',
					data: $('#addUserForm').serialize(),
					success : function(html)
					{
							$('#form_container').html(html);
					}           
		});
	});
});
</script>