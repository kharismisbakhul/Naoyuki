var url = $(location).attr("href");
var segments = url.split("/");

$("#table-daftar-user").DataTable({
    "pageLength": 5
});

$('#table-daftar-user').on('click', '.hapus_user', function () {
    let id_user = $(this).data('id');
	Swal.fire({
		title: 'Anda yakin? User akan dihapus',
		text: "",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Hapus'
	}).then(function (result) {
		if (result.value) {
			window.location = window.location.origin + "/admin/hapusUser/" + id_user;
		}
	})
});

$('#table-daftar-user').on('click', '.edit_user', function () {
    let id_user = $(this).data('id');
    $.ajax({
        url: segments[0] + '/admin/getUser/' + id_user,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            $('.id_user').val(id_user);
            $('.username').val(data['username']);
            $('.password').val(data['password']);
            // var link_image = window.location.origin + '/' + data['image'];
            // $('.image-profil').attr('src', link_image);
            // $('.no_telp_p').val(data['no_hp']);
            // $('.asal_sekolah_p').val(data['asal_sekolah']);
            // $('.alamat_p').val(data['alamat']);
        }
    });
})