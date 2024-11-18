 <?php
    if (isset($_SESSION['user'])) {
        if (isset($_GET['buscar'])) {
            require "../../acnxerdm/cnxplz.php";

            $cnx = conexion('implementtaTecateA');

            $cuenta = $_GET['cuenta'];
            $sql_datos = "select top 1 Cuenta,Propietario
            from implementta as i where i.Cuenta='$cuenta'";

            $cnx_datos = sqlsrv_query($cnx, $sql_datos);
            $array_datos = sqlsrv_fetch_array($cnx_datos);
            // CONSULTAR SI LA CUENTA TIENE UN PDF GENERADO
            $sql_pdf = "select cuenta from acuerdoInicio where cuenta='$cuenta'";
            $cnx_pdf = sqlsrv_query($cnx, $sql_pdf);
            $pdf = sqlsrv_fetch_array($cnx_pdf);
        }
    ?>
     <!DOCTYPE html>
     <html>



     <head>
         <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>Tecate Agua</title>
         <!-- Bootstrap -->
         <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
         </script>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha384-DyZ88mC6Up2uqS0ObZWp3uc81CKGoZ48j8ag5l29Y9wz75gCaFqKf5f5r77B7HT2" crossorigin="anonymous">
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
         <div class="container">
             <form action="" method="get">

                 <h2 style="text-shadow: 0px 0px 2px #717171;">Acuerdo de Inicio</h2>
                 <h4 style="text-shadow: 0px 0px 2px #717171;"><img src="https://img.icons8.com/color/40/000000/signing-a-document.png" /> Municipio de Tecate Agua</h4>
                 <hr>




                 <div class="card">
                     <div class="card-header">
                         <h5 style="text-shadow: 0px 0px 2px #717171;">Generar formato</h5>
                     </div>
                     <div class="card-body">
                         <blockquote class="blockquote mb-0">
                             <div class="form-row">
                                 <div class="col-md-6">
                                     <img src="https://img.icons8.com/external-sbts2018-outline-color-sbts2018/40/000000/external-search-ecommerce-basic-1-sbts2018-outline-color-sbts2018.png" /> Buscar cuenta
                                 </div>
                                 <div class="col-md-6">
                                     <div class="justify-content-center justify-content-md-center">
                                         <div class="input-group col-md-12">
                                             <input type="text" class="form-control border border-secondary"
                                                 placeholder="Buscar cuenta predial o propietario"
                                                 name="cuenta"
                                                 id="busqueda"
                                                 value="<?php echo isset($_GET['cuenta']) ? $_GET['cuenta'] : ''; ?>"
                                                 required autofocus>
                                             <div class="input-group-append">
                                                 <button type="submit" name="buscar" class="btn btn-info">
                                                     <img src="https://img.icons8.com/ios/20/search--v1.png" />
                                                 </button>
                                             </div>
                                         </div>

                                     </div>
                                 </div>
                             </div>
                         </blockquote>
                     </div>
                 </div>
                 <br><br>
             </form>
             <?php if (isset($array_datos)) { ?>
                 <table class="table table-hover table-sm">
                     <thead class="thead-dark">
                         <tr>
                             <th scope="col" style="text-align:center;">Cuenta Predial</th>
                             <th scope="col" style="text-align:center;">Propietario</th>
                             <th scope="col" style="text-align:center;">Opciones</th>
                         </tr>
                     </thead>
                     <tbody>

                         <tr>
                             <td style="text-align:center;"><?php echo $array_datos['Cuenta'] ?></td>
                             <td style="text-align:center;"><?php echo $array_datos['Propietario'] ?></td>
                             <td style="text-align:center;">
                                 <form action="" method="post">
                                     &nbsp;
                                     <a href="form?cta=<?php echo $array_datos['Cuenta'] ?>" class="btn btn-outline-dark btn-sm" style="padding:0%;border:0px;" data-toggle="tooltip" data-placement="right" title="Formato Acuerdo de Inicio"><img src="https://img.icons8.com/fluency/30/000000/general-ledger.png" />Acuerdo Inicio&nbsp;</a>

                                     <!-- si la cunsulta pdf trae algo entonses muestra el boton del pdf generado -->
                                     <?php if (isset($pdf)) { ?>
                                         <a class="btn btn-outline-dark btn-sm" target="_blank" href="acuerdoInicio.php?cta=<?php echo $pdf['cuenta'] ?>" style="padding:0%;border:0px;" data-toggle="tooltip" data-placement="right" title="Pdf generados" name="pdf">
                                             <img src="https://img.icons8.com/fluency/30/null/pdf.png" />
                                             Formato Generado</a>
                                     <?php } ?>
                                 </form>
                             </td>
                         </tr>

                     </tbody>
                 </table>

             <?php } else if (isset($_GET['buscar'])) { ?>
                 <div class="alert alert-info" role="alert">
                     <img src="https://img.icons8.com/fluency/40/000000/about.png" /> No se encontró la cuenta <b>"<?php echo $_GET['cuenta'] ?>"</b>
                 </div>
             <?php
                } ?>


             <br>


             <br><br>
         </div>
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

     </html>

 <?php
    } else {
        echo '<meta http-equiv="refresh" content="1,url=https://gallant-driscoll.198-71-62-113.plesk.page/implementta/login.php">';
    }
    ?>