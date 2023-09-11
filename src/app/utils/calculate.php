<?php

    require_once __DIR__.'/../domain/models/PayStub.php';

    function getWageByWorkedDays(PayStub $ps) {
        $workedDays = $ps->getTimeSheet()->getDaysWorked();
        $wage = $ps->getEmployee()->getEmployeeWage();
        return ($wage / 30) * $workedDays;
    }

    function getWageByVacancyDays(PayStub $ps) {
        $vacancyDays = $ps->getTimeSheet()->getVacationsDays();
        $wage = $ps->getEmployee()->getEmployeeWage();
        return ($wage / 30) * $vacancyDays;
    }

    function getTransportAux(PayStub $ps) {
        $workedDays = $ps->getTimeSheet()->getDaysWorked();
        return (97032/30)*$workedDays;
    }

    function getEPSPayment(PayStub $ps) {
        $wage = $ps->getEmployee()->getEmployeeWage();
        $result = 0;
        if ((($wage/30) * $ps->getTimeSheet()->getSickDays()) * 0.6667 < ((828116/30) * $ps->getTimeSheet()->getSickDays())) {
            $result = (828116/30) * $ps->getTimeSheet()->getSickDays();
        } else {
            $result = (($wage/30) * $ps->getTimeSheet()->getSickDays()) * 0.6667;
        }
        return $result;
    }

    function getARLPayment(PayStub $ps){
        return ($ps->getEmployee()->getEmployeeWage() / 30) * $ps->getTimeSheet()->getSickDays();
    }

    function getAlimentAux(PayStub $ps){
        return (150000/30) * $ps->getTimeSheet()->getDaysWorked();
    }

    function getHealthPayment(PayStub $ps){
        return ($ps->getEmployee()->getEmployeeWage()) * 0.04;
    }

    function getRetirementPayment(PayStub $ps){
        return ($ps->getEmployee()->getEmployeeWage()) * 0.04;
    }

    function getSolidarityPayment(PayStub $ps){
        if ($ps->getEmployee()->getEmployeeWage() < 3124968) {
            return 0;
        } else {
            return ($ps->getEmployee()->getEmployeeWage()) * 0.01;
        }
    }

    function getDeducements(PayStub $ps, $loansValues){
        return getHealthPayment($ps) + getRetirementPayment($ps) + getSolidarityPayment($ps) + $loansValues;
    }

?>







