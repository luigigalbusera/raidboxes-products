<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Product_Post_Type {

	public static function register() {

		register_post_type(
			'product',
			[
				'labels' => [
					'name'          => __( 'Products', 'raidboxes-products' ),
					'singular_name' => __( 'Product', 'raidboxes-products' ),
					'add_new_item'  => __( 'Add New Product', 'raidboxes-products' ),
					'edit_item'     => __( 'Edit Product', 'raidboxes-products' ),
					'menu_name'     => __( 'Products', 'raidboxes-products' ),
				],

				'public'              => true,

				// Gutenberg + REST
				'show_in_rest'        => true,

				// requirement: exclude from search
				'exclude_from_search' => true,

				// requirement: no archive
				'has_archive'         => false,

				'show_ui'             => true,
				'show_in_menu'        => true,

				'menu_icon'           => 'dashicons-products',

				'supports'            => [ 'title' ],

				'taxonomies'          => [ 'target_group' ],
			]
		);

	}
}