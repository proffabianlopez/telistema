$(document).ready(function () {
  $("#logout").on("click", function (e) {
    e.preventDefault(); // Evita la redirección inmediata

    // Mostrar el SweetAlert de confirmación
    swal(
      {
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí, cerrar sesión",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          // Si el usuario confirma, redirigir a la página de cierre de sesión
          window.location.href = "../../logout.php";
        }
      }
    );
  });
});

$(document).ready(function () {
  $("#logout-link").on("click", function (e) {
    e.preventDefault(); // Evita la redirección inmediata

    // Mostrar el SweetAlert de confirmación
    swal(
      {
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sí, cerrar sesión",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
      },
      function (isConfirm) {
        if (isConfirm) {
          // Si el usuario confirma, redirigir a la página de cierre de sesión
          window.location.href = "../../logout.php";
        }
      }
    );
  });
});

document.querySelectorAll(".delete-btn").forEach((button) => {
  button.addEventListener("click", function () {
    const id = this.id.split("-")[1]; // Obtener el ID del botón (asume que el ID del botón es "delete-{id}")
    const token = this.id.split("-")[2]; // Obtener el ID del botón (asume que el ID del botón es "delete-{id}")
    const crudClass = this.getAttribute("data-crud"); // Obtener el tipo de CRUD
    Delete(id, crudClass, token);
  });
});

function Delete(id, crudClass, token) {
  let url = "";
  let action = "";

  // Determina la URL y la acción basándose en la clase del CRUD
  switch (crudClass) {
    case "admin":
      url = "adminController.php?token=" + token;
      action = "delete_admin";
      break;
    case "suppliers":
      url = "suppliersController.php?token=" + token;
      action = "delete_suppliers";
      break;
    case "materiales":
      url = "materialsController.php?token=" + token;
      action = "delete_materials";
      break;
    case "clients":
      url = "clientsController.php?token=" + token;
      action = "delete_clients";
      break;
    case "technicians":
      url = "technicianController.php?token=" + token;
      action = "delete_technician";
      break;
    case "orders":
      url = "ordersController.php?token=" + token;
      action = "delete_orders";
      break;
    // Agrega más casos según tus necesidades
    default:
      console.error("Clase de CRUD no reconocida");
      return;
  }

  swal(
    {
      title: "¿Estás seguro?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#1ab394",
      confirmButtonText: "¡Sí, elimínalo!",
      cancelButtonText: "Cancelar",
      closeOnConfirm: false,
    },
    function () {
      // Realiza una solicitud AJAX para eliminar el elemento
      $.ajax({
        type: "POST",
        url: url,
        data: {
          action: action,
          id: id,
        },
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            swal(
              {
                title: "¡Eliminado!",
                type: "success",
              },
              function () {
                location.reload(); // Recarga la página
              }
            );
          } else {
            swal(
              {
                title: "Error",
                text: "Hubo un problema al eliminar.",
                type: "error",
              },
              function () {
                location.reload(); // Recarga la página en caso de error también si es necesario
              }
            );
          }
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          swal(
            {
              title: "Error",
              text: "Hubo un problema al eliminar.",
              type: "error",
            },
            function () {
              location.reload(); // Recarga la página en caso de error también
            }
          );
        },
      });
    }
  );
}
