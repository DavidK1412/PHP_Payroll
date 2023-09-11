<?php
    require_once __DIR__.'/../domain/repositories/CostCenterRepository.php';
    require_once __DIR__.'/../domain/repositories/PositionRepository.php';

    $costCenterRepository = new CostCenterRepository();
    $costCenters = $costCenterRepository->getAll();

    if (isset($_POST['ccIdDel'])) {
        $costCenterRepository->delete($_POST['ccIdDel']);
        echo '<script>alert("Centro de costos eliminado exitosamente")</script>';
        header("Refresh:0");
    }

    if (isset($_POST['ccName']) && $_POST['ccName'] != "") {
        $costCenter = new CostCenter('', $_POST['ccName']);
        $costCenterRepository->insert($costCenter);
        echo '<script>alert("Centro de costos creado exitosamente")</script>';
        header("Refresh:0");
    }
?>

<h2 class="text-center">Administración de Centro de Costos</h2>

<div class="m-3  flex-nowrap">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Crear nuevo C. Costos
    </button>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar nuevo Centro de Costos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="posName" class="form-label">Nombre centro de costos</label>
                        <input type="text" class="form-control" id="posName" name="ccName" required>
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
        <th scope="col">CC</th>
        <th scope="col">Acciones</th>
    </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach ($costCenters as $costCenter): ?>
            <tr>
                <th scope="row"><?php echo $costCenter->getCostCenterId() ?></th>
                <td><?php echo $costCenter->getCostCenterName() ?></td>
                <td>
                    <form method="post" action="">
                        <input type="hidden" name="ccIdDel" value="<?php echo $costCenter->getCostCenterId() ?>">
                        <input type="submit" class="btn btn-danger" name="eliminar" value="Elminar">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
