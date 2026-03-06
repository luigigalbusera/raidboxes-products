<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Product_Meta {

	public static function register() {
		$string_fields = [
			            'product_price',
			'product_cpu',
			'product_ram',
			'product_ssd',
			'product_cta_label',
			'product_cta_url',
		];

		foreach ( $string_fields as $field ) {
			register_post_meta(
				'product',
				$field,
				[
					'single'            => true,
					'type'              => 'string',
					'show_in_rest'      => true,
					'sanitize_callback' => [ __CLASS__, 'sanitize_string_field' ],
					'auth_callback'     => [ __CLASS__, 'can_edit_products' ],
				]
			);
		}

		register_post_meta(
			'product',
			'product_features',
			[
				'single'            => true,
				'type'              => 'array',
				'show_in_rest'      => [
					'schema' => [
						'type'  => 'array',
						'items' => [
							'type' => 'string',
						],
					],
				],
				'sanitize_callback' => [ __CLASS__, 'sanitize_features' ],
				'auth_callback'     => [ __CLASS__, 'can_edit_products' ],
			]
		);
	}


    // Sanitize the features array to ensure valid and safe data
	public static function sanitize_string_field( $value ) {
		return is_string( $value ) ? sanitize_text_field( $value ) : '';
	}

	public static function sanitize_features( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		$sanitized = array_map( 'sanitize_text_field', $value );
		$sanitized = array_filter( $sanitized );

		return array_values( $sanitized );
	}

//permission of the User
	public static function can_edit_products() {
		return current_user_can( 'edit_posts' );
	}
}