<?php

namespace RB_Products;

//Run from Wordpress
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Activation {

	/**
	 * Runs when the plugin is activated
	 */
	public static function activate() {

		// Example activation task
		error_log( 'Raidboxes Products plugin activated' );

		// Refresh rewrite rules
		flush_rewrite_rules();

	}

}