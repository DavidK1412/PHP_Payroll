<?php

require_once __DIR__.'/../../databases/DatabaseService.php';

class PositionRepository {
    private DatabaseService $db;

    public function __construct() {
        $this->db = new DatabaseService();
    }

    public function getAll(): array {
        $sql = "SELECT * FROM Position";
        $result = $this->db->getConnection()->query($sql);
        $positions = array();
        while ($row = $result->fetch_assoc()) {
            $position = new Position($row["PositionID"], $row["PositionName"]);
            array_push($positions, $position);
        }
        return $positions;
    }

    public function getById($id): Position {
        $sql = "SELECT * FROM Position WHERE PositionID = $id";
        $result = $this->db->getConnection()->query($sql);
        $row = $result->fetch_assoc();
        $position = new Position($row["PositionID"], $row["PositionName"]);
        return $position;
    }

    public function insert(Position $position) {
        $sql = "INSERT INTO Position (PositionName) VALUES ('" . $position->getPositionName() . "')";
        $this->db->getConnection()->query($sql);
    }

    public function update(Position $position) {
        $sql = "UPDATE Position SET PositionName = '" . $position->getPositionName() . "' WHERE PositionID = " . $position->getPositionID();
        $this->db->getConnection()->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM Position WHERE PositionID = $id";
        $this->db->getConnection()->query($sql);
    }

}

?>