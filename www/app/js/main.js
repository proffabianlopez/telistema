function isInputNumber(evt) {
  var ch = String.fromCharCode(evt.which);
  if (!/[0-9]/.test(ch)) {
    evt.preventDefault();
  }
}

$(document).ready(function () {
  $(".reload").click(function () {
    location.reload();
  });

  $.validator.addMethod(
    "lettersonly",
    function (value, element) {
      return (
        this.optional(element) || /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s']+$/i.test(value)
      );
    },
    "Solo se permiten letras en este campo."
  );

  function setupFormValidation(formId) {
    var rules = {};
    var messages = {};

    $(formId)
      .find(".validate-field")
      .each(function () {
        var elementClasses = $(this).attr("class").split(" ");
        var fieldName = $(this).attr("name");

        elementClasses.forEach(function (cls) {
          switch (cls) {
            case "vname":
              rules[fieldName] = {
                required: true,
                minlength: 2,
                maxlength: 20,
                lettersonly: true,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                minlength: "Por favor, ingrese al menos 2 caracteres.",
                maxlength: "Por favor, ingrese un máximo de 20 caracteres.",
                lettersonly: "Solo se permiten letras",
              };
              break;
            case "vphone":
                rules[fieldName] = {
                    required: true,
                    digits: true,
                    minlength: 11,
                    maxlength: 11,
                };
                messages[fieldName] = {
                    required: "Por favor, ingrese un número de teléfono.",
                    digits: "Por favor, ingrese solo dígitos.",
                    minlength: "Formato inválido. Faltan digitos. ",
                    maxlength: "Formato inválido. Digitos demas ingresados. ",
                };
                break;
            case "vemail":
              rules[fieldName] = {
                required: true,
                maxlength: 100,
                minlength: 11,
                email: true,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                minlength: "Ingrese un email válido",
                maxlength: "Por favor, ingrese un máximo de 100 caracteres.",
                email: "Ingrese un email válido",
              };
              break;

            case "vaddress":
              rules[fieldName] = {
                required: true,
                maxlength: 100,
                minlength: 3,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                maxlength: "Por favor, ingrese un máximo de 100 caracteres.",
                minlength: "Por favor, ingrese un minimo de 3 caracteres.",
              };
              break;
            case "vhousenumber":
              rules[fieldName] = {
                max: 99999999,
                min: 0,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                max: "Por favor, ingrese un máximo de 8 digitos.",
                min: "Por favor, no ingreses números negativos",
              };
              break;
            case "vfloor_dep":
              rules[fieldName] = {
                maxlength: 8,
              };
              messages[fieldName] = {
                maxlength: "Por favor, ingrese un máximo de 8 caracteres.",
              };
              break;
            case "vcost":
              rules[fieldName] = {
                required: true,
                number: true,
                min: 0,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                number: "Por favor, ingrese un número válido.",
                min: "El costo no puede ser negativo!",
              };
              break;

            case "vammount":
              rules[fieldName] = {
                required: true,
                number: true,
                min: 0,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                number: "Por favor, ingrese un número válido.",
                min: "La cantidad no puede ser negativa!",
              };
              break;

              case "select":
              rules[fieldName] = {
                required: true,
              };
              messages[fieldName] = {
                required: "Debe seleccionar una opción.",
              };
              break;

            case "vtextarea":
              rules[fieldName] = {
                required: true,
                maxlength: 150,
                minlength: 3,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                maxlength: "Por favor, ingrese un máximo de 255 caracteres.",
                minlength: "Por favor, ingrese un minimo de 3 caracteres.",
              };
              break;
              
              case "vavatar":
              rules[fieldName] = {
                required: true,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
              };
              break;

              case "vname_product":
              rules[fieldName] = {
                required: true,
                minlength: 2,
                maxlength: 20,
              };
              messages[fieldName] = {
                required: "Este campo es obligatorio.",
                minlength: "Por favor, ingrese al menos 2 caracteres.",
                maxlength: "Por favor, ingrese un máximo de 20 caracteres.",
              };
              break;

              case "vcuicuit":
                rules[fieldName] = {
                    required: true,
                    digits: true,
                    maxlength: 6,
                    minlength: 1,
                };
                messages[fieldName] = {
                    required: "Este campo es obligatorio.",
                    digits: "Por favor, ingrese solo dígitos.",
                    maxlength: "Por favor, ingrese un máximo de 6 dígitos.",
                    minlength: "Debe ingresar al menos 1 dígito.",
                };
                break;
          }
        });
      });

      rules["remito_first_part"] = {
        required: true,
        digits: true, // Solo permite dígitos
        minlength: 4,
        maxlength: 4,
      };
      messages["remito_first_part"] = {
        required: "Este campo es obligatorio.",
        digits: "Ingrese solo dígitos.",
        minlength: "Debe tener exactamente 4 dígitos.",
        maxlength: "Debe tener exactamente 4 dígitos.",
      };
  
      rules["remito_second_part"] = {
        required: true,
        digits: true, // Solo permite dígitos
        minlength: 8,
        maxlength: 8,
      };
      messages["remito_second_part"] = {
        required: "Este campo es obligatorio.",
        digits: "Ingrese solo dígitos.",
        minlength: "Debe tener exactamente 8 dígitos.",
        maxlength: "Debe tener exactamente 8 dígitos.",
      };


    $(formId).validate({
      rules: rules,
      messages: messages,
    });
  }

  function handleFormSubmit(formId, actionUrl) {
    $(formId).on("submit", function (e) {
      e.preventDefault();
      
      // Crear un objeto FormData para manejar la subida de archivos y otros datos del formulario
      var formData = new FormData(this);

        // Para enviar el avatar
        var avatar = $('#avatar')[0].files[0];
        if(avatar) {
          var files = $('#avatar')[0].files[0];
          formData.append('avatar',files);
        }
  
      if (!$(formId).valid()) {
        return; // Salir si el formulario no es válido
      }
  
      var laddaButton = Ladda.create(
        document.querySelector(formId + " .ladda-button")
      );
      laddaButton.start();
  
      $.ajax({
        type: "POST",
        url: actionUrl,
        data: formData,
        dataType: "json",
        contentType: false, // No establecer el content-type automáticamente
        processData: false, // No procesar los datos, enviar el objeto FormData tal como está
        success: function (response) {
          var messageContainer = $("#response-message");
  
          if (response.status === "user_in_deleted") {
            swal(
              {
                title: "Este email ya estuvo registrado",
                text: "El email ya existe en la base de datos con estado eliminado. ¿Deseas actualizarlo?",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, actualizar",
                cancelButtonText: "No, cancelar",
              },
              function (isConfirm) {
                if (isConfirm) {
                  $.ajax({
                    type: "POST",
                    url: actionUrl + "&isUpdate=true",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    success: function (updateResponse) {
                      laddaButton.stop();
                      if (updateResponse.status === "success") {
                        $("#myModal6").modal("hide");
                        setTimeout(function () {
                          toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            showMethod: "slideDown",
                            timeOut: 1500,
                            onHidden: function () {
                              location.reload();
                            },
                          };
                          toastr.success(updateResponse.message, "¡Actualizado!");
                        });
                      } else {
                        swal({
                          title: "Error",
                          text: updateResponse.message,
                          type: "error",
                        });
                      }
                    },
                    error: function (xhr, status, error) {
                      laddaButton.stop();
                      console.error(xhr.responseText);
                      swal({
                        title: "Error",
                        text: "Hubo un problema al actualizar.",
                        type: "error",
                      });
                    },
                  });
                } else {
                  laddaButton.stop();
                }
              }
            );
          } else if (response.status === "success") {
            laddaButton.stop();
            $("#myModal6").modal("hide");
            setTimeout(function () {
              toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: "slideDown",
                timeOut: 1500,
                onHidden: function () {
                  location.reload();
                },
              };
              toastr.success(response.message, "ÉXITO");
            });
          } else {
            laddaButton.stop();
            messageContainer.html(
              '<div class="alert alert-danger">' + response.message + "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          laddaButton.stop();
          console.log(xhr.responseText);
          $("#response-message").html(
            '<div class="alert alert-danger">Error en la solicitud AJAX: ' +
              error +
              "</div>"
          );
        },
      });
    });
  }

  function buysFormSubmit(formId, actionUrl) {
    $(formId).on("submit", function (e) {
      e.preventDefault();
      var formData = $(this).serialize();

      if (!$(formId).valid()) {
        return; // Salir si el formulario no es válido
      }
      $.ajax({
        type: "POST",
        url: actionUrl,
        data: formData,
        dataType: "json",
        success: function (response) {
          var messageContainer = $("#response-message");
          if (response.status === "success") {
            setTimeout(function () {
              toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: "slideDown",
                timeOut: 1500,
              };
              toastr.success(response.message, "ÉXITO");
            });
            //messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
            resetForm();

            setTimeout(function () {
              messageContainer.html("");
            }, 3000);
          } else {
            messageContainer.html(
              '<div class="alert alert-danger">' + response.message + "</div>"
            );
          }
        },
        error: function (xhr, status, error) {
          console.log(xhr.responseText);
          $("#response-message").html(
            '<div class="alert alert-danger">Error en la solicitud AJAX: ' +
              error +
              "<br>" +
              xhr.responseText +
              "</div>"
          );
        },
      });
    });

    $(".reload").click(function () {
      location.reload();
    });

    function resetForm() {
      $(".reset").val("");
    }
  }

  // Configurar validación y envío para cada formulario

  // USER
  setupFormValidation("#change-insertuser-form");
  handleFormSubmit(
    "#change-insertuser-form",
    "usersController.php?token=" + token + "&action=add_user"
  );
  setupFormValidation("#change-edituser-form");
  handleFormSubmit(
    "#change-edituser-form",
    "usersController.php?token=" + token + "&action=edit_user&email=" + email
  );

  // ADMIN
  setupFormValidation("#change-editadmin-form");
  handleFormSubmit(
      "#change-editadmin-form",
      "../crudusers/usersController.php?token=" + token + "&action=edit_user&email=" + email
  );
  setupFormValidation("#change-adminavatar-form");
  handleFormSubmit(
      "#change-adminavatar-form",
      "../crudusers/usersController.php?token=" + token + "&action=edit_user_avatar"
  );

  // TECHNIC
  setupFormValidation("#change-edittechnic-form");
  handleFormSubmit(
      "#change-edittechnic-form",
      "../crudusers/usersController.php?token=" + token + "&action=edit_user&email=" + email
  );

  setupFormValidation("#change-technicavatar-form");
  handleFormSubmit(
      "#change-technicavatar-form",
      "../../Admin/crudusers/usersController.php?token=" + token + "&action=edit_user_avatar"
  ); 

  // SUPPLIER
  setupFormValidation("#change-insertsupplier-form");
  handleFormSubmit(
    "#change-insertsupplier-form",
    "suppliersController.php?token=" + token + "&action=add_supplier"
  );

  setupFormValidation("#change-editsupplier-form");
  handleFormSubmit(
    "#change-editsupplier-form",
    "suppliersController.php?token=" + token + "&action=edit_supplier"
  );

  // CLIENT
  setupFormValidation("#change-insertclient-form");
  handleFormSubmit(
    "#change-insertclient-form",
    "clientsController.php?token=" + token + "&action=add_client"
  );
  setupFormValidation("#change-editclient-form");
  handleFormSubmit(
    "#change-editclient-form",
    "clientsController.php?token=" + token + "&action=edit_client"
  );


  // BUYS
  setupFormValidation("#add-buy-form");
  buysFormSubmit(
    "#add-buy-form",
    "buysController.php?token=" + token + "&action=add_buy"
  );


  //ORDERS
  setupFormValidation("#change-editordertec-form");
  handleFormSubmit(
    "#change-editordertec-form",
    "controllerOrders.php?token=" + token + "&action=edit_order_technic"
  );
  setupFormValidation("#change-insertorder-form");
  buysFormSubmit(
    "#change-insertorder-form",
    "ordersController.php?token=" + token + "&action=add_order"
  );
  setupFormValidation("#change-editorder-form");
  handleFormSubmit(
    "#change-editorder-form",
    "ordersController.php?token=" + token + "&action=edit_order"
  );

  
  
    //PRODUCTS
    setupFormValidation("#add-product-form");
    buysFormSubmit("#add-product-form", 'materialsController.php?token=' + token + '&action=add_product');

    setupFormValidation("#change-editproduct-form");
    handleFormSubmit(
      "#change-editproduct-form",
      "materialsController.php?token=" + token + "&action=edit_product"
    );
  
});


document.getElementById('show-urgent').addEventListener('click', function() {
  // Mostrar solo órdenes urgentes
  var urgentOrders = document.querySelectorAll('.urgent-order');
  var normalOrders = document.querySelectorAll('.normal-order');

  // Ocultar normales y mostrar urgentes
  normalOrders.forEach(function(order) {
    order.style.display = 'none';
  });
  urgentOrders.forEach(function(order) {
    order.style.display = 'block';
  });
});

document.getElementById('show-normal').addEventListener('click', function() {
  // Mostrar solo órdenes normales
  var urgentOrders = document.querySelectorAll('.urgent-order');
  var normalOrders = document.querySelectorAll('.normal-order');

  // Ocultar urgentes y mostrar normales
  urgentOrders.forEach(function(order) {
    order.style.display = 'none';
  });
  normalOrders.forEach(function(order) {
    order.style.display = 'block';
  });
});



// Ejecutar cuando el DOM esté completamente cargado
  document.addEventListener('DOMContentLoaded', function() {
    // Mostrar solo las órdenes urgentes por defecto al cargar la página
    const urgentButton = document.getElementById('show-urgent');
    if (urgentButton) {
        urgentButton.click();
    }
  });

 // Guardar una copia del select original al cargar la página
const materialTemplate = document.getElementById('material-template').cloneNode(true);
materialTemplate.removeAttribute('id'); // Eliminar el id para evitar duplicados

// Script para agregar nuevas filas de material y cantidad
document.getElementById('add-material').addEventListener('click', function() {
    const materialsSection = document.getElementById('materials-section');
    const materialRow = document.createElement('div');
    materialRow.classList.add('material-row');

    // Clonar el template guardado en lugar de clonar el select del DOM
    const materialSelect = materialTemplate.cloneNode(true);

    // Crear el contenedor de la nueva fila
    materialRow.innerHTML = `
        <div class="row mt-2">
            <div class="col-md-7"></div> <!-- Aquí insertaremos el select clonado -->
            <div class="col-md-3">
                <input type="number" name="quantities[]" class="form-control" placeholder="Cantidad">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-material">Eliminar</button>
            </div>
        </div>
    `;

    // Insertar el select clonado en el div correspondiente
    materialRow.querySelector('.col-md-7').appendChild(materialSelect);

    // Agregar la nueva fila al contenedor
    materialsSection.appendChild(materialRow);

    // Agregar el evento de eliminación a los nuevos botones
    addRemoveMaterialEvent(materialRow);
});

// Función para agregar el evento de eliminación a los botones de "Eliminar"
function addRemoveMaterialEvent(materialRow) {
    materialRow.querySelector('.remove-material').addEventListener('click', function() {
        materialRow.remove();
    });
}

// Aplicar el evento a la primera fila existente si es necesario
document.querySelectorAll('.material-row').forEach(function(row) {
    addRemoveMaterialEvent(row);
});

// Validar el formulario antes de enviarlo
document.getElementById('change-editordertec-form').addEventListener('submit', function(event) {
    let valid = true;
    document.querySelectorAll('select[name="materials[]"]').forEach(function(select) {
        if (select.value === '') {
            valid = false;
            alert('Debe seleccionar un material');
        }
    });
    document.querySelectorAll('input[name="quantities[]"]').forEach(function(input) {
        if (input.value === '' || input.value <= 0) {
            valid = false;
            alert('Debe ingresar una cantidad válida para cada material');
        }
    });
    if (!valid) {
        event.preventDefault();  // Evita el envío si no es válido
    }
});

