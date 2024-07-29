validateField = (data, field, regExPattern, name) => {
    if (data.length === 0) {
        $(field).html("Empty field").css('color', "red").show();
        return false;
    }
    
    else if (!regExPattern.test(data)) {
        $(field).html(name + " is not valid").css('color', "red").show();
        return false;
    }
    
    $(field).hide();
    return true;
}

seat_count = (seats_booked, available_seats, Field) => {
    if (isNaN(seats_booked) || seats_booked <= 0) {
        $(Field).html("Please enter a valid number of seats");
        $(Field).css('color', "red");
        $(Field).show();
        return false;
    }
    if (seats_booked > available_seats) {
        $(Field).html("You can allot seats equal to or less than " + available_seats);
        $(Field).css('color', "red");
        $(Field).show();
        return false;
    }
    $(Field).hide();
    return true;
}

jQuery(document).ready(function($) {

    $('.btn-danger').on('click', function() {
        var $row = $(this).closest('tr');
        var id = $row.data('row-id');
        console.log('Clicked button for ID:', id);    
        $row.fadeOut(400,()=>{
            $(this).remove()
        })
    });
    $('.register-btn').click(function() { 
        var postId = $(this).data('post-id');
        var starting = $(this).data('starting_route');
        var ending = $(this).data('ending_route');
        var busname = $(this).data('bus-name');
        const availableSeats = $(this).data('available-seats');
        $('#route_id').val(postId);
        $('#number_of_seats_allocated').attr('max', availableSeats);
        $('#bus_name').val(busname);
        $('#starting_route').val(starting);
        $('#ending_route').val(ending);
    });


    $("#email").on('keyup',()=>{

        const emAil = $("#email").val();
        validateField(emAil,"#EmailCheck",/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/,"Email");
  
    })
    $("#phone").on('keyup',()=>{

        const pHone = $("#phone").val();
        var field = "#PhoneCheck";

        if(pHone.length < 9){
            $(field).html("Number should be at least 9 digits").css('color', "red").show();
            return false;
        }else if(pHone.length > 10){
            $(field).html("Number should not exceed 10 digits").css('color', "red").show();
            return false;
        }else{
            validateField(pHone,field,/^[789]\d+$/,"Phone");
        }
    })

    $('#number_of_seats_allocated').on('keyup', function() {
        var availableSeats = parseInt($('#number_of_seats_allocated').attr('max'));
        var seats_booked = parseInt($(this).val());
        seat_count(seats_booked, availableSeats, '#SeatAllocate');
    });

    $("#form").on('submit', function(e) {
        e.preventDefault();
        var email = $("#email").val();
        var phone = $("#phone").val();
        var seats_booked = parseInt($("#number_of_seats_allocated").val());
        var availableSeats = parseInt($('#number_of_seats_allocated').attr('max'));

        var isEmailValid = validateField(email, "#EmailCheck", /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/, "Email");
        var isPhoneValid = validateField(phone, "#PhoneCheck", /^((\+91)?|0?)[789]\d{9}$/, "Phone");
        var isSeatsValid = seat_count(seats_booked, availableSeats, '#SeatAllocate');

        if (!isEmailValid || !isPhoneValid || !isSeatsValid) {
            return; 
        }

        var formData = new FormData($(this)[0]);
        formData.append('action', 'register_route');

        for(var[key,value] of formData.entries()){
            console.log(key,"=>",value);
        }
        $.ajax({
            type: "POST",
            url: ajax_object.ajax_url,
            data: formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: function(res) {
                console.log("Success:", res);
                if(res.success){
                    $("#response").html(res.data.message).css('color','green');
                } else {
                    $("#response").html(res.data.message).css('color','red');
                }
                setTimeout(function() {
                    $('#form').trigger("reset");
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
                console.log("Full response:", xhr.responseText);
                $("#response").html("An error occurred. Please try again.").css('color','red');
            }
        });
    });
});