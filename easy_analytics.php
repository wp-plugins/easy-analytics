<?php
/*
Plugin Name: Easy Analytics
Plugin URI: http://www.ryanwelcher.com/work/easy-analytics
Description: Easily add your Google Analytics tracking snippet to your WordPress site.
Author: Ryan Welcher
Version: 1.0
Author URI: http://www.ryanwelcher.com

Copyright 2011  Ryan Welcher  (email : me@ryanwelcher.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


//function to insert GA code
function ea_insert_bug()
{
	
	?>
	<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try{
var pageTracker = _gat._getTracker("<?php echo esc_attr(get_option('ea_tracking_num')); ?>");
pageTracker._trackPageview();
} catch(err) {}
</script>
<?php
}

add_action('wp_footer','ea_insert_bug');


//=======================ADMIN CODE

//register the settings
function ea_init()
{
	load_plugin_textdomain('easy-analytics');
	register_setting('ea_options','ea_tracking_num');
}

add_action('admin_init','ea_init');

//create the form
function ea_option_page()
{
	?>
    <div class="wrap">
    <?php screen_icon();?>
    <h2><?php _e('Easy Analytics Settings','easy-analytics');?></h2>
    <form action="options.php" method="post" id="ea_options_form">
    <?php settings_fields('ea_options'); ?>
    	<label><?php _e('Google Analytics Tracking Number','easy-analytics');?></label>
        <input type="text" id="ea_tracking_num" name="ea_tracking_num" value="<?php echo esc_attr(get_option('ea_tracking_num')); ?>" />
       <input type="submit" name="submit" value="<?php _e('Save Google Tracking Number','easy-analytics');?>" />
        </form>
    </div>
	<?php
}

//add the setting menu to the plugins section
function ea_plugin_menu()
{
	add_plugins_page('Easy Analytics Settings','Easy Analytics','manage_options','ea-admin-options','ea_option_page');
}

add_action('admin_menu','ea_plugin_menu');
?>