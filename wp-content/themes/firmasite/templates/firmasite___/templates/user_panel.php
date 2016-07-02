<?php
	?> 
	<style>
		.content_panel
		{
			width:100%; 
			max-width:300px; 
			height:50px; 
			float:right; 
			margin-right:0; 
			background-color: #FFFFFF;
			border-color: #BF3E11;
		}
		
		.tittle_panel
		{
			color:#FFFFFF; 
			background-color: #DD4814; 
			height:100%; 
			padding-top:10px;
			border-top-left-radius: 15px;
		}
		
		
		.side_panel
		{
			color:#FFFFFF; 
			background-color:#DD4814; 
			height:100%; 
			border-top-left-radius: 5px;
		}
		
		.cart_panel
		{
			height:100%; 
			background-color: #DD4814;
			padding-top:2%; 
			padding-left:1%; 
			border-top-right-radius: 4px;
			border-bottom-right-radius: 4px;
		}
		
		.cart_panel:hover
		{
			background-color:#AE3910;
		}
		.text_tittle
		{
			font-weight:bold;
		}
		.text_name
		{
			font-weight:normal;
		}
		
		.admin_users_panel
		{
			height:100%; 
			background-color: #DD4814;
			padding-top:2%; 
			padding-left:1%;
			color:#FFFFFF; 
		}
		
		.admin_users_panel:hover
		{
			background-color:#AE3910;
		}
		
	</style>
	<div style="display:inline-block; background-color:#FFFFFF; width:100%; height:45px; margin-bottom:10px;">
		<div style="display:inline-block; background-color:#772953; width:100%; max-width:450px; height:50px; padding-top:5px; border-top-right-radius:15px;">
			<div class="col-md-8">
				<input id="grid_searsh_g" class="form-control" type="text" name="grid_searsh_g">
			</div>
			<div class="col-md-3" >
				<div id="boton_buscar_g" class="btn btn-primary btn-block" name="boton_buscar_g" onclick="searsh_redirect();">Buscar</div>
			</div>
			<div class="col-md-1"  >
			</div>
		</div>
		<div style="display:inline-block; background-color:#FFFFFF; width:auto; height:50px;">
		</div>
		<?php 
		if(codeigniter_is_login())
		{
		?>
		
		<div style="display:inline-block; float:right; background-color:#FFFFFF; width:100%; max-width:300px; height:50px;">
			<div class="col-md-8 tittle_panel" >
				<label class="text_tittle" >Bienvenido: </label> 
				<label class="text_name" ><?php echo get_codeigniter_session_var('nombre');?></label>
			</div>
			<?php 
				if(get_codeigniter_session_var('rol')<3)
				{
			?>
			<a href="<? echo modulo_url('usuario');?>">
				<div class="col-md-2 admin_users_panel" >
				<img src="<?php echo home_url();?>/wp-includes/images/user.png" style="width:45px; max-width:100px;">
				</div>
			</a>
			<?php 
				}
			?>
			<a href="http://localhost/josema/">
				<div class="col-md-2 cart_panel" >
					<img src="<?php echo home_url();?>/wp-includes/images/carrito.png" style="width:42px; max-width:100px;">
				</div>
			</a>
		</div>
		<?php
			}
		?>
	</div>