var url = $(location).attr("href");
var segments = url.split("/");

$('#program').on('click', '.program', function () {
    let id = $(this).data('id');
    $.ajax({
        url: segments[0] + '/getProgram/' + id,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            var link_image = window.location.origin + '/' + data['image'];
            $('.image-info').attr('src', link_image);
            $('.judul-caption').html(data['nama_program_les']);
            $('.pertemuan-les').html(data['jumlah_pertemuan'] + " Kali");
            $('.deskripsi-les').html(data['deskripsi']);
            $('.materi-les').html(data['cakupan_materi']);
        }
    });
})