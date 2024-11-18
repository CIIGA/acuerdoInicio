<?php
$cuenta = $_POST['cuenta'];
if (
    isset(
        $_POST['fecha'],
        $_POST['n_exp'],
        $_POST['anio_exp'],
        $_POST['nombre'],
        $_POST['domicilio'],
        $_POST['medidor'],
        $_POST['cantidad'],
        $_POST['tipoc']
    )
    and !empty($_POST['fecha'])
    and !empty($_POST['n_exp'])
    and !empty($_POST['anio_exp'])
    and !empty($_POST['nombre'])
    and !empty($_POST['domicilio'])
    and !empty($_POST['medidor'])
    and !empty($_POST['cantidad'])
    and !empty($_POST['tipoc'])
) {
    require "../../acnxerdm/cnxplz.php";
    $cnx = conexion('implementtaTecateA');

    $fecha = $_POST['fecha'];
    $n_exp = $_POST['n_exp'];
    $anio_exp = $_POST['anio_exp'];
    $nombre = $_POST['nombre'];
    $domicilio = $_POST['domicilio'];
    $medidor = $_POST['medidor'];
    $cantidad = $_POST['cantidad'];
    $tipoc = $_POST['tipoc'];

    $sql_delete_cuenta = sqlsrv_query($cnx, "delete from acuerdoInicio where cuenta='$cuenta");

    $sql_insert = sqlsrv_query($cnx, "insert into acuerdoInicio values 
    ('$cuenta','$fecha','$n_exp','$anio_exp','$nombre','$domicilio','$medidor','$cantidad','$tipoc')");

    if ($sql_insert === false) {
        header("Location: form.php?cta=$cuenta&erri");
        exit;
    }
    echo '<meta http-equiv="refresh" content="0,url=./">';
    echo '<script type="text/javascript">window.open("./acuerdoInicio.php?cta=' . $cuenta . '");</script>';
} else {
    header("Location: form.php?cta=$cuenta&errp");
}
