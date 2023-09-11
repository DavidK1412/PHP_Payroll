<!doctype html>
<html lang="es">
<?php
    include '../components/header.inc.php';
?>
<body>
    <form method="post" action="../middlewares/middlewares.php?method=login">
        <div class="login-form border border-dark rounded">
            <h3> Iniciar Sesión </h3>
            <hr>
            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">@</span>
                <input name="user" type="text" class="form-control" placeholder="Usuario" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            <div class="input-group flex-nowrap mt-3">
                <span class="input-group-text" id="addon-wrapping">*</span>
                <input type="password" name="password" class="form-control" placeholder="Contraseña" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            <div class="d-grid gap-2 mt-3">
                <input type="submit" class="btn btn-primary" type="button">Iniciar Sesión</input>
            </div>
            <?php
                if (isset($_GET['error'])) {
                    echo '<div class="alert alert-danger mt-3" role="alert">Usuario o contraseña incorrectos</div>';
                }
            ?>
        </div>
    </form>
<?php
    include '../components/header.inc.php';
?>
</body>
</html>