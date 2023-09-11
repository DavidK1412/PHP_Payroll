<?php
require_once __DIR__.'/../domain/models/TimeSheet.php';
require_once __DIR__.'/../domain/repositories/TimeSheetRepository.php';
require_once __DIR__.'/../domain/models/PayStub.php';
require_once __DIR__.'/../domain/repositories/PayStubRepository.php';
require_once __DIR__.'/../domain/repositories/EmployeeRepository.php';
require_once __DIR__.'/../utils/calculate.php';

$payStubRepository = new PayStubRepository();
$payStubs = $payStubRepository->getAll();

if (isset($_POST['employee']) && isset($_POST['workedDays']) && isset($_POST['sickDays']) && isset($_POST['vacationDays'])) {
    $timeSheetRepository = new TimeSheetRepository();
    $employeeRepository = new EmployeeRepository();
    $timeSheet = new TimeSheet(
        0,
        $employeeRepository->getById($_POST['employee']),
        new DateTime(),
        $_POST['workedDays'],
        $_POST['sickDays'],
        $_POST['vacationDays']
    );
    $timeSheetRepository->create($timeSheet);
    $payStub = new PayStub(
        '',
        $timeSheetRepository->getLast(),
        $employeeRepository->getById($_POST['employee']),
        new DateTime(),
        0,
        0
    );

    $payStub->setGrossPay(getWageByWorkedDays($payStub) + getWageByVacancyDays($payStub) + getTransportAux($payStub) + getEPSPayment($payStub) + getARLPayment($payStub) + getAlimentAux($payStub));
    $payStub->setNetPay($payStub->getGrossPay() - getDeducements($payStub, 0));
    $payStubRepository->createPayStub($payStub);
    header("Refresh:0");
}

?>

<h2 class="text-center">Pagos de nómina</h2>

<div class="m-3  flex-nowrap">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Generar nuevo desprendible
    </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo pago</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="posName" class="form-label">Empleado</label>
                        <select class="form-select" aria-label="Default select example" name="employee">
                            <?php
                            $employeeRepository = new EmployeeRepository();
                            $employees = $employeeRepository->getAll();
                            foreach ($employees as $employee) {
                                echo '<option value="'.$employee->getEmployeeUUID().'">'.$employee->getEmployeeName().'</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="workedDays">Dias de trabajo</label>
                        <input type="number" class="form-control" id="workedDays" name="workedDays" required>
                    </div>

                    <div class="mb-3">
                        <label for="sickDays">Dias de incapacidad</label>
                        <input type="number" class="form-control" id="sickDays" name="sickDays" required>
                    </div>

                    <div class="mb-3">
                        <label for="vacationDays">Dias de vacaciones</label>
                        <input type="number" class="form-control" id="vacationDays" name="vacationDays" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" name="create" class="btn btn-success">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>





<table class="table m-4 table-hover table-responsive">
    <thead>
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Empleado</th>
        <th scope="col">Fecha</th>
        <th scope="col">Pago sin Deducciones</th>
        <th scope="col">Pago neto</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php foreach ($payStubs as $payStub): ?>
        <tr>
            <th scope="row"><?php echo $payStub->getId(); ?></th>
            <td><?php echo $payStub->getEmployee()->getEmployeeName(); ?></td>
            <td><?php echo $payStub->getDate()->format('Y-m-d'); ?></td>
            <td><?php echo $payStub->getGrossPay(); ?></td>
            <td><?php echo $payStub->getNetPay(); ?></td>
            <td>
                <a href="../controllers/payroll/createpdf.php?id=<?php echo $payStub->getId() ?>" class="btn btn-warning">Voucher</a>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
