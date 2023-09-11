<?php

require_once __DIR__.'/../../databases/DatabaseService.php';
require_once 'EmployeeRepository.php';

class UserRepository {

        private DatabaseService $db;

        public function __construct(DatabaseService $db = new DatabaseService()) {
            $this->db = $db;
        }

        public function getAll(): array {
            $sql = "SELECT * FROM Users";
            $result = $this->db->getConnection()->query($sql);
            $users = array();
            $employeeRepository = new EmployeeRepository($this->db);
            while ($row = $result->fetch_assoc()) {
                $user = new UserModel($row["UserUUID"], $row["Username"], $row["Password"], $employeeRepository->getById($row["EmployeeUUID"]));
                array_push($users, $user);
            }
            return $users;
        }

        public function getByUsername($username): UserModel {
            $sql = "SELECT * FROM Users WHERE Username = '$username'";
            $result = $this->db->getConnection()->query($sql);
            $row = $result->fetch_assoc();
            if ($row == null) {
                throw new Exception("Usuario no encontrado");
            }
            $employeeRepository = new EmployeeRepository($this->db);
            $user = new UserModel($row["UserUUID"], $row["Username"], $row["Password"], $employeeRepository->getById($row["EmployeeUUID"]));
            return $user;
        }

        public function getById($id): UserModel {
            $sql = "SELECT * FROM Users WHERE UserUUID = '$id'";
            $result = $this->db->getConnection()->query($sql);
            $row = $result->fetch_assoc();
            $employeeRepository = new EmployeeRepository($this->db);
            $user = new UserModel($row["UserUUID"], $row["Username"], $row["Password"], $employeeRepository->getById($row["EmployeeUUID"]));
            return $user;
        }

        public function insert(UserModel $user) {
            try {
                $sql = "INSERT INTO Users (Username, Password, EmployeeUUID) VALUES ('" . $user->getUsername() . "', '" . $user->getPassword() . "', '" . $user->getEmployee()->getEmployeeUUID() . "')";
                $this->db->getConnection()->query($sql);
            } catch (Exception $e) {
                throw new Exception("Error al insertar el usuario");
            }
        }

        public function update(UserModel $user) {
            $sql = "UPDATE Users SET Username = '" . $user->getUsername() . "', Password = '" . $user->getPassword() . "', EmployeeUUID = '" . $user->getEmployee()->getEmployeeUUID() . "' WHERE UserUUID = '" . $user->getUserId() . "'";
            $this->db->getConnection()->query($sql);
        }

        public function delete($id) {
            $sql = "DELETE FROM Users WHERE UserUUID = '$id'";
            $this->db->getConnection()->query($sql);
        }

}

?>