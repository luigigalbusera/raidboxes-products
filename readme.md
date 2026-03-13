Products Carousel Plugin for Raidboxes
Overview

The Products Carousel is a custom WordPress plugin that provides a dynamic Gutenberg block for displaying hosting products inside a responsive carousel.
Products are loaded dynamically via a custom REST API.
This ensures that the carousel content is always up to date and can be filtered by target group.
The block uses server-side rendering, so no static HTML is saved in the post content.

Features

Custom Products post type
Custom Target Group taxonomy
Dynamic Gutenberg block
Responsive carousel powered by Swiper.js
Data loaded via custom REST API
Filter products by taxonomy
SCSS based styling architecture

REST API

Namespace
/wp-json/products-carousel/v1

Available routes:
/target-groups
/items
/items?target_group=agency
/items?target_group=website%20owner

Block Rendering
The block is dynamic and rendered on the server:
"render": "file:./render.php"

No frontend markup is stored inside post content.

Plugin Structure
Root

raidboxes-product.php
Main plugin bootstrap file.

Includes

includes/class-plugin.php
Initializes the plugin and registers REST API endpoints.

includes/class-product-admin.php
Handles admin UI logic for creating and saving products.

includes/class-product-meta.php
Registers custom metadata fields for products.

includes/class-post-type.php
Registers the custom Products post type.

includes/class-group-taxonomy.php
Registers the custom Target Group taxonomy.

Gutenberg Block

src/product-carousel/block.json
Block definition and configuration.

src/product-carousel/edit.js
Inspector Controls panel for selecting the target group.

src/product-carousel/editor.scss
Styles applied inside the Gutenberg editor.

src/product-carousel/save.js
Returns null because the block is dynamic.

src/product-carousel/view.js
Frontend logic: fetching products and initializing Swiper.

Frontend Styles

src/product-carousel/variables.scss
Global SCSS variables.

src/product-carousel/style.scss
Carousel layout and Swiper styling.

src/product-carousel/product-card.scss
Product card design with hover and active states.

Assets are compiled using @wordpress/scripts.

Usage

Create products in the WordPress admin.
Assign a Target Group taxonomy.
Add the Products Carousel block in Gutenberg.
Select the desired target group in the block sidebar.
The carousel will load products dynamically on the frontend.
