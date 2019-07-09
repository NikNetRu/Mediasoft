<?php

    /*
     * вспомогательная функция разделения условия
     * на входе массив типа ['name = admin', 'age>=19'...]
     * на выходе получим массива  - ключи, значения, операторы
     * [key[name,age...],value[admin,19...],operators[=,>=...]]
     */
    
    function sliceCondition (array $arrayCondition) 
    {
        $sizeCondition = count($arrayCondition);
        $i=0;
        $key = [];
        $value = [];
        $operators =[];
           while ($i<$sizeCondition){
                $expresson = $arrayCondition[$i];
                $pattern = "/[^A-zА-я0-9]+/";
                $expressonKeyValues = preg_split($pattern, $expresson);
                $expressonCondition['keys'][] = $expressonKeyValues[0];
                $expressonCondition['values'][] = $expressonKeyValues[1];
                $pattern = "/[A-zА-я0-9 ]+/";
                $expressonOperators = preg_split($pattern, $expresson);
                $expressonCondition['operators'][] = $expressonOperators[1];
                $i++;
                }
         return $expressonCondition;
                
    }
    
    /*
    * Вспомогательная функция для вывода элементов массива в виде 
    * пригодным для выолнения SQL
    * @return = (string) (array[0],array[1],...)
    */
    function constructorCondition ($array)
    {
        $result = "(";
        $countArray = count($array);
        $i=0;
        while ($i<$countArray){
            $result .= "$array[$i],";
            $i++;
            }
            $result = substr($result, 0,-1);
            $result .= ")";
            return $result;
       }
       
    /*
    * Вспомогательная функция для вывода элементов массива в виде 
    * пригодным для выолнения SQL
    * @return = (string) array[0],array[1]...
    */
    function constructorConditionSel ($array)
    {
        $countArray = count($array);
        $i=0;
        $result = "";
        while ($i<$countArray){
            $result .= "$array[$i],";
            $i++;
            }
            $result = substr($result, 0,-1);
            return $result;
    }
       
    /*
    * Вспомогательная функция для вывода элементов массива в виде 
    * пригодным для выолнения SQL
     * на входе array[key[name,age...],value[admin,19...],operators[=,>=...]]
    * @return = (string) (key[0] [operators[0] 'value[0]', ...)
    */
    function constructorLinearCondition (array $condition)
    {
       $keys = array_values($condition['keys']);
       $values = array_values($condition['values']);
       $operators = array_values($condition['operators']);
       $countArray = count($condition['keys']);
       $i=0;
       $result = "";
        while ($i<$countArray){
            $result .= "$keys[$i] $operators[$i] '$values[$i]',";
            $i++;
            }
            $result = substr($result, 0,-1);
            return $result;
       }
       
    /*
    * Вспомогательная функция для вывода элементов массива в виде ([1],[2]..)
    * пригодным для выолнения SQL
    * @return = (string) ('array[0]',''...)
    */
    function constructorConditionApf ($array)
       {
        $result = "(";
        $countArray = count($array);
        $i=0;
        while ($i<$countArray){
            $result .= "'$array[$i]',";
            $i++;
            }
        $result = substr($result, 0,-1);
        $result .= ")";
        return $result;
        }
       
            
            
    
    /*
     * на входе array[key[name,age...],value[admin,19...],operators[=,>=...]]
     * ConditionInsert - генерирует сообщение вида ('name','19') VALUES ('admin', 19)
     * $condition - резульат выполнения SliceCondition
     */
    
    function conditionInsert (array $condition) 
       {
        
       $keys = array_values($condition['keys']);
       $values = array_values($condition['values']);
       $result = constructorCondition($keys);
       $result .= " VALUES ";
       $result .= constructorConditionApf($values);
       return $result;
       }
       
    /*
    * на входе array[key[name,age...],value[admin,19...],operators[=,>=...]]
    * На выходе получаем строку admin = '0' AND ... AND z=p
    */
    function constructorRavenstv (array $condition, $razdelitel) 
    {   
       $keys = array_values($condition['keys']);
       $values = array_values($condition['values']);
       $operators = array_values($condition['operators']);
       $result = "";
           $countArray = count($keys);
           $i=0;
           while ($i<$countArray){
                $result .= "$keys[$i]$operators[$i]'$values[$i]' $razdelitel ";
                $i++;
                }
            $result = substr($result, 0,-4);
            return $result;
    } 