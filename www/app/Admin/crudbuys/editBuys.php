<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
    header("Location: ../../includes/404.php");
    exit();
}

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../configsmtp/generate_config.php');
include('../configsmtp/endEmail.php');

if (isset($_GET['id'])) {

    $id_user = $_GET['id'];
    $stmt = $conn->prepare(SQL_SELECT_BUY_BY_ID);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();

    // Obtener resultados de la consulta
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Obtener la fila como un array asociativo
        $row = $result->fetch_assoc();
    } else {
        // Mostrar un mensaje si no se encuentra ningún cliente con el ID proporcionado
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningún producto con ese ID.</div>';
    }
} else {
    echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se captó el ID.</div>';
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Compra</title>
    <!-- Incluye tus estilos y scripts aquí -->
</head>

<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-xl">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <i class="bi bi-person-gear modal-icon"></i>
                    <h4 class="modal-title">Editar Compra</h4>
                </div>
                <div class="modal-body">
                    <form id="change-buy-form" action="" method="POST">
                        <div style="display: none" class="form-group">
                            <label for="id_buy">ID Compra</label>
                            <input type="text" class="form-control" id="id_buy" name="id_buy" value="<?php if (isset($row['id_buy'])) {
                                                                                                            echo $row['id_buy'];
                                                                                                        } ?>" readonly>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">

                                <label for="id_material">Producto</label>
                                <select name="id_material" id="id_material" class="form-control">
                                    <?php
                                    $state = $row['id_material'];
                                    $stmt = $conn->prepare(SQL_SELECT_PRODUCT_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Verificar si hay resultados
                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["material_name"];
                                        $id_material = $row_state["id_material"];
                                    } else {
                                        $id_material = 0; // O el valor que desees
                                    }

                                    // Obtener todos los estados de la tabla measures
                                    $stmt = $conn->prepare(SQL_SELECT_MATERIALS);
                                    $stmt->execute();
                                    $rows = $stmt->get_result();

                                    foreach ($rows as $state) {
                                        $stateName = $state["material_name"];
                                        $stateId = $state["id_material"];
                                        $selected = ($stateId == $id_measure) ? "selected" : "";
                                        echo "<option value='$stateId' $selected>$stateName</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="id_supplier">Proveedor</label>
                                <select name="id_supplier" id="id_supplier" class="form-control">
                                    <?php
                                    $state = $row['id_supplier'];
                                    $stmt = $conn->prepare(SQL_SELECT_SUPPLIER_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Verificar si hay resultados
                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["supplier_name"];
                                        $id_supplier = $row_state["id_supplier"];
                                    } else {
                                        $id_supplier = 0; // O el valor que desees
                                    }

                                    // Obtener todos los estados de la tabla measures
                                    $stmt = $conn->prepare(SQL_FROM_SUPPLIERS);
                                    $stmt->execute();
                                    $rows = $stmt->get_result();

                                    foreach ($rows as $state) {
                                        $stateName = $state["supplier_name"];
                                        $stateId = $state["id_supplier"];
                                        $selected = ($stateId == $id_measure) ? "selected" : "";
                                        echo "<option value='$stateId' $selected>$stateName</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-sm-4">
                                <label for="id_measure">Unidad de Medida</label>
                                <select name="id_measure" id="id_measure" class="form-control">
                                    <?php
                                    $state = $row['id_measure'];
                                    $stmt = $conn->prepare(SQL_SELECT_MEASURE_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    // Verificar si hay resultados
                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["name_measure"];
                                        $id_measure = $row_state["id_measure"];
                                    } else {
                                        $id_measure = 0; // O el valor que desees
                                    }

                                    // Obtener todos los estados de la tabla measures
                                    $stmt = $conn->prepare(SQL_SELECT_MEASURES);
                                    $stmt->execute();
                                    $rows = $stmt->get_result();

                                    foreach ($rows as $state) {
                                        $stateName = $state["name_measure"];
                                        $stateId = $state["id_measure"];
                                        $selected = ($stateId == $id_measure) ? "selected" : "";
                                        echo "<option value='$stateId' $selected>$stateName</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row mt-3">
                            <div class="col-sm-4">
                                <label for="cost">Costo</label>
                                <input type="number" name="cost" id="cost" class="form-control" value="<?php if (isset($row['cost'])) { echo $row['cost']; } ?>" />
                            </div>
                            
                            <div class="col-sm-4">
                                <label for="ammount">Cantidad</label>
                                <input type="number" class="form-control" id="ammount" name="ammount" value="<?php if (isset($row['ammount'])) { echo $row['ammount']; } ?>" />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                            <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                        </div>
                        <div class="text-center" id="response-message"></div>
                    </form>


                    <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al editar un producto, asegúrese de revisar y actualizar correctamente todos los campos. Los cambios realizados se reflejarán inmediatamente en el sistema.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var laddaButton;

            $('#change-buy-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                laddaButton = Ladda.create(document.querySelector('.ladda-button'));
                laddaButton.start();

                $.ajax({
                    type: 'POST',
                    url: 'buysController.php?token=<?php echo $_SESSION["token"]; ?>&action=edit_buy', // La URL de tu archivo PHP
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        laddaButton.stop();
                        var messageContainer = $('#response-message');
                        if (response.status === 'success') {
                            messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
                        } else {
                            messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                        }
                    },
                    error: function() {
                        laddaButton.stop();
                        $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX</div>');
                    }
                });
            });

            $('.reload').click(function() {
                location.reload();
            });
        });
    </script>

</body>

</html>