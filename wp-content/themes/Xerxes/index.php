<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package web2feel
 */

get_header(); ?>

	<div class="feature">
		<div class="container"><div class="row">
			<div class="col-md-12">
				<div id="slide" class="flex-slider">
					<ul class="slides">
					<?php 	
					$count = ft_of_get_option('fabthemes_slide_number');
					$slidecat =ft_of_get_option('fabthemes_slide_categories');
					
					$query = new WP_Query( array( 'cat' =>$slidecat,'posts_per_page' =>$count ) );
		           	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();	?>
		 	
			 		<li>
			 			
					<?php
						$thumb = get_post_thumbnail_id();
						$img_url = wp_get_attachment_url( $thumb,'full' ); //get full URL to image (use "large" or "medium" if the images too big)
						$image = aq_resize( $img_url, 1140, 550, true ); //resize & crop the image
					?>
					
					<?php if($image) : ?>
						<a href="<?php the_permalink(); ?>"><img class="grayscale"  src="<?php echo $image ?>"/></a>
					<?php endif; ?>
	
					<div class="flex-caption">
						<h2><?php the_title(); ?></h2>
						<p><?php echo excerpt(30); ?></p>
						
					</div>
			<?php endwhile; endif; ?>
					    		
		  </li>
		</ul>
				</div>
			</div>
		</div></div>
	</div>
	<?php if( ft_of_get_option('fabthemes_cta_text')!=''){ ?>
	<div class="cta">
		<div class="container"><div class="row">
			<div class="col-xs-8"> 
			<div class="cta-text"> <?php echo ft_of_get_option('fabthemes_cta_text'); ?></div>
			
			</div>
			<div class="col-xs-4"> <button class="btn cta-button"> <a href="<?php echo ft_of_get_option('fabthemes_cta_link'); ?>"> <?php echo ft_of_get_option('fabthemes_cta_button'); ?></a>   </button> </div>
		</div></div>
	</div>
	<?php } ?>
	<div class="container"> <div class="row"> 
	<div id="primary" class="content-area col-md-8">
		<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to overload this in a child theme then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );
				?>

			<?php endwhile; ?>

			<?php bootstrap_pagination();?>

		<?php else : ?>

			<?php get_template_part( 'no-results', 'index' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
</div></div>
<?php get_footer(); ?>
