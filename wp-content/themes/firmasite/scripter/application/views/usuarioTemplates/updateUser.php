<div id="container">
	<form id="editUserForm">
	<?php
		if(!empty($usuario->id_usuario)){
			$id_usuario_back      =$usuario->id_usuario;
			$id_tipo_cliente_back =$usuario->id_tipo_cliente;
			$id_vendedor_back     =$usuario->id_vendedor;
		}
		else{
			$id_usuario_back      ='';
			$id_tipo_cliente_back ='';
			$id_vendedor_back     ='';
		}
	?>
	<input type="hidden" name="id_usuario" id="id_usuario" value="<? echo set_value('id_usuario',$id_usuario_back);?>" />
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
												'value' => set_value('nombre',$usuario->nombre),
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
												'value' => set_value('apellido_paterno',$usuario->apellido_paterno),
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
				<?php 							
						if(!empty($usuario->apellido_materno))
							$apellido_materno_back=$usuario->apellido_materno;
						else
							$apellido_materno_back='';
							
						echo form_input( 
									array	(	'id' 	=> 'apellido_materno',
												'name' 	=> 'apellido_materno',
												'class' => 'form-control',
												'value' => set_value('apellido_materno',$apellido_materno_back),
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
												'value' => set_value('nick',$usuario->nick),
												'size' 	=> '50'
											) 
								) ;
				?>
			</td>
		</tr>
		<?php echo form_error('nick');?>
		<?php
			if($rol_editor=='1')
			{
		?>
		<tr>
			<td >
				Cambiar clave?:
			</td>
			<td >
				<?php echo form_checkbox(
											array(	'id' 		=> 'cambiar_clave',
													'name' 		=> 'cambiar_clave',
													'checked' 	=> set_value('cambiar_clave','true'),
													'class' 	=> 'form-control',
													'value' 	=> 1
													)
									); 
				?>
			</td>
		</tr>
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
		<?php
			}
		?>
		<?php echo form_error('clave');?>
		<tr>
			<td >
				Domicilio:
			</td>
			<td >
				<?php 
					if(!empty($usuario->domicilio))
						$domicilio_back=$usuario->domicilio;
					else
						$domicilio_back='';
					echo form_input( 
										array	(	'id' 	=> 'domicilio',
													'name' 	=> 'domicilio',
													'class' => 'form-control',
													'value' => set_value('domicilio',$domicilio_back),
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
												'value' => set_value('telefono',$usuario->telefono),
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
				<?php 	
						if(!empty($usuario->rfc))
							$rfc_back=$usuario->rfc;
						else
							$rfc_back='';
						echo form_input( 
									array	(	'id' 	=> 'rfc',
												'name' 	=> 'rfc',
												'class' => 'form-control',
												'value' => set_value('rfc',$rfc_back),
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
												'value' => set_value('email',$usuario->email),
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
				<?php 	
						if(!empty($usuario->id_rol_usuario))
							$id_rol_back=$usuario->id_rol_usuario;
						else
							$id_rol_back='-';
					echo form_dropdown(	"id_rol",
											$roles,
											set_value('id_rol',$id_rol_back),
											" id='id_rol'"
										);
				?>
			</td>
		</tr>
		<?php echo form_error('id_rol');?>
		<tr class="row-tipo-cliente">
			<td >
				Tipo cliente:
			</td>
			<td class="select-container">
			</td>
		</tr>
		<?php echo form_error('id_tipo_cliente');?>
		<tr class="row-vendedor">
			<td >
				Vendedor:
			</td>
			<td class="select-container">
			</td>
		</tr>
		<?php echo form_error('vendor_id');?>
		<tr>
			<td >
				Suspendido:
			</td>
			<td >
				<?php echo form_checkbox(
											array(	'id' 		=> 'suspended',
													'name' 		=> 'suspended',
													'checked' 	=> set_value('suspended')?1:$usuario->suspended,
													'class' 	=> 'form-control',
													'value' 	=> 1
													)
									); 
				?>
			</td>
		</tr>
		
	</table>
	</form>
	<div>
		<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Registrar</div>
	</div>
</div>
<script>
var oldidClientType = "<?php echo set_value('id_tipo_cliente',$id_tipo_cliente_back);?>";
var oldVendor       = "<?php echo set_value('id_vendedor',$id_vendedor_back);?>";

function loadClientTypes(){
	$.ajax(
	{
		url        :'<?php echo site_url();?>/usuario/ajaxClientTypeSelect',
		type       :'get',
		contentType:"application/json; charset=utf-8",
		dataType   :"json",
		success : function(json){
			$(".row-tipo-cliente .select-container").html("<select id='id_tipo_cliente'>"+getOptions(json)+"<select>");
			$(".row-tipo-cliente .select-container select").val(oldidClientType);
			$(".row-tipo-cliente").slideDown(slideTime);
		}           
	});
};

function loadVendors(){
	$.ajax(
	{
		url        :'<?php echo site_url();?>/usuario/ajaxVendorSelect',
		type       :'get',
		contentType:"application/json; charset=utf-8",
		dataType   :"json",
		success : function(json){
			$(".row-vendedor .select-container").html("<select id='id_vendedor'>"+getOptions(json)+"<select>");
			$(".row-vendedor .select-container select").val(oldVendor);
			$(".row-vendedor").slideDown(slideTime);
		}           
	});
};

function switchOptions(){
	loadClientTypes();
	if($("#id_rol option:selected").text()==="Cliente"){
		loadVendors();
	}
	else{
		$(".row-tipo-cliente .select-container").html("");
		$(".row-tipo-cliente,.row-vendedor").slideUp(slideTime);
		$(".row-vendedor .select-container").html("");
		$(".row-vendedor,.row-vendedor").slideUp(slideTime);
	}
}

$(document).ready(function()
{
	$('#boton_enviar').click(function()
	{
		var serializedData = $('#editUserForm').serialize();
		if(	$(".row-tipo-cliente .select-container select").length && 
			$(".row-tipo-cliente .select-container select").val() && 
			$(".row-tipo-cliente .select-container select").val()!=="-"
			)
			serializedData+="&id_tipo_cliente="+$(".row-tipo-cliente .select-container select").val();

		if(	$(".row-vendedor .select-container select").length && 
			$(".row-vendedor .select-container select").val() && 
			$(".row-vendedor .select-container select").val()!=="-"
			)
			serializedData+="&id_vendedor="+$(".row-vendedor .select-container select").val();
		$.ajax(
		{
			url : '<?php echo site_url();?>/usuario/saveUser',
			type: 'POST',
			data: serializedData,
			success : function(html)
			{
				$('#form_container').html(html);
			}           
		});
	});

	$("#id_rol").change(function(event){
		switchOptions();
	});

	switchOptions();

});
</script>