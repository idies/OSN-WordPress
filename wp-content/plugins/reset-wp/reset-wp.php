<?php
/*
Plugin Name: Reset WP
Plugin URI: https://wpreset.com
Description: Reset the WordPress database to the default installation values including all content and customizations. Only the database is reset. No files are modified or deleted.
Version: 1.3
Author: WebFactory Ltd
Author URI: https://www.webfactoryltd.com/
Text Domain: reset-wp
*/

/*

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

*/

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed this file directly
} 

if ( is_admin() ) {

// todo: rename constant
define( 'REACTIVATE_THE_RESET_WP', true );

class ResetWP {
	static $version = 1.3;
	
	function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ) );
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_filter( 'favorite_actions', array( $this, 'add_favorite' ), 100 );
		add_action( 'wp_before_admin_bar_render', array( $this, 'admin_bar_link' ) );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, 'plugin_action_links') );
	}
	
	// Checks reset_wp post value and performs an installation, adding the users previous password also
	function admin_init() {
		global $current_user, $wpdb;

		$reset_wp = ( isset( $_POST['reset_wp'] ) && $_POST['reset_wp'] == 'true' ) ? true : false;
		$reset_wp_confirm = ( isset( $_POST['reset_wp_confirm'] ) && $_POST['reset_wp_confirm'] == 'reset' ) ? true : false;
		$valid_nonce = ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'reset_wp' ) ) ? true : false;

		if ( $reset_wp && $reset_wp_confirm && $valid_nonce ) {
			@require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

			$blogname = get_option( 'blogname' );
			$admin_email = get_option( 'admin_email' );
			$blog_public = get_option( 'blog_public' );
      		$wplang = get_option( 'wplang' );
      		$siteurl = get_option ( 'siteurl' );
      		$home = get_option ( 'home' );

			if ( $current_user->user_login != 'admin' )
				$user = get_user_by( 'login', 'admin' );

			if ( empty( $user->user_level ) || $user->user_level < 10 )
				$user = $current_user;

			$prefix = str_replace( '_', '\_', $wpdb->prefix );
			$tables = $wpdb->get_col( "SHOW TABLES LIKE '{$prefix}%'" );
			foreach ( $tables as $table ) {
				$wpdb->query( "DROP TABLE $table" );
			}

			$result = wp_install( $blogname, $current_user->user_login, $current_user->user_email, $blog_public, '', '', $wplang);
			$user_id = $result['user_id'];

			$query = $wpdb->prepare( "UPDATE {$wpdb->users} SET user_pass = %s, user_activation_key = '' WHERE ID = %d LIMIT 1", array($current_user->user_pass, $user_id));
			$wpdb->query( $query );

      		update_option('siteurl', $siteurl);
      		update_option('home', $home);

			if ( get_user_meta( $user_id, 'default_password_nag' ) ) {
			  update_user_meta( $user_id, 'default_password_nag', false );
			}
			if ( get_user_meta( $user_id, $wpdb->prefix . 'default_password_nag' ) ) {
			  update_user_meta( $user_id, $wpdb->prefix . 'default_password_nag', false );
			}


			
			if ( defined( 'REACTIVATE_THE_RESET_WP' ) && REACTIVATE_THE_RESET_WP === true )
				@activate_plugin( plugin_basename( __FILE__ ) );
			

			wp_clear_auth_cookie();
			wp_set_auth_cookie( $user_id );

			wp_redirect( admin_url()."?reset-wp=reset-wp" );
			exit();
		}

		if ( array_key_exists( 'reset-wp', $_GET ) && stristr( $_SERVER['HTTP_REFERER'], 'reset-wp' ) ) {
			add_action( 'admin_notices', array( $this, 'admin_notices_successfully_reset' ) );
		}
	}

	// add settings link to plugins page
	static function plugin_action_links($links) {
		$settings_link = '<a href="' . admin_url('tools.php?page=reset-wp') . '" title="' . __('Reset WordPress', 'reset-wp') . '">' . __('Reset WordPress', 'reset-wp') . '</a>';
	
		array_unshift($links, $settings_link);
	
		return $links;
	  } // plugin_action_links
	
	
	  // test if we're on plugin's page
	  function is_plugin_page() {
		$current_screen = get_current_screen();
	
		if ($current_screen->id == 'tools_page_reset-wp') {
		  return true;
		} else {
		  return false;
		}
	  } // is_plugin_page
	
	// admin_menu action hook operations & Add the settings page
	function add_page() {
		$hook = add_management_page( 'Reset WP', 'Reset WP', 'administrator', 'reset-wp', array( $this, 'admin_page' ) );
		add_action( "admin_print_scripts-{$hook}", array( $this, 'admin_javascript' ) );
		add_action( "admin_footer-{$hook}", array( $this, 'footer_javascript' ) );
	}
	
	function add_favorite( $actions ) {
		$reset['tools.php?page=reset-wp'] = array( 'Reset WP', 'level_10' );
		return array_merge( $reset, $actions );
	}

	function admin_bar_link() {
		global $wp_admin_bar;
		$wp_admin_bar->add_menu(
			array(
				'parent' => 'site-name',
				'id'     => 'reset-wp',
				'title'  => 'Reset WP',
				'href'   => admin_url( 'tools.php?page=reset-wp' )
			)
		);
	}
	
	// Inform the user that WordPress has been successfully reset
	function admin_notices_successfully_reset() {
		global $current_user;

		echo '<div id="message" class="updated"><p><strong>WordPress has been reset successfully.</strong> User "' . $current_user->user_login . '" was recreated with its old password.</p></div>';
		do_action( 'reset_wp_post', $current_user );
	}
	
	function admin_javascript() {
		if ( $this->is_plugin_page() ) {
		  wp_enqueue_script( 'jquery' );
		}
	}

	function footer_javascript() {
	?>
	<script type="text/javascript">
		jQuery('#reset_wp_submit').click(function(){
			if ( jQuery('#reset_wp_confirm').val() == 'reset' ) {
				var message = 'Please note - THERE IS NO UNDO!\n\nClicking "OK" will reset your database to the default installation values.\nAll content and customizations will be gone.\nNo files will be modified or deleted.\n\nClick "Cancel" to stop the operation.'
				var reset = confirm(message);
				if ( reset ) {
					jQuery('#reset_wp_form').submit();
				} else {
					return false;
				}
			} else {
				alert('Invalid confirmation. Please type \'reset\' in the confirmation field.');
				return false;
			}
		});
	</script>	
	<?php
	}

	// add_option_page callback operations
	function admin_page() {
		global $current_user;

		if ( isset( $_POST['reset_wp_confirm'] ) && $_POST['reset_wp_confirm'] != 'reset-wp' )
			echo '<div class="error fade"><p><strong>Invalid confirmation. Please type \'reset-wp\' in the confirmation field.</strong></p></div>';
		elseif ( isset( $_POST['_wpnonce'] ) )
			echo '<div class="error fade"><p><strong>Invalid wpnonce. Please try again.</strong></p></div>';
			
	?>
	<div class="wrap">
		<h2>Reset WP</h2>

		<div class="card">
			<p><strong>After completing the reset operation, you will be automatically logged in and redirected to the dashboard.</strong></p>
			
			<?php 
				echo '<p>Current user "' . $current_user->user_login . '" will be recreated after resetting with its current password and admin privileges. Reset WP <strong>will be automatically reactivated</strong> after the reset operation.</p>';
			?>
			<hr/>
			
			<p>To confirm the reset operation, type "<strong>reset</strong>" in the confirmation field below and then click the Reset button</p>
			<form id="reset_wp_form" action="" method="post" autocomplete="off">
				<?php wp_nonce_field( 'reset_wp' ); ?>
				<input id="reset_wp" type="hidden" name="reset_wp" value="true">
				<input id="reset_wp_confirm" style="vertical-align: middle;" type="text" name="reset_wp_confirm" placeholder="Type in 'reset'">
				<input id="reset_wp_submit" style="vertical-align: middle;" type="submit" name="Submit" class="button-primary" value="Reset">
			</form>
		</div>
	</div>
    
	<div class="card">
	<p><b>Please help us keep the plugin going</b></p>
		<p>If you enjoy this plugin, <b>please rate it on WordPress</b>. It only takes a second and helps us keep the plugin free and maintained.
		<a title="Reset WP" target="_blank" href="https://wordpress.org/support/plugin/reset-wp/reviews/#new-post">Rate the plugin</a></p>
	</div>
	<?php
	}
}

$ResetWP = new ResetWP();

}