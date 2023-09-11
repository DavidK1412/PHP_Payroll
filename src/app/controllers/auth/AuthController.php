<?php

require_once __DIR__.'/../../databases/DatabaseService.php';
require_once __DIR__.'/../../domain/models/UserModel.php';
require_once __DIR__.'/../../domain/repositories/UserRepository.php';
require_once __DIR__.'/../../utils/passwords.php';

class AuthController {
    private UserModel $user;
    private UserRepository $userRepository;

    public function __construct() {
        $this->userRepository = new UserRepository(new DatabaseService());
    }

    public function login($user, $password){
        $this->user = $this->userRepository->getByUsername($user);
        if(validatePassword($password, $this->user->getPassword())){
            return $this->user;
        }
        return null;
    }

    public function register($user){
        $this->user = $user;
        $this->user->setPassword(encryptPassword($this->user->getPassword()));
        try {
            $this->userRepository->insert($this->user);
        } catch (Exception $e){
            echo '<script>alert("Error al registrar el usuario")</script>';
        }

    }
}

?>