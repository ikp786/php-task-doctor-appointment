</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script src="https://jqueryvalidation.org/files/dist/additional-methods.min.js"></script>
<script>
    var datesToBeDisabled = '[]';
    var new_date = '';
    $(function() {
        $("#slot_date").datepicker("refresh");
        $("#slot_date").datepicker({
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            beforeShowDay: function(date) {
                var dateStr = jQuery.datepicker.formatDate('yy-mm-dd', date);
                return [datesToBeDisabled.indexOf(dateStr) == -1];
            }
        });
    });

    $("#add_slot_form").validate({
        rules: {
            slot_date: "required",
            start_time: "required",
            end_time: "required",
            slot: "required",
        },
        messages: {
            slot_date: "Plese select Slot Date",
            start_time: "Please Select Start Time",
            end_time: "Please Select End Time",
            slot: "Please Select Slot",
        }
    });

    $(document).on('click', '#submit_slot_form', function(e) {

        var isValid = $("#add_slot_form").valid();
        //var isValid = $(e.target).parents('form').isValid();
        if (!isValid) {
            alert('validation required');
            e.preventDefault(); //prevent the default action
            return false;
        }

    });
</script>

{{-- DATE NEXT AND PREVIOUS -M- --}}
<script>
    $(document).ready(function() {
        changeDate('', ".date-box.show-date")
        $("button.date-previous, button.date-next").click(function(e) {
            e.preventDefault()
            changeDate($(this).data("type"), ".date-box.show-date")
        })
    })
</script>

<script>
    function changeDate(button, target_) {
        var box_date = $(target_).text();
        var date = new Date(`${box_date}-${new Date().getFullYear()}`);

        if (button == "prev") {
            date.setDate(date.getDate() - 1)
        } else if (button == "next") {
            date.setDate(date.getDate() + 1)
        }

        var d = date.getDate();
        if (date.getDate() < 10) {
            d = "0" + date.getDate();
        }

        var send_date = (`${d}-${date.toLocaleString('default', { month: 'short' })}-${new Date().getFullYear()}`);
        if (isFutureDate(date)) {
            getTimeSlot(send_date).done(function(result) {
                console.log(result)
                if (result.status) {
                    $(".data-ajax-date").html(result.data);
                } else {
                    $(".data-ajax-date").empty();
                }
            })
            $(target_).text((`${d}-${date.toLocaleString('default', { month: 'short' })}`))
        }

    }

    function getTimeSlot(date) {
        var doc_id = $("[name=doctor_id]").val(),
            token_ = "{{ csrf_token() }}";
        return $.ajax({
            type: "post",
            url: "{{ route('appointment.get_slot') }}",
            data: {
                _token: token_,
                doctor_id: doc_id,
                date: date
            },
        })
    }

    const isFutureDate = (date) => {
        const specificDate = new Date(date).setHours(0, 0, 0, 0);
        const today = new Date().setHours(0, 0, 0, 0);
        return specificDate >= today;
    }

    $(document).on("click", ".data-ajax-date button.bg-success", function() {
        console.log()
        $("#doct_orid").val($("[name=doctor_id]").val());
        $("#startT_ime").val($(this).html());
        $("#exampleModal").modal("show");
    })


    function printErrorMsg(msg) {
        // console.log(msg);
        $(".validation_error").find("ul").html('');
        $(".validation_error").css('display', 'block');
        $.each(msg, function(key, value) {
            $(".validation_error").find("ul").append('<li>' + value + '</li>');
        });
    }


    $('#bookAppoitments').click(function() {
        $(".validation_error").find("ul").html('');
        $(".validation_error").css('display', 'none');

        var name = $("#name").val();
        var email = $("#email").val();
        var contact_number = $("#contact_number").val();
        var doctor_id = $("#doct_orid").val();
        var startT_ime = $("#startT_ime").val();
        var box_date = $('.date-box.show-date').text();
        var d = new Date();
        var slot_date = box_date + "-" + d.getFullYear(); // + "/" + (d.getMonth()+1) + "/" + d.getDate();
        var formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('contact_number', contact_number);
        formData.append('doctor_id', doctor_id);
        formData.append('start_time', startT_ime);
        formData.append('slot_date', slot_date);

        $.ajax({
            type: 'POST',
            dataType: "json",
            url: '{{ route('appointment.store') }}',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                if ($.isEmptyObject(data.error)) {
                    alert('appointment booked success')
                    $("#exampleModal").modal("hide");
                    location.reload();
                } else {
                    printErrorMsg(data.error)
                }
            }
        });

    });
</script>
