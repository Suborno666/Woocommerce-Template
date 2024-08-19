<?php

/**
 * Template Name: Footer 
 */
?>

<!-- Footer Start -->
    <div class="container-fluid bg-secondary text-dark mt-5 pt-5">
        <div class="row px-xl-5 pt-5">
            <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">
                <a href="" class="text-decoration-none">
                    <h1 class="mb-4 display-5 font-weight-semi-bold"><span class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>
                </a>
                <p>Dolore erat dolor sit lorem vero amet. Sed sit lorem magna, ipsum no sit erat lorem et magna ipsum dolore amet erat.</p>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i><?php echo the_field('footer_address','option')?></p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i><?php echo the_field('footer_email','option')?></p>
                <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i><?php echo the_field('footer_phone_number','option')?></p>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="row">
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="<?php echo esc_url(home_url('/'))?>"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="<?php echo get_home_url( null,'shop' ) ?>"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Quick Links</h5>
                        <div class="d-flex flex-column justify-content-start">
                            <a class="text-dark mb-2" href="index.html"><i class="fa fa-angle-right mr-2"></i>Home</a>
                            <a class="text-dark mb-2" href="shop.html"><i class="fa fa-angle-right mr-2"></i>Our Shop</a>
                            <a class="text-dark mb-2" href="cart.html"><i class="fa fa-angle-right mr-2"></i>Shopping Cart</a>
                            <a class="text-dark mb-2" href="checkout.html"><i class="fa fa-angle-right mr-2"></i>Checkout</a>
                            <a class="text-dark" href="contact.html"><i class="fa fa-angle-right mr-2"></i>Contact Us</a>
                        </div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                        <form action="">
                            <div class="form-group">
                                <input type="text" class="form-control border-0 py-4" placeholder="Your Name" required="required" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control border-0 py-4" placeholder="Your Email"
                                    required="required" />
                            </div>
                            <div>
                                <button class="btn btn-primary btn-block border-0 py-3" type="submit">Subscribe Now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-top border-light mx-xl-5 py-4">
            <div class="col-md-6 px-xl-0">
                <p class="mb-md-0 text-center text-md-left text-dark">
                    &copy; <a class="text-dark font-weight-semi-bold" href="#">Your Site Name</a>. All Rights Reserved. Designed
                    by
                    <a class="text-dark font-weight-semi-bold" href="https://htmlcodex.com">HTML Codex</a><br>
                    Distributed By <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                </p>
            </div>
            <div class="col-md-6 px-xl-0 text-center text-md-right">
                <img class="img-fluid" src="img/payments.png" alt="">
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

    <?php 
        wp_footer();
    ?>
    <script>     
    jQuery(document).ready(function($) {

        // Code for updating the cart content in real time
        var current_items_in_cart = <?php echo count(WC()->cart->get_cart()); ?>;
        var product_id = $('.ID').val();
        update_number_on_count = () => {
            $.ajax({
                url: wc_add_to_cart_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'get_cart_count'
                },
                success: function(response) {
                    current_items_in_cart = parseInt(response);
                    $('.fa-shopping-cart').closest('.border').find('.badge').text(current_items_in_cart);
                    $('.table').trigger("reload");
                }
            }); 
        }
        // Here

        // $('.add_to_cart_button').on('click', function(e) {
        //     e.preventDefault();
        //     var id = $(this).attr('data-product_id');
        //     alert(`Product Id: ${id}`)
        //     console.log('Clicked!');
        //     console.log(`Product Id: ${id}`);
        //     // updateTable(id);
        // });

            updateTable = (productId) =>{
                $.ajax({
                    url: wc_add_to_cart_params.ajax_url,
                    type: 'POST',
                    data: {
                        action: 'update_table',
                        product_id: productId
                    },
                    success: function(response) {
                        if (response.success) {
                            let data = response.data;
                            let row = $(`tr[data-product-id="${data.productId}"]`);
                            if (row.length) {
                                row.find('.quantity-input').val(data.quantity);
                                row.find('.price').text(data.price);
                            } else {
                                let newRow = `
                                    <tr data-product-id="${data.productId}">
                                        <td class="ID">${data.productId}</td>
                                        <td class="product_name">${data.name}</td>
                                        <td class="price">${data.price}</td>
                                        <td style="display: flex; flex-direction: row;">
                                            <button onclick="totalClick(1, ${data.productId})">+</button>
                                            <input type="number" style="width: 100px;" class="quantity-input" value="${data.quantity}" min="0" />
                                            <button onclick="totalClick(-1, ${data.productId})">-</button>
                                        </td>
                                        <td><button onclick="deleteRow(${data.productId})">Delete</button></td>
                                    </tr>
                                `;
                                $('table.table-striped').append(newRow);
                            }
                        } else {
                            console.error("Error updating table:", response.data);
                        }
                    }
                });
            }

        // Here

        // update_number_on_count();
        console.log("Product-ID:",product_id);

        $(document.body).on('added_to_cart removed_from_cart', function(e) {
            e.preventDefault();
            update_number_on_count();
            console.log("Product-ID:",product_id);
            updateTable(product_id)
        });

        function updateTableRow(data) {
            let row = $(`tr[data-product-id="${data.productId}"]`);
            row.find('.quantity-input').val(data.quantity);
            row.find('.price').text(data.price);
        }
        
        // Code for addition and substraction
        window.totalClick = function(change, productId) {
            let row = $(`tr[data-product-id="${productId}"]`);
            let input =  row.find(`.quantity-input`)
            let newQuantity = parseInt(input.val()) + change;
            if (newQuantity >= 1) {
                input.val(newQuantity);
                updateCart(productId, newQuantity);
            }
        }

        updateCart=(product_id, quantity)=>{
            $.ajax({
                url: wc_add_to_cart_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'update_cart_item',
                    product_id: product_id,
                    quantity: quantity,
                },
                success: (response) => {
                    if(response.success){
                        updateTableRow(response.data)
                    } else {
                        console.error("Error:", response.data);
                    }
                },
                error: (xhr, status, error) => {
                    console.error("AJAX error:", status, error);
                }
            });
        }


        deleteRow = (productId) => {
            $.ajax({
                url: wc_add_to_cart_params.ajax_url,
                type: 'POST',
                data: {
                    action: 'delete_cart_item',
                    product_id: productId,
                },
                success: (response) => {
                    if (response.success) {
                        console.log("Delete Response Data:",response.data);

                        $(`tr[data-product-id="${productId}"]`).fadeOut(400,()=>{
                            $(this).remove()
                        })
                        current_items_in_cart = parseInt(response.data.quantity);
                        console.log("Current Item:",current_items_in_cart);
                        $('.fa-shopping-cart').closest('.border').find('.badge').text(current_items_in_cart);
                    } else {
                        console.error("Error:", response.data);
                    }
                },
                error: (xhr, status, error) => {
                    console.error("AJAX error:", status, error);
                }
            });
        }
    });
    </script>
</body>
</html>