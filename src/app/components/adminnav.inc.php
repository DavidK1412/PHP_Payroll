<?php

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema gestor de nómina</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="../views/admin.php?view=payroll">Nomina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/admin.php?view=users">Usuarios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/admin.php?view=employees">Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/admin.php?view=positions">Cargos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/admin.php?view=costcenters">Centros de costo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/admin.php?view=loans">Prestamos</a>
                </li>
            </ul>
            <span class="navbar-text">
            <?php
                require_once __DIR__.'/../middlewares/AuthMiddleware.php';
                $authMiddleware = new AuthMiddleware();
                $user = $authMiddleware->getTokenUser($_COOKIE['access_data']);
                echo "Empleado: ".$user->getEmployee()->getEmployeeName();
            ?>
                <a href="../views/admin.php?method=logout"> <i class="bi bi-box-arrow-right"></i></a>
      </span>
        </div>
    </div>
</nav>
