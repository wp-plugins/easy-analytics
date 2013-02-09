<?php
/*
Plugin Name: Easy Analytics
Plugin URI: http://www.ryanwelcher.com/work/easy-analytics
Description: Easily add your Google Analytics tracking snippet to your WordPress site.
Author: Ryan Welcher
Version: 3.0
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


if( ! class_exists( 'EasyAnalytics' ) ):

class EasyAnalytics {
	
	
	function __construct() {
		
		//setup the actions for the front end
		add_action('wp_footer',array( &$this, 'ea_action_insert_bug' ) );
		//admin side
		//--init the settings
		add_action('admin_init',array( &$this,'ea_action_init_settings') );
		//--add the page to the admin area
		add_action('admin_menu',array( &$this, 'ea_action_init_plugin_page') );
		
		
	}
	
	
	/*
	 * methods that outputs the actual GA snippet
	 *
	**/
	public function ea_action_insert_bug() {
		?>
        <script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', '<?php echo esc_attr(get_option('ea_tracking_num')); ?>']);
		<?php if( get_option('ea_domain_name')) : ?>
		_gaq.push(['_setDomainName', '<?php echo esc_attr(get_option('ea_domain_name')); ?>']);
		<?php endif;  ?>
		<?php if (get_option('ea_site_speed') == 1) :?>
		_gaq.push(['_setSiteSpeedSampleRate', <?php echo esc_attr(get_option('ea_site_speed_sr')); ?>]);
		<?php endif;  ?>
		(function() {
			 var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			 ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		</script>
        <?php
	}
	
	
	/*
	 * registers settings and plugin text domain
	**/
	public function ea_action_init_settings() {
		
		load_plugin_textdomain( 'easy-analytics', false, dirname( plugin_basename( __FILE__ ) ) . '/_languages/' );
		register_setting('ea_options','ea_tracking_num');
		register_setting('ea_options','ea_domain_name');
	}
	
	/*
	 * inits the settings page for the plugin
	**/
	public function ea_action_init_plugin_page() {
		
		add_plugins_page( __('Easy Analytics Settings', 'easy-analytics'), __('Easy Analytics', 'easy-analytics'),'manage_options','ea-admin-options',array( &$this, 'render_ea_plugin_page' ) );
	}
	
	public function render_ea_plugin_page() {
		?>
        <div class="wrap">
			<?php screen_icon();?>
            <h2><?php _e('Easy Analytics Settings','easy-analytics');?></h2>
            <br/>
            <form action="options.php" method="post" id="ea_options_form">
            <?php settings_fields('ea_options'); ?>
            <table class="widefat">
            	<tr>
                	<td>
                    	<label for="ea_tracking_num"><?php _e('Google Analytics Tracking Number','easy-analytics');?></label>
                        <input type="text" id="ea_tracking_num" name="ea_tracking_num" value="<?php echo esc_attr(get_option('ea_tracking_num')); ?>" />
                    </td>
                </tr>
                <tr>
                	<td>
                    	<label for="ea_domain_name"><?php _e('_setDomain','easy-analytics');?></label>
                        <input type="text" id="ea_domain_name" name="ea_domain_name" value="<?php echo esc_attr(get_option('ea_domain_name')); ?>" />
                    </td>
                </tr>
                <tr>
                	<td>
                    	<input type="submit" name="submit" class="button-primary" value="<?php _e('Update','easy-analytics');?>" />
                    </td>
                </tr>
            </table>
            </form>
        </div>
        <?php
	
	}
	
	
}

new EasyAnalytics;

endif;

?>