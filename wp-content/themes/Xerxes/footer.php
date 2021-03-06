<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package web2feel
 */
?>

	</div><!-- #content -->
	
	<div id="bottom">
	<div class="container"> <div class="row">
		
		<?php if ( !function_exists('dynamic_sidebar')
		        || !dynamic_sidebar("Footer") ) : ?>  
		<?php endif; ?>
		
		
	</div></div>
	</div>	
	
	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="container"> <div class="row"> 
		<div class="site-info col-md-10">
			<div class="fcred">
				Copyright &copy; <?php echo date('Y');?> <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?></a> - <?php bloginfo('description'); ?>.<br />
<?php fflink(); ?> | <a href="http://fabthemes.com/<?php echo FT_scope::tool()->themeName ?>/" ><?php echo FT_scope::tool()->themeName ?> WordPress Theme</a>
			</div>		
		</div><!-- .site-info -->
		<div class="col-md-2"> <a href="#" class="go-top">Back to Top</a> </div>
		</div></div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
