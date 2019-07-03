<?php
include_once 'Engine.php';

class Select {
    private $tablename = null;
    private $conditions = null;
    private $where = null;
    private $groupBy = null;
    private $orderBy = null;
    
    function __construct ($tablename) {
        $this->tablename = $tablename;
    }
    
    function ConditionExample(array $condition) {
        $this->conditions = constructorLinearCondition($condition);
    }
    
    function Where(array $condition) {
        $this->where = ' WHERE ';
        $this->where .= constructorLinearCondition($condition);
    }
    
    function OrderBy($conditions) {
        $this->orderBy = "ORDER BY ";
        $this->orderBy .= constructorLinearCondition($conditions);
    }
    
    function GroupBy($conditions) {
        $this->groupBy = "GROUP BY ";
        $this->groupBy .= constructorLinearCondition($conditions);
    }
    
    function GetExample() {
        return "SELECT  $this->conditions from $this->tablename $this->where $this->groupBy $this->orderBy";
    }
    
}
