<?php

    require_once __DIR__.'/../../../../vendor/autoload.php';
    require_once __DIR__.'/../../domain/repositories/TimeSheetRepository.php';
    require_once __DIR__.'/../../domain/repositories/PayStubRepository.php';
    require_once __DIR__.'/../../utils/calculate.php';

    ob_start();

    if(isset($_GET['id'])){
        $payStubRepository = new PayStubRepository();
        $payStub = $payStubRepository->getPayStubById($_GET['id']);
    }

    $dompdf = new Dompdf\Dompdf();
    $employeeId = $payStub->getEmployee()->getEmployeeId();
    $employeeName = $payStub->getEmployee()->getEmployeeName();
    $date = $payStub->getDate();
    $date = $date->format('d-m-Y');
    $costCenter = $payStub->getEmployee()->getCostCenter()->getCostCenterName();
    $auxTransport = getTransportAux($payStub);
    $baseSalary = $payStub->getEmployee()->getEmployeeWage();
    $healthPayment = getHealthPayment($payStub);
    $retirementPayment = getRetirementPayment($payStub);
    $solidarityPayment = getSolidarityPayment($payStub);
    $workedDays = $payStub->getTimeSheet()->getDaysWorked();
    $sickDays = $payStub->getTimeSheet()->getSickDays();
    $vacaDays = $payStub->getTimeSheet()->getVacationsDays();
    $valueVacaDays = getWageByVacancyDays($payStub);
    $totalDev = getWageByWorkedDays($payStub) + getWageByVacancyDays($payStub) + getTransportAux($payStub) + getEPSPayment($payStub) + getARLPayment($payStub) + getAlimentAux($payStub);
    $totalDeduct = getDeducements($payStub, 0);
    $payment = $payStub->getGrossPay() - $totalDeduct;


    $html = " <style>

    table{
        border-collapse: collapse;
        width: 100%;
    }

    .t-header{
        font-weight: bold;
        text-align: center;
        padding: 2rem;
    }

    .t-header span {
        display: flex;
        justify-content: center;
    }
</style>

<table border='3'>
    <thead>
        <tr>
            <th class='t-header' colspan='6'>
                <span style='font-size: 2rem'>EMPRESA S.A.S</span>
                <span>NIT 901.473.720</span>
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan='1'>Nombre del trabajador: </td>
            <td colspan='3' style='width: 40%'> <b> $employeeName </b>  </td>
            <td colspan='2'>#N/D</td>
        </tr>
        <tr>
            <td colspan='1'>Identificación </td>
            <td colspan='2'><b> $employeeId </b> </td>
            <td colspan='1'>#N/D</td>
            <td colspan='2'>Fecha: <b> $date </b></td>
        </tr>
        <tr>
            <td colspan='1'>Centro de Costo </td>
            <td colspan='2'><b> $costCenter </b></td>
            <td colspan='1'><b>Días laborados </b></td>
            <td colspan='2'> $workedDays </td>
        </tr>
        <tr>
            <td colspan='1' style='width: 15%;' >Salario mensual </td>
            <td colspan='2' style='width: 35%;'><b>$ $baseSalary</b> </td>
            <td colspan='1' style='width: 15%;'>Auxilio no prestacional</td>
            <td colspan='2' style='width: 35%;'><b>N/A/b></td>
        </tr>
        <tr>
            <td colspan='1'>Auxilio transporte </td>
            <td colspan='3'><b>$ $auxTransport </b></td>
            <td colspan='1'></td>
            <td colspan='1'></td>
        </tr>
        <tr>
            <td colspan='3'>Devengados</td>
            <td colspan='3'>Deducidos</td>
        </tr>
        <tr style='text-align: center; background-color: darkslateblue;'>
            <td style='width: 25%'>Concepto</td>
            <td style='width: 10%'>Dias</td>
            <td style='width: 15%'>Valor</td>
            <td style='width: 25%'>Concepto</td>
            <td style='width: 10%'>Dias</td>
            <td style='width: 15%'>Valor</td>
        </tr>
        <tr>
            <td style='width: 25%'>Salario</td>
            <td style='width: 10%; text-align: center;'>N/D</td>
            <td style='width: 15%'>$ $baseSalary </td>
            <td style='width: 25%'>Salud</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>$ $healthPayment</td>
        </tr>
        <tr>
            <td style='width: 25%'>Extraturno</td>
            <td style='width: 10%; text-align: center;'>N/D</td>
            <td style='width: 15%'>N/D</td>
            <td style='width: 25%'>Pensión</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>$ $retirementPayment</td>
        </tr>
        <tr>
            <td style='width: 25%'>Aux. No Prestacional</td>
            <td style='width: 10%; text-align: center;'>N/D</td>
            <td style='width: 15%'>N/D</td>
            <td style='width: 25%'>Fondo Solidaridad Pensional</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>$ $solidarityPayment</td>
        </tr>
        <tr>
            <td style='width: 25%'>Aux. Transporte</td>
            <td style='width: 10%; text-align: center;'>N/D</td>
            <td style='width: 15%'>$ $auxTransport</td>
            <td style='width: 25%'>Anticipos</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>N/D</td>
        </tr>
        <tr>
            <td style='width: 25%'>Aux. Incapacidad</td>
            <td style='width: 10%; text-align: center;'>N/D</td>
            <td style='width: 15%'></td>
            <td style='width: 25%'>Préstamos</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>N/D</td>
        </tr>
        <tr>
            <td style='width: 25%'>Vacaciones Disfrutadas</td>
            <td style='width: 10%; text-align: center;'>$vacaDays</td>
            <td style='width: 15%'>$ $valueVacaDays</td>
            <td style='width: 25%'>Anticipo Vacaciones Pagadas</td>
            <td style='width: 10%; text-align: center;'>30</td>
            <td style='width: 15%'>N/D</td>
        </tr>
        <tr style='background-color: darkslateblue;'>
            <td colspan='2'>
                <b>Total Devengados: </b>
            </td>
            <td colspan='1'>
                $totalDev
            </td>
            <td colspan='2'>
                <b>Total Deducidos: </b>
            </td>
            <td colspan='1'>
                $totalDeduct
            </td>
        </tr>
        <tr>
            <td colspan='3'>

            </td>
            <td colspan='2' style='background-color: darkslateblue;'>
                <b>NETO A PAGAR: </b>
            </td>
            <td colspan='1' style='background-color: darkslateblue;'>
                $payment
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<div style='display: flex; flex-direction: row; padding: 1rem;'>
    <div style=' width: 50%;'>
        RECIBÍ DE CONFORMIDAD Y ACEPTO EN TODAS LAS PARTES ESTE PAGO:
        <br>
        <br>
        _________________________________________
        <br>
        David Hernan Casallas Burgos
        <br>
        C.C. No. 1015993002
    </div>
</div>";

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation

    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF

    $dompdf->render();

    // Output the generated PDF to Browser

    $dompdf->stream("voucher.pdf", [ "Attachment" => true]);

?>