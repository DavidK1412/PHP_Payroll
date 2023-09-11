<?php

class CostCenter {
    private string $costCenterId;
    private string $costCenterName;

    public function __construct($costCenterId, $costCenterName){
        $this->costCenterId = $costCenterId;
        $this->costCenterName = $costCenterName;
    }

    public function getCostCenterId(){
        return $this->costCenterId;
    }

    public function getCostCenterName(){
        return $this->costCenterName;
    }

    public function setCostCenterId($costCenterId){
        $this->costCenterId = $costCenterId;
    }

    public function setCostCenterName($costCenterName){
        $this->costCenterName = $costCenterName;
    }


}
?>