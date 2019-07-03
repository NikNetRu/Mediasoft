<?php

include_once 'Engine.php';

class Delete {
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
    
    /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params) {
       echo "</br>Данный метод $name не предусмотрен классом INSERT</br>";        
    }
}