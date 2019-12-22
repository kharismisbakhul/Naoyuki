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