<?php

include_once 'Engine.php';

class Delete 
{
    private $tablename = null;
    private $conditions = null;
    private $conditionsOr = null;
    
    function __construct ($tablename) 
    {
        $this->tablename = $tablename;
    }
    
    function conditionExample (array $condition) 
    {
        Delete::whereExample($condition);
    }
    
    function whereExample(array $condition) 
    {
        $slicedCondition = sliceCondition($condition);
        $this->conditions = 'WHERE '.constructorRavenstv($slicedCondition, 'AND');
    }
    
    function whereOrExample(array $condition) 
    {
        $slicedCondition = sliceCondition($condition);
        $this->conditionsOr = 'OR '.constructorRavenstv($slicedCondition, 'OR');
    }
    
    function getExample() 
    {
        return "DELETE FROM $this->tablename $this->conditions $this->conditionsOr";
    }
    
    /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params) 
    {
       echo "</br>Данный метод $name не предусмотрен классом DELETE</br>";        
    }
}