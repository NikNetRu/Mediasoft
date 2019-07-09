<?php

include_once 'Engine.php';

class Update {
    private $tablename = null;
    private $conditions = null;
    private $where = null;
    private $whereOr = null;
    
    function __construct ($tablename) 
    {
        $this->tablename = $tablename;
    }
    
    function conditionExample(array $condition) 
    {
        $slicedCondition = sliceCondition($condition);
        $this->conditions = constructorRavenstv($slicedCondition, 'AND');
    }
    
    
    function whereExample(array $condition) 
    {
        $this->where = ' WHERE ';
        $slicedCondition = SliceCondition($condition); 
        $this->where .= constructorRavenstv($slicedCondition, 'AND');
    }

    function whereOrExample(array $condition) 
    {
    $slicedCondition = sliceCondition($condition);
    $this->whereOr = 'OR '.constructorRavenstv($slicedCondition, 'OR');
    }
    
    function getExample() 
    {
        return "UPDATE $this->tablename SET $this->conditions $this->where $this->whereOr";
    }
    
    /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params)  
    {
       echo "</br>Данный метод $name не предусмотрен классом UPDATE</br>";        
    }
}