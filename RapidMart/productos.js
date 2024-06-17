document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formNuevoProducto').addEventListener('submit', function(event) {
        event.preventDefault();  // Prevenir el envío estándar del formulario

        const formData = new FormData(this);

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'map.php?accion=insertar_producto', true);

        xhr.onload = function() {
            if (xhr.status === 200) {
                const data = JSON.parse(xhr.responseText);
                if (data.success) {
                    // Notifica al usuario
                    alert('Bien al insertar el producto: ');

                    // Redirige a index.php
                    window.location.href = 'map.php?accion=inicio';
                } else {
                    alert('Error al insertar el producto: ' + data.message);
                }
            } else {
                console.error('Error:', xhr.statusText);
            }
        };

        xhr.onerror = function() {
            console.error('Error:', xhr.statusText);
        };

        xhr.send(formData);
    });
});
