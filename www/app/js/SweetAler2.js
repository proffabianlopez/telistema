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