<?php
session_start();

if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}
////////////////////////////////

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
$token = $_SESSION['token'];
$admin_id = $_SESSION['user_id'];

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../includes/header.php');
include('../configsmtp/generate_config.php');



// if (isset($_GET['id_client'])) {
//     $id_client = $_GET['id_client'];
// }
//     $id_client = $_SESSION['id_client'];
//     if (isset($_POST['reqsubmit'])) {
//         if (
//             empty(trim($_POST['order_date'])) || empty(trim($_POST['order_description'])) || empty(trim($_POST['order_server'])) || empty(trim($_POST['address'])) || empty(trim($_POST['height'])) || empty(trim($_POST['floor'])) || empty(trim($_POST['departament'])) || empty(trim($_POST['id_priority'])) || empty(trim($_POST['id_material'])) || empty(trim($_POST['admin_id'])) || empty(trim($_POST['technic_id']))
//         ) {
//             $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Completa todos los campos </div>';
//         } else {

//             $order_date = $_POST['order_date'];
//             $order_hour = $_POST['order_hour'];
//             $order_description = $_POST['order_description'];
//             $order_server = $_POST['order_server'];
//             $address = capitalizeWords($_POST['address']);
//             $height = $_POST['height'];
//             $floor = trim($_POST['floor']);
//             $departament = trim($_POST['departament']);
//             $id_priority = $_POST['id_priority'];
//             $id_state_order = 3;
//             $admin_id = $_POST['admin_id'];
//             $technic_id = $_POST['technic_id'];

//             $stmt = $conn->prepare(SQL_INSERT_ORDER);
//             if ($stmt === false) {
//                 die('Error en la preparación de la consulta: ' . $conn->error);
//             }
//             $stmt->bind_param("ssisissiiiii", $order_date, $order_hour, $order_description, $order_server, $address, $height, $floor, $departament, $id_client, $id_priority, $id_state_order, $admin_id, $technic_id);
//             if ($stmt->execute()) {
//                 $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Agregado exitosamente </div>';
//             } else {
//                 $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo agregar </div>';
//             }
//         }
//     }
// } else {
//     $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> ID de cliente no especificado </div>';
// }
?>

<body>
    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <button type="button" class="close reload" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                    </button>
                    <h4 class="modal-title">Registrar Nueva Orden</h4>
                </div>
                <div class="modal-body">
                    <form id="change-insertorder-form" action="" method="POST">

                        <!-- Contenedor principal flex -->
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Primera columna -->
                                <div class="col-md-6">
                                    <div class="form-group" style="display: none;">
                                        <input type="hidden" class="form-control" id="admin_id" name="admin_id" value="<?php echo htmlspecialchars($admin_id); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cuicuit_number">N° de Circuito <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control validate-field vcuicuit reset" id="cuicuit_number" name="cuicuit_number">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_client">Cliente <span class="text-danger">*</span></label>
                                        <select class="form-control validate-field select reset" id="id_client" name="id_client" required>
                                            <option value=""></option>
                                            <?php
                                            $stmt = $conn->prepare(SQL_SELECT_ALL_CLIENTS);
                                            $stmt->execute();
                                            $result = $stmt->get_result();
                                            if ($result->num_rows > 0) {
                                                while ($row_client = $result->fetch_assoc()) {
                                                    $id_client = $row_client["id_client"];
                                                    $client_name = $row_client["client_name"];
                                                    $client_lastname = $row_client["client_lastname"];
                                                    echo '<option value="' . htmlspecialchars($id_client) . '">' . htmlspecialchars($client_name . ' ' . $client_lastname) . '</option>';
                                                }
                                            } else {
                                                echo '<option>No hay clientes disponibles</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_priority">Prioridad <span class="text-danger">*</span></label>
                                        <select class="form-control validate-field select reset" name="id_priority" id="id_priority">
                                            <option value="" selected></option>
                                            <?php
                                            $stmt = $conn->prepare(SQL_SELECT_PRIORITYS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();
                                            foreach ($rows as $state) {
                                                $priorityName = $state["priority"];
                                                $priorityId = $state["id_priority"];
                                                $selected = ($priorityId == $id_priority) ? "selected" : "";
                                                echo "<option value='$priorityId' $selected>$priorityName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="technic_id">Asignar Técnico <span class="text-danger">*</span></label>
                                        <select name="technic_id" id="technic_id" class="form-control validate-field select reset">
                                        <option value=""></option>
                                            <?php
                                            $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();
                                            foreach ($rows as $user) {
                                                if ($user["id_rol"] == 2) {
                                                    $technicName = $user["name_user"] . ' ' . $user["surname_user"];
                                                    $technicId = $user["id_user"];
                                                    $selected = ($technicId == $technic_id) ? "selected" : "";
                                                    echo "<option value='$technicId' $selected>$technicName</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="order_description">Descripción <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea reset" id="order_description" name="order_description" style="resize: none; max-width: 100%;"></textarea>
                                    </div>
                                </div>
                                <!-- Segunda columna -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="id_type_work">Tipo de trabajo <span class="text-danger">*</span></label>
                                            <select name="id_type_work" id="id_type_work" class="form-control validate-field select reset">
                                                <option value=""> </option>
                                                <?php
                                                $stmt = $conn->prepare(SQL_SELECT_TYPES_WORKS_ORDERS);
                                                $stmt->execute();
                                                $rows = $stmt->get_result();
                                                foreach ($rows as $type_work) {
                                                    $type_workName = $type_work["type_work"];
                                                    $type_workId = $type_work["id_type_work"];
                                                    $selected = ($type_workId == $id_type_work) ? "selected" : "";
                                                    echo "<option value='$type_workId' $selected>$type_workName</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <div class="form-group">
                                        <label for="address">Dirección <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control validate-field vaddress reset" id="address" name="address">
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Altura</label>
                                        <input type="number" class="form-control validate-field vhousenumber reset" id="height" name="height">
                                    </div>
                                    <div class="form-group">
                                        <label for="floor">Piso</label>
                                        <input type="text" class="form-control validate-field vfloor_dep reset" id="floor" name="floor">
                                    </div>
                                    <div class="form-group">
                                        <label for="departament">Departamento</label>
                                        <input type="text" class="form-control validate-field vfloor_dep reset" id="departament" name="departament">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Agregar</button>
                                <button type="button" class="btn btn-white reload" data-dismiss="modal">Cerrar</button>
                            </div>
                            <div class="text-center" id="response-message"></div>
                        </div>
                    </form>
                    <div class="p-xxs font-italic bg-muted border-top-bottom text">
                        <span class="font-bold">NOTA:</span> Al agregar una nueva Orden, asegúrese de completar todos los campos obligatorios. La información ingresada se reflejará inmediatamente en el sistema.<br>
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