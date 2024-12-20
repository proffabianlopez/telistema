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
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../configsmtp/generate_config.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>

</head>

</body>
<div class="modal inmodal fase" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <button type="button" class="close reload" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title">Registrar Nuevo Producto</h4>
            </div>
            <div class="modal-body">
                <form id="add-product-form" action="" method="POST">
                <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="material_name">Nombre <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control validate-field vname_product reset" id="material_name" name="material_name">
                                </div>
                                <div class="form-group">
                                    <label for="description">Descripción <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control reset" id="description" name="description">
                                </div>
                                <div class="form-group">
                                    <label for="id_measure">Unidad de Medida <span class="text-danger">*</span></label>
                                    <select name="id_measure" id="id_measure" class="form-control validate-field select reset">
                                    <option value="" selected disabled></option>
                                    <?php
                                        // Verifica si existe el campo 'id_measure' en el array $row y asígnalo a $state
                                        $state = isset($row['id_measure']) ? $row['id_measure'] : null;

                                        if ($state !== null) {

                                            $stmt = $conn->prepare(SQL_SELECT_MEASURE_BY_ID);
                                            $stmt->bind_param("i", $state);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            // Verificar si hay resultados
                                            if ($result->num_rows > 0) {
                                                // Obtener la fila como un array asociativo
                                                $row_state = $result->fetch_assoc();
                                                $name_state = $row_state["name_measure"];
                                                $id_measure = $row_state["id_measure"];
                                        
                                            } else {
                                                // Si no hay resultados, asignar un valor por defecto
                                                $id_measure = 0; // O el valor que desees
                                            }

                                        } else {
                                            $id_measure = 0;
                                        }

                                        // Luego, obtén todos los estados de la tabla states_users
                                        $stmt = $conn->prepare(SQL_SELECT_MEASURES);
                                        $stmt->execute();
                                        $rows = $stmt->get_result();

                                        // Itera sobre los estados para crear las opciones del select
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock">Cantidad</label>
                                    <input type="number" class="form-control validate-field vammount reset" id="stock" name="stock">
                                </div>
                                    <div class="form-group">
                                        <label for="stock_alert">Alerta de Stock</label>
                                        <input type="number" class="form-control validate-field vammount reset" id="stock_alert" name="stock_alert">
                                    </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="submit" class="ladda-button btn btn-primary"
                            data-style="zoom-in">Agregar</button>
                        <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                    </div>
                    <div class="text-center" id="response-message"></div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text ">
                    <span class="font-bold">NOTA:</span> Al agregar un nuevo producto, asegúrese de completar todos los campos obligatorios. La información ingresada se reflejará inmediatamente en el sistema.<br>
                    <span class="text-danger">*</span> Campo Obligatorio.
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