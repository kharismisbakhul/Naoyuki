var url = $(location).attr("href");
var segments = url.split("/");

$("#table-daftar-pertemuan").DataTable({
    "pageLength": 5
});

$('#table-daftar-peserta').on('click', '.detail_peserta_kelas', function () {
    let username = $(this).data('id');
    $.ajax({
        url: segments[0] + '/sensei/getMurid/' + username,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            var link_image = window.location.origin + '/' + data['image'];
            $('.image-profil').attr('src', link_image);
            $('.image-profil').attr('alt', data['nama_lengkap']);
            $('.nama_lengkap').val(data['nama_lengkap']);
            $('.email_p').val(data['email']);
            $('.no_telp_p').val(data['no_hp']);
            $('.asal_sekolah_p').val(data['asal_sekolah']);
            $('.alamat_p').val(data['alamat']);
        }
    });
})

$('#table-daftar-peserta').on('click', '.detail_nilai_peserta', function () {
    let id_peserta = $(this).data('id');
    $.ajax({
        url: segments[0] + '/sensei/getDetailPeserta/' + id_peserta,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            $('.nama_lengkap_nilai').val(data['nama_lengkap']);
            $('.nilai_evaluasi').val(data['nilai_evaluasi']);
            $('.id_peserta_kelas').val(id_peserta);
        }
    });
})

$('#table-daftar-pertemuan').on('click', '.detail_kehadiran', function () {
    $('.kehadiran_murid').html(``);
    let id_pertemuan = $(this).data('id');
    $.ajax({
        url: segments[0] + '/sensei/getKehadiranPeserta/' + id_pertemuan,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data);
            $('.pertemuan-judul').html(data['pertemuan']['pertemuan_ke'])
            data['kehadiran'].forEach(function(e) {
                var temp = '';
                var fb = '';
                if (e['kehadiran'] == 1) {
                    temp = '<td class="text-success text-center">Hadir</td>';
                } else {
                    temp = '<td class="text-danger text-center">Tidak Hadir</td>';
                }
                if (e['feedback'] == null) {
                    fb = '<td class="text-secondary text-center">* Belum ada feedback *</td>';
                } else {
                    fb = `<td class="text-warning text-center">`+e['feedback']+`</td>`;
                }
                $('.kehadiran_murid').append(`
                <tr>
                    <td>`+e['nama_lengkap']+`</td>`+
                    temp+fb+`
                </tr>
                `);
            });
        }
    });
})

$('#table-daftar-user').on('click', '.hapus_user', function () {
    let id_user = $(this).data('id');
    Swal.fire({
        title: 'Anda yakin ingin Menghapus User?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#868e96',
        confirmButtonText: 'Hapus'
    }).then(function (result) {
        if (result.value) {
            window.location = window.location.origin + "/admin/hapusUser/"+id_user;
        }
    })
})