<?php
    require_once __DIR__.'/../../app/domain/repositories/EmployeeRepository.php';
    require_once __DIR__.'/../../app/domain/repositories/PositionRepository.php';
    require_once __DIR__.'/../../app/domain/repositories/CostCenterRepository.php';
    require_once __DIR__.'/../../app/domain/models/Employee.php';
    $employeRepository = new EmployeeRepository();
    $employees = $employeRepository->getAll();

    if (isset($_POST['deleteId']) && $_POST['deleteId'] != "") {
        $employeRepository->delete($_POST['deleteId']);
        echo '<script>alert("Empleado eliminado exitosamente")</script>';
        header("Refresh:0");
    }

    if (isset($_POST['emploCC'])) {
        $temporal = [];
        if ($_POST['emploCC'] == "") {
            $employees = $employeRepository->getAll();
        } else {
            foreach ($employees as $employee) {
                if ($employee->getEmployeeId() == $_POST['emploCC']) {
                    array_push($temporal, $employee);
                }
            }
            $employees = $temporal;
        }
        if (count($employees) == 0) {
            echo '<script>alert("No se encontraron empleados similares")</script>';
            $employees = $employeRepository->getAll();
        }
    }

    if (isset($_POST['emploName']) ) {
        $positionRepository = new PositionRepository();
        $costCenterRepository = new CostCenterRepository();
        $position = $positionRepository->getById($_POST['emploPosition']);
        $costCenter = $costCenterRepository->getById($_POST['emploCostCenter']);
        $employe = new Employee('', $_POST['emploCC'], $_POST['emploName'], $_POST['emploEmail'], $position, $costCenter, $_POST['emploWage']);
        $employeRepository->insert($employe);
        echo '<script>alert("Empleado creado exitosamente")</script>';
        header("Refresh:0");
    }
?>

<h2 class="text-center">Administración de Empleados</h2>

<div class="m-3  flex-nowrap">
    <form class="m-3 w-25 input-group flex-nowrap" method="post" action="">
        <input type="text" name="emploCC" class="form-control" placeholder="C.C Empleado">
        <input type="submit" class="btn btn-success" value="Buscar">
    </form>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear nuevo empleado
    </button>

    <a href="../controllers/employees/listpdf.php" class="btn btn-warning">Listas</a>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body">

                    <div class="mb-3">
                        <label for="emploCC" class="form-label">C.C</label>
                        <input type="text" class="form-control" id="emploCC" name="emploCC" required>
                    </div>
                    <div class="mb-3">
                        <label for="emploName" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="emploName" name="emploName" required>
                    </div>
                    <div class="mb-3">
                        <label for="emploEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emploEmail" name="emploEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="emploPosition" class="form-label">Posición</label>
                        <select class="form-select" aria-label="Default select example" id="emploPosition" name="emploPosition" required>
                            <?php
                                $positionRepository = new PositionRepository();
                                $positions = $positionRepository->getAll();
                                foreach ($positions as $position) {
                                    echo '<option value="'.$position->getPositionId().'">'.$position->getPositionName().'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="emploPosition" class="form-label">Centro de costo</label>
                        <select class="form-select" aria-label="Default select example" id="emploCostCenter" name="emploCostCenter" required>
                            <?php
                            $costCenterRepository = new CostCenterRepository();
                            $costCenters = $costCenterRepository->getAll();
                            foreach ($costCenters as $costCenter) {
                                echo '<option value="'.$costCenter->getCostCenterId().'">'.$costCenter->getCostCenterName().'</option>';
                            }
                            ?>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="emploWage" class="form-label">Salario</label>
                        <input placeholder="Salario" type="number" class="form-control" id="emploWage" name="emploWage"  required>
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
        <th scope="col">C.C</th>
        <th scope="col">Nombre</th>
        <th scope="col">Email</th>
        <th scope="col">Posición</th>
        <th scope="col">C. Costo</th>
        <th scope="col">Salario</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach ($employees as $employee): ?>
<tr>
            <td><?php echo $employee->getEmployeeId(); ?></td>
            <td><?php echo $employee->getEmployeeName(); ?></td>
            <td><?php echo $employee->getEmployeeEmail(); ?></td>
            <td><?php echo $employee->getPosition()->getPositionName(); ?></td>
            <td><?php echo $employee->getCostCenter()->getCostCenterName(); ?></td>
            <td><?php echo $employee->getEmployeeWage(); ?></td>
            <td>
                <form method="post" action="">
                    <input type="hidden" name="deleteId" value="<?php echo $employee->getEmployeeUUID(); ?>">
                    <input type="submit" class="btn btn-danger" name="eliminar" value="Elminar">
                </form>
            </td>

        <?php endforeach; ?>
    </tbody>
</table>


