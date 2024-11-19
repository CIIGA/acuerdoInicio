<?php
session_start();
if (isset($_SESSION['user'])) {
    if (isset($_GET['cta'])) {
        require "../../acnxerdm/cnxplz.php";

        $cnx = conexion('implementtaTecateA');

        $cuenta = $_GET['cta'];


        // validamos si ya tiene un acuerdo
        $sql_count = sqlsrv_query($cnx, "select count(cuenta) as c from acuerdoInicio where cuenta='$cuenta'");
        $array_count = sqlsrv_fetch_array($sql_count);
        $count = $array_count['c'];

        if ($count > 0) {
            $da = "select * from acuerdoInicio where cuenta='$cuenta'";
            $dat = sqlsrv_query($cnx, $da);
            $datos = sqlsrv_fetch_array($dat);
        } else {
            $da = "select top 1 Propietario as nombre,SerieMedidor as medidor,
        concat('CALLE ',Calle,' #',NumExt,' COLONIA ',Colonia,' TECATE') as domicilio
        from implementta where cuenta='$cuenta'";
            $dat = sqlsrv_query($cnx, $da);
            $datos = sqlsrv_fetch_array($dat);
        }








?>

        <!DOCTYPE html>
        <html>

        <?php
        //  if(isset($_SESSION['user']) ) { 
        ?>

        <head>
            <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Tecate Agua</title>
            <!-- Bootstrap -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
            </script>
            <link rel="icon" href="../../img/implementtaIcon.png">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
            <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-material-ui/material-ui.css" id="theme-styles">

            <style>
                body {
                    background-image: url(../../img/back.jpg);
                    background-repeat: repeat;
                    background-size: 100%;
                    background-attachment: fixed;
                    overflow-x: hidden;
                    /* ocultar scrolBar horizontal*/
                }

                body {
                    font-family: sans-serif;
                    font-style: normal;
                    font-weight: normal;
                    width: 100%;
                    height: 100%;
                    margin-top: -1%;
                    margin-bottom: 0%;
                    padding-top: 0px;
                }

                .tableFormat {
                    width: 100%;
                    font-family: arial;
                    font-size: 12px;
                }
            </style>

            <!--********************************INICIO NAVBAR***************************************************************-->

            <br>
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="#"><img src="../../img/logoImplementtaHorizontal.png" width="250" height="82" alt=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <!-- <a class="nav-item nav-link" href="../"> Inicio </a> -->

                        <!-- <a class="nav-item nav-link" href="https://gallant-driscoll.198-71-62-113.plesk.page/implementta/modulos/Administrador/logout.php"> Salir <i class="fas fa-sign-out-alt"></i></a> -->

                    </ul>

                </div>
            </nav>
            <!--*************************************NAVBAR*************************************************************-->

        </head>

        <body>
            <?php if (!$datos) { ?>
                <script>
                    Swal.fire({
                        icon: 'error',

                        text: 'no se encontraron datos de esta cuenta en implementta.',
                        showConfirmButton: true,


                    })
                </script>
            <?php } ?>

            <?php if (isset($_GET['errp'])) { ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de parametros',
                        text: 'No se estan recibiendo los datos necesarios, intente nuevamente y si el problema persiste, comuníquese con soporte.',
                        showConfirmButton: true,
                    })
                </script>
            <?php } ?>
            <?php if (isset($_GET['erri'])) { ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de inserción',
                        text: 'Hubo un error al insertar los datos, intente nuevamente y si el problema persiste, comuníquese con soporte.',
                        showConfirmButton: true,
                    })
                </script>
            <?php } ?>

            <?php if ($datos) { ?>
                <div class=" row">

                    <div class="container col-md-11">
                        <div class="mt-4">
                            <h2 style="text-shadow: 0px 0px 2px #717171;"><img src="https://img.icons8.com/color/47/null/signature.png" />
                                Acuerdo de Inicio</h2>
                            <h4 style="text-shadow: 0px 0px 2px #717171;">Tecate Agua</h4>
                        </div>
                        <hr>
                        <div class="p-1 mx-auto">
                            <form action="procesarAcuerdo.php" method="post">
                                <!-- contenedor 1 -->
                                <div class="p-2 rounded-4 col-md-12" style=" background-color: #E8ECEF; border: inherit;">
                                    <div class="text-white m-2 align-items-end" style="text-align:right;">
                                        <span class="badge badge-pill badge-success"><img src="https://img.icons8.com/fluency/30/000000/user-manual.png" />Datos
                                            Generales</span>
                                    </div>
                                    <div class="row align-items-start form-row">
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="fecha" class="form-label mb-2">Fecha del acuerdo*</label>
                                                <input type="date" class="form-control mb-2" value="<?php echo isset($datos['fecha']) ? $datos['fecha'] : date('Y-m-d') ?>" id="fecha" name="fecha" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="cuenta" class="form-label mb-2">Cuenta:*</label>
                                                <input type="text" value="<?php echo $cuenta ?>" class="form-control mb-2" id="cuenta" name="cuenta" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="n_exp" class="form-label mb-2">Numero de expediente:*</label>
                                                <div class="input-group mb-6">
                                                    <input type="text" class="form-control mb-2" value="CESPTE/CL/" readonly>
                                                    <input type="number" value="<?php echo isset($datos['n_exp']) ? $datos['n_exp'] : '' ?>" class="form-control mb-2" id="n_exp" name="n_exp" required>
                                                    <input type="number" value="<?php echo isset($datos['anio_exp']) ? $datos['anio_exp'] : date('Y') ?>" class="form-control mb-2" id="anio_exp" name="anio_exp" required>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- linea 2 -->
                                    <div class="row align-items-start form-row">
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="nombre" class="form-label mb-2">Contribuyente:*</label>
                                                <input type="text" value="<?php echo utf8_encode($datos['nombre']) ?>" class="form-control mb-2" id="nombre" name="nombre" required>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="md-form form-group">
                                                <label for="domicilio" class="form-label mb-2">Domicilio:*</label>
                                                <input type="text" value="<?php echo utf8_encode($datos['domicilio']) ?>" class="form-control mb-2" id="domicilio" name="domicilio" required>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- linea 3 -->
                                    <div class="row align-items-start form-row">
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="medidor" class="form-label mb-2">Medidor:*</label>
                                                <input type="text" value="<?php echo isset($datos['medidor']) ? $datos['medidor'] : '' ?>" class="form-control mb-2" id="medidor" name="medidor" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="cantidad" class="form-label mb-2">Cantidad:*</label>
                                                <input type="number" value="<?php echo isset($datos['cantidad']) ? $datos['cantidad'] : '' ?>" class="form-control mb-2" id="cantidad" name="cantidad" step="any" min="0" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="md-form form-group">
                                                <label for="tipo" class="form-label mb-2">Tipo de comercio:*</label>
                                                <input type="text" value="<?php echo isset($datos['tipoc']) ? $datos['tipoc'] : '' ?>" class="form-control mb-2" id="tipoc" name="tipoc" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-row p-4">
                                    <div class="col">
                                        <div style="text-align:right;">
                                            <a href="javascript:history.back(-1);" class="btn btn-dark btn-sm"><img src="https://img.icons8.com/fluency/30/null/cancel.png" />
                                                Cancelar</a>
                                            <button type="submit" target="_blank" class="btn btn-primary btn-sm"><img src="https://img.icons8.com/fluency/30/null/pdf.png" />
                                                Generar Formato</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </body>

        <nav class="navbar sticky-bottom navbar-expand-lg">
            <span class="navbar-text" style="font-size:12px;font-weigth:normal;color: #7a7a7a;">
                Implementta ©<br>
                Estrategas de México <i class="far fa-registered"></i><br>
                Centro de Inteligencia Informática y Geografía Aplicada CIIGA
                <hr style="width:105%;border-color:#7a7a7a;">
                Created and designed by <i class="far fa-copyright"></i> <?php echo date('Y') ?> Estrategas de México<br>
            </span>
            <hr>
            <span class="navbar-text" style="font-size:12px;font-weigth:normal;color: #7a7a7a;">
                Contacto:<br>
                <i class="fas fa-phone-alt"></i> Red: 187<br>
                <i class="fas fa-phone-alt"></i> 66 4120 1451<br>
                <i class="fas fa-envelope"></i> sistemas@estrategas.mx<br>
            </span>
            <ul class="navbar-nav mr-auto">
                <br><br><br><br><br><br><br><br>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <a href="#"><img src="../../img/logoImplementta.png" width="155" height="150" alt=""></a>
                <a href="http://estrategas.mx/" target="_blank"><img src="../../img/logoTop.png" width="200" height="85" alt=""></a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </form>
        </nav>



<?php
    } else {
        echo '<meta http-equiv="refresh" content="1,url=./">';
    }
} else {
    echo '<meta http-equiv="refresh" content="1,url=https://gallant-driscoll.198-71-62-113.plesk.page/implementta/login.php">';
}
?>

        </html>