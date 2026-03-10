<?php
/**
 * Render callback for Products Carousel block
 */



$target_group = isset( $attributes['targetGroup'] ) ? $attributes['targetGroup'] : '';

?>

<div
	<?php echo get_block_wrapper_attributes( [
		'class' => 'products-carousel'
	] ); ?>
	data-target-group="<?php echo esc_attr( $target_group ); ?>"
	data-endpoint="<?php echo esc_url( rest_url( 'products-carousel/v1/items' ) ); ?>"
>

	<div class="swiper">
		<div class="swiper-wrapper"></div>

		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>

</div>