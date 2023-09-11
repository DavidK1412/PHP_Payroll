<?php
    require_once __DIR__.'/../domain/repositories/LoanRepository.php';
    require_once __DIR__.'/../domain/repositories/EmployeeRepository.php';

    $loanRepository = new LoanRepository();
    $loans = $loanRepository->getAll();
    $employeeRepository = new EmployeeRepository();

    if(isset($_POST['totalQuotes']) && isset($_POST['amount']) && isset($_POST['employee'])){
        $loan = new Loan(
            '',
            $employeeRepository->getById($_POST['employee']),
            new DateTime(),
            $_POST['amount'],
            $_POST['totalQuotes'],
            0,
            false
        );
        $loanRepository->create($loan);
        header("Refresh:0");
    }

    if(isset($_POST['loanIdDel'])){
        $loanRepository->delete($_POST['loanIdDel']);
        header("Refresh:0");
    }

?>


<h2 class="text-center">Administración de Prestamos</h2>

<div class="m-3  flex-nowrap">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Generar nuevo prestamo
    </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo Prestamo</h1>
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
                        <label for="posName" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="posName" name="amount" required>
                    </div>

                    <div class="mb-3">
                        <label for="totalQuotes" class="form-label">Cuotas</label>
                        <input type="number" class="form-control" id="totalQuotes" name="totalQuotes" required>
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
        <th scope="col">Monto</th>
        <th scope="col">Fecha</th>
        <th scope="col">Cuotas</th>
        <th scope="col">¿Pago?</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach ($loans as $loan): ?>
            <tr>
                <th scope="row"><?php echo $loan->getId() ?></th>
                <td><?php echo $loan->getUser()->getEmployeeName() ?></td>
                <td><?php echo $loan->getAmount() ?></td>
                <td><?php echo $loan->getDate()->format('Y-m-d') ?></td>
                <td><?php echo $loan->getQuotes() ?></td>
                <td><?php
                        if($loan->getIsPayed()){
                            echo "Si";
                        }else {
                            echo "No";
                        }
                    ?>
                </td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="loanIdDel" value="<?php echo $loan->getId() ?>">
                        <input type="submit" class="btn btn-danger" name="eliminar" value="Elminar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

