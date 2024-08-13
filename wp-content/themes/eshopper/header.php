<?php
/** 
 * Template name: Header
 */
 $post_id = get_the_ID();
 $GLOBALS['post_id'] = $post_id;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet"> 

    <?php
    wp_head();
    ?>

</head>

<body <?php body_class(); ?>>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-2 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center">
                    <a class="text-dark" href="">FAQs</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Help</a>
                    <span class="text-muted px-2">|</span>
                    <a class="text-dark" href="">Support</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
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
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-dark pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center py-3 px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a href="" class="text-decoration-none">
                    <h1 class="m-0 display-5 font-weight-semi-bold"><a href="<?php echo esc_url(home_url('/'))?>" style="text-decoration:none currentColor !important;" ><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</a></h1>
                </a>
            </div>
            <div class="col-lg-6 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" id="search_by_string" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search" id="search_item"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-3 col-6 text-right">
                <a href="" class="btn border">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge">0</span>
                </a>
                <button class="btn border" data-toggle="modal" data-target="#exampleModalCenter" >
                    <i class="fas fa-shopping-cart text-primary" ></i>
                    <span class="badge" style="color: #D19C97;"></span>
                </button>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Popup Start -->

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-center modal-title" id="exampleModalLongTitle">Your Cart</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <?php
                            global $woocommerce;
                            $items = $woocommerce->cart->get_cart();
                        ?>
                        <table>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center" colspan="2">Action</th>
                            </tr>
                            <?php foreach($items as $item => $values):
                                    $_product =  wc_get_product( $values['data']->get_id()); ?>
                                        <tr data-product-id="<?php echo $values['product_id']; ?>">
                                            <td class="text-center"><?php echo $_product->get_title(); ?></td>
                                            <td class="text-center price"><?php echo get_post_meta($values['product_id'], '_price', true); ?></td>
                                            <td style="display: flex; flex-direction: row;">
                                                <button onclick="totalClick(1, <?php echo $values['product_id']; ?>)">+</button>
                                                <input type="number" style="width: 100px;" class="quantity-input" value="<?php echo $values['quantity']; ?>" min="0" />
                                                <button onclick="totalClick(-1, <?php echo $values['product_id']; ?>)">-</button>
                                            </td>
                                            <td>Update</td>
                                            <td>Delete</td>
                                        </tr>
                            <?php endforeach ?>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- Popup End -->

    <!-- Navbar Start -->
    <div class="container-fluid mb-5">
            <!-- <div class="row border-top px-xl-5">
                <div class="col-lg-3 d-none d-lg-block">
                   
                </div>
            </div> -->
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <h1 class="m-0 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
 
                            <a href="<?php echo esc_url(home_url('/'))?>" class="nav-item nav-link <?php echo (is_front_page())?"active":""?>"> Home</a>
   
                            <a href="<?php echo get_home_url(null,'shop')?>" class="nav-item nav-link <?php echo (is_shop())?"active":""?>">Shop</a> 

                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu rounded-0 m-0">
                                    <a href="<?php echo get_home_url(null,'cart')?>" class="dropdown-item <?php echo (is_page('cart'))?"active":"";?>">Shopping Cart</a>
                                    <a href="checkout.html" class="dropdown-item">Checkout</a>
                                </div>
                            </div>
                            <a href="contact.html" class="nav-item nav-link">Contact</a>
                        </div>
                        <div class="navbar-nav ml-auto py-0">
                            <a href="" class="nav-item nav-link">Login</a>
                            <a href="" class="nav-item nav-link">Register</a>
                        </div>
                    </div>
                </nav>
                <?php 
                    if(is_shop()){
                    ?>
                        <div class="container-fluid bg-secondary mb-5">
                            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px;">
                                <h1 class="font-weight-semi-bold text-uppercase mb-3">Our Shop</h1>
                                <div class="d-inline-flex">
                                    <p class="m-0"><a href="<?php echo esc_url(home_url('/'))?>">Home</a></p>
                                    <p class="m-0 px-2">-</p>
                                    <p class="m-0">Shop</p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    else if(is_front_page()){
                    ?>
                        <div id="header-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $fields = get_field('image_banners', $post_id);
                                if ($fields):
                                    $is_first_item = true;  
                                    foreach ($fields as $field):
                                        $image_url = esc_url($field['banner_image']['url']); 
                                        $heading = esc_html($field['banner_headings']);
                                        $paragraph = esc_html($field['banner_paragraph']);
                                        ?>
                                        <div class="carousel-item <?php echo $is_first_item?'active':""; ?>" style="height: 410px;">
                                            <img class="img-fluid" src="<?php echo $image_url; ?>" alt="Image">
                                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                                <div class="p-3" style="max-width: 700px;">
                                                    <h4 class="text-light text-uppercase font-weight-medium mb-3"><?php echo $heading; ?></h4>
                                                    <h3 class="display-4 text-white font-weight-semi-bold mb-4"><?php echo $paragraph; ?></h3>
                                                    <a href="<?php echo esc_url(get_home_url(null, 'shop')); ?>" class="btn btn-light py-2 px-3">Shop Now</a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $is_first_item = false;
                                    endforeach;
                                endif;
                                ?>

                            </div>
                            <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">
                                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                                    <span class="carousel-control-prev-icon mb-n2"></span>
                                </div>
                            </a>
                            <a class="carousel-control-next" href="#header-carousel" data-slide="next">
                                <div class="btn btn-dark" style="width: 45px; height: 45px;">
                                    <span class="carousel-control-next-icon mb-n2"></span>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                    else if(is_singular()){
                    ?>
                        <!-- Page Header Start -->
                        <div class="container-fluid bg-secondary mb-5">
                            <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
                                <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
                                <div class="d-inline-flex">
                                    <p class="m-0"><a href="<?php esc_url(home_url('/'))?>">Home</a></p>
                                    <p class="m-0 px-2">-</p>
                                    <p class="m-0">Shop Detail</p>
                                </div>
                            </div>
                        </div>
                        <!-- Page Header End -->
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Navbar End -->


                