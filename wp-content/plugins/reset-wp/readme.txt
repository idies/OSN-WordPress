=== Reset WP - Easiest WordPress Reset Plugin ===
Contributors: WebFactory, WPreset
Tags: reset wp, reset wordpress, wordpress reset, wp reset, reset, restart wordpress, clean wordpress, clean database, restart, reset database, default wordpress, developer
Requires at least: 4.0
Tested up to: 4.9
Requires PHP: 5.2
Stable tag: 1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Reset WordPress resets the WP database back to the default installation values without deleting or modifying any files.

== Description ==

**This plugin has a new home in the WordPress repo - <a href="https://wordpress.org/plugins/wp-reset/">wordpress.org/plugins/wp-reset/</a> - Please download it from there. Thank you!** More info about this change is available on the <a href="https://wpreset.com/rebranding-reset-wp/?utm_source=wordpressorg&utm_medium=content&utm_campaign=reset-wp&utm_term=wp%20reset%20blog">WP Reset blog</a>.


<a href="https://wpreset.com/?utm_source=wordpressorg&utm_medium=content&utm_campaign=reset-wp&utm_term=reset%20wordpress">Reset WordPress</a> resets the WP database back to the default installation values without deleting or modifying any files. It's fast and safe to use and an ideal tool for testing during WP development.

* plugin's page is accessed through the Tools menu or via the main home menu
* no files are touched; plugins, themes, uploads, content - everything stays as is
* database is wiped clean and restored to default installation values
* custom tables with the prefixed defined in wp-config are removed as well, other tables are left untouched
* takes less than 5 seconds to reset even the largest sites
* 2 fail-safe mechanisms are built-in so you can't "reset accidentally"
* very handy for plugin and theme developers
* more info is available on <a href="https://wpreset.com/?utm_source=wordpressorg&utm_medium=content&utm_campaign=reset-wp&utm_term=wpreset.com">WPreset.com</a>

Usage :

1. Plugin is page is in Dashboard -> Tools -> Reset WP
2. Enter "reset" in the confirmation box
3. Confirm again with "OK"
4. Wait till the process is done
5. Done. You're back in the dashboard logged in with the same account as before

== Installation ==

Follow the standard routine;

1. Open WordPress admin, go to Plugins, click Add New
2. Enter "wp reset" in search and hit Enter
3. Plugin will show up as the first on the list, click "Install Now"
4. Activate & open plugin's settings page located under the Tools menu

Or if needed, upload manually;

1. Download the plugin.
2. Unzip it and upload to _/wp-content/plugins/_
3. Open WordPress admin - Plugins and click "Activate" next to the plugin
4. Activate & open plugin's settings page located under the Tools menu

== Screenshots ==

1. Admin page screenshot

== Changelog ==

= 1.4 =
* 2018/07/25
* started moving users to WP Reset - https://wordpress.org/plugins/wp-reset/

= 1.3 =
* 2018/06/19
* WebFactory took over development
* bug fixes
* rate plugin box
* new logo
* 40k installs, 256k downloads

= 1.2 =
* Compatible with WordPress Version 4.9

= 1.1 =
* Small Fix in $wpdb->prepare query. Compatible with WordPress Version 4.8.1

= 1.0 =
* 2015/12/01
* Initial release.


== Frequently Asked Questions ==

= Is Reset WP regularly maintained? =

Yes, but **it will soon be removed from the repository**. Please install <a href="https://wordpress.org/plugins/wp-reset/">WP Reset</a> instead. It has the same functionality, it's created by the same people. It's free and safe to use. If you need more info about this change visit the <a href="https://wpreset.com/rebranding-reset-wp/?utm_source=wordpressorg&utm_medium=content&utm_campaign=reset-wp&utm_term=wp%20reset%20blog">WP Reset blog</a>.

= How can I log in after resetting? =

Use the same username and password you used while doing the reset. Only one user will be restored after resetting. The one you used at that time.

= Will any files be deleted or modified? =

No. No files are touched.

= Will I have to edit wp-config.php after resetting? =

No editing is needed as no files are modified.
