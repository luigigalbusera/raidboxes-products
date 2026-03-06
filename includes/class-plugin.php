<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	/**
	 * Initialize the plugin
	 */
	public static function init() {
        add_action( 'init', [ Product_Post_Type::class, 'register' ] );
		add_action( 'init', [ Target_Group_Taxonomy::class, 'register' ] );
	}

	/**
	 * Runs on WordPress init hook
	 */
	public static function on_init() {
		// For now just log a messagevv
		error_log( 'Raidboxes Products plugin loaded' );
	}

}