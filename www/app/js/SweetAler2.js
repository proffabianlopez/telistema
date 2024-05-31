    // Espera a que el documento esté listo
    document.addEventListener('DOMContentLoaded', function () {
      // Obtén el botón de "Actualizar"
      var updateButton = document.getElementById('update');

      // Agrega un event listener para el clic en el botón
      updateButton.addEventListener('click', function (event) {
          // Previene el comportamiento por defecto del formulario
          event.preventDefault();

          // Muestra la alerta de SweetAlert2
          Swal.fire({
              title: '¿Estás seguro?',
              text: 'Esta acción será permanente',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#d33',
              cancelButtonColor: '#3085d6',
              confirmButtonText: 'Sí, actualizar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              // Si el usuario confirma la acción, puedes realizar la actualización
              if (result.isConfirmed) {
                  // Aquí puedes ejecutar la acción de actualización
                  // Por ejemplo, puedes enviar el formulario
                  document.getElementById('updateForm').submit(); // Reemplaza 'updateForm' con el ID de tu formulario
              }
          });
      });
  });

  document.addEventListener('DOMContentLoaded', function () {
    // Obtén el botón de "Actualizar"
    var clientUpdateButton = document.getElementById('clientupdate');

    // Agrega un event listener para el clic en el botón
    clientUpdateButton.addEventListener('click', function (event) {
        // Previene el comportamiento por defecto del formulario
        event.preventDefault();

        // Muestra la alerta de SweetAlert2
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esta acción será permanente',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            // Si el usuario confirma la acción, puedes realizar la actualización
            if (result.isConfirmed) {
                // Aquí puedes ejecutar la acción de actualización
                // Por ejemplo, puedes enviar el formulario
                document.getElementById('clientUpdateForm').submit(); // Reemplaza 'clientUpdateForm' con el ID de tu formulario
            }
        });
    });
});

document.getElementById('delete-button').addEventListener('click', function(event) {
    event.preventDefault(); // Evita que el botón envíe el formulario automáticamente

    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí puedes poner la lógica para eliminar el elemento
            // Por ejemplo, enviar un formulario o hacer una petición AJAX
            Swal.fire(
                'Eliminado!',
                'El elemento ha sido eliminado.',
                'success'
            )
            // Si estás utilizando un formulario, puedes descomentar la siguiente línea
            // event.target.closest('form').submit();
        }
    })
});


document.getElementById('logout-link').addEventListener('click', function(event) {
    event.preventDefault(); // Evita que el enlace navegue automáticamente

    Swal.fire({
        title: '¿Estás seguro?',
        text: "Vas a cerrar tu sesión.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cerrar sesión!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirigir al usuario a la página de login
            window.location.href = event.target.href;
        }
    })
});