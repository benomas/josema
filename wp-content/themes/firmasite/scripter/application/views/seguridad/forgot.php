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
		<h3>Recuperar Contrase�a</h3><br/><br/>
	    <?php echo form_label( 'Correo', $login['id']);?>:<br />
		<?php echo form_input($login)?>
		<?php echo form_error($login['name']); ?>
		<br /><br />
		<?php echo form_submit( $entrar );?>		
</div>

<?php echo form_close()?>

		</div>
		
		<div class="col3">
         <h3>�Qu� es el directorio de proveedores?</h3>
		<p>
       Es la relaci�n nominal de personas f�sicas y/o morales que suministran o provisionan a la 
      Comisi�n Nacional Forestal los bienes de consumo, servicios o activo fijo necesarios para la 
      realizaci�n de sus actividades.</p>
      <h3>�Cu�l es el objetivo del Directorio de Proveedores?</h3>

      <p>Lograr que la Gerencia de Recursos Materiales y Obras coordine y dirija la conformaci�n de un 
      Directorio de Proveedores confiable, integrado por personas f�sicas y/o morales que deseen ofrecer 
      sus productos o servicios a la<strong> CONAFOR</strong>, promoviendo su activa participaci�n y desarrollo.
Principios Establecidos por la Comisi�n Nacional Forestal para la relaci�n con sus Proveedores.</p>
      
		</div>