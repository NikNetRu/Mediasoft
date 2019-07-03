<?php
/*
 * Фраза запроса комманда - имя таблицы/или где выполнять запрос - условие - постусловие
 */
include_once 'Insert.php';
include_once 'Select.php';
include_once 'Engine.php';
class SQL_Builder {
    
        private $host = null;
        private $login = null;
        private $password = null;
        private $database = null;
        private $querry = null;  // результирующий запрос
        private $shemeCall = null; //содержит обьект запроса
        //
    // при обьявлении экземпляра можно указать свойства подключения к БД
    function __construct ($host = null, $login = null, $password = null, $database = null) {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;
        $this->database = $database;
    }
    
    
    /*
     * команда INSERT SQL - создаёт класс внутри обекта SQL Builder
     * $tablename - имя таблицы 
     */
    function Insert ($tablename) {
        $this->shemeCall = new Insert($tablename);
    }
    
    function Select ($tablename) {
        $this->shemeCall = new Select($tablename);
    }
    
    
    /*
     * Condition - условие которое требуется передать
     * Для всех запросов $condition должен иметь форму: [name=Andrey, age=>28,...]
     * может быть как 1 так и несколько условий.
     * Внутри функции реализуются все необходимые преобразования для запроса
     * Для запросов в которых непредусмотрено условий выведется сообщение об ошибки
     */
    
    function Condition (array $condition) {
        $this->shemeCall->ConditionExample($condition);
    }
    
    
     /*
     * Функция возращает полученный запрос в виде строки
     * @return string
     */   
    function Get(){
       return $this->shemeCall->GetExample();
    }
    
    
    /*
     * Обработка непредусмотренных вызываемых функций
     * Так же включен вызов OrderBy и GroupBy - они схожие
     */
    public function __call($name, array $params) {
        if ($this->shemeCall === null){
            echo 'Инициализируйте команду смотри HELP';
            die();
        }
        
        if (!method_exists($this->shemeCall, $name)) {
            echo 'В рамках класса '. get_class($this->shemeCall).' метод '.$name.' не предусмотрен';
            die();
            } 
        return $this->shemeCall->$name($params);
        
    }
}
echo '</br> INSERT TEST</br>';
$test = new SQL_Builder();
$test->Insert('mytable');
$test->Condition(['name=andrey','age <=> 28']);
$querry = $test->Get();
//$test->OrderBy();
echo $querry;

echo '</br></br> SELECT TEST</br>';
$test = new SQL_Builder();
$test->Select('testTable');
$test->Condition(['row1','row2']);
$test->OrderBy(['names','d']);
$test->Where(['name','d']);
echo $test->Get();