<?php
/**
 * Plugin Name: Raidboxes Products
 * Description: Custom Products post type, target group taxonomy, and Gutenberg block.
 * Author: Luigi Galbusera
 * Text Domain: raidboxes-products
 */


// Security Open only with wordpress
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Declaration of the Const
define( 'RB_PRODUCTS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'RB_PRODUCTS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-plugin.php';
require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-activation.php';
require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-target-group-taxonomy.php';
require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-product-post-type.php';
require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-product-meta.php';
require_once RB_PRODUCTS_PLUGIN_PATH . 'includes/class-product-admin.php';


//for debugging 
register_activation_hook( __FILE__, [ 'RB_Products\\Activation', 'activate' ] );
//initiation of the plugin
RB_Products\Plugin::init();