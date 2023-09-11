<?php
class Position {
    private string $positionId;
    private string $positionName;

    public function __construct($positionId, $positionName){
        $this->positionId = $positionId;
        $this->positionName = $positionName;
    }

    public function getPositionId(){
        return $this->positionId;
    }

    public function getPositionName(){
        return $this->positionName;
    }

    public function setPositionId($positionId){
        $this->positionId = $positionId;
    }

    public function setPositionName($positionName){
        $this->positionName = $positionName;
    }
}

?>