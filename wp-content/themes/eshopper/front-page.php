<?php
/**
 * Template Name: Front Page
 */
get_header();
?>
    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <?php
            // Get the ID of the 'Uncategorized' category
            $uncategorized_term = get_term_by('slug', 'uncategorized', 'product_cat');
            $uncategorized_id = $uncategorized_term ? $uncategorized_term->term_id : 0;

            // Get all product categories excluding 'Uncategorized'
            $terms = get_terms([
                'taxonomy' => 'product_cat',
                'hide_empty' => false,
                'order' => 'DESC',
                'exclude' => [$uncategorized_id]
            ]);

            foreach ($terms as $term) {
                // Get category thumbnail image
                $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
                $image = wp_get_attachment_url($thumbnail_id);
                $image_url = $image 
            ?>
            <div class="col-lg-4 col-md-6 pb-1">
                <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                    <a href="<?php echo get_term_link($term); ?>" class="cat-img position-relative overflow-hidden mb-3">
                        <img class="img-thumbnail img-fluid" src="<?php echo $image_url ?>" alt="<?php echo esc_attr($term->name); ?>">
                    </a>
                    <h5 class="font-weight-semi-bold m-0"><?php echo esc_html($term->name); ?></h5>

                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
    <!-- Categories End -->

    <!-- Offer Start -->
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <?php 
            $fields = get_field('advertisement_field',$post_id);
            if($fields):
                
                foreach($fields as $field):
                    $image_url = esc_url($field['advertisement_images']['url']);
                    $heading1 = esc_html($field['advertisement_first_header']);
                    $heading2 = esc_html($field['advertisement_second_header']);
                    $link = esc_url($field['link']);
            ?>
            <div class="col-md-6 pb-4">
                <div class="position-relative bg-secondary text-center text-md-left text-white mb-2 py-5 px-5">
                    <img src="<?php echo $image_url;?>" alt="">
                    <div class="position-relative" style="z-index: 1;">
                        <h5 class="text-uppercase text-primary mb-3"><?php echo $heading1;?></h5>
                        <h1 class="mb-4 font-weight-semi-bold"><?php echo $heading2;?></h1>
                        <a href="<?php echo $link;?>" class="btn btn-outline-primary py-md-2 px-md-3">Shop Now</a>
                    </div>
                </div>
            </div>
            <?php 
                endforeach;
            endif;
            ?>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Trendy Products</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php 
            $items = get_field('trendy_product');
            foreach($items as $item):
                    $product_id = $item->ID;
                    $_product = wc_get_product( $product_id );
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );?>
                            <img class="w-100 h-100" src="<?php echo $image[0]; ?>" alt="Image">
                        <img class="img-fluid w-100" src="img/product-5.jpg" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php echo $item->post_title; ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6>Rs. <?php echo $_product->get_sale_price();?></h6><h6 class="text-muted ml-2"><del>Rs. <?php echo $_product->get_regular_price();?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?php echo the_permalink()?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        
                        <?php
                        // $product_id = $product->get_id();
                        $add_to_cart_url = esc_url( '?add-to-cart=' . $product_id );
                        ?>
                        <a href="<?php echo $add_to_cart_url; ?>" class="btn btn-sm text-dark p-0 add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" data-quantity="1" aria-label="<?php echo $_product->add_to_cart_description(); ?>" rel="nofollow">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                        </a>
                    </div>
                </div>
            </div>
            <?php
            endforeach;
            ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Subscribe Start -->
    <div class="container-fluid bg-secondary my-5">
        <div class="row justify-content-md-center py-5 px-xl-5">
            <div class="col-md-6 col-12 py-5">
                <div class="text-center mb-2 pb-2">
                    <h2 class="section-title px-5 mb-3"><span class="bg-secondary px-2">Stay Updated</span></h2>
                    <p>Amet lorem at rebum amet dolores. Elitr lorem dolor sed amet diam labore at justo ipsum eirmod duo labore labore.</p>
                </div>
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-white p-4" placeholder="Email Goes Here">
                        <div class="input-group-append">
                            <button class="btn btn-primary px-4">Subscribe</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Subscribe End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            <?php
            $args = [
                'post_type'=>['product'],
                'post_status'=>'publish',
                'posts_per_page'=>-1,
                'orderby'=>[
                    'date'=>'ASC'
                ],
                'order'=>'ASC'
            ];
            $loop = new WP_Query($args);
            while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php $product_id=get_the_ID(); ?>
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );?>
                            <img class="w-100 h-100" src="<?php echo $image[0]; ?>" alt="Image">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><a style="color:darkgoldenrod !important;" href="<?php the_permalink(); ?>"><?php the_title()?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo "Rs. ".get_post_meta(get_the_ID(),'_sale_price',true)?></h6><h6 class="text-muted ml-2"><del><?php echo "Rs. ".get_post_meta(get_the_ID(),'_regular_price',true)?></del></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?php the_permalink(); ?>" href="" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <?php
                        $product_id = $product->get_id();
                        $add_to_cart_url = esc_url( '?add-to-cart=' . $product_id );
                        ?>
                        <a href="<?php echo $add_to_cart_url; ?>" class="btn btn-sm text-dark p-0 add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo $product_id; ?>" data-quantity="1" aria-label="<?php echo $product->add_to_cart_description(); ?>" rel="nofollow">
                            <i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart
                        </a>
                    </div>
                </div>
            </div>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-1.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-2.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-3.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-4.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-5.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-6.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-7.jpg" alt="">
                    </div>
                    <div class="vendor-item border p-4">
                        <img src="img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->

    <!-- Video Field  -->
    <?php
    // $video_URL = get_field('video_ad',$post_id);
    ?>
    <!-- <div class="embed-responsive embed-responsive-4by3">
        <iframe class="embed-responsive-item" src="<?php echo $video_URL; ?>"  ></iframe>
    </div> -->
    <!--  Video Field End  -->

<?php
    get_footer();
?>