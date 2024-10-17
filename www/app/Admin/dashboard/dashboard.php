<?php
session_start();

// Verificación de sesión
if ($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
    if ($_SESSION['user_idRol'] != 1) {
        header("Location:../../includes/404/404.php");
    }
    $rEmail = $_SESSION['mail'];
    $rolUser = $_SESSION['user_role'];
} else {
    echo "<script> location.href='../../login.php'; </script>";
}

define('TITLE', 'Dashboard Admin');
define('PAGE', 'dashboard admin');

include('../../includes/header.php');
include('../../dbConnection.php');
include('../../Querys/querys.php');

// Consulta para contar órdenes de la semana
$sql = SQL_COUNT_ORDERS_WITH_STATE_WEEK;
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $confirmadas = $row['confirmadas'];
    $pendientes = $row['pendientes'];
    $realizadas = $row['realizadas'];
    $totalordenes = $row['total_orders'];
    $criticas = $row['criticas'];
    $porcentaje_pendientes = $row['porcentaje_pendientes'];
    $porcentaje_realizadas = $row['porcentaje_realizadas'];
    $porcentaje_criticas = $row['porcentaje_criticas'];
} else {
    $confirmadas = $pendientes = $realizadas = $totalordenes = $criticas = 0;
}
?>

<div id="wrapper">
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <?php include('../../includes/menu.php'); ?>
        </div>
    </nav>

    <div id="page-wrapper" class="gray-bg">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i class="fa fa-bars"></i></a>
                </div>
            </nav>
        </div>

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-lg-12">
                <h2>Inicio</h2>
                <ol class="breadcrumb">
                        <li class="active">
                            <strong>Inicio</strong>
                        </li>
                        <li>
                            <a href="../crudorders/order.php">Órdenes de Trabajo</a>
                        </li>
                        <li>
                            <a href="../crudusers/users.php">Miembros</a>
                        </li>
                        <li>
                            <a href="../crudmaterials/materials.php">Tienda</a>
                        </li>
                    </ol>
            </div>
        </div>

        <!-- Contenedores de resumen de órdenes -->
        <div class="row text-center">
            <?php
            $ordenes = [
                ['label' => 'Órdenes Pendientes', 'valor' => $pendientes, 'color' => 'warning', 'porcentaje' => $porcentaje_pendientes],
                ['label' => 'Órdenes Urgentes', 'valor' => $criticas, 'color' => 'danger', 'porcentaje' => $porcentaje_criticas],
                ['label' => 'Órdenes Realizadas', 'valor' => $realizadas, 'color' => 'primary', 'porcentaje' => $porcentaje_realizadas],
            ];

            foreach ($ordenes as $orden) {
                echo "
                <div class='col-lg-4 col-md-6'>
                    <div class='ibox float-e-margins'>
                        <div class='ibox-title'>
                            <span class='label label-{$orden['color']} pull-right'>Semanal</span>
                            <h5>{$orden['label']}</h5>
                        </div>
                        <div class='ibox-content'>
                            <h1 class='no-margins' style='font-size: 3rem; font-weight: bold;'>{$orden['valor']}</h1>
                            <div class='stat-percent font-bold text-{$orden['color']}'>{$orden['porcentaje']}% <i class='fa fa-level-up'></i></div>
                            <small>Total de {$orden['label']}</small>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>

        <!-- Contenedores de las listas de órdenes -->
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row justify-content-center">
                <?php
                // Consulta para obtener órdenes
                $stmt = $conn->prepare(SQL_ALL_ORDERS_WEEK);
                $stmt->execute();
                $result = $stmt->get_result();

                $pendientes = [];
                $completas = [];
                $urgentes = [];

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Primero traigo las órdenes Realizadas
                        if ($row['state_order'] == 'Realizada') {
                            $completas[] = $row;
                        } else {
                            // Luego clasifico las órdenes Pendientes según la prioridad
                            if ($row['state_order'] == 'Pendiente' && $row['priority'] == 'Normal') {
                                $pendientes[] = $row;
                            } elseif ($row['state_order'] == 'Pendiente' && $row['priority'] == 'Urgente') {
                                $urgentes[] = $row;
                            } else {
                                // Nada
                            }
                        }
                    }
                }
                ?>

                <?php
                // Definir las listas de órdenes
                $listas_ordenes = [
                    ['title' => 'Pendientes', 'items' => $pendientes, 'class' => 'warning'],
                    ['title' => 'Urgentes', 'items' => $urgentes, 'class' => 'danger'],
                    ['title' => 'Realizadas', 'items' => $completas, 'class' => 'success'],
                ];

                foreach ($listas_ordenes as $lista) {
                    echo "
                    <div class='col-lg-4 col-md-6 mb-4'>
                        <div class='ibox'>
                            <div class='ibox-content'>
                                <h3>{$lista['title']}</h3>
                                <ul class='sortable-list connectList agile-list'>";
                    foreach ($lista['items'] as $row) {
                        echo "
                                    <li class='{$lista['class']}-element' id='task{$row['id_order']}' style='cursor: default;'>
                                        <strong>Orden: </strong>{$row['id_order']}<br>
                                        <strong>Descripción: </strong>{$row['order_description']}<br>
                                        <strong>Fecha: </strong>" . date('d/m/Y', strtotime($row['order_date'])) . "
                                    </li>";
                    }
                    echo "
                                </ul>
                            </div>
                        </div>
                    </div>";
                }
                ?>
            </div>
        </div>
        <div class="footer">
                <div class="pull-right">
                </div>
                <div>
                    <strong>Copyright</strong> Telistema &copy; 2024
                </div>
        </div>
    </div>
</div>

<?php include('../../includes/footer.php'); ?>
</body>
</html>