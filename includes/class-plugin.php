<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Plugin {

	public static function init() {
		add_action( 'init', [ Product_Post_Type::class, 'register' ] );
		add_action( 'init', [ Target_Group_Taxonomy::class, 'register' ] );
		add_action( 'init', [ Product_Meta::class, 'register' ] );
		add_action( 'init', [ __CLASS__, 'register_block' ] );

		Product_Admin::init();
	}

	public static function register_block() {

		if ( file_exists( RB_PRODUCTS_PLUGIN_PATH . 'gutenberg-blocks/products-carousel/build/products-carousel/block.json' ) ) {
			error_log( 'Block JSON found' );
		} else {
			error_log( 'Block JSON NOT found' );
		}
		
		register_block_type(RB_PRODUCTS_PLUGIN_PATH . 'gutenberg-blocks/products-carousel/build/products-carousel');
		error_log( 'Register block running' );
	}
}

