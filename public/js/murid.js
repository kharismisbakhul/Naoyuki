var url = $(location).attr("href");
var segments = url.split("/");

// $("#table-kegiatan").DataTable({
//     "pageLength": 5,
//     "columnDefs": [{
//         "sortable": false,
//         "targets": [0, 2, 3]
//     }],
//     initComplete: function () {
//         this.api().columns([4]).every(function () {
//             var column = this;
//             var select = $('<select class="custom-select col-lg-4 mr-2" ><option value="">Pilih Status Kegiatan</option></select>')
//                 .prependTo($('.dataTables_filter'))
//                 .on('change', function () {
//                     var val = $.fn.dataTable.util.escapeRegex(
//                         $(this).val()
//                     );

//                     column
//                         .search(val ? '^' + val + '$' : '', true, false)
//                         .draw();
//                 });
//             console.log(select);

//             column.data().unique().sort().each(function (d, j) {
//                 select.append('<option value="' + d + '">' + d + '</option>')
//             });
//         });
//     }
// });

$("#table-pertemuan").DataTable({
    "pageLength": 5
});

$("#table-daftar-program").DataTable({
    "pageLength": 3
});
$("#table-program-berjalan").DataTable({
    "pageLength": 3
});

$('#table-daftar-program').on('click', '.detailProgram', function () {
    let id = $(this).data('id');
    console.log(id);
    $.ajax({
        url: segments[0] + '/getProgram/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var link_image = window.location.origin + '/' + data['image'];
            $('.image-info').attr('src', link_image);
            $('.judul-caption').html(data['nama_program_les']);
            $('.pertemuan-les').html(data['jumlah_pertemuan'] + " Kali");
            $('.deskripsi-les').html(data['deskripsi']);
            $('.materi-les').html(data['cakupan_materi']);
        }
    });
})

$('#table-program-berjalan').on('click', '.detailProgramTerdaftar', function () {
    let id = $(this).data('id');
    console.log(id);
    $.ajax({
        url: segments[0] + '/murid/getProgramTerdaftar/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            var link_image = window.location.origin + '/' + data['image'];
            var link_bukti = window.location.origin + '/bukti_pembayaran/' + data['bukti_pendaftaran'];
            $('.image-info').attr('src', link_image);
            $('.bukti-les-terdaftar').attr('src', link_bukti);
            // $('.bukti-les-terdaftar').html('Bukti Pendaftaran: ');
            $('.judul-caption-terdaftar').html('Program ' + data['nama_program_les']);
            $('.pertemuan-les-terdaftar').html('Pertemuan ' + data['jumlah_pertemuan'] + " Kali");
            $('.pendaftar-les-terdaftar').html('Nama Pendaftar: ' + data['nama_lengkap']);
            $('.waktu-les-terdaftar').html('Tanggal Pendaftaran: ' + data['tanggal_pendaftaran']);
            if (data['status_pendaftaran'] == "1") {
                $('.status-les-terdaftar').html('Status Pendaftaran: Valid');
            } else if (data['status_pendaftaran'] == "2") {
                $('.status-les-terdaftar').html('Status Pendaftaran: Sedang diproses');
            } else {
                $('.status-les-terdaftar').html('Status Pendaftaran: Belum bayar');
            }
        }
    });
})

$('#table-pertemuan').on('click', '.feedback', function () {
    let id = $(this).data('id');
    console.log(id);
    // var link_form = window.location.origin + '/murid/feedback/' + id;
    // $('#form-pertemuan').attr('action', link_form);
    $('#id_kehadiran').val(id);
})

$('#table-pertemuan').on('click', '.detail-feedback', function () {
    let id = $(this).data('id');
    console.log(id);
    $.ajax({
        url: segments[0] + '/murid/getFeedbackKelas/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#pertemuan-detail').val(data['pertemuan_ke']);
            $('#feedback-detail').html(data['feedback']);
        }
    });
})