<?php
    require_once 'AuthMiddleware.php';

    // Validate if post method has login atribute
    if($_GET['method'] == 'login'){
        $authMiddleware = new AuthMiddleware();
        $authMiddleware->login($_POST['user'], $_POST['password']);
    }

?>
