var url = $(location).attr("href");
var segments = url.split("/");

$("#table-pertemuan-akademik").DataTable({
    "pageLength": 5
});
$("#table-daftar-kelas").DataTable({
    "pageLength": 5
});

$('#table-daftar-kelas').on('click', '.detail_kelas', function () {
    let id_kelas = $(this).data('id');
    $.ajax({
        url: segments[0] + '/akademik/getDetailKelas/' + id_kelas,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            console.log(data);
            $('#nama-kelas-modal').html(data['nama_kelas']);
            $('#body-pertemuan-modal').html(``);
            $('#body-peserta-modal').html(``);
            if(data['pertemuan'].length == 0){
                $('#body-pertemuan-modal').html(`
                    <tr>
                        <td colspan="3"><h5>Belum ada pertemuan</h5></td>
                    </tr>
                `);
            }
            else{
                var j = 1;
                data['pertemuan'].forEach(function(pp) {
                    $('#body-pertemuan-modal').append(`
                    <tr>
                        <td>`+pp['pertemuan_ke']+`</td>
                        <td>`+pp['tanggal_indo']+`</td>
                        <td>`+pp['deskripsi']+`</td>
                    </tr>
                `);
                });
            }
            if(data['peserta'].length == 0){
                $('#body-peserta-modal').html(`
                    <tr>
                        <td colspan="3"><h5>Belum ada peserta</h5></td>
                    </tr>
                `);
            }
            else{
                var i = 1;
                data['peserta'].forEach(function(p) {
                    $('#body-peserta-modal').append(`
                    <tr>
                        <td>`+(i++)+`</td>
                        <td>`+p['nama_lengkap']+`</td>
                        <td>`+p['nilai_evaluasi']+`</td>
                    </tr>
                `);
                });
            }
            // var link_image = window.location.origin + '/' + data['image'];
            // $('.image-profil').attr('src', link_image);
            // $('.nama_lengkap').val(data['nama_lengkap']);
            // $('.email_p').val(data['email']);
            // $('.no_telp_p').val(data['no_hp']);
            // $('.asal_sekolah_p').val(data['asal_sekolah']);
            // $('.alamat_p').val(data['alamat']);
        }
    });
})