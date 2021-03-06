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
                var j = 0;
                data['pertemuan'].forEach(function(pp) {
                    j++;
                    $('#body-pertemuan-modal').append(`
                    <tr>
                        <td>`+pp['pertemuan_ke']+`</td>
                        <td>`+pp['tanggal_indo']+`</td>
                        <td>`+pp['deskripsi']+`</td>
                        <td class="kehadiran-detail`+j+`"></td>
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
                            $('.kehadiran-detail'+j).append(`
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

        }
    });
})


$('.detail-jadwal').on('click', function(){
    $('#hariPertemuan1').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#hariPertemuan2').html(`<option value="" hidden selected>Pilih Hari</option>`)
    $('#waktuPertemuan1').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#waktuPertemuan2').html(`<option value="" hidden selected>Pilih Sesi</option>`)
    $('#nama_sensei').html(`<option value="" hidden selected>Pilih Sensei</option>`)

    var murid = document.getElementsByName('peserta[]');

    let peserta = [];
    for (var index = 0; index < murid.length; index++) {
        if(murid[index].checked == true){
            peserta.push(murid[index].value)
        }
    }

    $.ajax({
        url: segments[0] + '/akademik/getJadwalKosong',
        method: 'get',
        data:{
            murid: peserta
        },
        dataType: 'json',
        success: function (data) {
            console.log(data)
            data.forEach(function(jadwal){
                if(data.length == 0){
                    $('#hariPertemuan1').append(`
                        <option value="">* Tidak ada waktu kosong *</option>
                    `)
                    $('#waktuPertemuan1').append(`
                        <option value="">* Tidak ada waktu kosong *</option>
                    `)
                }else{
                    $('#hariPertemuan1').append(`
                        <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                    `)
                    $('#hariPertemuan2').append(`
                        <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
                    `)
                }
            })
        }
    })

})

// Get Sesi 1
$('#hariPertemuan1').on('click', function(){
    var murid = document.getElementsByName('peserta[]');
    // console.log(murid.length);

    let peserta = [];
    for (var index = 0; index < murid.length; index++) {
        if(murid[index].checked == true){
            peserta.push(murid[index].value)
        }
    }
    var murid = peserta[0];
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

// $('#waktuPertemuan1').on('click', function(){
//     var murid = document.getElementsByName('kehadiran[]');
//     // console.log(murid.length);

//     let peserta = [];
//     for (var index = 0; index < murid.length; index++) {
//         if(murid[index].checked == true){
//             peserta.push(murid[index].value)
//         }
//     }
//         var id_hari = $('#hariPertemuan1').val();
//         var id_sesi = $('#waktuPertemuan1').val();
//         $.ajax({
//             url: segments[0] + '/akademik/getJadwalOpsi?id_hari='+id_hari+'&id_sesi='+id_sesi,
//             method: 'get',
//             data:{
//                 murid: peserta
//             },
//             dataType: 'json',
//             success: function (data) {
//                 console.log(data)
//                 if(data.length == 0){
//                     $('#hariPertemuan2').append(`
//                         <option value="">* Tidak ada waktu kosong lagi *</option>
//                     `)
//                     $('#waktuPertemuan2').append(`
//                         <option value="">* Tidak ada waktu kosong lagi *</option>
//                     `)
//                 }
//                 else{
//                     data.forEach(function(jadwal){
//                         $('#hariPertemuan2').append(`
//                             <option value="`+jadwal['id_hari']+`">`+jadwal['hari']+`</option>
//                         `)
//                     })
//                 }
//             }
//         })
    
    // })

// Get Sesi 2
$('#hariPertemuan2').on('click', function(){
    var murid = document.getElementsByName('peserta[]');
    // console.log(murid.length);

    let peserta = [];
    for (var index = 0; index < murid.length; index++) {
        if(murid[index].checked == true){
            peserta.push(murid[index].value)
        }
    }
    var murid = peserta[0];
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