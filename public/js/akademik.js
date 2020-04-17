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
                        <td colspan="4"><h5>Belum ada pertemuan</h5></td>
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
                        <td class="kehadiran-detail"></td>
                    </tr>
                    `);

                    if(pp['kehadiran_peserta'].length != 0){
                        pp['kehadiran_peserta'].forEach(function(kp){
                            var kehadiran = '';
                            var feedback = '';
                            if (kp['kehadiran'] == 1) {
                                kehadiran = '<span class="text-success text-center">Hadir</span>';
                            } else {
                                kehadiran = '<span class="text-danger text-center">Tidak Hadir</span>';
                            }
                            if (kp['feedback'] == null) {
                                feedback = '<span class="text-secondary text-center">* Belum ada feedback *</span>';
                            } else {
                                feedback = `<span class="text-warning text-center">`+kp['feedback']+`</span>`;
                            }
                            $('.kehadiran-detail').append(`
                            <span>
                                `+kp['nama_lengkap']+`\t
                                [`+kehadiran+`]\t
                                [`+feedback+`]
                            </span><br>
                            `);
                        })  
                    }

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

$('.tambah-murid').on('click', function () {
    var id_program = $('#nama_program').val();
    var jumlah_murid = parseInt($('#jumlah_murid').val()) + 1;
    $('#jumlah_murid').val(jumlah_murid)
    console.log(jumlah_murid);

    if(jumlah_murid == 2){
        $('#icon-murid-plus').after(`<span><a href="#" class="btn btn-danger kurang-murid"><i class="fas fa-fw fa-minus text-white" id="icon-murid-minus"></i></a></span>`)
    }

    if($('#icon-murid').attr('class') == "fas fa-fw fa-minus text-white"){
        $('.murid-baru').remove();
        $('.waktu-pertemuan').removeBefore();
        $('#hariPertemuan1').html(`<option value="" hidden selected>Pilih Hari</option>`)
        $('#hariPertemuan2').html(`<option value="" hidden selected>Pilih Hari</option>`)
        $('#waktuPertemuan1').html(`<option value="" hidden selected>Pilih Sesi</option>`)
        $('#waktuPertemuan2').html(`<option value="" hidden selected>Pilih Sesi</option>`)
        $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
        $('#icon-murid').attr('class', 'fas fa-fw fa-plus text-white');
    }
    else{
        $('.waktu-pertemuan').before(`
        <div class="form-group row murid-baru">
            <label for="murid" class="col-sm-3 col-form-label"></label>
            <div class="col-sm-8">
                <select class="form-control" id="muridB" name="murid[]">
                  <option value="" hidden selected>Pilih Murid</option>
                </select>
            </div>
        </div>
        `)
        $.ajax({
            url: segments[0] + '/akademik/getMurid/'+id_program,
            method: 'get',
            dataType: 'json',
            success: function (data) {
                // console.log(data)
                data.forEach(function(d){
                    $('#muridB').append(`
                        <option value="`+d['id_pendaftaran']+`">`+d['nama_lengkap']+`</option>
                    `)
                })
            }
        })
        
        $('#icon-murid').attr('class', 'fas fa-fw fa-minus text-white');
    }
    // console.log($('#icon-murid').attr('class'))
})

// 1 Murid
$('#muridA').on('click', function(){
    var murid = $('#muridA').val();
    // console.log(murid);

    $('#hariPertemuan1').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#hariPertemuan2').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#waktuPertemuan1').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#waktuPertemuan2').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
    $.ajax({
        url: segments[0] + '/akademik/getJadwalKosong?murid1='+murid,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            data.forEach(function(jadwal){
                $('#hariPertemuan1').append(`
                    <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                `)
                $('#hariPertemuan2').append(`
                    <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                `)
            })
        }
    })

})

// 2 Murid
$('.form-kelas').on('click', '#muridB', function(){
    var murid1 = $('#muridA').val();
    var murid2 = $('#muridB').val();
    // console.log(murid2);

    $('#hariPertemuan1').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#hariPertemuan2').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#waktuPertemuan1').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#waktuPertemuan2').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
    $.ajax({
        url: segments[0] + '/akademik/getJadwalKosong?murid1='+murid1+'&murid2='+murid2,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            data.forEach(function(jadwal){
                $('#hariPertemuan1').append(`
                    <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                `)
                $('#hariPertemuan2').append(`
                    <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                `)
            })
        }
    })

})

// Get Sesi 1
$('#hariPertemuan1').on('click', function(){
    var murid = $('#muridA').val();
    var id_hari = $('#hariPertemuan1').val();
    $('#waktuPertemuan1').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
    $.ajax({
        url: segments[0] + '/akademik/getSesi?id_hari='+id_hari+'&murid='+murid,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            data.forEach(function(jadwal){
                $('#waktuPertemuan1').append(`
                    <option value="`+jadwal['id_sesi']+`">`+jadwal['jam_mulai']+` - `+jadwal['jam_selesai']+`</option>
                `)
            })
        }
    })

})

// Get Sesi 2
$('#hariPertemuan2').on('click', function(){
    var murid = $('#muridA').val();
    var id_hari = $('#hariPertemuan2').val();
    $('#waktuPertemuan2').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
    $.ajax({
        url: segments[0] + '/akademik/getSesi?id_hari='+id_hari+'&murid='+murid,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            data.forEach(function(jadwal){
                $('#waktuPertemuan2').append(`
                    <option value="`+jadwal['id_sesi']+`">`+jadwal['jam_mulai']+` - `+jadwal['jam_selesai']+`</option>
                `)
            })
        }
    })

})

// Get Sensei
$('#waktuPertemuan2').on('click', function(){

    var id_hari1 = $('#hariPertemuan1').val();
    var id_hari2 = $('#hariPertemuan2').val();
    var id_sesi1 = $('#waktuPertemuan1').val();
    var id_sesi2 = $('#waktuPertemuan2').val();
    // console.log(id_hari1, id_hari2, id_sesi1, id_sesi2)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
    $.ajax({
        url: segments[0] + '/akademik/getSensei?id_hari1='+id_hari1+'&id_sesi1='+id_sesi1+'&id_hari2='+id_hari2+'&id_sesi2='+id_sesi2,
        method: 'get',
        dataType: 'json',
        success: function (data) {
            // console.log(data)
            if(data.length == 0){
                $('#nama_sensei').append(`
                    <option value="">* Tidak ada sensei yang kosong pada jam tersebut *</option>
                `)
            }
            else{
                data.forEach(function(sensei){
                    $('#nama_sensei').append(`
                        <option value="`+sensei['id_sensei']+`">`+sensei['nama_sensei']+`</option>
                    `)
                })
            }
        }
    })

})

$('#waktuPertemuan1').on('click', function(){
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)
})