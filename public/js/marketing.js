$('#table-daftar-validasi').on('click', '.detailValidasi', function () {
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
            $('.bukti-les').attr('src', link_bukti);
            $('#id_validasi').val(id);
        }
    });
})