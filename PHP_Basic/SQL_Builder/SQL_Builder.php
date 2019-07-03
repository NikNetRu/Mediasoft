<?php
/*
 * Фраза запроса комманда - имя таблицы/или где выполнять запрос - условие - постусловие
 */
class SQL_Builder {
    
        private $host = null;
        private $login = null;
        private $password = null;
        private $database = null;
        private $querry = null;  // результирующий запрос
        private $shemeCall = null; //схема запроса SQL - INSERT, DELETE и тп
        private $command = null; //1ый кусок фразы команда
        private $where = null; //2ой кусок фразы откуда
        private $condition = null; //3ый кусок фразы условие
        private $postcondition = null; //4ый кусок фразы постусловие
        
    // при обьявлении экземпляра можно указать свойства подключения к БД
    function construct ($host = null, $login = null, $password = null, $database = null) {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;
        $this->database = $database;
    }
    
    /*
     * команда INSERT SQL
     * $tablename - имя таблицы 
     */
    function insert ($tablename) {
        $this->command = "INSERT INTO $tablename ";
        $this->shemeCall = "INSERT";
        return;
    }
    
    /*
     * Condition - условие которое требуется передать
     * Для всех запросов $condition должен иметь форму: [name=>Andrey, age=>28,...]
     * может быть как 1 так и несколько условий.
     * Внутри функции реализуются все необходимые преобразования для запроса
     * Для запросов в которых непредусмотрено условий выведется сообщение об ошибки
     */
    
    function condition (array $condition) {
        
       $keys = array_keys($condition);
       $values = array_values($condition);
       //$keysCount = count($keys);  // мб пригодится для проверки пользователя на некорректность введённых данных
       //$valuesSize = count($values);
       
       /*
        * Вспомогательная функция для вывода элементов массива в виде ([1],[2]..)
        * пригодным для выолнения SQL
        * @return = (string) (array[0]...)
        */
       function contructorCondition ($array){
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
        * В зависимости от схемы команды определенной в функции Command
        * определяется условие
        */
        switch ($this->shemeCall){
            case 'INSERT':
                $this->condition = contructorCondition($keys);
                $this->condition .= " VALUES ";
                $this->condition .= contructorCondition($values);
                break;
            default :
                echo "PLEASE CALL COMMAND: INSERT(\$tablename) or ...."; //дописать подсказку
                break;
                }
        
    }
    
    
    /*
     * Функция формирует пост условие
     * через метод перехватчик тк их код  - ORDER BY и GROUP BY идентичен
     * для Order и Group By передаётся аргументы (arg1...)
     */
    public function __call($name, array $params) {
        switch ($name){
            case 'OrderBy':
                $this->postcondition = " ORDER BY";
                break;
            default:
                echo "Method $name not exist";
                return;
        }
                
        $countParams = count($params);
        $i=0;
        while ($i<$countParams){
            $this->postcondition .= " $params[$i],";
            $i++;
            }
        $this->postcondition = substr($this->postcondition, 0,-1); 
        
    }
    
    
     /*
     * Функция возращает полученный запрос в виде строки
     * @return string
     */   
    function get(){
       $SQLquerry = $this->command.$this->where.$this->condition.$this->postcondition;
       echo $SQLquerry;
    }
}

$test = new SQL_Builder();

$test->insert('myTable');
$test->condition(['name'=>'Andrey', 'age'=>28]);
$test->OrderBy('name','age');
$test->get();
