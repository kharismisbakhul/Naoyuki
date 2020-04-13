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

$('#status').on('click', function () {
    let id_status_user = $('#status').val();
    // console.log(id_status_user);
    $('.nama_lengkap').html(``);
    $('.email').html(``);
    $('.no_hp').html(``);
    $('.asal_sekolah').html(``);
    $('.alamat').html(``);
    $('.foto').html(``);
    if(id_status_user == 1){
        $('.nama_lengkap').html(`
            <label for="nama_lengkap_user" class="col-sm-3 col-form-label">Nama Lengkap</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_lengkap_user" name="nama_lengkap_user" value="">
            </div>
        `);
        $('.email').html(`
        <label for="email_user" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email_user" name="email_user" value="">
        </div>
        `);
        $('.no_hp').html(`
        <label for="no_hp_user" class="col-sm-3 col-form-label">No HP</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="no_hp_user" name="no_hp_user" value="">
        </div>
        `);
        $('.asal_sekolah').html(`
        <label for="asal_sekolah_user" class="col-sm-3 col-form-label">Asal Sekolah</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="asal_sekolah_user" name="asal_sekolah_user" value="">
        </div>
        `);
        $('.alamat').html(`
        <label for="alamat_user" class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="alamat_user" name="alamat_user" value="">
        </div>
        `);
        $('.foto').html(`
        <label for="foto" class="col-sm-3 col-form-label">Foto User</label>
        <div class="col-sm-9">
            <input type="file" name="fotoUser">
        </div>
        `);
    }

    else if(id_status_user == 2){
        $('.nama_lengkap').html(`
            <label for="nama_lengkap_user" class="col-sm-3 col-form-label">Nama Lengkap</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="nama_lengkap_user" name="nama_lengkap_user" value="">
            </div>
        `);
        $('.no_hp').html(`
        <label for="no_hp_user" class="col-sm-3 col-form-label">No HP</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="no_hp_user" name="no_hp_user" value="">
        </div>
        `);
    }
})