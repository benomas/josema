<?php
/**
 * @package firmasite
 */
 global $firmasite_settings;
 ?>
<style>
	.shadow_marco
	{
		background-color: #FFFFFF;
		border: 2px solid #CCCCCC;
		border-radius: 5px;
		box-shadow: 5px 5px 0 rgba(0, 0, 0, 0.1);
		width:100%;
		margin-bottom: 21px;
		margin-left:1%;
		margin-right:1%;
	}
	
	
	.shadow_marco:hover
	{	
		/*border: 2px solid #DD4814;*/
		box-shadow: 15px 15px 0 rgba(0, 0, 0, 0.1);
		margin-top: -20px;
		margin-left: -20px;
	}
	
	.tittle_marco
	{
		color:#FFFFFF;
		background-color:#AE3910;
		font-size:20px;
		text-transform:uppercase;
		text-align:center;
		border-bottom:3px solid #772953;
		border-top:3px solid #772953;
		margin-top:-11px;
		/*margin-left:-16px;*/
		/*margin-right:-16px;*/
		border-top-left-radius:5px;
		border-top-right-radius:5px;
	}
</style>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
 <div class="panel panel-default">
   <div class="panel-body">
    <header class="entry-header">
        <h1 class="page-header page-title" style="text-align:center;">
            <strong><a style="color:#772953; text-transform:uppercase;" href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'firmasite' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">Productos de linea</a></strong>
            <?php if (!empty($post->post_excerpt)){ ?>
                <small><?php the_excerpt(); ?></small>
            <?php } ?>
		</h1>
    </header>
    <div class="entry-content">
 		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'firmasite' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><ul class="pagination pagination-lg"><li><span>' . __( 'Pages:', 'firmasite' ) . '</span></li>', 'after' => '</ul></div>','link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
        <?php if (empty($post->post_title)){ ?>
        <a class="pull-right" href="<?php the_permalink(); ?>" rel="bookmark">
			<small><i class="icon-bookmark"></i><?php  _e( 'Permalink', 'firmasite' ); ?></small>
        </a>
        <?php } ?>
    </div>
   </div>
   <div class="panel-footer entry-meta">
        <small>
        <?php do_action( 'open_entry_meta' ); ?>
        <?php $categories = get_the_category();
            if ($categories) {
                echo '<span class="loop-category"><span class="icon-folder-open"></span> '. /* __( 'Categories:', 'firmasite' ) . */' ';
                foreach($categories as $category) {
                    echo '<a class="label label-'.$firmasite_settings["color-tax"].'" href="' . get_category_link($category->term_id ) . '">';
                    echo '<span>' . $category->name . '</span>'; 
                    echo '</a> ';
                }
                echo "</span>";
            } ?>
        <span class="loop-author"> | <span class="icon-user"></span> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php echo get_the_author(); ?></a></span>
        <span class="loop-date"> | <span class="icon-calendar"></span> <time class="entry-date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></span>
        <?php $posttags = get_the_tags();
            if ($posttags) {
                echo '<span class="loop-tags"> | <span class="icon-tags"></span> &nbsp;  ' . /* __( 'Tags:', 'firmasite' ) . */ ' ';
                foreach($posttags as $tag) {
                    echo '<a class="label label-'.$firmasite_settings["color-tax"].'" href="' . get_tag_link($tag->term_id ) . '">';
                    echo '<span>'.$tag->name . '</span>'; 
                    echo '</a> ';
                }
                echo "</span>";
            } ?>
        <?php edit_post_link( __( 'Edit', 'firmasite' ), ' | <span class="edit-link"><span class="icon-edit"></span> ', '</span>' ); ?>   
        <?php do_action( 'close_entry_meta' ); ?>
        </small>
    </div>
 </div>
</article><!-- #post-<?php the_ID(); ?> -->