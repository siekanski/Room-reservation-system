$(document).ready(function () {

    $('#Show').click(function (e) {
        
        e.preventDefault();
        var input1 = $('#data').val();
        var inputTime1_hour = $('#timeStart_hour').val();
        var inputTime1_minute = $('#timeStart_minute').val();
        var inputTime1 = inputTime1_hour + ":" + inputTime1_minute;
        var inputTime2_hour = $('#timeEnd_hour').val();
        var inputTime2_minute = $('#timeEnd_minute').val();
        var inputTime2 = inputTime2_hour + ":" + inputTime2_minute;
        var date = new Date(input1);
        var date2 = new Date();
        var todayString = date2.getFullYear() + "-" + (date2.getMonth() + 1) + "-" + date2.getDate();
        var today = new Date(todayString);
        var error = $('<div class="errorForm"><span class="glyphicon glyphicon-exclamation-sign"></span>Wrong data</div>');
        var data = {key1: input1, key2: inputTime1, key3: inputTime2};
        var rooms = $('.room');

        if (date < today || !input1) {
            if ($('#data').prev().find('div').length === 0) {
                $('#data').prev().append(error);
                rooms.removeClass('available');
                rooms.removeClass('unavailable');
                rooms.off('click');
            } 
        } else {
            $('#data').prev().find('div').remove();
            if (inputTime1_hour > inputTime2_hour ||
                      ((inputTime1_hour === inputTime2_hour) && (inputTime1_minute >= inputTime2_minute))) {
                if (!$('#timeStart').hasClass('has-error')) {
                    $('#timeStart').addClass('has-error').append(error);
                    $('#timeEnd').addClass('has-error').append(error)
                }

            } else {
                $('#timeStart').removeClass('has-error');
                $('#timeEnd').removeClass('has-error');
                $('.errorForm').remove();
        }
        }
        if(!$('#timeStart').hasClass('has-error') && $('#data').prev().find('div').length === 0) {
            $('#timeStart').removeClass('has-error');
            $('.errorForm').remove();
            $.ajax({
                beforeSend: function () {
                    $('.hall').append('<div class="loading"></div>');
                },
                url: $('#index_form').attr('data-path-getRooms'),
                method: "POST",
                data: data

            })

                    .done(function (data) {
                        $('.loading').remove();
                        rooms.removeClass('unavailable');
                        $('.checked').removeClass('checked');
                        rooms.addClass('available');
                        $('.reservation-btn').remove();

                        if (typeof data !== 'undefined') {
                            for (i = 0; i < data.data.length; i++) {
                                for (j = 0; j < rooms.length; j++) {
                                    if (parseInt($(rooms[j]).attr('id')) === data.data[i]) {
                                        $(rooms[j]).removeClass('available');
                                        $(rooms[j]).addClass('unavailable');
                                    }
                                }
                            }
                        }
                        var count = 0;
                        $('.available').on('click', function (e) {

                            var roomsContainer = $('#floor').parent();
                            $('.reservation-btn').remove();

                            if (count < 1) {
                                $(this).addClass('checked');
                                count++;
                                var resButton = $("<div id='res_button'><a href=setReservation/" + $(this).attr('id') + " class='btn btn-primary reservation-btn'>Rezerwuj</a></div>");
                                roomsContainer.append(resButton);

                            } else {
                                $('.available').removeClass('checked');
                                count = 0;
                                $('.reservation-btn').remove();
                            }

                        });
                        $('.unavailable').off('click');


                    });
        }


    });



});


