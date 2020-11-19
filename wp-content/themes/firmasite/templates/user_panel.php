	<style>

		.main_panel
		{
			/*background-color:#FFFFFF;*/
			background-color:#FFFFFF;
			width:100%;
			height:45px;
			margin-bottom:5px;"
		}
		.text_tittle
		{
			font-weight:bold;
			display: inline-block;
			height:100%;
			color:#FFFFFF;
			padding-top:10px;
		}
		.text_name
		{
			font-weight:normal;
			display: inline-block;
			height:100%;
			color:#FFFFFF;
			padding-top:10px;
		}

		.size1{width:100%;}.size2{width:95%;}.size3{width:90%;}.size4{width:85%;}.size5{width:80%;}
		.size6{width:75%;}.size7{width:70%;}.size8{width:65;}.size9{width:60%;}.size10{width:55%;}
		.size11{width:50%;}.size12{width:45%;}.size13{width:40%;}.size14{width:35%;}.size15{width:30%;}
		.size16{width:25%;}.size17{width:20%;}.size18{width:15%;}.size19{width:10%;}.size20{width:5%;}

		.sub_panel
		{
			display:inline-block;
			background-color:#FF4031;
			border: 2px solid #FF4031;
			width:28%;
			max-width:350px;
			height:50px;
			padding-top:5px;
			padding-left:10px;
			padding-right:10px;
			padding-top:5px;
			padding-bottom:5px;
		}
		.sub1
		{
			border-top-right-radius:15px;
		}
		.sub2
		{
			border-top-left-radius:15px;
		}

		.bloque_input_buscador
		{
			width:62%;
			height:40px;
			display:inline-block;
			margin:0 3px;
		}

		.input_buscador
		{
			width:100%;
			display:inline-block;
			height:35px;
		}

		.bloque_botton_buscador
		{
			width:32%;
			height:40px;
			display:inline-block;
			margin:0 3px;
		}

		.botton_buscador
		{
			width:100%;
			height:35px;
			border-radius:4px;
			text-align:center;
			cursor:pointer;

			display:inline-block;
			padding-left: 0;
			padding-right: 0;
			padding-top:5px;

			background-color: #FFC931;
			color:#FF4031;

			font-size: 14px;
			font-weight: normal;
			line-height: 1.42857;
			margin-bottom: 0;
			vertical-align: middle;
			white-space: nowrap;
		}

		.botton_buscador:hover
		{
			background-color: #FFD358;
			color:#FF1401;
		}

		.bloque_user_data
		{
			width:45%;
			height:40px;
			display:inline-block;
			margin:0 3px;
			vertical-align:top;
		}


		.bloque_usuarios_button
		{
			width:20%;
			height:40px;
			display:inline-block;
			margin:0 3px;
			border-radius:4px;
		}

		.bloque_carrito_button
		{
			width:20%;
			height:40px;
			display:inline-block;
			margin:0 3px;
			border-radius:4px;
		}


		.bloque_usuarios_button:hover
		{
			background-color: #B83C11;
		}

		.bloque_carrito_button:hover
		{
			background-color: #B83C11;
		}


		.bno-accions
		{
			padding:4px 3px;
			display:inline-block;
		}
		.bno-button
		{
			color:#FFC931;
			/*background-color:#f1f1f1;*/
			font-size:28px;
			cursor:pointer;
			display:inline-block;
			padding:4px;
			border-radius:4px;
			display:inline-block;
		}

		.bno-button:hover
		{
			/*background-color:#FFFFFF;*/
			color:#D79F00;
		}


		/*size9*/
		@media (min-width:6000px)
		{
			.sub_panel{width:50%;max-width:540px; }
		}


		/*size8*/

		@media (min-width:6000px)	AND  (max-width:1900px)
		{	.sub_panel{width:28%;}
			.vista_carrito{ margin-left:18px; width:40px;}
			.bloque_vista_carrito{ margin-left: 0; width: 80px;}
		}

		/*size7*/

		@media (min-width:53px)	AND  (max-width:3000px)
		{
			.sub_panel{width:32%;}
			.vista_carrito{ margin-left:14px; width:40px;}
			.bloque_vista_carrito{ margin-left: 0; width: 68px;}
			.no_essencial2{display:none;}
		}


		/*size6*/

		@media (min-width:51px)	AND  (max-width:52px)
		{
			.sub_panel{width:42%;}
			.vista_carrito{ margin-left:8px; width:40px;}
			.bloque_vista_carrito{ margin-left: 0; width: 55px;}
			.no_essencial2{display:none;}
		}


		/*size5*/

		@media (min-width:50px)	AND  (max-width:51px)
		{
			.sub_panel{width:45%;}
			.vista_carrito{ margin-left: 8px; width: 40px;}
			.bloque_vista_carrito{ margin-left: 0; width: 55px;}
			.no_essencial2{display:none;}
		}


		/*size4*/

		@media (min-width:49px)	AND  (max-width:50px)
		{
			.sub_panel{width:100%; max-width:689px;}
			.bloque_botton_buscador{width:35%;}
			.sub1{border-top-right-radius:15px;border-top-left-radius:15px;}
			.sub2{border-radius:0; margin-top:-5px;}
			.bloque_user_data{width:35%;}
			.bloque_usuarios_button{width:30%;}
			.bloque_carrito_button{width:30%;}
			.vista_carrito{ margin-left: 7px; width: 40px;}
			.bloque_vista_carrito{ margin-left: 0; width: 55px;}
			.no_essencial2{display:none;}
		}


		/*size3*/

		@media (min-width:48px)	AND	(max-width:49px)
		{
			.sub_panel{width:100%; max-width:559px;}
			.bloque_botton_buscador{width:30%;}
			.sub1{border-top-right-radius:15px;border-top-left-radius:15px;}
			.sub2{border-radius:0; margin-top:-5px;}
			.bloque_user_data{width:40%;}
			.bloque_usuarios_button{width:25%;}
			.bloque_carrito_button{width:25%;}
			.no_essencial{display:none;}
			.no_essencial2{display:none;}
			.vista_carrito{ margin-left: 5px; width: 38px;}
			.bloque_vista_carrito{ margin-left: 0; width: 50px;}
			.img_contraer{margin-left: 5px; width: 38px;}
			.bloque_contraer_button{margin-left: 0; width: 50px;}
			.img_contraer_aniadir_carrito{margin-left: 5px; width: 38px;}
			.bloque_contraer_aniadir_carrito{margin-left: 0; width: 50px;}
			.imagen_middle{height:200px; width:200px;}
			.table{font-size:12px;}
		}

		/*size2*/
		@media (min-width:47px)	AND	(max-width:48px)
		{
			.sub_panel{width:100%; max-width:400px;}
			.bloque_botton_buscador{width:28%;}
			.sub1{border-top-right-radius:15px;border-top-left-radius:15px;}
			.sub2{border-radius:0; margin-top:-5px;}
			.bloque_user_data{width:50%;}
			.bloque_usuarios_button{width:18%;}
			.bloque_carrito_button{width:20%;}
			.no_essencial{display:none;}
			.no_essencial2{display:none;}
			.vista_carrito{ margin-left: 0; width: 35px;}
			.bloque_vista_carrito{ margin-left: 0; width: 38px;}
			.img_contraer{margin-left: 0; width: 35px;}
			.bloque_contraer_button{margin-left: 0; width: 38px;}
			.img_contraer_aniadir_carrito{margin-left: 5px; width: 35px;}
			.bloque_contraer_aniadir_carrito{margin-left: 0; width: 45px;}
			.imagen_middle{height:180px; width:180px;}
			.table{font-size:10px;}
		}

		/*size1*/
		@media (min-width:46px)	AND	(max-width:47px)
		{
			.sub_panel{width:100%; max-width:300px;}
			.bloque_botton_buscador{width:28%;}
			.sub1{border-top-right-radius:15px;border-top-left-radius:15px;}
			.sub2{border-radius:0; margin-top:-5px;}
			.bloque_user_data{width:60%;}
			.bloque_usuarios_button{width:12%;}
			.bloque_carrito_button{width:12%;}
			.no_essencial{display:none;}
			.no_essencial2{display:none;}
			.vista_carrito{ margin-left: 0; width: 35px;}
			.bloque_vista_carrito{ margin-left: 0; width: 38px;}
			.img_contraer{margin-left: 0; width: 35px;}
			.bloque_contraer_button{margin-left: 0; width: 38px;}
			.img_contraer_aniadir_carrito{margin-left: 0px; width: 35px;}
			.bloque_contraer_aniadir_carrito{margin-left: 0; width: 38px;}
			.imagen_middle{height:160px; width:160px;}
			.table{font-size:9px;}
		}

			<?php
			if(codeigniter_is_login())
			{
				if(in_array(get_codeigniter_session_var('rolName'),["Super Administrador","Administrador","Super Vendedor","Vendedor"])) //echo '.main_panel{height:90px;}';
					echo '@media (min-width:49px)	AND  (max-width:50px)	{.main_panel{height:90px;}}';
			}
			?>
	</style>
	<div class="main_panel">
		<div class="sub_panel sub1" >
			<div class="bloque_input_buscador">
				<input id="grid_searsh_g" class="input_buscador" type="text" name="grid_searsh_g" value="<?php echo !empty($_GET["grid_searsh"])?$_GET["grid_searsh"]:"" ?>">
			</div>
			<div class="bloque_botton_buscador" >
				<div id="boton_buscar_g" class="botton_buscador" name="boton_buscar_g" onclick="searsh_redirect();">Buscar</div>
			</div>
		</div>
		<?php
		if(codeigniter_is_login())
		{
		?>

		<div class="sub_panel sub2" style="float:right; background-color:#3F47CC;  border-top:0; border-left:0; border-right:0; border-bottom-width:1px; border-color:#CCCCCC;">
			<div class="bloque_user_data" >
				<label class="text_tittle" >Bienvenido: </label>
				<label class="text_name" ><?php echo get_codeigniter_session_var('nombre');?></label>
			</div>
			<div class="bno-accions">
				<?php
					if(in_array(get_codeigniter_session_var('rolName'),["Super Administrador","Administrador","Super Vendedor","Vendedor"]))
					{
				?>
					<a href="<? echo modulo_url('Usuarios');?>">
						<div class="icon- bno-button tooltip_panel" title="Administraciónn de usuarios">&#xe674
						</div>
					</a>
				<?php
					}
				?>
				<a href="<? echo modulo_url('Pedidos');?>">
					<div class="icon- bno-button tooltip_panel" title="Carrito de compras" >&#xe636
					</div>
				</a>
			</div>
		</div>
		<?php
			}
		?>
	</div>