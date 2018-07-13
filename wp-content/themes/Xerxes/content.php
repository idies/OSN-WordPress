<?php
/**
 * @package web2feel
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('row'); ?>>

	<header class="entry-header col-md-12">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php web2feel_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
		
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<div class="col-sm-6 post-image">
			<?php
			$thumb = get_post_thumbnail_id();
			$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
			$image = aq_resize( $img_url, 720, 480, true ); //resize & crop the image
		?>
					
		<?php if($image) : ?>
		<a href="<?php the_permalink(); ?>"> <img class="img-responsive" src="<?php echo $image ?>"/></a>
		<?php endif; ?>	

	</div>
	<div class="entry-summary col-sm-6">
		<?php the_excerpt(); ?>
		<button class="btn  pull-right readmore"> <a href="<?php the_permalink(); ?>"> Read More </a> </button> 
	</div><!-- .entry-summary -->
	
    <div class="clearfix"></div>

</article><!-- #post-## -->
