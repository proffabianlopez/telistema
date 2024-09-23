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
include ('../configsmtp/generate_config.php');
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
                    <h4 class="modal-title">Editar Orden</h4>
                </div>
                <div class="modal-body">
                    <form id="change-editorder-form" action="" method="POST">
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
                                        <label for="circuit_number">N° de Circuito <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="circuit_number" name="circuit_number" value="<?php if (isset($row['circuit_number'])) {
                                            echo $row['circuit_number'];
                                        } ?>">
                                    </div> 
                                    <div class="form-group">
                                        <label for="id_client">Cliente <span class="text-danger">*</span></label>
                                        <select name="id_client" id="id_client" class="form-control">
                                            <?php
                                            $client = $row['id_client'];
                                            $stmt = $conn->prepare(SQL_SELECT_CLIENTS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $client);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_client = $result->fetch_assoc();
                                          $name_client = $row_client["client_name"] . ' ' . $row_client["client_lastname"];
                                                $id_client = $row_client["id_client"];
                                            }

                                            $stmt_all = $conn->prepare(SQL_SELECT_ALL_CLIENTS);
                                            $stmt_all->execute();
                                            $result_all = $stmt_all->get_result();

                                            foreach ($result_all as $clie) {
                                                $clientName = $clie["client_name"] . ' ' . $clie["client_lastname"];
                                                $clientId = $clie["id_client"];
                                                $selected = ($clientId == $id_client) ? "selected" : "";
                                                echo "<option value='$clientId' $selected>$clientName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
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
                                        <label for="technic_id">Asignar Técnico <span class="text-danger">*</span></label>
                                        <select name="technic_id" id="technic_id" class="form-control">
                                            <?php
                                            $technic = $row['technic_id'];
                                            $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $technic);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_technic = $result->fetch_assoc();
                                          $name_technic = $row_technic["name_user"] . ' ' . $row_technic["surname_user"];
                                                $id_technic = $row_technic["id_user"];
                                            }

                                            $stmt_all = $conn->prepare(SQL_SELECT_TECNS_ORDERS);
                                            $stmt_all->execute();
                                            $result_all = $stmt_all->get_result();

                                            foreach ($result_all as $tech) {
                                                $technicName = $tech["name_user"] . ' ' . $tech["surname_user"];
                                                $technicId = $tech["id_user"];
                                                $selected = ($technicId == $id_technic) ? "selected" : "";
                                                echo "<option value='$technicId' $selected>$technicName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_order">Estado <span class="text-danger">*</span></label>
                                        <select name="id_state_order" id="id_state_order" class="form-control">
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
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="id_type_work">Tipo de trabajo <span class="text-danger">*</span></label>
                                        <select name="id_type_work" id="id_type_work" class="form-control">
                                            <option value="1" <?php if ($row["id_type_work"] === 1)
                                                echo 'selected'; ?>>
                                                Alta</option>
                                            <option value="2" <?php if ($row["id_type_work"] === 2)
                                                echo 'selected'; ?>>
                                                Reparación</option>
                                        </select>
                                    </div>
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
                                        <label for="order_description">Descripción <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea" id="order_description" name="order_description"
                                            style="resize: none; max-width: 100%;"><?php if (isset($row['order_description'])) {
                                                echo $row['order_description'];
                                            } ?></textarea>
                                </div>
                            <div class="modal-footer">
                                <button type="submit" class="ladda-button btn btn-primary"
                                    data-style="zoom-in">Actualizar</button>
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
    <script src="../../js/main.js"></script>
</body>

</html>