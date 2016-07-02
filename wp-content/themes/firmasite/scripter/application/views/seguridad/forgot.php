<?php
$login = array(
	'name'	=> 'login',
	'id'	=> 'login',
	'size'	=> 30,
	'value' => set_value('login')
);

$entrar = array(
	'name' => 'recuperar',
	'value' => 'Recuperar',
	'class' => 'controles'
);	

?>

<div class="col1">
			<img src="<?=base_url()?>images/proveedor.jpg" width="306" height="336" align="proveedores" />
        </div> 
        
		<div class="col2">
<?php  if (strlen($this->centinela->get_errors()) > 0) 
		echo  '<p class="error">'.$this->centinela->get_errors().'</p>'; ?>
<?php echo form_open(  $this->uri->uri_string()  )?>

<div class="acceso">
		<h3>Recuperar Contraseña</h3><br/><br/>
	    <?php echo form_label( 'Correo', $login['id']);?>:<br />
		<?php echo form_input($login)?>
		<?php echo form_error($login['name']); ?>
		<br /><br />
		<?php echo form_submit( $entrar );?>		
</div>

<?php echo form_close()?>

		</div>
		
		<div class="col3">
         <h3>¿Qué es el directorio de proveedores?</h3>
		<p>
       Es la relación nominal de personas físicas y/o morales que suministran o provisionan a la 
      Comisión Nacional Forestal los bienes de consumo, servicios o activo fijo necesarios para la 
      realización de sus actividades.</p>
      <h3>¿Cuál es el objetivo del Directorio de Proveedores?</h3>

      <p>Lograr que la Gerencia de Recursos Materiales y Obras coordine y dirija la conformación de un 
      Directorio de Proveedores confiable, integrado por personas físicas y/o morales que deseen ofrecer 
      sus productos o servicios a la<strong> CONAFOR</strong>, promoviendo su activa participación y desarrollo.
Principios Establecidos por la Comisión Nacional Forestal para la relación con sus Proveedores.</p>
      
		</div>