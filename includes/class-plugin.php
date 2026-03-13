<?php

namespace RB_Products;

use WP_Query;
use WP_REST_Request;
//security check if the plugin is being accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class Plugin {
	/**
	 * Initializes the plugin
	 * Registers custom post types, taxonomies, meta fields, blocks, and REST API routes
	 */
	public static function init() {
		add_action( 'init', [ Product_Post_Type::class, 'register' ] );
		add_action( 'init', [ Target_Group_Taxonomy::class, 'register' ] );
		add_action( 'init', [ Product_Meta::class, 'register' ] );
		add_action( 'init', [ __CLASS__, 'register_block' ] );
		add_action( 'rest_api_init', [ __CLASS__, 'register_rest_routes' ] );
		Product_Admin::init();
	}

	/**
	 * Registers the Gutenberg block for the products carousel
	 * Checks if the block.json file exists before attempting to register the block
	*/
	public static function register_block() {
		if ( file_exists( RB_PRODUCTS_PLUGIN_PATH . 'gutenberg-blocks/products-carousel/build/products-carousel/block.json' ) ) {
			error_log( 'Block JSON found' );
		} else {
			error_log( 'Block JSON NOT found' );
		}

		register_block_type(
			RB_PRODUCTS_PLUGIN_PATH . 'gutenberg-blocks/products-carousel/build/products-carousel'
		);

		error_log( 'Register block running' );
	}

	/**
	 * Registers custom REST API routes for fetching target groups and products
	 * The routes are publicly accessible and return data in a structured format
	 * readme.md for more information and the endpoint documentation
	 */
	public static function register_rest_routes() {
		register_rest_route(
			'products-carousel/v1',
			'/target-groups',
			[
				'methods'             => 'GET',
				'callback'            => [ __CLASS__, 'get_target_groups' ],
				'permission_callback' => '__return_true',
			]
		);

		register_rest_route(
			'products-carousel/v1',
			'/items',
			[
				'methods'             => 'GET',
				'callback'            => [ __CLASS__, 'get_items' ],
				'permission_callback' => '__return_true',
			]
		);
	}

	public static function get_target_groups() {
		$terms = get_terms(
			[
				'taxonomy'   => 'target_group',
				'hide_empty' => false,
			]
		);

		if ( is_wp_error( $terms ) ) {
			return [];
		}

		return array_map(
			function ( $term ) {
				return [
					'id'   => $term->term_id,
					'name' => $term->name,
					'slug' => $term->slug,
				];
			},
			$terms
		);
	}

	public static function get_items( WP_REST_Request $request ) {
		$target_group = sanitize_text_field( $request->get_param( 'target_group' ) );

		$args = [
			'post_type'      => 'rb_product',
			'post_status'    => 'publish',
			'posts_per_page' => 9,
		];

		if ( ! empty( $target_group ) ) {
			$args['tax_query'] = [
				[
					'taxonomy' => 'target_group',
					'field'    => 'slug',
					'terms'    => $target_group,
				],
			];
		}

		$query = new \WP_Query( $args );
		$items = [];

		while ( $query->have_posts() ) {
			$query->the_post();

			$post_id = get_the_ID();
			$terms   = get_the_terms( $post_id, 'target_group' );

			$items[] = [
				'id'           => $post_id,
				'title'        => get_the_title(),
				'target_group' => ( ! empty( $terms ) && ! is_wp_error( $terms ) )
					? implode( ', ', wp_list_pluck( $terms, 'name' ) )
					: '',

				'price'     => get_post_meta( $post_id, 'product_price', true ),
				'cpu'       => get_post_meta( $post_id, 'product_cpu', true ),
				'ram'       => get_post_meta( $post_id, 'product_ram', true ),
				'ssd'       => get_post_meta( $post_id, 'product_ssd', true ),

				'cta_label' => get_post_meta( $post_id, 'product_cta_label', true ),
				'cta_url'   => get_post_meta( $post_id, 'product_cta_url', true ),

				'features'  => get_post_meta( $post_id, 'product_features', true ),
			];
		}
		wp_reset_postdata();

		return $items;
	}

}