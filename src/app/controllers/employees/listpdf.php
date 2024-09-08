<?php

    require_once __DIR__.'/../../../../vendor/autoload.php';
    require_once __DIR__.'/../../domain/repositories/EmployeeRepository.php';
    require_once __DIR__.'/../../utils/calculate.php';

    ob_start();


    $dompdf = new Dompdf\Dompdf();
    $employeeRepository = new EmployeeRepository();
    $employees = $employeeRepository->getAll();

    /*
    <th scope="col">C.C</th>
    <th scope="col">Nombre</th>
    <th scope="col">Email</th>
    <th scope="col">Posición</th>
    <th scope="col">C. Costo</th>
    <th scope="col">Salario</th>
    <th scope="col">Acciones</th>
    */
    $html = " 
    <style>
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
            <tr>
                <th class='t-header' colspan='6'>
                    <span style='font-size: 1.5rem'>Nómina de empleados</span>
                </th>
            </tr>
            <tr>
                <th class='t-header'>C.C</th>
                <th class='t-header'>Nombre</th>
                <th class='t-header'>Email</th>
                <th class='t-header'>Posición</th>
                <th class='t-header'>C. Costo</th>
                <th class='t-header'>Salario</th>
            </tr>
        </thead>";

    $html .= "<tbody>";
    foreach($employees as $employee){
        $html .= "<tr>";
        $html .= "<td>".$employee->getEmployeeId()."</td>";
        $html .= "<td>".$employee->getEmployeeName()."</td>";
        $html .= "<td>".$employee->getEmployeeEmail()."</td>";
        $html .= "<td>".$employee->getPosition()->getPositionName()."</td>";
        $html .= "<td>".$employee->getCostCenter()->getCostCenterName()."</td>";
        $html .= "<td>".$employee->getEmployeeWage()."</td>";
        $html .= "</tr>";
    }
    

    $html .= "</tbody>";

    $dompdf->loadHtml($html);

    // (Optional) Setup the paper size and orientation

    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF

    $dompdf->render();

    // Output the generated PDF to Browser

    $dompdf->stream("voucher.pdf", [ "Attachment" => true]);

?>