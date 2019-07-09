<?php

include_once 'Engine.php';

class Insert 
{
    private $tablename = null;
    private $conditions = null;
    
    function __construct ($tablename) 
    {
        $this->tablename = $tablename;
    }
    
    function conditionExample(array $condition) 
    {
        $slicedCondition = sliceCondition($condition);
        $this->conditions = conditionInsert($slicedCondition);
    }
    
    function getExample() 
    {
        return "INSERT INTO $this->tablename $this->conditions";
    }
    
    /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params) 
    {
       echo "</br>Данный метод $name не предусмотрен классом INSERT</br>";        
    }
}
