    document.addEventListener('DOMContentLoaded', () => {
    function abrirModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function cerrarModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    window.cerrarModal = cerrarModal; 

    
    document.querySelectorAll('.btn-ver').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('ver_id').textContent = btn.dataset.id;
            document.getElementById('ver_nombre').textContent = btn.dataset.nombre;
            document.getElementById('ver_cedula').textContent = btn.dataset.cedula;
            document.getElementById('ver_total').textContent = Number(btn.dataset.total).toFixed(2);
            abrirModal('modalVer');
        });
    });

    document.querySelectorAll('.btn-editar').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById('editar_id_factura').value = btn.dataset.id;
            document.getElementById('editar_nombre').value = btn.dataset.nombre;
            document.getElementById('editar_cedula').value = btn.dataset.cedula;
            document.getElementById('editar_total').value = Number(btn.dataset.total).toFixed(2);
            abrirModal('modalEditar');
        });
    });

    window.addEventListener('click', (event) => {
        ['modalVer', 'modalEditar'].forEach(idModal => {
            const modal = document.getElementById(idModal);
            if (event.target === modal) {
                cerrarModal(idModal);
            }
        });
    });
});

setTimeout(() => {
    document.querySelectorAll('.mensaje').forEach((mensaje) => {
        mensaje.style.transition = 'opacity 0.5s ease';
        mensaje.style.opacity = '0';
        setTimeout(() => mensaje.remove(), 500);
    });
}, 2000);
