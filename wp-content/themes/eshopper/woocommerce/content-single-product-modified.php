<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<!-- <div id="product- -->
<?php 
// the_ID(); 
?>
<?php 
// wc_product_class( '', $product ); 
?>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	// do_action( 'woocommerce_before_single_product_summary' );
	?>

	<!-- <div class="summary entry-summary"> -->
		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		?>
	<!-- </div> -->

	
<!-- </div> -->

<?php
/**
 * Custom Template Incoming
 */
?>
<style>
	input[type="radio"]{
		display: none;
	}
</style>

	<!-- Shop Detail Start -->
	<div class="container-fluid py-5">
		<div class="row px-xl-5">
			<div class="col-lg-5 pb-5">
				<div id="product-carousel" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner border">
						<div class="carousel-item active">
							<?php $product_id=get_the_ID(); ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );?>
							<img class="w-100 h-100" src="<?php  echo $image[0]; ?>" alt="Image">
						</div>
						<?php
							$product_id = get_the_ID();
							$product = new WC_product($product_id);
							$attachment_ids = $product->get_gallery_image_ids();

							foreach( $attachment_ids as $attachment_id ) 
								{
								$Original_image_url = wp_get_attachment_url( $attachment_id );
								?>
								<div class="carousel-item">
									<img class="w-100 h-100" src="<?php echo $Original_image_url?>" alt="Image">
								</div>
								
							    <?php
								}
						?>
						
					</div>
					<a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
						<i class="fa fa-2x fa-angle-left text-dark"></i>
					</a>
					<a class="carousel-control-next" href="#product-carousel" data-slide="next">
						<i class="fa fa-2x fa-angle-right text-dark"></i>
					</a>
				</div>
			</div>
			<div class="col-lg-7 pb-5">
				<h3 class="font-weight-semi-bold"><?php the_title()?></h3>
				<div class="d-flex mb-3">
					<?php
						$rating_count = $product->get_rating_count();
						$review_count = $product->get_review_count();
						$average = $product->get_average_rating();
						$max_stars = 5;
					?>
						
					<?php if ($rating_count > 0) : ?>
						<div class="rating">
							<?php 
								if ($average) {
									$full_stars = floor($average);
									$half_star = ($average - $full_stars >= 0.5) ? 1 : 0;
									$empty_stars = $max_stars - $full_stars - $half_star;

									for ($i = 0; $i < $full_stars; $i++) {
										echo '<small class="fas fa-star"></small>';
									}
									if ($half_star) {
										echo '<small class="fas fa-star-half-alt"></small>';
									}
									for ($i = 0; $i < $empty_stars; $i++) {
										echo '<small class="far fa-star"></small>';
									}
								} 
							?>
						</div>
					<?php endif; ?>
					<small class="pt-1">(<?php comments_number(); ?>)</small>
				</div>

				<h3 class="font-weight-semi-bold mb-4"><?php echo "Rs. ".$product->sale_price;?></h3>
				<p class="mb-4"><?php the_content()?></p>
				<div class="d-flex mb-3">
					<p class="text-dark font-weight-medium mb-0 mr-3">Sizes:</p>
					<form>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="size-1" name="size">
							<label class="custom-control-label" for="size-1">XS</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="size-2" name="size">
							<label class="custom-control-label" for="size-2">S</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="size-3" name="size">
							<label class="custom-control-label" for="size-3">M</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="size-4" name="size">
							<label class="custom-control-label" for="size-4">L</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="size-5" name="size">
							<label class="custom-control-label" for="size-5">XL</label>
						</div>
					</form>
				</div>
				<div class="d-flex mb-4">
					<p class="text-dark font-weight-medium mb-0 mr-3">Colors:</p>
					<form>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="color-1" name="color">
							<label class="custom-control-label" for="color-1">Black</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="color-2" name="color">
							<label class="custom-control-label" for="color-2">White</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="color-3" name="color">
							<label class="custom-control-label" for="color-3">Red</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="color-4" name="color">
							<label class="custom-control-label" for="color-4">Blue</label>
						</div>
						<div class="custom-control custom-radio custom-control-inline">
							<input type="radio" class="custom-control-input" id="color-5" name="color">
							<label class="custom-control-label" for="color-5">Green</label>
						</div>
					</form>
				</div>
				<div class="d-flex align-items-center mb-4 pt-2">
					<div class="input-group quantity mr-3" style="width: 130px;">
						<div class="input-group-btn">
							<button class="btn btn-primary btn-minus" >
							<i class="fa fa-minus"></i>
							</button>
						</div>
						<input type="text" class="form-control bg-secondary text-center" value="1">
						<div class="input-group-btn">
							<button class="btn btn-primary btn-plus">
								<i class="fa fa-plus"></i>
							</button>
						</div>
					</div>
					<button class="btn btn-primary px-3"><i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
				</div>
				<div class="d-flex pt-2">
					<p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
					<div class="d-inline-flex">
						<a class="text-dark px-2" href="">
							<i class="fab fa-facebook-f"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-twitter"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-linkedin-in"></i>
						</a>
						<a class="text-dark px-2" href="">
							<i class="fab fa-pinterest"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="row px-xl-5">
			<div class="col">
				<div class="nav nav-tabs justify-content-center border-secondary mb-4">
					<a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
					<a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
					<a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo get_comments_number(); ?>)</a>
				</div>
				<div class="tab-content">
					<div class="tab-pane fade show active" id="tab-pane-1">
						<h4 class="mb-3">Product Description</h4>
						<p><?php the_content()?></p>
					</div>
					<div class="tab-pane fade" id="tab-pane-2">
						<h4 class="mb-3">Additional Information</h4>
						<p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
						<div class="row">
							<div class="col-md-6">
								<ul class="list-group list-group-flush">
									<li class="list-group-item px-0">
										Sit erat duo lorem duo ea consetetur, et eirmod takimata.
									</li>
									<li class="list-group-item px-0">
										Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
									</li>
									<li class="list-group-item px-0">
										Duo amet accusam eirmod nonumy stet et et stet eirmod.
									</li>
									<li class="list-group-item px-0">
										Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
									</li>
									</ul> 
							</div>
							<div class="col-md-6">
								<ul class="list-group list-group-flush">
									<li class="list-group-item px-0">
										Sit erat duo lorem duo ea consetetur, et eirmod takimata.
									</li>
									<li class="list-group-item px-0">
										Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
									</li>
									<li class="list-group-item px-0">
										Duo amet accusam eirmod nonumy stet et et stet eirmod.
									</li>
									<li class="list-group-item px-0">
										Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
									</li>
									</ul> 
							</div>
						</div>
					</div>
					<!--COMMENTS SECTION-->
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
								<h4 class="mb-4"></h4>
								
								<?php
									$id = $product->id;
								
									$args = array ('post_type' => 'product', 'post_id' => $id);
									$comments = get_comments( $args );
									wp_list_comments( array( 'callback' => 'woocommerce_comments' ), $comments);
								?>

                            </div>
							<!--Start Adding Comments-->
                            <div class="col-md-6">
								<div class="leave-review-form">
									<?php
									// Get current commenter information
									$commenter = wp_get_current_commenter();
									$req = get_option('require_name_email');
									$aria_req = ($req ? " aria-required='true'" : '');

									// Define form fields
									$fields = [
										'author' => '<div class="form-group"><input id="author" name="author" type="text" class="form-control" placeholder="Your Name *" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></div>',
										'email' => '<div class="form-group"><input id="email" name="email" type="email" class="form-control" placeholder="Your Email *" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></div>',
									];

									// Define comment form arguments
									$comments_args = [
										'fields' => apply_filters('comment_form_default_fields', $fields),
										'comment_field' => '<div class="form-group"><textarea id="comment" name="comment" class="form-control" cols="30" rows="5" placeholder="Your Review *" aria-required="true"></textarea></div>',
										'title_reply' => '<h4 class="mb-4">Leave a Review</h4>',
										'label_submit' => __('Submit Review', 'textdomain'),
										'class_submit' => 'btn btn-primary px-3',
										'comment_notes_before' => '<small>Your email address will not be published. Required fields are marked *</small>',
										'submit_button' => '<input type="submit" class="btn btn-primary px-3" value="%2$s" />',
										'submit_field' => '<div class="form-group">%1$s %2$s</div>', // Ensures the submit button is part of a form group
									];

									// Add WooCommerce product rating field to the comment form
									add_action('comment_form_logged_in_after', 'add_product_rating_field');
									add_action('comment_form_after_fields', 'add_product_rating_field');

									function add_product_rating_field() {
										global $product;
										
										if (!is_product() || !$product) {
											return;
										}

										$rating = 0;
										$rating_html = '<div class="form-group"><p class="mb-0 mr-2">Your Rating * :</p><div class="text-primary">';
										for ($i = 1; $i <= 5; $i++) {
											$rating_html .= '<input type="radio" id="rating-' . $i . '" name="rating" value="' . $i . '" />';
											$rating_html .= '<label for="rating-' . $i . '"><i class="far fa-star"></i></label>';
										}
										$rating_html .= '</div></div>';

										echo $rating_html;
									}

									// Validate WooCommerce product rating before submission
									add_filter('preprocess_comment', 'validate_product_rating');

									function validate_product_rating($comment_data) {
										if (!isset($_POST['rating']) || empty($_POST['rating'])) {
											wp_die(__('Error: Please select a rating before submitting your review.'));
										}

										return $comment_data;
									}

									// Output the comment form
									comment_form($comments_args);
									?>
								</div>
                            </div>
							<!--COMMENTS SECTION CLOSED-->
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
	<!-- Shop Detail End -->



	<!-- Products Start -->
	<div class="container-fluid py-5">
		<div class="text-center mb-4">
			<h2 class="section-title px-5"><span class="px-2">You May Also Like</span></h2>
		</div>
		<div class="row px-xl-5">
			<div class="col">
				<div class="owl-carousel related-carousel">
				<?php
					// Get the terms for the product category
					$terms = get_the_terms($product_id, 'product_cat');

					if ($terms && ! is_wp_error($terms)) {
						$category = ''; 
						
						foreach ($terms as $term) {
							$category = $term->slug;
							break; 
						}
					?>

					<?php
					} else {
						echo "<p>No terms found.</p>";
					}
						// Define the query arguments
						$args = [
							'post_type' => 'product',
							'post_status' => 'publish',
							'posts_per_page' => -1,
							'orderby' => 'date', 
							'order' => 'ASC',
							'post__not_in'=>[get_the_ID()],
							'tax_query' => [
								[
									'taxonomy' => 'product_cat',
									'field' => 'slug',
									'terms' => $category,
								],
							],
						];

					$loop = new WP_Query($args);
					while ( $loop->have_posts() ) : $loop->the_post(); 
					$product_id=get_the_ID();
					$_product = wc_get_product( $product_id );
					$_product->get_regular_price();
					$_product->get_price();
				?>
					<div class="card product-item border-0">
						<div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0"><?php $product_id=get_the_ID(); ?>
							<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );?>
                            <a href="<?php the_permalink(); ?>" href="" ><img class="img-fluid w-100" src="<?php echo $image[0];?>" alt=""></a>
						</div>
						<div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
							<h6 class="text-truncate mb-3"><?php the_title();?></h6>
							<div class="d-flex justify-content-center">
								<h6><?php echo "Rs. ".$_product->get_price();?></h6><h6 class="text-muted ml-2"><del><?php echo "Rs ".$_product->get_regular_price();?></del></h6>
							</div>
						</div>
						<div class="card-footer d-flex justify-content-between bg-light border">
							<a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
							<a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
						</div>
					</div>
				<?php 
				endwhile;
				wp_reset_postdata();
				?>
				</div>
			</div>
		</div>
	</div>
	<!-- Products End -->





<?php do_action( 'woocommerce_after_single_product' ); ?>
