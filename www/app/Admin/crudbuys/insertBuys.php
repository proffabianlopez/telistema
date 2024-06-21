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
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Compra</title>
    <!-- Incluye tus estilos y scripts aquí -->
</head>

</body>
<div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <i class="bi bi-person-fill-add modal-icon"></i>
                <h4 class="modal-title">Registrar Nueva Compra</h4>
            </div>
            <div class="modal-body">

                <form id="add-buy-form" action="" method="POST">
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="material_name">Nombre</label>
                            <select name="id_material" id="id_material" class="form-control">
                                <option value="" selected disabled>Producto</option>
                                <?php
                                // Verifica si existe el campo 'id_material' en el array $row y asígnalo a $state
                                $state = isset($row['id_material']) ? $row['id_material'] : null;

                                if ($state !== null) {
                                    $stmt = $conn->prepare(SQL_SELECT_PRODUCT_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["material_name"];
                                        $id_material = $row_state["id_material"];
                                    } else {
                                        $id_material = 0;
                                    }
                                } else {
                                    $id_material = 0;
                                }

                                $stmt = $conn->prepare(SQL_SELECT_MATERIALS);
                                $stmt->execute();
                                $rows = $stmt->get_result();

                                foreach ($rows as $name) {
                                    $materialName = $name["material_name"];
                                    $nameId = $name["id_material"];
                                    $selected = ($nameId == $id_material) ? "selected" : "";
                                    echo "<option value='$nameId' $selected>$materialName</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="id_measure">Medida</label>
                            <select name="id_measure" id="id_measure" class="form-control">
                                <option value="" selected disabled>Unidad de medida</option>
                                <?php
                                $state = isset($row['id_measure']) ? $row['id_measure'] : null;

                                if ($state !== null) {
                                    $stmt = $conn->prepare(SQL_SELECT_MEASURE_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["name_measure"];
                                        $id_measure = $row_state["id_measure"];
                                    } else {
                                        $id_measure = 0;
                                    }
                                } else {
                                    $id_measure = 0;
                                }

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
                        <div class="col-sm-4">
                            <label for="id_supplier">Proveedor</label>
                            <select name="id_supplier" id="id_measure" class="form-control">
                                <option value="" selected disabled>Proveedor</option>
                                <?php
                                $state = isset($row['id_supplier']) ? $row['id_supplier'] : null;

                                if ($state !== null) {
                                    $stmt = $conn->prepare(SQL_SELECT_SUPPLIER_BY_ID);
                                    $stmt->bind_param("i", $state);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $row_state = $result->fetch_assoc();
                                        $name_state = $row_state["supplier_name"];
                                        $id_supplier = $row_state["id_supplier"];
                                    } else {
                                        $id_supplier = 0;
                                    }
                                } else {
                                    $id_supplier = 0;
                                }

                                $stmt = $conn->prepare(SQL_FROM_SUPPLIERS);
                                $stmt->execute();
                                $rows = $stmt->get_result();

                                foreach ($rows as $state) {
                                    $stateName = $state["supplier_name"];
                                    $stateId = $state["id_supplier"];
                                    $selected = ($stateId == $id_supplier) ? "selected" : "";
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
                            <input type="number" name="cost" id="cost" class="form-control" placeholder="Costo">
                        </div>
                        <div class="col-sm-4">
                            <label for="ammount">Cantidad</label>
                            <input type="number" name="ammount" id="ammount" class="form-control" placeholder="Cantidad">
                        </div>
                    </div>
                    <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Comprar</button>
                            <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                        </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span>Al registrar una nueva compra, es imprescindible que complete todos los campos obligatorios. Los datos proporcionados se actualizarán inmediatamente en el sistema para reflejar la nueva entrada.
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function () {
    $('#add-buy-form').on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var laddaButton = Ladda.create(document.querySelector('.ladda-button'));
        laddaButton.start();
        $.ajax({
            type: 'POST',
            url: 'buysController.php?token=<?php echo $token; ?>&action=add_buy',
            data: formData,
            dataType: 'json',
            success: function (response) {
                laddaButton.stop();
                var messageContainer = $('#response-message');
                if (response.status === 'success') {
                    messageContainer.html('<div class="alert alert-success">' + response.message + '</div>');
                } else {
                    messageContainer.html('<div class="alert alert-danger">' + response.message + '</div>');
                }
            },
            error: function (xhr, status, error) {
                laddaButton.stop();
                console.log(xhr.responseText);
                $('#response-message').html('<div class="alert alert-danger">Error en la solicitud AJAX: ' + error + '<br>' + xhr.responseText + '</div>');
            }
        });
    });
    $('.reload').click(function () {
        location.reload();
    });
});
</script>


</body>

</html>