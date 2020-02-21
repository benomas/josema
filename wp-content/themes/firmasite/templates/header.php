<?php global $firmasite_settings; ?>
<header id="masthead" class="site-header" role="banner">
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
			margin-top:40px;
		}
		
		@media (max-width:992px)
		{ 
			.propiertis_spot {display:none;}
			.tittle_spot {margin-top:0;}
			.logo_spot {text-align:center;}
		}
		body{
			background-color:#9AD9EA;
			color:#4049C0 !important;
		}
		.panel{
		    background-color: #9AD9EA;
		}
		.navbar-default .navbar-nav li a {
			color:#FFFFFF !important;
		}
		.panel-footer{
		    background-color: #9AD9EA;
		}
		.dropdown-menu{
		    background-color: #dd4814;
		}
		.dropdown-menu > li > a:hover {
		    background-color: #ae3910;
		}
	</style>
    <div id="logo" class="row show-grid" style="width:100%;">   

		<div class="col-md-4 logo_spot">	
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home" id="logo-link" class="logo" data-section="body">
				<?php if (isset($firmasite_settings["logo"]) && !empty($firmasite_settings["logo"])) 
				{?>
				<div style="display:inline-block; max-width:250px; width:100%;">
					<img src="<?php echo site_url();?>/wp-includes/images/logo.png" alt="<?php bloginfo( 'description' ); ?>" title="<?php bloginfo( 'name' ); ?>" id="logo-img" />
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
		<div class="col-md-4">
			<?/*php bloginfo( 'name' ); */?>
			<div class="tittle_spot">
				<label class="titulo1" style="width:100%; text-align:center; font-size:24px; color:#14A9DD;">
					<?php bloginfo( 'name' ); ?><?php /*JOSEMA DISTRIBUIDOR*/?>
				</label>				
				<br>
				<label class="titulo2"  style="width:100%; text-align:center; font-size:16px; text-transform:uppercase; color:#AE3910;">
					<?php bloginfo( 'description' ); ?><?php/*ESPECIALISTAS EN FULLINJECTION Y ELECTRICO*/?>
				</label>	
			</div>
		</div>
		<div class="col-md-4 propiertis_spot" >
			<ul style="text-align:left; float:right; margin-top:20px; font-size:20px; color:#EF784E;">
				<li>Experiencia
				</li>
				<li>Servicio
				</li>
				<li>Calidad
				</li>
				<li>Innovación
				</li>
			</ul>
		</div>
       <?php if (get_bloginfo( 'description' )) {?>
       <?php } ?>
    </div>
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
                  <nav id="mainmenu" class="collapse navbar-collapse main-menu-collapse" role="navigation">
                    <?php  wp_nav_menu(array('theme_location' => 'main_menu', 'menu_class' => 'nav nav-pills')); ?>
                  </nav>
           <?php
                break;
               
                case "default":
                case "alternative":
                default:
           ?>
            <nav id="mainmenu" role="navigation" class="site-navigation main-navigation navbar <?php if ((isset($firmasite_settings["alternative"]) && !empty($firmasite_settings["alternative"])) || "alternative" == $firmasite_settings["menu-style"]){ echo " navbar-inverse";} else { echo " navbar-default"; } ?>">          
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
