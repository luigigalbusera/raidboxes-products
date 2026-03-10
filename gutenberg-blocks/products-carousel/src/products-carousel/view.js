import Swiper from "swiper";
import { Navigation } from "swiper/modules";

import "swiper/css";
import "swiper/css/navigation";

document.addEventListener("DOMContentLoaded", () => {
	const blocks = document.querySelectorAll(".products-carousel");

	blocks.forEach((block) => {
		console.log("block:", block);
		console.log("dataset:", block.dataset);
		console.log("targetGroup:", block.dataset.targetGroup);
	});
});

//construction of the card in an HTML
function buildCard(product) {
	//features as a <li> elements
	const features = product.features
		? product.features.map((f) => `<li>${f}</li>`).join("")
		: "";

	return `
	<div class="swiper-slide">
		<div class="product-card">
			<h3>${product.title}</h3>
			<p><strong>Price:</strong> ${product.price}</p>
			<p><strong>CPU:</strong> ${product.cpu}</p>
			<p><strong>RAM:</strong> ${product.ram}</p>
			<p><strong>SSD:</strong> ${product.ssd}</p>
			<ul>${features}</ul>
		</div>
	</div>
	`;
}

async function initCarousel(block) {
	const endpoint = block.dataset.endpoint;
	const targetGroup = block.dataset.targetGroup;
	const url = new URL(endpoint);
	if (targetGroup) {
		url.searchParams.set("target_group", targetGroup);
	}

	const response = await fetch(url);
	const products = await response.json();

	const wrapper = block.querySelector(".swiper-wrapper");

	wrapper.innerHTML = products.map(buildCard).join("");

	new Swiper(block.querySelector(".swiper"), {
		modules: [Navigation],

		slidesPerView: 1,
		spaceBetween: 16,

		navigation: {
			nextEl: block.querySelector(".swiper-button-next"),
			prevEl: block.querySelector(".swiper-button-prev"),
		},

		breakpoints: {
			768: {
				slidesPerView: 2,
			},
			1024: {
				slidesPerView: 3,
			},
		},
	});
}

document.addEventListener("DOMContentLoaded", () => {
	const blocks = document.querySelectorAll(
		".wp-block-create-block-products-carousel",
	);

	blocks.forEach(initCarousel);
});
