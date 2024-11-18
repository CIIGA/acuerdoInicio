<?php
session_start();
set_time_limit(28800);
if (isset($_SESSION['user'])) {
    require "../../acnxerdm/cnxplz.php";

    $cnx = conexion('implementtaTecateA');
    $cuenta = $_GET['cta'];

    $da = "select * from acuerdoInicio where cuenta='$cuenta'";
    $dat = sqlsrv_query($cnx, $da);
    $datos = sqlsrv_fetch_array($dat);

    $total_numero = $datos['cantidad'];

    // Asegúrate de que la extensión `intl` esté habilitada en tu servidor.
    $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);

    // Separa la parte entera y la parte decimal
    $parteEntera = floor($total_numero);
    $parteDecimal = round(($total_numero - $parteEntera) * 100);

    // Convierte la parte entera a texto
    $textoEntero = strtoupper($formatter->format($parteEntera));

    // Formatea el texto final
    $total_texto = $textoEntero . ' PESOS';

    // Agrega la parte decimal si existe
    if ($parteDecimal > 0) {
        $textoCentavos = strtoupper($formatter->format($parteDecimal));
        $total_texto .= " CON $textoCentavos CENTAVOS";
    }

    // Añade el formato de centavos en fracción
    $total_texto .= ' ' . str_pad($parteDecimal, 2, '0', STR_PAD_LEFT) . "/100 MONEDA NACIONAL";


    require('functions.php');
    require('funciones_fecha.php');

    $fecha_larga = formatearFechaCompleta($datos['fecha']->format('Y-m-d'));
    $fecha_corta = formatearFechaCorta($datos['fecha']->format('Y-m-d'));

    $pdf = new PDF('P', 'mm', 'Letter');
    $pdf->SetAutoPageBreak(true, 20);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $archivo = rand(100, 999) . '_' . date('Ymd_His') . '.pdf';
    $pdf->SetTitle($archivo);



    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(196, 4, utf8_decode('ACUERDO DE INICIO'), 0, 'C', 0);
    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->CellDots(utf8_decode('Tecate, Baja California, a los ' . $fecha_larga . '.'));
    $pdf->Ln(1);
    $pdf->CellDots(utf8_decode(''));
    $pdf->Ln(5);


    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('VISTO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('           El estado que guarda en la Comisión Estatal de Servicios Públicos de Tecate, Baja California, la cuenta número ' . $datos['cuenta'] . ', a nombre de ' . $datos['nombre'] . ', con el número de medidor ' . $datos['medidor'] . ', en el domicilio que se ubica en ' . $datos['domicilio'] . ', de adeudos al no registrar pagos de los derechos de suministro de agua potable y alcantarillado sanitario, como se desprende de la constancia que emite la Comisión Estatal de Servicios Públicos de Tecate.'));

    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(196, 4, utf8_decode('C O N S I D E R A N D O'), 0, 'C', 0);
    $pdf->Ln(1);


    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('I.- COMPETENCIA.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('                           Con fundamento en los artículos 14 y 16 de la Constitución Política de los Estados Unidos Mexicanos; artículo 22 fracción II de la Ley de las Entidades Paraestatales del Estado de  Baja California; los artículos 1, 2 fracción V y Vll, 16 fracción I y VII, y 21 de la Ley de las Comisiones  Estatales de Servicios Públicos del Estado de Baja California, en relación con lo dispuesto por el artículo 2 y primer párrafo del artículo 3 fracciones I, II, lll y IV, así como los correlativos15, 16, 17, 59, 60, 96 fracción III y 101 de la Ley que Reglamenta el Servicio de Agua Potable en el Estado de Baja California; artículos 1, 2, 3, 11, 12 y 13 de la Ley del Procedimiento para los Actos de la Administración Pública; título cuarto, artículo 9, sección V y Vl inciso A) numeral 2 para ambas secciones de la Ley de Ingresos 2024 para el Estado de Baja California, y 1, 19 fracción XVl, XXlV, 21 fracción XlV, 43 inciso e, 44 Vlll, 48 fracción V, VII, lX y X del Reglamento Interno de la Comisión Estatal de Servicios Públicos de Tecate, la Subdirección Comercial de la Comisión Estatal de Servicios Públicos de Tecate, es competente para emitir el presente ACUERDO DE INICIO. '));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('II.-'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('    La Comisión Estatal de Servicios Públicos de Tecate, tiene como facultades la ejecución de las obras de captación, conducción y distribución de los Sistemas de Agua Potable para el servicio público de las población, así como, la operación, conservación, vigilancia y reparación de los Sistemas de Agua Potable y las obras de ampliación, de conformidad con los artículos 1° y 2° de la Ley que Reglamenta el Servicio de Agua Potable  en el Estado de Baja California, lo que realiza derivado de los ingresos que percibe dentro de los que se encuentra el pago de los usuarios por el servicio del agua y alcantarillado.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('III.-'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('      De conformidad con el artículo 2° de la Ley que Reglamenta el Servicio de Agua Potable en el Estado de Baja California, la Comisión Estatal tiene la facultad de recaudar los ingresos por la prestación de los servicios, además, del mismo numeral se desprende la competencia de la imposición de sanciones por infracción a las disposiciones de citada Ley.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('V.-'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('     De los registros que obran dentro de los archivos de esta Comisión Estatal se desprende          que el usuario ' . $datos['nombre'] . ', titular de la cuenta número ' . $datos['cuenta'] . ', ha omitido realizar el pago de los derechos de agua potable y alcantarillado sanitario, los cuales ascienden a la cantidad total de $' . number_format($datos['cantidad'], 2) . ' M.N (' . $total_texto . '), lo que se acredita de la constancia de fecha ' . $fecha_corta . ', emitida por la Comisión Estatal de Servicios Públicos de Tecate.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('VI.-'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('       Como se ha establecido la Comisión Estatal, es quien presta el servicio público de agua potable y alcantarillado a los usuarios con lo que suscribió un contrato, que para la prestación de este servicio se requiere el mantenimiento y obra de la red hidráulica, para mantenerlo en óptimas condiciones, para ello es de vital importancia la recaudación de los derechos de los servicios, pues su incumplimiento demerita las acciones de mejora y perjudica los servicios a los usuarios, máxime cuando se trata de industria y comercio, por ello, la Ley que Reglamenta el Servicio de Agua Potable en el Estado de Baja California, en su artículo 96 fracción III, establece que el incumplimiento de pago de las cuotas por servicio de agua por un mes o más, tratándose de giros mercantiles o industriales puede traer como consecuencia la clausura del negocio de conformidad con el artículo de la, que a la letra dice:'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetX(80);
    $pdf->MultiCell(126, 4, utf8_decode('"ARTICULO 96.- ...se podrá ordenar la clausura del negocio o la suspensión del servicio de agua:'), 0, 'J', 0);

    $pdf->Ln(3);
    $pdf->SetX(80);
    $pdf->MultiCell(126, 4, utf8_decode('III.- Por falta de pago de las cuotas por servicio de agua por un mes o más."'), 0, 'J', 0);


    $pdf->Ln(3);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('VII.-'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('       Al existir el registro de adeudo en los términos expuestos por falta de pago del servicio de agua potable y alcantarillado, se actualiza el supuesto previsto en el artículo 96 fracción III de la Ley que Reglamenta el Servicio de Agua Potable en el Estado de Baja California, por lo que procede la CLAUSURA DEL NEGOCIO, para ello previamente y con el objeto de respetar los derechos humanos del usuario de conformidad con el artículo 1°, 14 y 16 de la Constitución Política de los Estados Unidos Mexicanos, 48 y 54 de la Ley del Procedimiento para los Actos de la Administración Pública del Estado de Baja California, deberá requerirse el pago y para tal efecto deberá otorgarse un plazo de tres días para acreditar estar al corriente o realizar el pago respectivo. '));


    $pdf->Ln(20);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('VIII. '), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('        Se designa como notificadores y ejecutores de la Comisión Estatal de Servicios Públicos de Tecate, a los CC. Karen Guadalupe Alba Villegas, Raúl Mayoral Flores, Ricardo Iñiguez Martínez, Samanta Anahy Ruiz Ortiz, Lizeth Edith Hito Martínez, Lisset Lara Méndez y/o Briana Zamora Real, para que de manera conjunta o separada cumplimenten el requerimiento de pago y en su caso la diligencia de clausura, quien en todas diligencias donde intervengan deberán de estar plenamente identificados.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('En vista de lo anterior,'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('                                el Lic. Rolando Urbina Pertack,  en su carácter de subdirector Comercial,  de la Comisión Estatal de Servicios Públicos de Tecate.'));


    $pdf->Ln(8);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->MultiCell(196, 4, utf8_decode('A C U E R D A'), 0, 'C', 0);
    $pdf->Ln(5);


    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('PRIMERO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('              De conformidad  con el considerando I del presente acuerdo, la Comisión  Estatal de  Servicios  Públicos de Tecate es competente para iniciar el procedimiento administrativo de CLAUSURA DE NEGOCIO.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('SEGUNDO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('           Fórmese expediente de posible clausura, y con el objeto de guardar su debido control interno asígnese el número CESPTE/CL/' . $datos['n_exp'] . '/' . $datos['anio_exp'] . '.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('TERCERO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('                  En términos del considerando V, se tiene plenamente acreditado el adeudo del usuario ' . $datos['nombre'] . ' derivado de la omisión de pago por los servicios de agua potable y alcantarillado sanitarios registrados en esta Comisión Estatal de acuerdo con la constancia de fecha ' . $fecha_corta . ', emitida por la Comisión Estatal de Servicios Públicos de Tecate, la cual se incorpora al presente expediente para que surta efectos legales correspondientes.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('CUARTO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('                 De acuerdo con el  considerando VII, se ordena requerir al usuario,  propietario y/o posesionario del  inmueble ubicado en  ' . $datos['domicilio'] . ', para que dentro del plazo de tres días hábiles demuestre haber realizado el pago correspondiente o en su caso lo cumpla por la cantidad de $' . number_format($datos['cantidad'],2) . ' M.N (' . $total_texto . '),'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('QUINTO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('               De conformidad con el  considerando VIII, se tiene por designados  notificadores y  ejecutores de la Comisión Estatal de Servicios Públicos de Tecate.'));


    $pdf->Ln(5);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->Cell(20, 4, utf8_decode('SEXTO.'), 0, 0, 'L', 0);
    $pdf->SetX(10);
    $pdf->SetFont('Arial', '', 9);
    $pdf->CellDots(utf8_decode('              En su oportunidad y una vez que se realice en requerimiento de pago, de no acreditar el pago o realizar el mismo, procédase a la Clausura del Negocio / Industria, denominado ' . $datos['tipoc'] . ''));


    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiCell(196, 4, utf8_decode('ASÍ LO ORDENA EL LIC. ROLANDO URBINA PERTACK, EN SU CARÁCTER DE SUBDIRECTOR COMERCIAL, DE LA COMISIÓN ESTATAL DE SERVICIOS PÚBLICOS DE TECATE, A LOS ' . mb_strtoupper($fecha_larga,'UTF-8') . '.'), 0, 'C', 0);


    $pdf->Ln(30);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->MultiCell(196, 4, utf8_decode('______________________________________________'), 0, 'C', 0);
    $pdf->MultiCell(196, 4, utf8_decode('LIC. ROLANDO URBINA PERTACK'), 0, 'C', 0);
    $pdf->MultiCell(196, 4, utf8_decode('SUBDIRECTOR COMERCIAL'), 0, 'C', 0);
    $pdf->MultiCell(196, 4, utf8_decode('DE LA COMISIÓN ESTATAL DE SERVICIOS PÚBLICOS DE TECATE'), 0, 'C', 0);
















    $pdf->Output($archivo, 'I');
}
