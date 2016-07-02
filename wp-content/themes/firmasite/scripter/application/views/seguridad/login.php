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
	'<div class="cargando"> <img src="<?=base_url()?>images/template/loading.gif" alt="[Cargando]" /> Cargando... </div>';
}
</script>
<img src="<?=base_url()?>images/template/loading.gif" alt="[Cargando]" style="display:none" />

<div id="message">
<?php 
	if( strlen(form_error($username['name']))>0 ||  strlen(form_error($password['name']))>0 ) 
	echo "<script>document.getElementById('message').style.display = 'block';</script>";
?>
<?php echo form_error($username['name']); ?>
<?php echo form_error($password['name']); ?>
</div>



<div class="slogan"><img src="<?=base_url()?>images/sloganBco.png"></div>

<div id="pleca"></div>





<div id="login-form">

<div class="logo"><img src="<?=base_url()?>images/logoLoginNuevoBco.png"></div>
<!--
<div class="boxtitle">Bienvenido</div>
-->






<div class="boxcontent">
<?php echo form_open(  $this->uri->uri_string()  )?>
<?$folio = empty($folio)? $this->input->get('folio'):$folio;?>
<input type="hidden" name="folio" value="<?=empty($folio)? '':$folio ?>"/>
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


</div>

<div class="logoConafor"><img class="lc" src="<?=base_url()?>images/logoConafor.png"><img class="logoSemarnat" src="<?=base_url()?>images/logoSemarnatNuevo.png"></div>

<style>

div#login-form{
	/*border:thin solid #ff9000;*/
	position:relative;
	left:0;
	width:47%;
	margin:0 auto;
	}

div.slogan{
		position:absolute;
		top:30px;
		left:100px;
}

div.logoConafor img.logoSemarnat{ 
	width:263px;
	margin-top:0;
	margin-left:43px;
	margin-bottom:0px;

}

div.logoConafor img.lc{ 
	float:right;
	width:150px;
	margin-top:0;
	margin-left:43px;
	margin-bottom:0px;
}

div.logoConafor{
	margin:0 auto;
	width:98%;
	background-color:#ffffff;
	padding:15px;
	border-bottom:30px solid #ec941f;
}


div.logo{
	margin:0 0 0 170px;
	width:558px;
	/*border:thin solid #ff9000;*/
}

div.logo img{
	width:558px;
	margin:0 0 0 0;
}

body{
	background-size:cover;
	background-image:url(<?=base_url()?>images/propuestaLoginDos.jpg);
	background-repeat:repeat;
}

*{border:0;}


#message {
    /*display: none;*/
    left: 20%;
    margin-left: -225px;
    opacity: 0.85;
    position: absolute;
    top: -1px;
    z-index: 5000;
}

#message div.error, #message div.warning {
    background: url("<?=base_url()?>images/template/icons.png") no-repeat scroll 6px -97px #EF9398;
    border: 1px solid #DC5757;
}
#message div.cargando{	text-align:center; border:2px solid #999999; padding:5px;}

#message div {
    margin: 0;
    min-height: 22px;
    padding: 8px 10px 8px 46px;
    width: 400px;
}

#login-form {
	font-family:Arial, Helvetica, sans-serif;
	text-align:left;
	/*border: 1px solid #e98602;*/
   margin:0px auto;
   width: 200px;
	higth:400px;
	font-size:12px;
	/*background-image:url("<?=base_url()?>images/template/fondo_login.jpg");*/
}

#login-form table {
	font-family:Arial, Helvetica, sans-serif;
   /* border: thin solid #00FF00;*/
    font-size: 12px;
	color:#e98602;
    margin: 0 auto;
    width: 342px;
}

.boxtitle {
    border-bottom: 1px solid #e98602;
	font-family:Arial, Helvetica, sans-serif;
    color: #E98602;
    font-size: 22px;
    font-weight: bold;
    height: 30px;
    padding: 2px 10px;
    width: 670px;
	margin:0 auto;
	width:200px;
}

.boxcontent {
	font-family:Arial, Helvetica, sans-serif;
    background-image: none;
    color: #E98602;
    height: 107px;
    padding: 10px 10px 10px 0;
    width: 310px;
	margin:166px 0 0 0 ;
	position:absolute;
	top:0;
	left:0;
	z-index:1000;
	/*border:thin solid #f99000;*/
}

.boxcontent table td.title {
	font-family:Arial, Helvetica, sans-serif;
    font-size:1.5em;
    color: #ffffff;
    padding-right: 10px;
	text-align: right;
    white-space: nowrap;
}

.boxcontent table {
	font-family:Arial, Helvetica, sans-serif;
    font-size:1.5em;
    color: #e98602;
    padding-right: 200px;
	text-align: right;
    white-space: nowrap;
}

#username, #password{width: 200px;}
#username:hover, #password:hover,#username:focus, #password:focus{/* background: #FFFDCF;*/}
input[type="text"], input[type="button"], input[type="password"], textarea {
   /* background-color: #FFFFFF;*/
    border: 1px solid #666666;
    color: #333333;
}

input, textarea {    color: black;    padding: 1px 3px;	}

input.mainaction {
	background-image: url("http://10.0.1.107/01800/images/fondo_boton.jpg");
    /*border: 1px solid #999999;*/
    float: left;
    font-weight: normal;
    height: 28px;
    margin-left: 165px;
    width: 150px;
}

input.button {
    background: url("<?=base_url()?>images/template/buttons/bg.gif"); 
    border: 1px solid #A4A4A4;
    color: #333333;
    font-size: 12px;
    height: 20px;
    padding-left: 8px;
    padding-right: 8px;
}

.titulo{
    color: #ff0000;
    font-size: 34px;
    font-weight: bold;
    letter-spacing: 2px;
}

#logo{margin:10px auto 10px auto;}

#pleca{
	width:100%;
	margin:200px auto 0 auto ;
	background-color:#ec941f;
	height:10px;
}





</style>
</body>
</html>