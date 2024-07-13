<?php
// Inicia la sesión
session_start();

// Verifica si la sesión está iniciada y el token es válido
if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    // Si no hay sesión o el token no es válido, redirige al usuario o muestra un mensaje de error
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
include('../configsmtp/generate_config.php');
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
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Registrar Nueva Compra</h4>
            </div>
            <div class="modal-body">
                <form id="add-buy-form" action="" method="POST">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_buy">Fecha:</label>
                                    <input type="date" name="date_buy" id="date_buy" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="id_supplier">Proveedor <span class="text-danger">*</span></label>
                                    <select name="id_supplier" id="id_supplier" class="form-control validate-field select">
                                        <option value="" selected disabled></option>
                                        <?php
                                        $stmt = $conn->prepare(SQL_FROM_SUPPLIERS);
                                        $stmt->execute();
                                        $rows = $stmt->get_result();
                                        foreach ($rows as $state) {
                                            $stateName = $state["supplier_name"];
                                            $stateId = $state["id_supplier"];
                                            echo "<option value='$stateId'>$stateName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="remito">N° Remito <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" name="remito_first_part" id="remito_first_part" class="form-control validate-field vcost" placeholder="Primeros 4 dígitos" maxlength="4" style="width: 35%;" required>
                                        <input type="text" name="remito_second_part" id="remito_second_part" class="form-control validate-field vcost" placeholder="Siguientes 8 dígitos" maxlength="8" style="width: 60%;" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="id_material">Producto <span class="text-danger">*</span></label>
                                    <select name="id_material" id="id_material" class="form-control validate-field select reset">
                                        <option value="" selected disabled></option>
                                        <?php
                                        $stmt = $conn->prepare(SQL_SELECT_MATERIALS);
                                        $stmt->execute();
                                        $rows = $stmt->get_result();
                                        foreach ($rows as $name) {
                                            $materialName = $name["material_name"];
                                            $nameId = $name["id_material"];
                                            echo "<option value='$nameId'>$materialName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cost">Costo <span class="text-danger">*</span></label>
                                        <input type="number" name="cost" id="cost" class="form-control validate-field vcost reset" placeholder="Costo" min="0">
                                    </div>
                                    <div class="form-group">
                                        <label for="ammount">Cantidad <span class="text-danger">*</span></label>
                                        <input type="number" name="ammount" id="ammount" class="form-control validate-field vammount reset" placeholder="Cantidad" min="0">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-cart-plus"></i> Comprar</button>
                                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                                    </div>
                                    <div class="text-center" id="response-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>



                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span>Al registrar una nueva compra, es imprescindible que complete todos los campos obligatorios. Los datos proporcionados se actualizarán inmediatamente en el sistema para reflejar la nueva entrada.<br>
                    <span class="text-danger">*</span> Campo Obligatorio
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    let token = '<?php echo $token; ?>';
    let email = '';
</script>

<script src="../../js/main.js"></script>

</body>

</html>