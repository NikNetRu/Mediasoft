<?php
include_once 'Engine.php';

class Select {
    private $tablename = null;
    private $conditions = null;
    private $where = null;
    private $groupBy = null;
    private $orderBy = null;
    private $conditionsOr = null;
    
    function __construct ($tablename) 
    {
        $this->tablename = $tablename;
    }
    
    function conditionExample(array $condition) 
    {
        //$slicedCondition = sliceCondition($condition);
        $this->conditions = constructorConditionSel($condition);
    }
    
    function whereExample(array $condition) 
    {
        $this->where = ' WHERE ';
        $slicedCondition = SliceCondition($condition); 
        $this->where .= constructorRavenstv($slicedCondition, 'AND');
    }
    
    function orderByExample($conditions) 
    {
        $this->orderBy = "ORDER BY ";
        $this->orderBy .= constructorConditionSel($conditions);
    }
    
    function groupByExample($conditions) 
    {
        $this->groupBy = "GROUP BY ";
        $this->groupBy .= constructorConditionSel($conditions);
    }
    
        
    function whereOrExample(array $condition) 
    {
    $slicedCondition = sliceCondition($condition);
    $this->conditionsOr = 'OR '.constructorRavenstv($slicedCondition, 'OR');
    }
    
    function getExample() 
    {
        return "SELECT  $this->conditions FROM $this->tablename $this->where $this->groupBy $this->orderBy $this->conditionsOr";
    }
    
    
     /*
     * Обработка непредусмотренных вызываемых функций
     * 
     */
    public function __call($name, $params) 
    {
       echo "</br>Данный метод $name не предусмотрен классом Select";
        
    }
    
}
