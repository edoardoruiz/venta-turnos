<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$DPI = $dpi = $primernombre = $segundonombre = $primerapellido = $segundoapellido = $idturno = $cantidad = $disponibilidad = $total = $idprecio = "";
$DPI_err = $primernombre_err = $segundonombre_err = $primerapellido_err = $segundoapellido_err = $idturno_err = $cantidad_err = $fecha_err = "";
$fecha = date('Y-m-d');
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
   
    $input_dpi = trim($_POST["DPI"]);
    $dpi = $input_dpi;
   
    $input_pnombre = trim($_POST["primernombre"]);
    if(empty($input_pnombre)){
        $primernombre_err = "Por favor ingresa un nombre.";
    } elseif(!filter_var($input_pnombre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $primernombre_err = "Por favor ingresa un nombre válido.";
    } else{
        $primernombre = $input_pnombre;
    }

    $input_snombre = trim($_POST["segundonombre"]);
    $segundonombre = $input_snombre;


    $input_papellido = trim($_POST["primerapellido"]);
    if(empty($input_papellido)){
        $primerapellido_err = "Por favor ingresa un apellido.";
    } elseif(!filter_var($input_papellido, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $primerapellido_err= "Por favor ingresa un apellido válido.";
    } else{
        $primerapellido = $input_papellido;
    }

    $input_saepllido = trim($_POST["segundoapellido"]);
    $segundoapellido = $input_saepllido;
    
    $input_turno = trim($_POST["Turno"]);
    $idturno = $id;

    $input_cantidad = trim($_POST["cantidad"]);
    if(empty($input_cantidad)){
        $cantidad_err = "Por favor ingresa una cantidad.";     
    } elseif(!ctype_digit($input_cantidad)){
        $cantidad_err = "Por favor ingresa una cantidad válida.";
    } else{
        $cantidad = $input_cantidad;
    }

     
    // Check input errors before inserting in database
    if(empty($primernombre_err) && empty($cantidad_err) && empty($primerapellido_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO devoto (DPI, Primer_nombre, Segundo_Nombre, Primer_apellido, Segundo_apellido, ID_turno, Cantidad, Fecha_Compra) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssiis", $param_dpi, $param_pnombre, $param_snombre, $param_papellido, $param_sapellido, $param_turno, $param_cantidad, $param_fecha);
            
            $param_dpi = $dpi;
            $param_pnombre = $primernombre;
            $param_snombre = $segundonombre;
            $param_papellido = $primerapellido;
            $param_sapellido = $segundoapellido;
            $param_turno = $idturno;
            $param_cantidad = $cantidad;
            $param_fecha = $fecha;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            
        }

        if((empty($primernombre_err) && empty($cantidad_err) && empty($primerapellido_err))){
            
            // Prepare an update statement
            $sql = "UPDATE turno SET Disponibilidad = Disponibilidad - ? WHERE ID=?";
             
            if($stmtUpdate = mysqli_prepare($link, $sql)){

                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmtUpdate, "ii", $cantidad, $idturno);
                                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmtUpdate)){
                    // Records updated successfully. Redirect to landing page
                    header("location: devoto.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmtUpdate);
    }
    // Close connection
    mysqli_close($link);
}else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM turno WHERE ID = ?";
        if($stmtget = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmtget, "i", $id);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmtget)){
                $result = mysqli_stmt_get_result($stmtget);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $idturno = $row["Turno"];
                    $idprecio = $row["Precio"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmtget);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Venta de turno</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Venta de Turno</h2>
                    <p>Por favor llena esta información para grabarlo dentro de la base de datos.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label>DPI</label>
                            <input type="text" name="DPI" class="form-control <?php echo (!empty($DPI_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $DPI; ?>">
                            <span class="invalid-feedback"><?php echo $DPI_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="primernombre" class="form-control <?php echo (!empty($primernombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $primernombre; ?>">
                            <span class="invalid-feedback"><?php echo $primernombre_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Segundo Nombre</label>
                            <input type="text" name="segundonombre" class="form-control <?php echo (!empty($segundonombre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $segundonombre; ?>">
                            <span class="invalid-feedback"><?php echo $segundonombre_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Primer Apellido</label>
                            <input type="text" name="primerapellido" class="form-control <?php echo (!empty($primerapellido_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $primerapellido; ?>">
                            <span class="invalid-feedback"><?php echo $primerapellido_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Segundo Apellido</label>
                            <input type="text" name="segundoapellido" class="form-control <?php echo (!empty($segundoapellido_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $segundoapellido; ?>">
                            <span class="invalid-feedback"><?php echo $segundoapellido_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Turno</label>
                            <input type="text" disabled=»disabled name="turno" class="form-control <?php echo (!empty($idturno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idturno; ?>">
                            <span class="invalid-feedback"><?php echo $idturno_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Cantidad</label>
                            <input type="text" name="cantidad" class="form-control <?php echo (!empty($cantidad_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $cantidad; ?>">
                            <span class="invalid-feedback"><?php echo $cantidad_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Precio</label>
                            <input type="text" disabled=»disabled name="precio" class="form-control <?php echo (!empty($idturno_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idprecio; ?>">
                            <span class="invalid-feedback"><?php echo $idturno_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>