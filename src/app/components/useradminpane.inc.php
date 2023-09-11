<?php
    require_once __DIR__.'/../../app/controllers/users/UsersController.php';
    require_once __DIR__.'/../../app/domain/repositories/EmployeeRepository.php';
    require_once __DIR__.'/../../app/controllers/auth/AuthController.php';
    $userRepository = new UsersController();
    $employeRepository = new EmployeeRepository();
    $authController = new AuthController();
    $users = $userRepository->getAll();
    $employees = $employeRepository->getAll();

    if(isset($_POST['emploName'])){
        $temporal = [];
        if ($_POST['emploName'] == ""){
            $users = $userRepository->getAll();
        } else {
            foreach ( $users as $user ) {
                similar_text($user->getEmployee()->getEmployeeName(), $_POST['emploName'], $percent);
                if($percent >= 45){
                    array_push($temporal, $user);
                }
                $users = $temporal;
            }
        }
        if (count($users) == 0){
            echo '<script>alert("No se encontraron usuarios similares")</script>';
            $users = $userRepository->getAll();
        }
    }

    if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['employee'])){
        $selectedEmployee = $employeRepository->getById($_POST['employee']);
        $authController->register(
                new UserModel(
                    '',
                    $_POST['username'],
                    $_POST['password'],
                    $selectedEmployee
                )
        );
        echo '<script>alert("Usuario creado exitosamente")</script>';
        header("Refresh:0");
    }

    if(isset($_POST['deleteId'])){
        $userRepository->delete($_POST['deleteId']);
        echo '<script>alert("Usuario eliminado exitosamente")</script>';
        header("Refresh:0");
    }
?>
<h2 class="text-center">Administración de usuarios</h2>

<div class="m-3  flex-nowrap">
    <form class="m-3 w-25 input-group flex-nowrap" method="post" action="">
        <input type="text" name="emploName" class="form-control" placeholder="Nombre Empleado">
        <input type="submit" class="btn btn-success" value="Buscar">
    </form>

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear nuevo usuario
    </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="">
            <div class="modal-body">

                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="employee" class="form-label">Empleado</label>
                        <select class="form-select" aria-label="Default select example" id="employee" name="employee">
                            <?php foreach($employees as $employee): ?>
                                <option value="<?php echo $employee->getEmployeeUUID(); ?>">
                                    <?php echo $employee->getEmployeeName(); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit"  class="btn btn-success">Crear</button>
            </div>
            </form>

        </div>
    </div>
</div>





<table class="table m-4 table-hover table-responsive">
    <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Username</th>
            <th scope="col">Empleado</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody class="table-grou-divider">
        <?php foreach($users as $user): ?>
            <tr>
                <th scope="row"><?php echo $user->getUserId(); ?></th>
                <td><?php echo $user->getUsername(); ?></td>
                <td><?php echo $user->getEmployee()->getEmployeeName(); ?></td>
                <td >
                    <form method="post" action="">
                        <input type="hidden" name="deleteId" value="<?php echo $user->getUserId(); ?>">
                        <input type="submit" class="btn btn-danger" value="Eliminar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

