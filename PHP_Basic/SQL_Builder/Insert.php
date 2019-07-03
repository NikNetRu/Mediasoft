<?php

include_once 'Engine.php';

class Insert {
    private $tablename = null;
    private $conditions = null;
    
    function __construct ($tablename) {
        $this->tablename = $tablename;
    }
    
    function ConditionExample(array $condition) {
        $slicedCondition = SliceCondition($condition);
        $this->conditions = conditionInsert($slicedCondition);
    }
    
    function GetExample() {
        return "INSERT INTO $this->tablename $this->conditions";
    }
}
