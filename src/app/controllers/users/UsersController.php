<?php

    require_once __DIR__.'/../../databases/DatabaseService.php';
    require_once __DIR__.'/../../domain/repositories/UserRepository.php';
    require_once __DIR__.'/../../domain/models/UserModel.php';

    class UsersController{
        private DatabaseService $db;
        private UserRepository $userRepository;

        public function __construct(){
            $this->db = new DatabaseService();
            $this->userRepository = new UserRepository($this->db);
        }


        public function getAll(){
            return $this->userRepository->getAll();
        }

        public function create($user){
            try{
                $this->userRepository->insert($user);
            } catch (Exception $e){
                echo '<script>alert("Error al registrar el usuario")</script>';
            }
        }

        public function delete($id){
            try{
                $this->userRepository->delete($id);
            } catch (Exception $e){
                echo '<script>alert("Error al eliminar el usuario")</script>';
            }
        }

        public function searchSimilar($user){
            return $this->userRepository->searchSimilar($user);
        }
    }

?>