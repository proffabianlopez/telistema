document.querySelectorAll(".modaledit-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const id = this.id.split("-")[1]; // Obtener el ID del botón (asume que el ID del botón es "delete-{id}")
      const token = this.id.split("-")[2]; // Obtener el ID del botón (asume que el ID del botón es "delete-{id}")
      const crudClass = this.getAttribute("data-crud"); // Obtener el tipo de CRUD
      openEditModal(id, crudClass, token);
    });
  });

  function openEditModal(id, crudClass, token) {
    // Realiza una solicitud AJAX para obtener el formulario de edición
    let url= "";

    switch (crudClass) {
        case "users":
            url = "editUsers.php?token="+ token;
            break;
        case "materials":
            url = "editMaterial.php?token="+ token;
            break;
        case "clients":
            url = "editclient.php?token="+ token;
            break;
        case "orders":
            url = "editorder.php?token="+ token;
            break;
        case "suppliers":
            url = "editsupplier.php?token="+ token;
            break; 
        case "technicians":
            url = "edittechnic.php?token="+ token;
            break;
        default:
            console.error("Clase de CRUD no reconocida");
            return;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
          id: id,
        },
        success: function(response) {
            // Muestra el formulario de edición en el contenedor
            $("#edit-form-container").html(response).slideDown();
            // Abre el modal
            $("#myModal6").modal("show");
        },
        error: function() {
            alert("Error al cargar el formulario de edición.");
        }
    });
}