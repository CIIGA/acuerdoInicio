<?php
function convertirNumeroALetras($numero) {
    $numeros = [
        0 => "cero", 1 => "uno", 2 => "dos", 3 => "tres", 4 => "cuatro", 5 => "cinco",
        6 => "seis", 7 => "siete", 8 => "ocho", 9 => "nueve", 10 => "diez",
        11 => "once", 12 => "doce", 13 => "trece", 14 => "catorce", 15 => "quince",
        16 => "dieciséis", 17 => "diecisiete", 18 => "dieciocho", 19 => "diecinueve", 20 => "veinte",
        21 => "veintiuno", 22 => "veintidós", 23 => "veintitrés", 24 => "veinticuatro", 25 => "veinticinco",
        26 => "veintiséis", 27 => "veintisiete", 28 => "veintiocho", 29 => "veintinueve", 30 => "treinta",
        31 => "treinta y uno"
    ];
    return $numeros[$numero] ?? $numero;
}

function convertirAnoALetras($ano) {
    $anos = [
        2023 => "dos mil veintitrés",
        2024 => "dos mil veinticuatro",
        2025 => "dos mil veinticinco"
    ];
    return $anos[$ano] ?? $ano;
}

// Función para formatear la fecha en el primer formato
function formatearFechaCompleta($fecha) {
    $timestamp = strtotime($fecha);
    $dia = convertirNumeroALetras(date("j", $timestamp));
    $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    $mes = $meses[date("n", $timestamp) - 1];
    $ano = convertirAnoALetras(date("Y", $timestamp));
    return "$dia días del mes de $mes del año $ano";
}

// Función para formatear la fecha en el segundo formato
function formatearFechaCorta($fecha) {
    $timestamp = strtotime($fecha);
    $dia = date("j", $timestamp);
    $meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
    $mes = $meses[date("n", $timestamp) - 1];
    $ano = date("Y", $timestamp);
    return "$dia de $mes del $ano";
}


?>
