<?php


require_once __DIR__.'/../controllers/auth/AuthController.php';
require_once __DIR__.'/../domain/models/UserModel.php';
require_once __DIR__.'/../domain/repositories/UserRepository.php';
require_once '../utils/tokens.php';

class AuthMiddleware {

    private UserModel $user;

    public function __construct() {
    }

    public function login($user, $password) {
        $authController = new AuthController();

        $user = $authController->login($user, $password);
        if($user != null){
            $token = generateToken($user);
            setcookie('access_data', $token, time() + 3600, '/');
            if (getDecodedToken($token)->userTypePermission == 1) {
                header('Location: ../views/admin.php?view=payroll');
            } else {
                header("Location: ../views/employee.php");
            }
        } else {
            header('Location: ../views/login.php?error=1');
        }
    }

    public function validateSession($token) {
        try {
            if (!validateToken($token)) {
                header('Location: ../views/login.php');
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    public function logout() {
        setcookie('access_data', '', time() - 300, '/');
        header('Location: ../views/login.php');
    }

    public function getTokenUser($token) {
        $userRepo = new UserRepository();
        try {
            $this->user = $userRepo->getById(getDecodedToken($token)->userid);
        } catch (Exception $e) {
            echo " <script> alert('Usuario no existe'); </script>";
            return null;
        }

        return $this->user;
    }

}

?>