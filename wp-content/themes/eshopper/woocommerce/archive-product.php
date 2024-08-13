<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.6.0
 */

defined( 'ABSPATH' ) || exit;
global $product;

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' );

/**
 * Hook: woocommerce_shop_loop_header.
 *
 * @since 8.6.0
 *
 * @hooked woocommerce_product_taxonomy_archive_header - 10
 */
do_action( 'woocommerce_shop_loop_header' );

if ( woocommerce_product_loop() ) {

	/**
	 * Hook: woocommerce_before_shop_loop.
	 *
	 * @hooked woocommerce_output_all_notices - 10
	 * @hooked woocommerce_result_count - 20
	 * @hooked woocommerce_catalog_ordering - 30
	 */
	do_action( 'woocommerce_before_shop_loop' );

	?>
	<!-- Shop Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-12">
                <?php 
                    if ( is_active_sidebar( 'sidebar-1' ) ) : 
                    ?>
                        <div id="secondary" class="widget-area" role="complementary">
                            <?php 
                            dynamic_sidebar( 'sidebar-1' ); 
                            ?>
                        </div>
                    <?php 
                    endif; 
                ?>
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
			<div class="col-lg-9 col-md-12">
				<div class="col-12 pb-1">
					<div class="d-flex align-items-center justify-content-between mb-4">
					<?php 
						if ( is_active_sidebar( 'sidebar-2' ) ) : 
						?>
							<div id="secondary" class="widget-area" role="complementary">
								<?php 
								dynamic_sidebar( 'sidebar-2' ); 
								?>
							</div>
						<?php 
						endif; 
					?>
						<form action="">
							<div class="input-group">
								<input type="text" class="form-control" id="search_by_name" placeholder="Search by name">
								<div class="input-group-append">
									<span class="input-group-text bg-transparent text-primary">
										<i class="fa fa-search" id="search"></i>
									</span>
								</div>
							</div>
						</form>
						<div class="dropdown ml-4">
							<button class="btn border dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
									aria-expanded="false">
										Sort by
									</button>
							<div class="dropdown-menu dropdown-menu-right" aria-labelledby="triggerId">
								<a class="dropdown-item" href="#">Latest</a>
								<a class="dropdown-item" href="#">Popularity</a>
								<a class="dropdown-item" href="#">Best Rating</a>
							</div>
						</div>
					</div>
				</div>
				<?php
					woocommerce_product_loop_start();

					if ( wc_get_loop_prop( 'total' ) ) {
						?>
						<div class="row">;
						<?php

						while ( have_posts() ) {
							the_post();
							?>
							<div class="col-lg-4 col-md-6 col-sm-12 pb-1">
								<div class="card product-item border-0 mb-4">
									<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
										<?php $product_id=get_the_ID(); ?>
										<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );?>
										<img class="w-100 h-100" src="<?php  echo $image[0]; ?>" alt="Image">
									</div>
									<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
										<h6 class="text-truncate mb-3"><?php the_title();?></h6>
										<div class="d-flex justify-content-center">
											<?php
											$_product = wc_get_product( $product_id );

											?>
											<h6><?php echo "Rs. ".get_post_meta(get_the_ID(),'_sale_price',true)?></h6><h6 class="text-muted ml-2"><del><?php echo "Rs ".$_product->get_regular_price();?></del></h6>
										</div>
									</div>
									<div class="card-footer d-flex justify-content-between bg-light border">
									<a href="<?php the_permalink();?>" class="btn btn-sm text-dark p-0">
										<i class="fas fa-eye text-primary mr-1"></i>View Detail
									</a>
									<?php
									$product_id = get_the_ID();
									$add_to_cart_url = esc_url( '?add-to-cart=' . $product_id );

									// Retrieve the product object
									$product = wc_get_product( $product_id );

									// Check if the product is valid
									if ( $product ) {
										$add_to_cart_description = $product->add_to_cart_description();
										?>
										<a href="<?php echo $add_to_cart_url; ?>" class="btn btn-sm text-dark p-0 add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" data-quantity="1" aria-label="<?php echo esc_attr( $add_to_cart_description ); ?>" rel="nofollow">
											<i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
										</a>
										<?php
									} else {
										echo '<p>Product not found.</p>';
									}
									?>
									</div>
								</div>
							</div>
							<?php
							// Add columns dynamically, ensure no extra rows are added
						}
						?>
						</div>
						<?php
					}

					woocommerce_product_loop_end();
				?>
			</div>

            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->

    <?php
	/**
	 * Hook: woocommerce_after_shop_loop.
	 *
	 * @hooked woocommerce_pagination - 10
	 */
	do_action( 'woocommerce_after_shop_loop' );
} else {
	/**
	 * Hook: woocommerce_no_products_found.
	 *
	 * @hooked wc_no_products_found - 10
	 */
	do_action( 'woocommerce_no_products_found' );
}

/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action( 'woocommerce_sidebar' );

get_footer( 'shop' );
?>
<script>
	$(document).ready(function() {
		function performSearch() {
			var WoofText = $('#search_by_name').val();
			var currentWindow = window.location.href.split('?')[0];
			var redirectURL = currentWindow + "?swoof=1";

			const queryString = window.location.search;
			const urlParams = new URLSearchParams(queryString);
			
			var paTextValue = urlParams.get('woof_text') || '';
			var paColor = urlParams.get('pa_color') || '';

			if (WoofText) {
				redirectURL += "&woof_text=" + encodeURIComponent(WoofText);
			} else if (paTextValue) {
				redirectURL += "&woof_text=" + encodeURIComponent(paTextValue);
			}
			
			if (paColor) {
				redirectURL += "&pa_color=" + encodeURIComponent(paColor);
			}

			window.location.href = redirectURL;
		}

		// Click event for the search icon
		$('#search').on('click', function() {
			performSearch();
		});

		// Handle Enter key press in the input field
		$('#search_by_name').on('keypress', function(e) {
			if (e.which == 13) { // Enter key pressed
				performSearch();
				e.preventDefault(); // Prevent form submission
			}
		});
	});
</script>
