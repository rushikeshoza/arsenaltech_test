$(document).ready(function () {
    selectedSeatNo       = new Array();
    cancelSelectedSeatNo = new Array();
    
    if (window.sessionMsg !== '') {
        $.notify(window.sessionMsg);
    }
    
    $('.book-seat').on('click', function () {
        var _this = $(this),
            seatNo = _this.data('seat-no');
        
        if (!_this.hasClass('not-available')) {
            
            if (_this.hasClass('selected')) {
                _this.removeClass('selected');
            } else {
                _this.addClass('selected');
            }
            
            var selectedSeats = $('.table').find('.selected');
            
            if (selectedSeats.length > 0) {
                $('.book-now-btn').show();
            } else {
                $('.book-now-btn').hide();
            }
            
            selectedSeatNo = [];
            
            $.each(selectedSeats, function (key, seat) {
                selectedSeatNo.push($(seat).data('seat-no'));
            });
            
            $('.seat-text').html('You have selected ' + selectedSeatNo.join(', ') + ' seats...!!!');
            
        } else {
            
            if (_this.hasClass('cancel-selected')) {
                _this.removeClass('cancel-selected');
            } else {
                _this.addClass('cancel-selected');
            }
            
            var selectedSeats = $('.table').find('.cancel-selected');
            
            if (selectedSeats.length > 0) {
                $('.cancel-now-btn').show();
            } else {
                $('.cancel-now-btn').hide();
            }
            
            cancelSelectedSeatNo = [];
            
            $.each(selectedSeats, function (key, seat) {
                cancelSelectedSeatNo.push($(seat).data('seat-no'));
            });
            
            $('.seat-text').empty().append('You have selected ' + cancelSelectedSeatNo.join(', ') + ' seats...!!!');
        }
    });
    
    $('.book-seat-btn').on('click', function () {
        $('#selectedSeats').val(selectedSeatNo);
    });
    
    $('.cancel-booking').on('click', function () {
        $.ajax({
            url: window.cancelUrl,
            method: "POST",
            data: {
                _token : $('input[name="_token"]').val(),
                cancel_email : $('input[name="cancel_email"]').val(),
                confirmation_no : $('input[name="confirmation_no"]').val(),
                cancelSelectedSeatNo : cancelSelectedSeatNo
            },
            success: function(result) {
                location.reload(true);
            }
        });
    });
});
