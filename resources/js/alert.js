import Swal from 'sweetalert2';
import 'animate.css';

console.log('alertas cargado');

window.mostrarAlertaMsgOk = function(mensaje) {
    Swal.fire({
        toast: true,
        position: 'bottom-end',
        icon: 'success',
        width: '17rem',
        background: '#022B4E',
        title: mensaje,
        showClass: { popup: 'animate__animated animate__bounceIn' },
        hideClass: { popup: 'animate__animated animate__bounceOut' },
        customClass: { title: 'l-message-ok' },
        showConfirmButton: false,
        timer: 1600
    });
};
