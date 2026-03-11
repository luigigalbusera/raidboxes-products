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
	<div class="carousel-shell">
		<div class="swiper">
			<div class="swiper-wrapper"></div>
		</div>

		<div class="swiper-navigation-buttons">
			<button class="swiper-arrow-prev" aria-label="Previous"></button>
			<button class="swiper-arrow-next" aria-label="Next"></button>
		</div>
	</div>
</div>