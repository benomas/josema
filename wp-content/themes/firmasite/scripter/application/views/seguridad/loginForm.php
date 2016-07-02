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


<script>
$(document).ready(function(){ 	$('#username').focus();	});

function cargando()
{
	document.getElementById('message').style.display = 'block';
	document.getElementById('message').innerHTML = 
	'<div class="cargando"> <img style="width:30px;" src="<?=base_url()?>images/template/loading.gif" alt="[Cargando]" /> Cargando... </div>';
}
</script>
<img src="<?=base_url()?>images/template/loading.gif" alt="[Cargando]" style="display:none" />

<div id="message">
<?php 
	if( strlen(form_error($username['name']))>0 ||  strlen(form_error($password['name']))>0 ) 
	echo "<script>document.getElementById('message').style.display = 'block';</script>";
?>
<?php echo utf8_encode(form_error($username['name'])); ?>
<?php echo utf8_encode(form_error($password['name'])); ?>
</div>

<div id="container">
<?php
	$attributes = array('name' => 'formularioLogin', 'id' => 'formularioLogin');
	echo form_open(  $this->uri->uri_string(),$attributes); ?>
	<table summary="" border="0" class="logon">
		<tbody>
			<tr>
			<td class="title"><label for="username">Usuario</label></td>
			<td><input type="text" name="username" value="" class="user_input" id="username" size="30"/></td>
			</tr>

			<tr>
			<td class="title"><label for="rcmloginpwd"><label for="password">Contraseña</label></label></td>
			<td><input type="password" name="password" value="" class="user_input" id="password" size="30"  /></td>
			</tr>
			<tr>
				<td></td>
				<!--
				<td><input type="checkbox" name="remember" value="1" id="remember" style="margin:0;padding:0"  /> <label for="remember">Recordar</label></td>
				-->
			</tr>

		</tbody>
</table>
</form>

<p align="center"><input type="submit" name="login" id="login_button" value="Iniciar Sesión" class="mainaction" onclick="javascript:cargando();" /></p>
</div>
<script>
$(document).ready(function()
{
	$('#login_button').click(function()
	{		
		sendUserData();
	});
	
	$('.user_input').keydown(function (e)
	{
		if(e.keyCode == 13)
			sendUserData();
	});	
});

function sendUserData()
{
	$.ajax(
	{
		url : '<?php echo site_url();?>/seguridad/login',
		type: 'POST',
		data: $('#formularioLogin').serialize(),
		success : function(html)
		{
				if( html!='correcto')
					$('#form_container').html(html);
				else
					window.location = '<?php echo word_pres_url();?>';
		}           
	});
}
</script>