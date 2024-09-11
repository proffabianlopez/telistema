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
                    <h4 class="modal-title">Reporte de la Orden N°<?php  echo $row['id_order']?></h4>
                </div>
                <div class="modal-body">
                <form id="change-editordertec-form" action="" method="POST" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div style="display: none;" class="form-group">
                                        <label for="id_order">N° de Orden</label>
                                        <input type="text" class="form-control" id="id_order" name="id_order" value="<?php if (isset($row['id_order'])) {
                                            echo $row['id_order'];
                                        } ?>" readonly>
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
                                        <label for="order_description">Reporte <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea" id="report_technic" name="report_technic"
                                            ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="name_image" class="form-label">Imagen</label>
                                        <input type="file" class="form-control" id="name_image" name="name_image[]" accept="image/*" multiple >
                                    </div>
                                </div>
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
                        <strong>NOTA:</strong> Al generar el reporte de una Orden, revise y actualice cuidadosamente todos los campos, 
                        ya que los cambios se reflejarán inmediatamente en el sistema y serán irreversibles.<br>
                        <span class="text-danger">*</span> Campo obligatorio
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