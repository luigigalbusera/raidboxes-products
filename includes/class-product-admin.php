<?php

namespace RB_Products;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Product_Admin {

	public static function init() {
		add_action( 'add_meta_boxes', [ __CLASS__, 'add_meta_box' ] );
		add_action( 'save_post_product', [ __CLASS__, 'save_meta_box' ] );
	}

	public static function add_meta_box() {
		add_meta_box(
			'rb_product_details',
			__( 'Product Details', 'raidboxes-products' ),
			[ __CLASS__, 'render_meta_box' ],
			'product',
			'normal',
			'default'
		);
	}

	public static function render_meta_box( $post ) {

        // create NONCE for other Requests Creating a hidden HTML field and whemn saved prove it again. 
		wp_nonce_field( 'rb_product_details_nonce', 'rb_product_details_nonce' );

		$price      = get_post_meta( $post->ID, 'product_price', true );
		$cpu        = get_post_meta( $post->ID, 'product_cpu', true );
		$ram        = get_post_meta( $post->ID, 'product_ram', true );
		$ssd        = get_post_meta( $post->ID, 'product_ssd', true );
		$features   = get_post_meta( $post->ID, 'product_features', true );
		$cta_label  = get_post_meta( $post->ID, 'product_cta_label', true );
		$cta_url    = get_post_meta( $post->ID, 'product_cta_url', true );

		if ( ! is_array( $features ) ) {
			$features = [];
		}

		$features_text = implode( "\n", $features );
		?>

		<p>
			<label for="product_price"><strong><?php esc_html_e( 'Price', 'raidboxes-products' ); ?></strong></label><br>
			<input type="text" id="product_price" name="product_price" value="<?php echo esc_attr( $price ); ?>" class="widefat">
		</p>

		<p>
			<label for="product_cpu"><strong><?php esc_html_e( 'CPU', 'raidboxes-products' ); ?></strong></label><br>
			<input type="text" id="product_cpu" name="product_cpu" value="<?php echo esc_attr( $cpu ); ?>" class="widefat">
		</p>

		<p>
			<label for="product_ram"><strong><?php esc_html_e( 'RAM', 'raidboxes-products' ); ?></strong></label><br>
			<input type="text" id="product_ram" name="product_ram" value="<?php echo esc_attr( $ram ); ?>" class="widefat">
		</p>

		<p>
			<label for="product_ssd"><strong><?php esc_html_e( 'SSD Storage', 'raidboxes-products' ); ?></strong></label><br>
			<input type="text" id="product_ssd" name="product_ssd" value="<?php echo esc_attr( $ssd ); ?>" class="widefat">
		</p>

		<p>
			<label for="product_features"><strong><?php esc_html_e( 'Features', 'raidboxes-products' ); ?></strong></label><br>
			<textarea id="product_features" name="product_features" rows="6" class="widefat"><?php echo esc_textarea( $features_text ); ?></textarea><br>
			<small><?php esc_html_e( 'One feature per line.', 'raidboxes-products' ); ?></small>
		</p>

		<p>
			<label for="product_cta_label"><strong><?php esc_html_e( 'CTA Label', 'raidboxes-products' ); ?></strong></label><br>
			<input type="text" id="product_cta_label" name="product_cta_label" value="<?php echo esc_attr( $cta_label ); ?>" class="widefat">
		</p>

		<p>
			<label for="product_cta_url"><strong><?php esc_html_e( 'CTA URL', 'raidboxes-products' ); ?></strong></label><br>
			<input type="url" id="product_cta_url" name="product_cta_url" value="<?php echo esc_attr( $cta_url ); ?>" class="widefat">
		</p>

		<?php
	}

	public static function save_meta_box( $post_id ) {
		if ( ! isset( $_POST['rb_product_details_nonce'] ) ) {
			return;
		}

		if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['rb_product_details_nonce'] ) ), 'rb_product_details_nonce' ) ) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		$string_fields = [
			'product_price',
			'product_cpu',
			'product_ram',
			'product_ssd',
			'product_cta_label',
			'product_cta_url',
		];

		foreach ( $string_fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				$value = sanitize_text_field( wp_unslash( $_POST[ $field ] ) );

				if ( 'product_cta_url' === $field ) {
					$value = esc_url_raw( wp_unslash( $_POST[ $field ] ) );
				}

				update_post_meta( $post_id, $field, $value );
			}
		}

		if ( isset( $_POST['product_features'] ) ) {
			$raw_features = explode( "\n", wp_unslash( $_POST['product_features'] ) );
			$features     = array_map( 'trim', $raw_features );
			$features     = array_filter( $features );
			$features     = array_map( 'sanitize_text_field', $features );

			update_post_meta( $post_id, 'product_features', array_values( $features ) );
		}
	}
}