<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    header("Location:../../includes/404/404.php");
    exit();
}

// Genera un token CSRF y lo guarda en la sesión
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

include('../../dbConnection.php');
include('../../Querys/querys.php');

if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Preparar la consulta para obtener la compra específica
    $stmt = $conn->prepare(SQL_SELECT_BUY_BY_ID);
    $stmt->bind_param('i', $id_user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
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
</head>

<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Editar Compra</h4>
                </div>
                <div class="modal-body">
                    <form id="change-buy-form" action="" method="POST">
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Primera columna -->
                                <div class="col-md-6">
                                    <div style="display: none" class="form-group">
                                        <label for="id_buy">ID Compra</label>
                                        <input type="text" class="form-control" id="id_buy" name="id_buy" value="<?php echo isset($row['id_buy']) ? $row['id_buy'] : ''; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="date_buy">Fecha:</label>
                                        <input type="date" name="date_buy" id="date_buy" class="form-control" value="<?php echo isset($row['date_buy']) ? $row['date_buy'] : ''; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="remito">N° Remito <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" name="remito_first_part" id="remito_first_part" class="form-control validate-field vcost" placeholder="4 dígitos" maxlength="4" style="width: 35%;" required value="<?php echo isset($row['remittance']) ? substr($row['remittance'], 0, 4) : ''; ?>" />
                                            <input type="text" name="remito_second_part" id="remito_second_part" class="form-control validate-field vcost" placeholder="8 dígitos" maxlength="8" style="width: 60%;" required value="<?php echo isset($row['remittance']) ? substr($row['remittance'], 4) : ''; ?>" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="material_name">Producto <span class="text-danger">*</span></label>
                                        <select name="id_material" id="id_material" class="form-control">
                                            <?php
                                            // Obtener todos los productos de la tabla materials
                                            $stmt = $conn->prepare(SQL_SELECT_MATERIALS);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // ID del material asociado a la compra actual
                                            $id_material_compra = isset($row['id_material']) ? $row['id_material'] : '';

                                            while ($material = $result->fetch_assoc()) {
                                                $materialId = $material['id_material'];
                                                $materialName = $material['material_name'];
                                                // Verifica si el ID del material coincide con el ID seleccionado en la compra
                                                $selected = ($materialId == $id_material_compra) ? "selected" : "";
                                                echo "<option value='$materialId' $selected>$materialName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="id_supplier">Proveedor</label>
                                        <select name="id_supplier" id="id_supplier" class="form-control">
                                            <?php
                                            // Obtener todos los proveedores de la tabla suppliers
                                            $stmt = $conn->prepare(SQL_FROM_SUPPLIERS);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // ID del proveedor asociado a la compra actual
                                            $currentSupplierId = isset($row['id_supplier']) ? $row['id_supplier'] : '';

                                            while ($supplier = $result->fetch_assoc()) {
                                                $supplierId = $supplier['id_supplier'];
                                                $supplierName = $supplier['supplier_name'];
                                                // Verifica si el ID del proveedor coincide con el ID seleccionado en la compra
                                                $selected = ($supplierId == $currentSupplierId) ? "selected" : "";
                                                echo "<option value='$supplierId' $selected>$supplierName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cost">Costo</label>
                                        <input type="number" name="cost" id="cost" class="form-control" value="<?php echo isset($row['cost']) ? $row['cost'] : ''; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="ammount">Cantidad</label>
                                        <input type="number" class="form-control" id="ammount" name="ammount" value="<?php echo isset($row['ammount']) ? $row['ammount'] : ''; ?>" />
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                                    <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                                </div>
                                <div class="text-center" id="response-message"></div>
                            </div>
                        </div>
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
                    url: 'buysController.php?token=<?php echo $_SESSION["token"]; ?>&action=edit_buy',
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
