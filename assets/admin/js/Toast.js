export let Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timerProgressBar: true,
    timer: 4000,
    customClass: {
        container: 'toast-container'
    }
});