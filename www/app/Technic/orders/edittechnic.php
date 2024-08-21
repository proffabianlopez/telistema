<?php
session_start();

if (!isset($_SESSION['is_login']) || !isset($_GET['token']) || $_GET['token'] !== $_SESSION['token']) {
    header("Location:../../includes/404/404.php");
    exit();
  }
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');
include ('../../dbConnection.php');
include ('../../Querys/querys.php');
include ('../../Admin/configsmtp/generate_config.php');
include ('../../includes/header.php');


if (isset($_POST['id'])) {
    $id = explode('*', $_POST['id']);

    $id_order = $id[0];
    $sql = SQL_SELECT_ORDER_BY_ID;
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_order);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert">No se encontró ningúna orden con ese ID.</div>';
    }
}

?>
<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Detalle de la Orden N°<?php  echo $row['id_order']?></h4>
                </div>
                <div class="modal-body">
                    <form id="change-editordertec-form" action="" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-6">
                                    <div style="display: none;" class="form-group">
                                        <label for="id_order">N° de Orden</label>
                                        <input type="text" class="form-control" id="id_order" name="id_order" value="<?php if (isset($row['id_order'])) {
                                            echo $row['id_order'];
                                        } ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_client">Cliente</label>
                                        <p class="form-control" id="full_name_client" readonly><?php if (isset($row['client_name']) && isset($row['client_lastname'])) {
                                            echo $row['client_name'] . ' ' . $row['client_lastname'];
                                        } ?></p> 
                                    </div>
                                    <input type="hidden" name="id_client" value="<?php if (isset($row['id_client'])) {
                                        echo $row['id_client'];
                                    } ?>">
                                    <input type="hidden" name="technic_id" value="<?php if (isset($row['technic_id'])) {
                                        echo $row['technic_id'];
                                    } ?>">
                                    <div class="form-group">
                                        <label for="id_priority">Prioridad <span class="text-danger">*</span></label>
                                        <select name="id_priority" id="id_priority" class="form-control">
                                            <option value="1" <?php if ($row["id_priority"] === 1)
                                                echo 'selected'; ?>>
                                                Normal</option>
                                            <option value="2" <?php if ($row["id_priority"] === 2)
                                                echo 'selected'; ?>>
                                                Urgente</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_order">Estado <span class="text-danger">*</span></label>
                                        <select name="id_state_order" id="id_state_order" class="form-control">
                                            <option value="1" <?php if ($row["id_state_order"] === 1)
                                                echo 'selected'; ?>>
                                                Confirmada</option>
                                            <option value="2" <?php if ($row["id_state_order"] === 2)
                                                echo 'selected'; ?>>
                                                Cancelada</option>
                                            <option value="3" <?php if ($row["id_state_order"] === 3)
                                                echo 'selected'; ?>>
                                                Pendiente</option>
                                            <option value="4" <?php if ($row["id_state_order"] === 4)
                                                echo 'selected'; ?>>
                                                Realizada</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="order_description">Descripción <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea" id="order_description" name="order_description"
                                            style="resize: none; max-width: 100%;"><?php if (isset($row['order_description'])) {
                                                echo $row['order_description'];
                                            } ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Dirección  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control validate-field vaddress" id="address" name="address" value="<?php if (isset($row['address'])) {
                                            echo $row['address'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Altura  <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control validate-field vhousenumber" id="height" name="height" value="<?php if (isset($row['height'])) {
                                            echo $row['height'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="floor">Piso</label>
                                        <input type="text" class="form-control validate-field vfloor_dep" id="floor" name="floor" value="<?php if (isset($row['floor'])) {
                                            echo $row['floor'];
                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="departament">Departamento</label>
                                        <input type="text" class="form-control validate-field vfloor_dep" id="departament" name="departament"
                                            value="<?php if (isset($row['departament'])) {
                                                echo $row['departament'];
                                            } ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name_image" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="name_image" name="name_image" accept="image/*"                      >
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
                                <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="text-center" id="response-message"></div>
                        </div>
                    </form>
                    <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al editar una Orden, asegúrese de revisar y actualizar
                        correctamente todos los campos. Los cambios realizados se reflejarán inmediatamente en el 
                        sistema.<br>
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
    <script>
        $(document).ready(function () {

            $('#full_name_client').prop('readonly', true);
            $('#full_name_client').attr('disabled', 'disabled');

        });
    </script>
    <script>
        // Asegúrate de que este código se ejecute después de que el DOM esté completamente cargado
        $(document).ready(function() {
            $('#change-editordertec-form').on('submit', function(event) {
                event.preventDefault(); // Prevenir el envío del formulario para depuración

                // Crear un objeto FormData para recoger los datos del formulario
                var formData = new FormData(this);

                // Convertir el FormData a un objeto simple para loguear
                var dataObj = {};
                formData.forEach(function(value, key) {
                    dataObj[key] = value;
                });

                // Loguear los datos en la consola
              console.log('Datos del formulario:', dataObj);

                // Opcional: Enviar el formulario manualmente para probar si los datos están correctos
                // $.ajax({
                //     url: $(this).attr('action'),
                //     method: 'POST',
                //     data: formData,
                //     processData: false,
                //     contentType: false,
                //     success: function(response) {
                //         console.log('Respuesta del servidor:', response);
                //     },
                //     error: function(jqXHR, textStatus, errorThrown) {
                //         console.error('Error en la solicitud:', textStatus, errorThrown);
                //     }
                // });
            });
        });
    </script>
    <script src="../../js/main.js"></script>
</body>
</html>