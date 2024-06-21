<?php
session_start();
////////////////////////////////
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_role'] != 'admin') {
        echo "<script> location.href='../../includes/404.php'; </script>";
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}
////////////////////////////////

define('TITLE', 'Ordenes');
define('PAGE', 'Ordenes');
include('../../dbConnection.php');
include('../../Querys/querys.php');
include('../configsmtp/generate_config.php');
include('../../includes/header.php');

if (isset($_REQUEST['update'])) {
    if (($_POST['order_date'] == "") || ($_POST['order_hour'] == "")) {
        $msg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Complete los campos </div>';
    } else {
        $order_date = $_POST['order_date'];
        $order_hour = $_POST['order_hour'];
        $order_description = $_POST['order_description'];
        $order_server = $_POST['order_server'];
        $address = capitalizeWords($_POST['address']);
        $height = $_POST['height'];
        $floor = trim($_POST['floor']);
        $departament = trim($_POST['departament']);
        $id_client = $_POST['id_client'];
        $id_priority = trim($_POST['id_priority']);
        $id_material = trim($_POST['id_material']);
        $id_state_order = trim($_POST['id_state_order']);
        $technic_id = trim($_POST['technic_id']);
        $id_order = $_POST['id_order'];

        $sql = SQL_UPDATE_ORDER;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssisissiiiiii",
            $order_date,
            $order_hour,
            $order_description,
            $order_server,
            $address,
            $height,
            $floor,
            $departament,
            $id_client,
            $id_priority,
            $id_material,
            $id_state_order,
            $technic_id,
            $id_order
        );

        if ($stmt->execute()) {
            $msg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Actualizado con éxito </div>';
        } else {
            $msg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> No se pudo actualizar </div>';
        }
    }
}
if (isset($_REQUEST['view'])) {

    $id_order = $_REQUEST['id_order'];
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
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php include('../../includes/menu.php') ?>
            </div>
        </nav>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="login.html">
                                <i class="fa fa-sign-out"></i> Cerrar Sección
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Ordenes</h2>
                </div>
                <div class="col-lg-2">
                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="ibox float-e-margins">
                            <div class="ibox-title">
                                <h5>Actualizar Orden de Trabajo</h5>
                            </div>
                            <div class="ibox-content">
                                <form action="" method="POST">
                                    <div class="form-group">
                                        <label for="id_order">ID Orden</label>
                                        <input type="text" class="form-control" id="id_order" name="id_order" value="<?php if (isset($row['id_order'])) {
                                                                                                                            echo $row['id_order'];
                                                                                                                        } ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_client">Cliente</label>
                                        <input type="text" class="form-control" id="full_name_client" value="<?php if (isset($row['client_name']) && isset($row['client_lastname'])) {
                                                                                                                    echo $row['client_name'] . ' ' . $row['client_lastname'];
                                                                                                                } ?>" readonly>


                                    </div>
                                    <input type="hidden" name="id_client" value="<?php if (isset($row['id_client'])) {
                                                                                        echo $row['id_client'];
                                                                                    } ?>">

                                    <div class="form-group">
                                        <label for="order_date">Fecha</label>
                                        <input type="date" class="form-control" id="order_date" name="order_date" value="<?php if (isset($row['order_date'])) {
                                                                                                                                echo $row['order_date'];
                                                                                                                            } ?>">

                                    </div>
                                    <div class="form-group">
                                        <label for="order_hour">Hora</label>
                                        <input type="time" class="form-control" id="order_hour" name="order_hour" value="<?php if (isset($row['order_hour'])) {
                                                                                                                                echo $row['order_hour'];
                                                                                                                            } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_description">Descripcion</label>
                                        <input type="text" class="form-control" id="order_description" name="order_description" value="<?php if (isset($row['order_description'])) {
                                                                                                                                            echo $row['order_description'];
                                                                                                                                        } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="order_server">Servidor</label>
                                        <input type="number" class="form-control" id="order_server" name="order_server" value="<?php if (isset($row['order_server'])) {
                                                                                                                                    echo $row['order_server'];
                                                                                                                                } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Dirección</label>
                                        <input type="text" class="form-control" id="address" name="address" value="<?php if (isset($row['address'])) {
                                                                                                                        echo $row['address'];
                                                                                                                    } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="height">Altura</label>
                                        <input type="number" class="form-control" id="height" name="height" value="<?php if (isset($row['height'])) {
                                                                                                                        echo $row['height'];
                                                                                                                    } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="floor">Piso</label>
                                        <input type="text" class="form-control" id="floor" name="floor" value="<?php if (isset($row['floor'])) {
                                                                                                                    echo $row['floor'];
                                                                                                                } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="departament">Depatamento</label>
                                        <input type="text" class="form-control" id="departament" name="departament" value="<?php if (isset($row['departament'])) {
                                                                                                                                echo $row['departament'];
                                                                                                                            } ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="id_priority">Prioridad</label>
                                        <select name="id_priority" id="id_priority" class="form-control">
                                            <?php

                                            $priority = $row['id_priority'];
                                            $stmt = $conn->prepare(SQL_SELECT_PRIORITYS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $priority);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_priority = $result->fetch_assoc();
                                                $name_priority = $row_priority["priority"];
                                                $id_priority = $row_priority["id_priority"];
                                            }
                                            $stmt = $conn->prepare(SQL_SELECT_PRIORITYS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();

                                            foreach ($rows as $priority) {
                                                $priorityName = $priority["priority"];
                                                $priorityId = $priority["id_priority"];
                                                $selected = ($priorityId == $id_priority) ? "selected" : "";
                                                echo "<option value='$priorityId' $selected>$priorityName</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="id_material">Material</label>
                                        <select name="id_material" id="id_material" class="form-control">
                                            <?php

                                            $material = $row['id_material'];
                                            $stmt = $conn->prepare(SQL_SELECT_MATERIALS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $material);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_material = $result->fetch_assoc();
                                                $name_material = $row_material["material_name"];
                                                $id_material = $row_material["id_material"];
                                            }
                                            $stmt = $conn->prepare(SQL_SELECT_MATERIALS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();

                                            foreach ($rows as $material) {
                                                $materialName = $material["material_name"];
                                                $materialId = $material["id_material"];
                                                $selected = ($materialId == $id_material) ? "selected" : "";
                                                echo "<option value='$materialId' $selected>$materialName</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="technic_id">Tencnico Asignado</label>
                                        <select name="technic_id" id="technic_id" class="form-control">
                                            <?php

                                            $technic = $row['technic_id'];
                                            $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDER_BY_ID);
                                            $stmt->bind_param("i", $technic);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_technic = $result->fetch_assoc();
                                                $name_technic = $row_technic["name_user"];
                                                $id_technic = $row_technic["id_user"];
                                            }
                                            $stmt = $conn->prepare(SQL_SELECT_TECNS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();

                                            foreach ($rows as $technic) {
                                                $technicName = $technic["name_user"] . ' ' . $technic["surname_user"];
                                                $technicId = $technic["id_user"];
                                                $selected = ($technicId == $technic_id) ? "selected" : "";
                                                echo "<option value='$technicId' $selected>$technicName</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="state_order">Estado</label>
                                        <select name="id_state_order" id="id_state_order" class="form-control">
                                            <?php

                                            $state = $row['id_state_order'];
                                            $stmt = $conn->prepare(SQL_SELECT_STATE_ORDER_BY_ID);
                                            $stmt->bind_param("i", $state);
                                            $stmt->execute();
                                            $result = $stmt->get_result();

                                            if ($result->num_rows > 0) {
                                                $row_state = $result->fetch_assoc();
                                                $name_state = $row_state["state_order"];
                                                $id_state_order = $row_state["id_state_order"];
                                            }
                                            $stmt = $conn->prepare(SQL_SELECT_STATUS_ORDERS);
                                            $stmt->execute();
                                            $rows = $stmt->get_result();

                                            foreach ($rows as $state) {
                                                $stateName = $state["state_order"];
                                                $stateId = $state["id_state_order"];
                                                $selected = ($stateId == $id_state_user) ? "selected" : "";
                                                echo "<option value='$stateId' $selected>$stateName</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger" id="update" name="update">Actualizar</button>
                                        <a href="../crudclients/clients.php" class="btn btn-secondary">Cerrar</a>
                                    </div>
                                    <?php if (isset($msg)) {
                                        echo $msg;
                                    } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer">
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
            </div>
        </div>
    </div>
    <?php include('../../includes/footer.php'); ?>
</body>

</html>