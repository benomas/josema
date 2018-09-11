<h3 class="titulo">Contacto telefonico</h3>
<div class="form-block">
	<table>
		<!--
			<tr>
				<td class="td_clean">
					Nancy Almazan Contreras
				</td>
			</tr>
		-->
		<tr>
			<td class="td_clean">
				Telefono:01 444 8209597
			</td>
		</tr>
		<tr>
			<td class="td_clean">
				Cel:01 444 1422514
			</td>
		</tr>
	</table>
	<div style="width:100%; text-align: center; background-color: #DF4916; border-radius:3px;">
		<img src="<?php echo base_url().'images/template/contacto.jpg'; ?>" alt="" style="margin:auto;">
	</div>
</div>
<h3 class="titulo">Contacto electrónico</h3>
<div class="form-block">
	<form id="contact-form" method="post" name="contact-form">
		<table class="table table-condensed .table-responsive">
			<tr>
				<td class="td_clean">Nombre
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					<input class="form-control" id="nombre" name="nombre" size="50" type="text" value="<?php echo set_value('nombre');?>"></input>
					<?php echo form_error('nombre');?>
				</td>
			</tr>
			<tr>
				<td class="td_clean">Teléfono
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					<input class="form-control" id="telefono" name="telefono" size="50" type="text" value="<?php echo set_value('telefono');?>"></input>
					<?php echo form_error('telefono');?>
				</td>
			</tr>
			<tr>
				<td class="td_clean">Correo electrónico
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					<input class="form-control" id="correo" name="correo" size="50" type="text" value="<?php echo set_value('correo');?>"></input>
					<?php echo form_error('correo');?>
				</td>
			</tr>
			<tr>
				<td class="td_clean">Asunto
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					<textarea class="form-control" rows="3" name="asunto" ><?php echo set_value('asunto');?></textarea>
					<?php echo form_error('asunto');?>
				</td>
			</tr>
		</table>
		<table>
			<tr>
				<td class="td_clean">
					Captcha:<iframe src="<?php echo site_url();?>/contactMail/printCaptcha" style="border:0; height:25px; width:100px;"></iframe>
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					Escribir captcha
				</td>
			</tr>
			<tr>
				<td class="td_clean">
					<input class="form-control" id="captcha" name="captcha" size="50" type="text" ></input>
					<?php echo form_error('captcha');?>
				</td>
			</tr>
		</table>
	</form >
	<table class="table table-condensed .table-responsive">
		<tr>
			<td class="td_clean">
				<div id="boton_enviar" name="boton_enviar" class="btn btn-primary btn-block">Enviar</div>
			</td>
		</tr>
	</table>
</div>
<script>
$(document).ready(function()
{

});

$('#boton_enviar').click(function()
{
	$('.form-control').prop('disabled', false);
	$.ajax(
	{
		url : '<?php echo site_url();?>/contactMail/sendContactForm',
		type: 'POST',
		data: $('#contact-form').serialize(),
		success : function(html)
		{
				$('#form_container').html(html);
		}
	});
});
</script>