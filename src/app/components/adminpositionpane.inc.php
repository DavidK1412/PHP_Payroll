<?php
    require_once __DIR__.'/../domain/models/Position.php';
    require_once __DIR__.'/../domain/repositories/PositionRepository.php';

    $positionRepository = new PositionRepository();
    $positions = $positionRepository->getAll();

    if ($_POST['posIdDel'] == 1){
        echo '<script>alert("No se puede eliminar el cargo de Administrador")</script>';
    }

    if (isset($_POST['posIdDel']) && $_POST['posIdDel'] != 1) {
        $positionRepository->delete($_POST['posIdDel']);
        echo '<script>alert("Cargo eliminado exitosamente")</script>';
        header("Refresh:0");
    }

    if (isset($_POST['posName']) && $_POST['posName'] != "") {
        $position = new Position(0, $_POST['posName']);
        $positionRepository->insert($position);
        echo '<script>alert("Cargo creado exitosamente")</script>';
        header("Refresh:0");
    }

?>

<h2 class="text-center">Administración de Cargos</h2>

<div class="m-3  flex-nowrap">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear nuevo cargo
    </button>
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
                        <label for="posName" class="form-label">Nombre cargo</label>
                        <input type="text" class="form-control" id="posName" name="posName" required>
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
        <th scope="col">Cargo</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
    <?php foreach ($positions as $position): ?>
    <tr>
        <th scope="row"><?php echo $position->getPositionId() ?></th>
        <td><?php echo $position->getPositionName() ?></td>
        <td>
            <form method="post" action="">
                <input type="hidden" name="posIdDel" value="<?php echo $position->getPositionId() ?>">
                <input type="submit" class="btn btn-danger" name="eliminar" value="Elminar">
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
