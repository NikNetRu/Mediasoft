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
    
    function WhereExample(array $condition) {
        $this->where = ' WHERE ';
        $slicedCondition = SliceCondition($condition); 
        $this->where .= constructorRavenstv($slicedCondition);
    }
    
    function OrderByExample($conditions) {
        $this->orderBy = "ORDER BY ";
        $this->orderBy .= constructorLinearCondition($conditions);
    }
    
    function GroupByExample($conditions) {
        $this->groupBy = "GROUP BY ";
        $this->groupBy .= constructorLinearCondition($conditions);
    }
    
    function GetExample() {
        return "SELECT  $this->conditions FROM $this->tablename $this->where $this->groupBy $this->orderBy";
    }
    
    
     /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params) {
       echo "</br>Данный метод $name не предусмотрен классом INSERT";
        
    }
    
}
