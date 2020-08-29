<?php global $firmasite_settings; ?>
<header id="masthead" class="site-header" role="banner">
	<div id="logo" class="show-grid w-100">   
		<div class="row col-sm-6 col-md-3 logo_spot m-auto h-100 d-flex">
			<div class="w-100 m-auto">
				<a 
					href="<?php echo esc_url( home_url( '/' ) ); ?>" 
					title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" 
					rel="home" 
					id="logo-link" 
					class="logo" 
					data-section="body"
				>
					<?php if (isset($firmasite_settings["logo"]) && !empty($firmasite_settings["logo"])) 
					{?>
					<div class="row h-100 w-100 m-auto" style="display:inline-block;">
						<img class="m-auto" style="max-width:220px; display:block;" src="<?php echo site_url();?>/wp-includes/images/logo.png" alt="<?php bloginfo( 'description' ); ?>" title="<?php bloginfo( 'name' ); ?>" id="logo-img" />
					</div>
					<?php 
					} else
					{?>
						<div style="display: inline-block;" ><?php bloginfo( 'name' ); ?></div>
					<?php
						}
					?>
				</a>
			</div>
		</div>

		<div class="hidden-xs hidden-md hidden-lg hidden-xl col-sm-6">
			<?/*php bloginfo( 'name' ); */?>
			<div class="tittle_spot" style="font-weight:bold; margin-left:150px;">
				<label style="text-align:center; margin-top:10px;">
					<?php bloginfo( 'name' ); ?><?php /*JOSEMA DISTRIBUIDOR*/?>
				</label>			
				<ul style=" margin-top:5px;">
					<li>
						EXPERIENCIA
					</li>
					<li>
						CALIDAD
					</li>
					<li>
						SERVICIO
					</li>
					<li>
						INNOVACIÓN
					</li>
				</ul>
			</div>
		</div>

		<div class="hidden-xs hidden-sm col-sm-4 col-md-3 h-100 list1-container-large">
			<?/*php bloginfo( 'name' ); */?>
			<div class="tittle_spot" style="font-weight:bold;">
				<label style="text-align:center; margin-top:10px;">
					<?php bloginfo( 'name' ); ?><?php /*JOSEMA DISTRIBUIDOR*/?>
				</label>			
				<ul style="margin-top:5px;">
					<li>
						EXPERIENCIA
					</li>
					<li>
						CALIDAD
					</li>
					<li>
						SERVICIO
					</li>
					<li>
						INNOVACIÓN
					</li>
				</ul>
			</div>
		</div>
		
		<div class="hidden-xs hidden-sm col-md-6 propiertis_spot h-100" style="font-size:11px; color:#FFFFFF; padding-left:17%; margin-top:20px;">
			<div class="m-auto" style="min-width:350px;">
				<div>
					ESPECIALISTAS EN AUTOPARTES ELÉCTRICAS Y FUEL INJECTION
				</div>
				<ul style="margin-top:10px;">
					<li>RECONSTRUCCIÓN DE BOMBAS DE GASOLINA
					</li>
					<li>LAVADO Y RECONSTRUCCIÓN DE INYECTORES DE GASOLINA
					</li>
					<li>DIAGNOSTICO Y VENTA DE SENSORES; MÓDULOS Y VÁLVULAS
					</li>
					<li>ESCANEO AUTOMITRIZ
					</li>
				</ul>
			</div>
		</div>
	<?php if (get_bloginfo( 'description' )) {?>
	<?php } ?>
	</div>
  <div id="masthead-inner" class="<?php echo $firmasite_settings["layout_container_class"]; ?>">

   <?php do_action( 'open_header' ); ?>
   <?php/* descripcion
    <div id="logo-side" class="pull-right">
       <?php do_action( 'logo_side_open' ); ?>

       <div id="site-description" class="no-margin-bot text-right text-muted hidden-xs hidden-sm"><?php bloginfo( 'description' ); ?></div>

       <?php do_action( 'logo_side_close' ); ?>           
    </div>
	<br>
	*/?>
	<style>
		.tittle_spot 
		{ 
			font-size:16px;
			color:#FF4031; 
		}
		
		@media (max-width:992px)
		{ 
			.propiertis_spot {display:none;}
			/*.tittle_spot {margin-top:0;}*/
			.logo_spot {text-align:center;}
		}
		body{
			background-color:#FFFFFF;
			color:#4049C0 !important;
		}
		.panel{
		    background-color: #FFFFFF;
		}
		.navbar-default .navbar-nav li a {
			color:#FFFFFF !important;
		}
		.panel-footer{
		    background-color: #FFFFFF;
		}
		.dropdown-menu{
		    background-color: #3F47CC;
		}
		.dropdown-menu > li > a:hover {
		    background-color: #FF4031;
		}

		#logo {
			/*margin: auto;*/
			height:150px;
			vertical-align: middle;
			background-position: center center;
			background-repeat: no-repeat;
			background-image: url("<?php echo site_url();?>/wp-content/themes/firmasite/scripter/images/header.jpg");
			background-size:cover;
			font-family: Arial, sans-serif !important;
			margin-bottom:30px;
			padding-left:10%;
			padding-right:10%;
		}

		#masthead{padding-top:0}
		.d-flex{
			display:flex;
		}
		.w-100{
			width:100%; 
		}
		.h-100{
			height:100%;
		}
		.m-auto{
			margin:auto;
		}
		.list1-container-large{
			padding-left:2%;
		}
		
		@media (max-width:768px) {
			#logo {
				background-image: none;
				margin-bottom:0;
				padding-left:0;
				padding-right:0;
			}
		}
		
		@media (max-width:991px) {
			#logo {
				padding-left:0;
				padding-right:0;
			}
			.tittle_spot{
				color:#FFFFFF; 
			}
		}
		
		@media (max-width:1200px) {
			#logo {
				padding-left:5%;
				padding-right:5%;
			}
			.tittle_spot label{
				font-size:16px;
			}
			.tittle_spot ul{
				font-size:13px;
			}
		}
	</style>
    <?php do_action( 'logo_side_before' ); ?>
    
    
    <?php do_action( 'logo_side_after' ); ?>
    
    <div id="navbar-splitter" class="clearfix"></div>
    <?php
		load_user_panel();
	?>
    <?php if (has_nav_menu('main_menu')) : 
           switch ($firmasite_settings["menu-style"]) {
                case "simple":
           ?>
                  <div class="hidden-md hidden-lg">
                      <a class="navbar-toggle btn btn-default btn-sm" data-toggle="collapse" data-target=".main-menu-collapse">
                        <span class="icon-reorder"></span>
                        <b class="caret"></b>
                      </a>
                  </div>                 
                  <nav id="mainmenu" style="" class="collapse navbar-collapse main-menu-collapse" role="navigation">
                    <?php  wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'nav nav-pills')); ?>
                  </nav>
           <?php
                break;
               
                case "default":
                case "alternative":
                default:
           ?>
            <nav id="mainmenu" style="border-top-left-radius: 0; border-top-right-radius: 0; border:none; font-weight:500; " role="navigation" class="site-navigation main-navigation navbar <?php if ((isset($firmasite_settings["alternative"]) && !empty($firmasite_settings["alternative"])) || "alternative" == $firmasite_settings["menu-style"]){ echo " navbar-inverse";} else { echo " navbar-default"; } ?>">          
              <div class="navbar-header">
                  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".main-menu-collapse">
                    <span class="sr-only"><?php _e("Toggle navigation", 'firmasite' );?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </button>
              </div>                
              <div id="nav-main" class="collapse navbar-collapse main-menu-collapse" role="navigation">
                <?php  wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'nav navbar-nav')); ?>
              </div>
            </nav>    <!-- .site-navigation .main-navigation --> 
           <?php 
                break;
           }
    endif; ?>
   
    <?php do_action( 'close_header' ); ?>
    
  </div>
</header><!-- #masthead .site-header -->
