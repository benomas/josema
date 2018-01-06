<div id="container">
	<form id="addUserForm">
	<table class="table" id="formSeccion1">
		<tr>
			<td >
				Nombre:
			</td>
			<td >
				<?php 
					echo form_input([	
						'id'    => 'nombre',
						'name'  => 'nombre',
						'class' => 'form-control',
						'value' => set_value('nombre'),
						'size'  => '50'
					]);
				?>
			</td>
		</tr>
		<?php echo form_error('nombre');?>
		<tr>
			<td >
				Apellido paterno:
			</td>
			<td >			
				<?php 
					echo form_input([
						'id' 	=> 'apellido_paterno',
						'name' 	=> 'apellido_paterno',
						'class' => 'form-control',
						'value' => set_value('apellido_paterno'),
						'size' 	=> '50'
					]);
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
					echo form_input([
						'id' 	=> 'apellido_materno',
						'name' 	=> 'apellido_materno',
						'class' => 'form-control',
						'value' => set_value('apellido_materno'),
						'size' 	=> '50'
					]) ;
				?>
				
			</td>
		</tr>
		<?php echo form_error('apellido_materno');?>
		<tr>
			<td >
				Nick:
			</td>
			<td >
				<?php 
					echo form_input([
						'id' 	=> 'nick',
						'name' 	=> 'nick',
						'class' => 'form-control',
						'value' => set_value('nick'),
						'size' 	=> '50'
					]);
				?>
			</td>
		</tr>
		<?php echo form_error('nick');?>
		<tr>
			<td >
				Clave:
			</td>
			<td >
				<?php 
					echo form_input([
						'id' 	=> 'clave',
						'name' 	=> 'clave',
						'class' => 'form-control',
						'value' => set_value('clave'),
						'size' 	=> '50'
					]);
				?>
			</td>
		</tr>
		<?php echo form_error('clave');?>
		<tr>
			<td >
				Domicilio:
			</td>
			<td >
				<?php 
					echo form_input([
						'id' 	=> 'domicilio',
						'name' 	=> 'domicilio',
						'class' => 'form-control',
						'value' => set_value('domicilio'),
						'size' 	=> '50'
					]);
				?>
			</td>
		</tr>
		<?php echo form_error('domicilio');?>
		<tr>
			<td >
				Telefono:
			</td>
			<td >
				<?php 
					echo form_input([
						'id' 	=> 'telefono',
						'name' 	=> 'telefono',
						'class' => 'form-control',
						'value' => set_value('telefono'),
						'size' 	=> '50'
					]);
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
					echo form_input([
						'id' 	=> 'rfc',
						'name' 	=> 'rfc',
						'class' => 'form-control',
						'value' => set_value('rfc'),
						'size' 	=> '50'
					]);
				?>
			</td>
		</tr>
		<?php echo form_error('rfc');?>
		<tr>
			<td >
				Email:
			</td>
			<td >
				<?php 
					echo form_input([
						'id' 	=> 'email',
						'name' 	=> 'email',
						'class' => 'form-control',
						'value' => set_value('email'),
						'size' 	=> '50'
					]);
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
					echo form_dropdown(
						"id_rol",
						$roles,
						set_value('id_rol','-'),
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
	</table>
	</form>
	<div>
		<div id="boton_enviar" class="btn btn-default"   name="boton_enviar">Registrar</div>
	</div>
</div>
<script>
var oldidClientType = "<?php echo set_value('id_tipo_cliente','-');?>";
var oldVendor       = "<?php echo set_value('id_vendedor','-');?>";

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
		var serializedData = $('#addUserForm').serialize();
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