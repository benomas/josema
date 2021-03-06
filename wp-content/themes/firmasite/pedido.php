<?php
/*
Template Name: Pedido template
*/
/**
 * @package firmasite
 */
// this one letting us translate page template names
if(!codeigniter_is_login())
	login_redirect();
get_header();
 ?>
<script src="<?php echo get_rcodeigniter_url();?>js/jquery-1.11.0.min.js" type="text/javascript" style=""></script>
<script src="<?php echo get_rcodeigniter_url();?>js/jquery.numeric.js" type="text/javascript" style=""></script>
<script src="<?php echo get_rcodeigniter_url();?>js/jquery-ui-1.10.4.custom.min.js" type="text/javascript" style=""></script>
<link id="dashicons-css" media="all" type="text/css" href="<?php echo get_rcodeigniter_url();?>/css/humanity/jquery-ui-1.10.4.custom.min.css" rel="stylesheet">
<br>
		<div id="primary" class="content-area clearfix <?php echo $firmasite_settings["layout_primary_class"]; ?>">
		<div class="panel panel-default">
			<header class="entry-header">
				<h1 class="page-header page-title" style="padding-left:20px;">
					<strong><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'firmasite' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a></strong>
					<?php if (!empty($post->post_excerpt)){ ?>
						<small><?php the_excerpt(); ?></small>
					<?php } ?>
				</h1>
			</header>
			<div id="form_container">
				<div style="width:100%; text-align:center;">
					<label > Cargando...</label>
					<br>
					<br>
					<br>
					<img src="<?php echo get_rcodeigniter_url('images/');?>loading.gif">
				</div>
			</div>
		<?php echo load_ci_template();?>
		<br>
		<br>
		<br>
		<span class="leyenda-cambios">Precios más iva, precios y disponibilidad sujetos a cambio sin previo aviso</span>
		</div>
		</div><!-- #primary .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>