<?php

    /*
     * вспомогательная функция разделения условия
     * на входе массив типа ['name = admin', 'age>=19'...]
     * на выходе получим массива  - ключи, значения, операторы
     * [key[name,age...],value[admin,19...],operators[=,>=...]]
     */
    
    function SliceCondition (array $arrayCondition) {
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
                $pattern = "/[A-zА-я0-9]+/";
                $expressonOperators = preg_split($pattern, $expresson);
                $expressonCondition['operators'][] = $expressonOperators[1];
                $i++;
                }
         return $expressonCondition;
                
    }
    
    /*
        * Вспомогательная функция для вывода элементов массива в виде ([1],[2]..)
        * пригодным для выолнения SQL
        * @return = (string) (array[0]...)
        */
       function constructorCondition ($array){
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
        * Вспомогательная функция для вывода элементов массива в виде ([1],[2]..)
        * пригодным для выолнения SQL
        * @return = (string) (array[0]...)
        */
       function constructorLinearCondition ($array){
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
     * ConditionInsert - генерирует сообщение вида ('name','19') VALUES ('admin', 19)
     * $condition - резульат выполнения SliceCondition
     */
    
    function conditionInsert (array $condition) {
        
       $keys = array_keys($condition['keys']);
       $values = array_values($condition['values']);
       
       $result = constructorCondition($keys);
       $result .= " VALUES ";
       $result .= constructorCondition($values);
       return $result;
       }
       
       /*
        * Входные данные - результат SliceCondition
        * На выходе получаем строку admin = 0 AND ... AND z=p
        */
    function constructorRavenstv (array $condition) {
       $keys = array_keys($condition['keys']);
       $values = array_values($condition['values']);
       $result = "";
           $countArray = count($keys);
           $i=0;
           while ($i<$countArray){
                $result .= "$keys[$i]=$values[$i] AND ";
                $i++;
                }
            $result = substr($result, 0,-4);
            return $result;
    }