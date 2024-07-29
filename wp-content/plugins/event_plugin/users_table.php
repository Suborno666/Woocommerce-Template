<?php
    global $wpdb;
    $post_id = get_the_ID();
        
    $table_name = $wpdb->prefix . 'user_route_details';
    $results = $wpdb->get_results("SELECT * FROM $table_name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
    <table class="table table-bordered table-hover">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Bus Name</th>
            <th>Starting Point</th>
            <th>Ending Point</th>
            <th>Seats Taken</th>
            <th>Action</th>
        </tr>
        <?php
        if ($results) {
            foreach ($results as $row) { ?>
                <tr id="row" data-row-id="<?php echo esc_html($row->id); ?>">
                    <td><?php echo esc_html($row->id)?></td>
                    <td><?php echo esc_html($row->name); ?></td>
                    <td><?php echo esc_html($row->phone_number); ?></td>
                    <td><?php echo esc_html($row->email); ?></td>
                    <td><?php echo esc_html($row->bus_name); ?></td>
                    <td><?php echo esc_html($row->starting_route); ?></td>
                    <td><?php echo esc_html($row->ending_route); ?></td>
                    <td><?php echo esc_html($row->seats_alloted); ?></td>
                    <td><p style="color:green">Approve</p><button type="button" class="btn btn-danger">Deny</button></td>
                </tr>
            <?php 
            }
        } else { ?>
            <tr>
                <td colspan="6" style="text-align: center;" id="empty">No routes found.</td>            
            </tr>
        <?php } ?>
    </table>
    <?php wp_enqueue_script('custom-ajax-script'); ?>
</body>
</html>