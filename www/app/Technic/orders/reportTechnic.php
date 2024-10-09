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
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../../Admin/configsmtp/generate_config.php');
include('../../includes/header.php');


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
                    <h4 class="modal-title">Reporte de la Orden N°<?php echo $row['id_order'] ?></h4>
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
                                        <?php if ($row["id_state_order"] === 2): ?>
                                            <!-- Mostrar si la orden ya está cancelada pero sin posibilidad de modificar -->
                                            <option value="2" selected>Cancelada</option>
                                        <?php endif; ?>
                                            <option value="3" <?php if ($row["id_state_order"] === 3) echo 'selected'; ?>>Pendiente</option>
                                            <option value="4" <?php if ($row["id_state_order"] === 4) echo 'selected'; ?>>Realizada</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="report_technic">Reporte <span class="text-danger">*</span></label>
                                        <textarea class="form-control validate-field vtextarea" id="report_technic" name="report_technic"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="name_image" class="form-label">Imagen</label>
                                        <input type="file" class="form-control" id="name_image" name="name_image[]" accept="image/*" multiple>
                                    </div>

                                    <!-- Nueva sección para materiales y cantidades -->
                                    <div class="form-group">
                                        <label for="materials">Materiales Utilizados</label>
                                        <div id="materials-section">
                                            <!-- Primera fila de material y cantidad -->
                                            <div class="material-row">
                                                <div class="row">
                                                    <div class="col-md-7">
                                                    <select name="materials[]" class="form-control" id="material-template">
                                                        <option value=""></option>
                                                        <?php
                                                        $stmt = $conn->prepare(SQL_SELECT_MATERIALS);
                                                        $stmt->execute();
                                                        $result = $stmt->get_result();
                                                        if ($result->num_rows > 0) {
                                                            while ($row_material = $result->fetch_assoc()) {
                                                                $id_material = $row_material["id_material"];
                                                                $material_name = $row_material["material_name"];
                                                                echo '<option value="' . htmlspecialchars($id_material) . '">' . htmlspecialchars($material_name) . '</option>';
                                                            }
                                                        } else {
                                                            echo '<option>No hay materiales disponibles</option>';
                                                        }
                                                        ?>
                                                    </select>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="number" name="quantities[]" class="form-control" placeholder="Cantidad">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger remove-material">Eliminar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <button type="button" id="add-material" class="btn btn-success mt-2">Agregar material</button>
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="ladda-button btn btn-primary" data-style="zoom-in">Actualizar</button>
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

    <script>
        const materialTemplate = document.getElementById('material-template').cloneNode(true);
        materialTemplate.removeAttribute('id'); // Eliminar el id para evitar duplicados

        // Script para agregar nuevas filas de material y cantidad
        document.getElementById('add-material').addEventListener('click', function() {
            const materialsSection = document.getElementById('materials-section');
            const materialRow = document.createElement('div');
            materialRow.classList.add('material-row');

            // Clonar el template guardado en lugar de clonar el select del DOM
            const materialSelect = materialTemplate.cloneNode(true);

            // Crear el contenedor de la nueva fila
            materialRow.innerHTML = `
        <div class="row mt-2">
            <div class="col-md-7"></div> <!-- Aquí insertaremos el select clonado -->
            <div class="col-md-3">
                <input type="number" name="quantities[]" class="form-control" placeholder="Cantidad">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-material">Eliminar</button>
            </div>
        </div>
    `;

            // Insertar el select clonado en el div correspondiente
            materialRow.querySelector('.col-md-7').appendChild(materialSelect);

            // Agregar la nueva fila al contenedor
            materialsSection.appendChild(materialRow);

            // Agregar el evento de eliminación a los nuevos botones
            addRemoveMaterialEvent(materialRow);
        });

        // Función para agregar el evento de eliminación a los botones de "Eliminar"
        function addRemoveMaterialEvent(materialRow) {
            materialRow.querySelector('.remove-material').addEventListener('click', function() {
                materialRow.remove();
            });
        }

        // Aplicar el evento a la primera fila existente si es necesario
        document.querySelectorAll('.material-row').forEach(function(row) {
            addRemoveMaterialEvent(row);
        });

        // Validar el formulario antes de enviarlo
        document.getElementById('change-editordertec-form').addEventListener('submit', function(event) {
            let valid = true;
            document.querySelectorAll('select[name="materials[]"]').forEach(function(select) {
                if (select.value === '') {
                    valid = false;
                    alert('Debe seleccionar un material');
                }
            });
            document.querySelectorAll('input[name="quantities[]"]').forEach(function(input) {
                if (input.value === '' || input.value <= 0) {
                    valid = false;
                    alert('Debe ingresar una cantidad válida para cada material');
                }
            });
            if (!valid) {
                event.preventDefault(); // Evita el envío si no es válido
            }
        });
    </script>
</body>

</html>