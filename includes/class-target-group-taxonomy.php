<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Target_Group_Taxonomy {

	public static function register() {
		register_taxonomy(
			'target_group',
			[ 'product' ],
			[
				'labels' => [
					'name'			=> __( 'Target Groups', 'raidboxes-products' ),
					'singular_name' => __( 'Target Group', 'raidboxes-products' ),
					'menu_name'		=> __( 'Target Groups', 'raidboxes-products' ),
					'all_items'     => __( 'All Target Groups', 'raidboxes-products' ),
					'edit_item'     => __( 'Edit Target Group', 'raidboxes-products' ),
					'add_new_item'  => __( 'Add New Target Group', 'raidboxes-products' ),
				],
				'public'            => true,
				'show_ui'           => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'hierarchical'      => false,
				'rewrite'           => false,
			]
		);
	}
}