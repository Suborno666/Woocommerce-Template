<?php
/**
 * Review Comments Template
 *
 * Closing li is left out on purpose!.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/review.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

			<div class="media mb-4">
				<img src="
						<?php
						/**
						 * The woocommerce_review_before hook
						 *
						 * @hooked woocommerce_review_display_gravatar - 10
						 */
						// do_action( 'woocommerce_review_before', $comment );
						echo get_avatar_url($comment, ['size' => 100]); 
						?>
				" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
				<div class="media-body">
					<h6><?php comment_author()?><small> - <i><?php echo get_comment_date();?></i></small></h6>
					<?php
					/**
					 * The woocommerce_review_before_comment_meta hook.
					 *
					 * @hooked woocommerce_review_display_rating - 10
					 */
					do_action( 'woocommerce_review_before_comment_meta', $comment );

					?>
					<p><?php comment_text(); ?></p>
				</div>
			</div>	
		<!-- <div class="comment-text"> -->

		<!-- </div> -->
	</div>
