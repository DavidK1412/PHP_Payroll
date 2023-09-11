<?php
    require_once __DIR__.'/../middlewares/AuthMiddleware.php';

    $authMiddleware = new AuthMiddleware();

    if (isset($_GET['method']) && $_GET['method'] == 'logout') {
        $authMiddleware->logout();
    }


?>

<!doctype html>
<html lang="es">
<?php include '../components/header.inc.php'; ?>
<body>
    <?php include '../components/adminnav.inc.php'; ?>
    <?php
        if (isset($_GET['view']) && $_GET['view'] == 'users') {
            include '../components/useradminpane.inc.php';
        }

        if (isset($_GET['view']) && $_GET['view'] == 'employees') {
            include '../components/employeadminpane.inc.php';
        }

        if (isset($_GET['view']) && $_GET['view'] == 'positions') {
            include '../components/adminpositionpane.inc.php';
        }

        if (isset($_GET['view']) && $_GET['view'] == 'costcenters') {
            include '../components/admincostcenterpane.inc.php';
        }

        if (isset($_GET['view']) && $_GET['view'] == 'loans') {
            include '../components/adminloanpane.inc.php';
        }

        if (isset($_GET['view']) && $_GET['view'] == 'payroll') {
            include '../components/adminpayroll.inc.php';
        }
    ?>
    <?php include '../components/footer.inc.php'; ?>
</body>
</html>


