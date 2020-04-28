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
    $.ajax({
        url: segments[0] + '/getProgram/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            var link_image = window.location.origin + '/' + data['image'];
            $('.image-info').attr('src', link_image);
            $('.image-info').attr('alt', data['nama_program_les']);
            $('.judul-caption').html(data['nama_program_les']);
            $('.pertemuan-les').html(data['jumlah_pertemuan'] + " Kali");
            $('.deskripsi-les').html(data['deskripsi']);
            $('.materi-les').html(data['cakupan_materi']);
        }
    });
})

$('#table-program-berjalan').on('click', '.detailProgramTerdaftar', function () {
    let id = $(this).data('id');
    $.ajax({
        url: segments[0] + '/murid/getProgramTerdaftar/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            var link_image = window.location.origin + '/' + data['program_les']['image'];
            var link_bukti = window.location.origin + '/bukti_pembayaran/' + data['bukti_pendaftaran'];

            $('.image-info').attr('src', link_image);
            if (data['bukti_pendaftaran'] == null) {
                $('.bukti-row').html('<alert class="alert alert-warning">Belum ada bukti</alert>');
            } else {
                $('.bukti-row').html('<img src="" class="bukti-les-terdaftar" style="width: 300px; height:300px;" alt=""></img>');
                $('.bukti-les-terdaftar').attr('src', link_bukti);
                $('.bukti-les-terdaftar').attr('alt', data['murid']['nama_lengkap']+'-'+data['program_les']['nama_program_les']);
            }
            $('.judul-caption-terdaftar').html('Program ' + data['program_les']['nama_program_les']);
            $('.pertemuan-les-terdaftar').html('Pertemuan ' + data['program_les']['jumlah_pertemuan'] + " Kali");
            $('.pendaftar-les-terdaftar').html('Nama Pendaftar: ' + data['murid']['nama_lengkap']);
            $('.waktu-les-terdaftar').html('Tanggal Pendaftaran: ' + data['tgl_indo']);
            var status_daftar = '';
            if (data['status_pendaftaran'] == "1") {
                status_daftar = '<span class="text-success">Valid</span>';
            } else if (data['status_pendaftaran'] == "0") {
                status_daftar = '<span class="text-danger">Belum Bayar</span>';
            } else if (data['status_pendaftaran'] == "2") {
                status_daftar = '<span class="text-warning">Sedang di Proses</span>';
            } else {
                status_daftar = '<span class="text-primary">Menunggu Kelas</span>';
            }
            $('.status-les-terdaftar').html('Status Pendaftaran: ' + status_daftar);
        }
    });
})

$('#table-pertemuan').on('click', '.feedback', function () {
    let id = $(this).data('id');
    $('#id_kehadiran').val(id);
    $.ajax({
        url: segments[0] + '/murid/getFeedbackKelas/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            $('#pertemuan').val(data['pertemuan']['pertemuan_ke']);
        }
    });
})

$('#table-pertemuan').on('click', '.detail-feedback', function () {
    let id = $(this).data('id');
    $.ajax({
        url: segments[0] + '/murid/getFeedbackKelas/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            $('#pertemuan-detail').val(data['pertemuan']['pertemuan_ke']);
            $('#feedback-detail').html(data['feedback']);
        }
    });
})

function cariPembelajaran() {
    var input, filter, table, tr, td, i, value;
    input = document.getElementById("cariPembelajaran");
    filter = input.value.toUpperCase();
    kelas = document.getElementsByClassName("kelasPembelajaran");
    spasi = document.getElementsByClassName("spasiPembelajaran");
    // Loop through all table rows, and hide those who don't match the search query
    var count = 0;
    for (i = 0; i < kelas.length; i++) {
        var nama_kelas = kelas[i].getElementsByClassName("namaKelas");
        if (nama_kelas) {
            value = nama_kelas[0].innerText;
            if (value.toUpperCase().indexOf(filter) > -1) {
                if($('.popup')){
                    $('.popup').remove();
                }
                kelas[i].style.display = "";
                spasi[i].style.display = "";
            } else {
                kelas[i].style.display = "none";
                spasi[i].style.display = "none";
                count++;
                if(count >= kelas.length){
                    if($('.popup')){
                        $('.popup').remove();
                    }
                    $('.kelasp').prepend(`
                        <div class="alert alert-warning text-center mb-2 col-lg-12 popup">Tidak ada pembelajaran yang sesuai dengan pencarian</div>
                    `)
                }
            }
        }
    }
}