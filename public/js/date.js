// Inisialisasi Variabel Username dan URL AJAX
var url = $(location).attr("href");
var segments = url.split("/");

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var date = new Date();
    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();

    if (day < 10) {
        day = '0' + day;
    }
    if (month < 10) {
        month = '0' + month;
    }

    var dateNow = year + '-' + month + '-' + day;

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list', 'rrule'],
        themeSystem: 'bootstrap',
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },

        defaultDate: dateNow,
        locale: 'en',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        backgroundColor: 'gray',
    });

    // Ubah Ukuran view list
    $('body').on('DOMSubtreeModified', ".fc-button-active", function () {
        var button = $('.fc-button-active').html();
        // console.log(button);
        if (button == "list") {
            // console.log(true);
        }
    });

    // Event sendiri di siujian
	$.ajax({
		url: segments[0] + '/murid/getJadwal/' + id,
		dataType: 'json',
		type: 'get',
		success: function (data) {
			// console.log(data);
			data.forEach(function (dataA) {
				var room = dataA.ruangan;
				if (room != null) {
					room = '\tRoom ' + room + '\n';
				} else {
					room = '';
				}
				var title = dataA.nama_agenda;
				if (dataA.kategoriAgenda == 3 || dataA.kategoriAgenda == 4) {
					calendar.addEvent({
						id: dataA.id_agenda,
						title: room + dataA.nama_agenda,
						rrule: {
							dtstart: dataA.tanggalMulai + 'T' + dataA.waktuMulai,
							until: dataA.tanggalSelesai,
							byweekday: rrule.RRule[dataA.hariAgenda],
							freq: 'weekly'
						},
						color: 'red',
						duration: dataA.durasi
					});
				} else if (dataA.kategoriAgenda == 2) {
					calendar.addEvent({
						id: dataA.id_agenda,
						title: room + dataA.nama_agenda,
						start: dataA.tanggalMulai + 'T' + dataA.waktuMulai,
						end: dataA.tanggalSelesai + 'T' + dataA.waktuSelesai,
						color: 'blue'
					});
				} else {
					calendar.addEvent({
						id: dataA.id_agenda,
						title: room + dataA.nama_agenda,
						start: dataA.tanggalMulai + 'T' + dataA.waktuMulai,
						end: dataA.tanggalMulai + 'T' + dataA.waktuSelesai,
						color: 'green',
					});
				}

			})
			var fc = $('.fc-center h2').html();
			var monthYear = fc.split(" ");
			$('.monthYear').html(fc);
			// console.log(fc);
		}
	});


    // render calendar
    calendar.render();

    $('#tanggalSpesifik').on('change', function () {
        var seleksiTanggal = $('#tanggalSpesifik').val();
        if (seleksiTanggal != "") {
            calendar.gotoDate(seleksiTanggal);
        } else {
            calendar.gotoDate(dateNow);
        }
    })

});

// Ubah Judul Bulan Tahun
$('body').on('DOMSubtreeModified', ".fc-center", function () {
    var fc = $('.fc-center h2').html();
    var monthYear = fc.split(" ");
    $('.monthYear').html(fc);
});