<?php
 /**
 * Plugin Name:       Field Editor
 * Plugin URI:        http://www.webmasteryagency.com
 * Description:       Edita los campos del formulario de woocommerce, importa y exporta los ajustes para que sea facil la mugracion o reemplazar ajustes
 * Version:           1.1.3
 * Requires at least: 5.2
 * Requires PHP:      7.2.2
 * Author:            Jose Pinto
 * Author URI:        http://www.webmasteryagency.com
 * License:           GPL v3 or later
 * Domain Path: /lang
 * Text Domain _JPinto
 */

if(!defined('WPINC')){	die; }

if (!function_exists('is_woocommerce_active')){
	function is_woocommerce_active(){
	    $active_plugins = (array) get_option('active_plugins', array());
	    if(is_multisite()){
		   $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	    }
	    
	    if(in_array('woocommerce/woocommerce.php', $active_plugins) || array_key_exists('woocommerce/woocommerce.php', $active_plugins) || class_exists('WooCommerce')){
	        return true;
	    }else{
	        return false;
	    }
	}
}

if(is_woocommerce_active()) {	
	define('THWCFE_VERSION', '3.1.8');
	!defined('THWCFE_SOFTWARE_TITLE') && define('THWCFE_SOFTWARE_TITLE', 'Checkout Field Editor');
	!defined('THWCFE_FILE_') && define('THWCFE_FILE_', __FILE__);
	!defined('THWCFE_PATH') && define('THWCFE_PATH', plugin_dir_path( __FILE__ ));
	!defined('THWCFE_URL') && define('THWCFE_URL', plugins_url( '/', __FILE__ ));
	!defined('THWCFE_BASE_NAME') && define('THWCFE_BASE_NAME', plugin_basename( __FILE__ ));

	/**
	 * The code that runs during plugin activation.
	 */
	function activate_thwcfe($network_wide) {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-thwcfe-activator.php';
		THWCFE_Activator::activate($network_wide);
	}
	
	/**
	 * The code that runs during plugin deactivation.
	 */
	function deactivate_thwcfe() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-thwcfe-deactivator.php';
		THWCFE_Deactivator::deactivate();
	}
	
	register_activation_hook( __FILE__, 'activate_thwcfe' );
	register_deactivation_hook( __FILE__, 'deactivate_thwcfe' );


	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-thwcfe.php';
	
	/**
	 * Begins execution of the plugin.
	 */
	function run_thwcfe() {
		$plugin = new THWCFE();
		$plugin->run();
	}
	run_thwcfe();

	/**
	 * Returns helper class instance.
	 */
	function get_thwcfe_helper(){
		return new THWCFE_Functions();
	}	
}

