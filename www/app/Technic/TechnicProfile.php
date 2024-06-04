<?php
session_start();
define('TITLE', 'Technic Profile');
define('PAGE', 'Technic Profile');
include ('../dbConnection.php');

if ($_SESSION['is_login']) {
    $rEmail = $_SESSION['mail'];
} else {
    echo "<script> location.href='../login.php'; </script>";
}

$sql = "SELECT * FROM TechnicLogin_tb WHERE r_email='$rEmail'";
$result = $conn->query($sql);
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $rName = $row["r_name"];
}

if (isset($_REQUEST['nameupdate'])) {
    if (($_REQUEST['rName'] == "")) {
        // msg displayed if required field missing
        $passmsg = '<div class="alert alert-warning col-sm-6 ml-5 mt-2" role="alert"> Fill All Fileds </div>';
    } else {
        $rName = $_REQUEST["rName"];
        $sql = "UPDATE TechnicLogin_tb SET r_name = '$rName' WHERE r_email = '$rEmail'";
        if ($conn->query($sql) == TRUE) {
            // below msg display on form submit success
            $passmsg = '<div class="alert alert-success col-sm-6 ml-5 mt-2" role="alert"> Updated Successfully </div>';
        } else {
            // below msg display on form submit failed
            $passmsg = '<div class="alert alert-danger col-sm-6 ml-5 mt-2" role="alert"> Unable to Update </div>';
        }
    }
}
?>
<?php
include ('../includes/header.php'); ?>

<body>

    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <?php
                include ('../includes/menu.php'); ?>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">

            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" href="#"><i
                                class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="../logout.php">
                                <i class="fa fa-sign-out"></i> Cerrar Sección
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Perfil</h2>

                </div>
                <div class="col-lg-2">

                </div>
            </div>
            <div class="wrapper wrapper-content animated fadeInRight">


                <div class="row m-b-lg m-t-lg">
                    <div class="col-md-6">

                        <!-- <div class="profile-image">
                            <img src="img/a4.jpg" class="img-circle circle-border m-b-md" alt="profile">
                        </div> -->
                        <div class="profile-info">
                            <div class="">
                                <div>
                                    <h2 class="no-margins">
                                        Alex Smith
                                    </h2>
                                    <h4>Founder of Groupeq</h4>
                                    <small>
                                        There are many variations of passages of Lorem Ipsum available, but the majority
                                        have suffered alteration in some form Ipsum available.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <table class="table small m-b-xs">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>142</strong> Projects
                                    </td>
                                    <td>
                                        <strong>22</strong> Followers
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <strong>61</strong> Comments
                                    </td>
                                    <td>
                                        <strong>54</strong> Articles
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>154</strong> Tags
                                    </td>
                                    <td>
                                        <strong>32</strong> Friends
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-3">
                        <small>Sales in last 24h</small>
                        <h2 class="no-margins">206 480</h2>
                        <div id="sparkline1"></div>
                    </div>


                </div>


            </div>
            <div class="footer">
                <div class="pull-right">
                   
                </div>
                <div>
                    <strong>Copyright</strong>  Telistema &copy; 2024
                </div>
            </div>

        </div>
    </div>



    <?php
    include ('../includes/footer.php');
    ?>

    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <script>
        $(document).ready(function () {


            $("#sparkline1").sparkline([34, 43, 43, 35, 44, 32, 44, 48], {
                type: 'line',
                width: '100%',
                height: '50',
                lineColor: '#1ab394',
                fillColor: "transparent"
            });


        });
    </script>

</body>

</html>