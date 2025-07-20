function mostrarCamposPago(metodo) {
    const efectivoDiv = document.getElementById('pago-efectivo');
    const tarjetaDiv = document.getElementById('pago-tarjeta');
    const btnPagar = document.getElementById('btnPagar');
    const camposPago = document.getElementById('campos-pago');
    camposPago.style.display = 'block';
    efectivoDiv.classList.add('hidden');
    tarjetaDiv.classList.add('hidden');
    btnPagar.style.display = 'none';
    const todosCampos = document.querySelectorAll('#pago-efectivo input, #pago-tarjeta input');
    todosCampos.forEach(campo => campo.required = false);

    if (metodo === 'Efectivo') {
        efectivoDiv.classList.remove('hidden');
        btnPagar.style.display = 'block';

        document.getElementById('titular_nombre_efectivo').required = true;
        document.getElementById('titular_cedula_efectivo').required = true;
        
    } else if (metodo === 'Tarjeta') {
        tarjetaDiv.classList.remove('hidden');
        btnPagar.style.display = 'block';

        document.getElementById('numero_tarjeta').required = true;
        document.getElementById('nombre_titular_tarjeta').required = true;
        document.getElementById('cedula_titular_tarjeta').required = true;
        document.getElementById('fecha_vencimiento').required = true;
        document.getElementById('codigo_seguridad').required = true;
    } else {
        camposPago.style.display = 'none';
    }
}

document.getElementById('formPago').addEventListener('submit', function(e) {
    const metodo = document.getElementById('payment-type').value;

    if (!metodo) {
        alert('Por favor seleccione un método de pago.');
        e.preventDefault();
        return;
    }

    if (metodo === 'Efectivo') {
        const nombre = document.getElementById('titular_nombre_efectivo').value.trim();
        const cedula = document.getElementById('titular_cedula_efectivo').value.trim();

        if (!nombre || !cedula) {
            alert('Por favor complete nombre y cédula del titular para pago en efectivo.');
            e.preventDefault();
            return;
        }
    } else if (metodo === 'Tarjeta') {
        const tarjeta = document.getElementById('numero_tarjeta').value.trim();
        const nombre = document.getElementById('nombre_titular_tarjeta').value.trim();
        const cedula = document.getElementById('cedula_titular_tarjeta').value.trim();
        const fecha = document.getElementById('fecha_vencimiento').value.trim();
        const codigo = document.getElementById('codigo_seguridad').value.trim();

        if (!tarjeta || !nombre || !cedula || !fecha || !codigo) {
            alert('Por favor complete todos los datos para el pago con tarjeta.');
            e.preventDefault();
            return;
        }
    }
    console.log("Formulario enviado");
});


document.addEventListener('DOMContentLoaded', function() {
    const selectMetodo = document.getElementById('payment-type');
    if (selectMetodo) {
        mostrarCamposPago(selectMetodo.value);
    }
});

document.getElementById('payment-type').addEventListener('change', function() {
    mostrarCamposPago(this.value);
});

document.addEventListener('DOMContentLoaded', () => {
    const mensaje = document.querySelector('.mensaje');
    if (mensaje) {
        mensaje.classList.add('animate__animated', 'animate__fadeInDown');

        setTimeout(() => {
            mensaje.classList.add('animate__fadeOutUp');
        }, 4000); 
    }
});
