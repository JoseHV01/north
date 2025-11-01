var modalConfirm = document.getElementById('modalExtendSession');
var btnDismissModal = document.getElementById('btnDismissModal');
let timeout;

function validateInactiveMouse() {
    $('#modalExtendSession').modal('show');
}

function resetTimer() {
    clearTimeout(timeout);
    // 5 minutos (300000 milisegundos)
    timeout = setTimeout(validateInactiveMouse, 300000);
}

document.addEventListener('mousemove', resetTimer);

resetTimer();

modalConfirm.addEventListener('hidden.bs.modal', function () {
    btnDismissModal.click();
});
