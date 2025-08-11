@extends('layouts.main')

@section('container')
    <div class="">
        {{ Breadcrumbs::render() }}
    </div>
    
    @include('partials.modal-info-rapat')

    <div class="container">
        <div class="border-bottom border-black">
            <h1 class="ms-3">Agenda Rapat</h1>
        </div>
        <br>
        <div>
            <div id="calendar"></div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var agenda = @json($events);

            $(`#calendar`).fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    // right: 'month,agendaWeek,agendaDay'
                    right: 'today'
                },
                events: agenda,
                selectable: false,
                selectHelper: true,

                select: function(start, end, allDay) {
                    // prevent user to select past date
                    const todayDate = moment().format('YYYY-MM-DD');
                    const dateToCheck = moment(start).format('YYYY-MM-DD');
                    if (dateToCheck < todayDate) {
                        return;
                    }

                    // display modal to create event
                    $('#createRapatModal').modal('show');

                    $('#saveBtn').click(function() {
                        const judul = $('#judul').val();
                        const perihal = $('#perihal').val();
                        const tempat = $('#tempat').val();
                        const pemimpinRapat = $('#pemimpin').val();
                        const pesertaRapat = $('#peserta').val();
                        const startTime = $('#start-time').val();
                        const endTime = $('#end-time').val();
                        const color = $('input[name=colorOptions]:checked').val();
                        const start_date = moment(start).format('YYYY-MM-DD');
                        const startDateTime = `${start_date} ${startTime}`;
                        const endDateTime = `${start_date} ${endTime}`;

                        let isValid = true;

                        // clear error messages first before checking
                        $('#judulError').text('');
                        $('#perihalError').text('');
                        $('#tempatError').text('');
                        $('#pemimpinError').text('');
                        $('#pesertaError').text('');
                        $('#startTimeError').text('');
                        $('#endTimeError').text('');

                        if (!judul.trim()) {
                            $('#judulError').text('judul is required');
                            isValid = false;
                        }

                        if (!perihal.trim()) {
                            $('#perihalError').text('Perihal tidak boleh kosong.');
                            isValid = false;
                        }

                        if (!tempat) {
                            $('#tempatError').text('Tempat tidak boleh kosong.');
                            isValid = false;
                        }

                        if (!pemimpinRapat) {
                            $('#pemimpinError').text('Pemimpin Rapat tidak boleh kosong.');
                            isValid = false;
                        }

                        if (!pesertaRapat[0]) {
                            $('#pesertaError').text('Peserta Rapat tidak boleh kosong.');
                            isValid = false;
                        }

                        if (!startTime) {
                            $('#startTimeError').text('Start time is required');
                            isValid = false;
                        }

                        if (!endTime) {
                            $('#endTimeError').text('End time is required');
                            isValid = false;
                        }

                        if (!isValid) {
                            return;
                        }

                        $.ajax({
                            url: '{{ route('rapat.store') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                judul: judul,
                                perihal: perihal,
                                tempat: tempat,
                                pemimpinRapat: pemimpinRapat,
                                pesertaRapat: pesertaRapat,
                                waktuMulai: startDateTime,
                                waktuSelesai: endDateTime,
                                warnaLabel: color,
                            },
                            success: function(response) {
                                $('#createRapatModal').modal('hide');
                                $('#calendar').fullCalendar('renderEvent', {
                                    'id': response.id,
                                    'title': response.title,
                                    'start': response.start,
                                    'end': response.end,
                                    'color': response.color,
                                });

                                // Clear form fields
                                $('#title').val('');
                                $('#start-time').val('');
                                $('#end-time').val('');
                                $('input[name=colorOptions]').prop('checked',
                                    false);
                            },
                            error: function(error) {
                                if (error.responseJSON.errors) {
                                    $('#titleError').text(error.responseJSON.errors
                                        .title);
                                }
                            }
                        });
                    });
                },

                // enable drag and drop agenda
                editable: false,

                // Callback function for when an event is dragged and dropped
                eventDrop: function(event) {
                    const id = event.id;

                    // Get the new date from the event drop
                    const newStartDate = event.start.format('YYYY-MM-DD');
                    const newEndDate = event.end.format('YYYY-MM-DD');

                    // Combine new date with original time
                    const newStartDateTime = `${newStartDate} ${event.startTime}`;
                    const newEndDateTime = `${newEndDate} ${event.endTime}`;

                    // Perform AJAX request to update the event
                    $.ajax({
                        url: '{{ route('rapat.update', '') }}' + '/' + id,
                        type: 'PATCH',
                        dataType: 'json',
                        data: {
                            waktuMulai: newStartDateTime,
                            waktuSelesai: newEndDateTime
                        },
                        success: function(response) {
                            swal("Berhasil", "Rapat berhasil diperbarui", "success");
                        },
                        error: function(error) {
                            if (error.responseJSON.errors) {
                                $('#titleError').text(error.responseJSON.errors
                                    .title);
                            }
                        }
                    });
                },

                // prevent user to select past date and drop event to past date
                eventConstraint: {
                    start: moment().format('YYYY-MM-DD'),
                    end: '2100-01-01' // hard coded goodness unfortunately
                },

                eventClick: function(event) {
                    const id = event.id;

                    $('.modal-title').text(event.title);
                    $('#hariTanggal').text(
                        `${event.hariTanggal} | ${event.waktuMulai} - ${event.waktuSelesai}`);
                    $('#tempat').text(event.tempat);
                    $('#perihal').text(event.perihal);
                    event.pesertaRapat.map(peserta => {
                        $('#peserta').append(`<li>${peserta.nama}</li>`);
                    });
                    $('#editModal').modal('show');
                },

                // prevent user to select multiple days
                selectAllow: function(event) {
                    return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1,
                        'second').utcOffset(false), 'day');
                },

                // Customize the day names and the month names
                dayNamesShort: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                dayNames: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
                buttonText: {
                    today: 'Hari Ini',
                    month: 'Bulan',
                    week: 'Minggu',
                    day: 'Hari'
                },

                // Customize the date formats
                views: {
                    month: {
                        titleFormat: 'MMMM YYYY', // Full month name and year
                        columnFormat: 'ddd' // Short day name and day/month
                    },
                    week: {
                        titleFormat: 'D MMMM YYYY', // Day Month Year for the entire week view title
                        columnFormat: 'ddd D/M' // Short day name and day/month
                    },
                    day: {
                        titleFormat: 'dddd, D MMMM YYYY', // Full day name, day, full month name, and year
                        columnFormat: 'dddd D/M' // Full day name and day/month
                    }
                },

                // Customize the time formats
                timeFormat: 'H:mm', // Time format without AM/PM (24-hour format)
                slotLabelFormat: 'H:mm', // Time format for the left-side labels (24-hour format)
                eventTimeFormat: { // For events' time display
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false, // Disable AM/PM
                    hour12: false // Use 24-hour format
                },

                // Callback function for rendering each event
                eventAfterRender: function(event, element) {
                    // This callback function is executed after each event is rendered

                    // Convert the start time of the event to ISO 8601 format and extract just the time part (HH:mm)
                    // For example, this will convert 2024-09-04T10:33:05.000Z to 10:33
                    var startTime = event.start.toISOString().split('T')[1].substring(0, 5);

                    // Find the `.fc-time` element within the current event element and update its text with the formatted time
                    element.find('.fc-time').text(startTime);
                }
            });

            $('#createRapatModal').on('hidden.bs.modal', function() {
                $('#saveBtn').unbind();
            });

            $('.fc-event').css('font-size', '14px');
            $('.fc-event').css('border-radius', '5px');

            // Change the background color of past dates
            $('.fc-past').css('background-color', '#f0f0f0');
        });
    </script>
@endsection
