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
        locale: 'id',
        navLinks: true, // can click day/week names to navigate views
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        backgroundColor: 'gray',
    });

    // Event sendiri di siujian
	$.ajax({
		url: segments[0] + '/murid/getJadwal',
		dataType: 'json',
		type: 'get',
		success: function (data) {
            console.log(data);
			data['kelas_berjalan'].forEach(function (kelas) {
                // console.log(kelas);
                kelas['jadwal'].forEach(function (jadwal) {
                    calendar.addEvent({
						id: kelas.id_kelas,
						title: kelas.nama_kelas,
						rrule: {
							dtstart: kelas.tanggal_mulai + 'T' + jadwal['sesi'].jam_mulai,
                            byweekday: rrule.RRule[jadwal.day],
                            count: kelas.jumlah_pertemuan,
							freq: 'weekly'
						},
						color: kelas.color,
						duration: jadwal.durasi
					});
                })
			})

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
