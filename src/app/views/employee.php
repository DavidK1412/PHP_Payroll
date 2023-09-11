<?php
    include_once __DIR__.'/../components/header.inc.php';
    include_once __DIR__.'/../middlewares/AuthMiddleware.php';
    require_once __DIR__.'/../domain/models/TimeSheet.php';
    require_once __DIR__.'/../domain/repositories/TimeSheetRepository.php';
    require_once __DIR__.'/../domain/models/PayStub.php';
    require_once __DIR__.'/../domain/repositories/PayStubRepository.php';
    require_once __DIR__.'/../domain/repositories/EmployeeRepository.php';
    require_once __DIR__.'/../utils/calculate.php';

    $authMiddleware = new AuthMiddleware();
    $user = $authMiddleware->getTokenUser($_COOKIE['access_data']);

    $payStubRepository = new PayStubRepository();
    $payStubs = $payStubRepository->getPayStubsByEmployeeId($user->getEmployee()->getEmployeeUUID());

?>
<nav class="navbar navbar-expand-lg bg-body-tertiary border">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistemga gestor de nómina</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">

            <span class="navbar-text">
            <?php
            echo "Empleado: ".$user->getEmployee()->getEmployeeName();
            ?>
                <a href="../views/admin.php?method=logout"> <i class="bi bi-box-arrow-right"></i></a>
      </span>
        </div>
    </div>
</nav>

    <h2 class="text-center">Mis vouchers de nómina <?php echo $user->getEmployee()->getEmployeeName() ?> </h2>
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
<?php
    include_once __DIR__.'/../components/footer.inc.php';
?>
