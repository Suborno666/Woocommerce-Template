<?php
global $wpdb;
$args = array(
    'post_type' => 'booking_details',
    'posts_per_page' => -1,
);
$query = new WP_Query($args);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Table</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <table class="table table-bordered table-hover">
        <tr>
            <th>Bus Status</th>
            <th>Start Route</th>
            <th>End Route</th>
            <th>Available Seats</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php

        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                $start_route = get_post_meta(get_the_ID(), 'mb_start_route', true);
                $end_route = get_post_meta(get_the_ID(), 'mb_end_route', true);
                $available_seats = get_post_meta(get_the_ID(), 'mb_available_seats', true);
                $status = $available_seats > 0 ? 'Available' : 'Not Available';
        ?>
                <tr>
                    <td><?php echo get_the_title(get_the_ID());?></td>
                    <td><?php echo esc_html($start_route); ?></td>
                    <td><?php echo esc_html($end_route); ?></td>
                    <td><?php echo esc_html($available_seats); ?></td>
                    <td style="color:<?php echo ($status == 'Available') ? 'chartreuse' : 'red'; ?>"><?php echo esc_html($status); ?></td>
                    <?php if ($status == 'Available'): ?>
                        <td>
                            <button type="button" class="btn btn-info btn-sm register-btn"
                                data-toggle="modal" 
                                data-target="#myModal"
                                data-bus-name=<?php echo get_the_title(get_the_ID());?>
                                data-starting_route=<?php echo $start_route?>
                                data-ending_route=<?php echo $end_route?>
                                data-post-id="<?php echo get_the_ID(); ?>"
                                data-available-seats="<?php echo esc_attr($available_seats); ?>"
                            >
                                Register
                            </button>
                        </td>
                    <?php else: ?>
                        <td>N/A</td>
                    <?php endif; ?>
                </tr>
            <?php 
            endwhile;
            wp_reset_postdata();
        else : ?>
            <tr>
                <td colspan="5" style="text-align: center;" id="empty">No routes found.</td>            
            </tr>
        <?php endif; ?>
    </table>

    <!-- Modal code remains the same -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Submit this form</h4>
                </div>
                <div class="modal-body">
                    <form id="form" method="post">
                        <?php wp_nonce_field('register_route_nonce', 'security'); ?>
                        
                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Write your name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                        </div>
                        
                        <!-- Phone -->
                        <div class="mb-3">
                            <p id="PhoneCheck"></p>
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" name="phone" id="phone" placeholder="Phone Number">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <p id="EmailCheck"></p>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                        </div>

                        <!-- Hidden field(postID) -->
                        <div class="mb-3">
                            <input type="hidden" class="form-control" name="route_id" id="route_id">
                        </div>

                        <!-- Bus Name -->
                        <div class="mb-3">
                            <label for="bus_name" class="form-label">Bus name</label>
                            <input type="text" class="form-control" name="bus_name" id="bus_name" readonly>
                        </div>
                        
                        <!-- Starting Route -->
                        <div class="mb-3">
                            <label for="starting_route" class="form-label">Starting Route</label>
                            <input type="text" class="form-control" name="starting_route" id="starting_route" readonly>
                        </div>
                        
                        <!-- Ending Route -->
                        <div class="mb-3">
                            <label for="ending_route" class="form-label">Ending Route</label>
                            <input type="text" class="form-control" name="ending_route" id="ending_route" readonly>
                        </div>
                        
                        <!-- Seats Allocation -->
                        <div class="mb-3">
                            <p id="SeatAllocate"></p>
                            <label for="number_of_seats_allocated" class="form-label">Allocate Seats</label>
                            <input type="number" class="form-control" name="number_of_seats_allocated" min="1" id="number_of_seats_allocated">
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                        <p id="response"></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?php wp_enqueue_script('custom-ajax-script'); ?>

</body>
</html>