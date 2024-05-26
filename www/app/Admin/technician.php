<?php
session_start();
////////////////////////////////
if($_SESSION['is_login'] && $_SESSION['state_user'] == 'activo') {
  if($_SESSION['user_role'] != 'admin') {
      echo "<script> location.href='../includes/404.php'; </script>";
  }
  $rEmail = $_SESSION['mail'];
  $rolUser = $_SESSION['user_role'];
 } else {
  echo "<script> location.href='../login.php'; </script>";
 }
////////////////////////////////

define('TITLE', 'Tecnicos');
define('PAGE', 'Tecnicos');
include('../includes/header.php'); 
include('../dbConnection.php');
include('../Querys/querys.php');

?>
<div class="col-sm-9 col-md-10 mt-5 text-center">
    <!--Table-->
    <p class=" bg-dark text-white p-2">Lista de Técnicos</p>
    <?php
    $sql = SQL_SELECT_TECHNIC;
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Imprimir etiquetas de encabezado una vez
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th scope="col">ID Técnico</th>';
        echo '<th scope="col">Nombre</th>';
        echo '<th scope="col">Teléfono</th>';
        echo '<th scope="col">Email</th>';
        echo '<th scope="col">Estado</th>';
        echo '<th scope="col">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        // Imprimir los datos de cada técnico
        while ($row = $result->fetch_assoc()) {
            $state = $row['id_state_user'];
            $stmt = $conn->prepare(SQL_SELECT_STATE_BY_ID);
            $stmt->bind_param("i", $state);
            $stmt->execute();
            $result_state = $stmt->get_result();

            // Verificar si hay resultados
            if ($result_state->num_rows > 0) {
                // Obtener la fila como un array asociativo
                $row_state = $result_state->fetch_assoc();
                $name_state = $row_state["state_user"];
            } else {
                // Si no hay resultados, asignar un valor por defecto
                $name_state = "Estado no encontrado"; // O el valor que desees
            }

            echo '<tr>';
            echo '<th scope="row">'.$row["id_user"].'</th>';
            echo '<td>'. $row["name_user"].'</td>';
            echo '<td>'.$row["phone_user"].'</td>';
            echo '<td>'.$row["mail"].'</td>';
            echo '<td>'.$name_state.'</td>';
            echo '<td>
                <form action="editemp.php" method="POST" class="d-inline"> 
                    <input type="hidden" name="id_user" value='. $row["id_user"] .'>
                    <button type="submit" class="btn btn-info mr-3" name="view" value="View">
                        <i class="fas fa-pen"></i>
                    </button>
                </form>  
                <form action="" method="POST" class="d-inline">
                    <input type="hidden" name="id_user" value='. $row["id_user"] .'>
                    <button type="submit" class="btn btn-secondary" name="delete" value="Eliminar">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </form>
            </td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo "0 Result";
    }
    ?>
</div>

<div><a class="btn btn-danger box" href="insertemp.php"><i class="fas fa-plus fa-2x"></i></a></div>

<?php
include('../includes/footer.php'); 
?>