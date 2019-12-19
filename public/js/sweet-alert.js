$('.logout').on('click', function () {
    Swal.fire({
        title: 'Anda yakin ingin logout?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#868e96',
        confirmButtonText: 'Logout'
    }).then(function (result) {
        if (result.value) {
            window.location = window.location.origin + "/logout";
        }
    })
});