    <?php
require('../../fpdf/fpdf.php');

class PDF extends FPDF
{

    function Header()
    {
        global $datos; // Hacer la variable accesible
        $this->Image('image/backAcuerdoIni.jpg', 5, 4, 205);
        $this->Ln(2);
        $this->SetFont('Arial', '', 10);
        $this->Cell(100, 6, utf8_decode(''), 0, 0, 'L', 0);
        $this->Cell(96, 6, utf8_decode('Comisión Estatal de Servicios Públicos de Tecate, Baja'), 'TLR', 1, 'L', 0);
        $this->Cell(100, 4, utf8_decode(''), 0, 0, 'L', 0);
        $this->Cell(96, 4, utf8_decode('California,'), 'LR', 1, 'L', 0);

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(100, 9, utf8_decode(''), 0, 0, 'L', 0);
        $this->Cell(38, 9, utf8_decode('NO. DE EXPEDIENTE:'), 'LB', 0, 'L', 0);
        $this->SetFont('Arial', '', 10);
        $this->Cell(58, 9, utf8_decode('CESPTE/CL/'.$datos['n_exp'].'/'.$datos['anio_exp']), 'BR', 1, 'L', 0);
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 11);
        $this->SetY(-15);
    }


    //*************************** COMPLETAR GUIONES EN TEXTO ***********************************************
    function getSizeColumn($txt){
        $cw = &$this->CurrentFont['cw'];
        $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b = 0;
        $border = 0;
        if($border)
        {
            if($border==1)
            {
                $border = 'LTRB';
                $b = 'LRT';
                $b2 = 'LR';
            }
            else
            {
                $b2 = '';
                if(strpos($border,'L')!==false)
                    $b2 .= 'L';
                if(strpos($border,'R')!==false)
                    $b2 .= 'R';
                $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
            }
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $ns = 0;
        $nl = 1;
        $text = "";
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $text .= substr($s,$j,$i-$j);
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
                continue;
            }
            if($c==' ')
            {
                $sep = $i;
                $ls = $l;
                $ns++;
            }
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    $text = substr($s,$j,$i-$j);
                }
                else
                {
                    $text = substr($s,$j,$sep-$j);
                    $i = $sep+1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $ns = 0;
                $nl++;
                if($border && $nl==2)
                    $b = $b2;
            }
            else
                $i++;
        }
        
        return substr($s,$j,$i-$j);
    }

    function CellDots($txt, $level=0) {
        if($this->GetStringWidth($txt) > 196) {
            $txt2 = $this->getSizeColumn($txt);
            $strsize = $this->GetStringWidth($txt2);

        } else {
            $strsize = $this->GetStringWidth($txt);
        }
        $this->MultiCell(196, $this->FontSize * 1.2, $txt); // Cambia 1.2 por el factor que prefieras (ancho de celda)
        
        $PageCellSize = $this->GetStringWidth(1);
        $w = $this->w - $this->lMargin - $this->rMargin - $PageCellSize- ($strsize);
        
        $nb = $w/$this->GetStringWidth('-');
        if($nb < 0) $nb = 1000;
        $dots = str_repeat('-', $nb);

        $currentY = $this->GetY();
        $this->SetY($currentY - 2);
    
        $this->SetX($strsize + 10);
        $this->Cell($w,$this->FontSize, $dots);
    }
//**************************************************************************************************











}
