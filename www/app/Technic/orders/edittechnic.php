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
                <form id="" action="" method="POST" enctype="multipart/form-data">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <div style="display: none;" class="form-group">
                                    <label for="id_order">N° de Orden</label>
                                    <input type="text" class="form-control" id="id_order" name="id_order" value="<?php if (isset($row['id_order'])) { echo $row['id_order']; } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="id_client">Cliente</label>
                                    <input type="text" class="form-control" id="full_name_client" value="<?php if (isset($row['client_name']) && isset($row['client_lastname'])) { echo $row['client_name'] . ' ' . $row['client_lastname']; } ?>" readonly>
                                </div>
                                <input type="hidden" name="id_client" value="<?php if (isset($row['id_client'])) { echo $row['id_client']; } ?>">
                                <input type="hidden" name="technic_id" value="<?php if (isset($row['technic_id'])) { echo $row['technic_id']; } ?>">
                                <div class="form-group">
                                    <label for="id_priority">Prioridad</label>
                                    <select name="id_priority" id="id_priority" class="form-control" disabled>
                                        <option value="1" <?php if ($row["id_priority"] === 1) echo 'selected'; ?>>Normal</option>
                                        <option value="2" <?php if ($row["id_priority"] === 2) echo 'selected'; ?>>Urgente</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="state_order">Estado</label>
                                    <select name="id_state_order" id="id_state_order" class="form-control" disabled>
                                        <option value="1" <?php if ($row["id_state_order"] === 1) echo 'selected'; ?>>Confirmada</option>
                                        <option value="2" <?php if ($row["id_state_order"] === 2) echo 'selected'; ?>>Cancelada</option>
                                        <option value="3" <?php if ($row["id_state_order"] === 3) echo 'selected'; ?>>Pendiente</option>
                                        <option value="4" <?php if ($row["id_state_order"] === 4) echo 'selected'; ?>>Realizada</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="order_description">Descripción</label>
                                    <textarea class="form-control validate-field vtextarea" id="order_description" name="order_description" style="resize: none; max-width: 100%;" readonly><?php if (isset($row['order_description'])) { echo $row['order_description']; } ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">Dirección</label>
                                    <input type="text" class="form-control validate-field vaddress" id="address" name="address" value="<?php if (isset($row['address'])) { echo $row['address']; } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="height">Altura</label>
                                    <input type="number" class="form-control validate-field vhousenumber" id="height" name="height" value="<?php if (isset($row['height'])) { echo $row['height']; } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="floor">Piso</label>
                                    <input type="text" class="form-control validate-field vfloor_dep" id="floor" name="floor" value="<?php if (isset($row['floor'])) { echo $row['floor']; } ?>" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="departament">Departamento</label>
                                    <input type="text" class="form-control validate-field vfloor_dep" id="departament" name="departament" value="<?php if (isset($row['departament'])) { echo $row['departament']; } ?>" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        </div>
                        <div class="text-center" id="response-message"></div>
                    </div>
                </form>
                <div class="p-xxs font-italic bg-muted border-top-bottom text">
                <span class="font-bold">NOTA:</span> Al visualizar una orden, solo se permite ver todos los datos asociados. No se permiten modificaciones en la información de la orden.

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
    <script src="../../js/main.js"></script>
</body>
</html>