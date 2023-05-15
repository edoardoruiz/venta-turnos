<?php
include('inc/header.php');
?>
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<link rel="stylesheet" href="css/dataTables.bootstrap.min.css" />
<script src="js/common.js"></script>
<?php include('inc/container.php'); ?>
<div class="container">
	<?php include("menus.php"); ?>
	<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Devotos Inscritos</h2>
                    </div>
                    <a href="plantilla.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Exportar a Excel</a>
                    <?php
                    // Include config file
                    require_once "config.php";
                    
                    // Attempt select query execution
                    $sql = "SELECT devoto.ID, devoto.DPI, devoto.Fecha_compra, devoto.Primer_nombre, devoto.Primer_apellido, turno.Turno, devoto.Cantidad * turno.Precio as Total from devoto Inner join Turno on devoto.ID_turno = turno.ID order by ID desc;
                    ";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>DPI</th>";
                                        echo "<th>Fecha</th>";
                                        echo "<th>Primer Apellido</th>";
                                        echo "<th>Primer Nombre</th>";
                                        echo "<th>Total</th>";
                                        echo "<th>Turno</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['ID'] . "</td>";
                                        echo "<td>" . $row['DPI'] . "</td>";
                                        echo "<td>" . $row['Fecha_compra'] . "</td>";
                                        echo "<td>" . $row['Primer_nombre'] . "</td>";
                                        echo "<td>" . $row['Primer_apellido'] . "</td>";
                                        echo "<td>" . $row['Total'] . "</td>";
                                        echo "<td>" . $row['Turno'] . "</td>";
										echo "<td>";
                                            echo '<a href="pdf.php?id='. $row['ID'] .'&DPI='. $row['DPI'] .'&Turno='. $row['Turno'] .' " class="mr-3" title="Print Record" data-toggle="tooltip" target="_blank"><span class="fa fa-print"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    // Close connection
                    mysqli_close($link);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
<?php include('inc/footer.php'); ?>
