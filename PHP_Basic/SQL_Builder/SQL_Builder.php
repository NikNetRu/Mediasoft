<?php
class SQL_Builder {
    
        private $host = null;
        private $login = null;
        private $password = null;
        private $database = null;
        private $querry = null;
        
    // при обьявлении экземпляра можно указать свойства подключения к БД
    function construct ($host = null, $login = null, $password = null, $database = null) {
        $this->host = $host;
        $this->login = $login;
        $this->password = $password;
        $this->database = $database;
    }
    
    
    /*
     * Функция возращает полученный запрос в виде строки
     * @return string
     */
    function get(){
        
    }
}

$test = new SQL_Builder();


function setMultiple($keys, $value, &$target) {
    if (count($keys) === 1) {
    $target[array_pop($keys)] = $value;
    return;
    }
    
    $firstkey = array_shift($keys);
    if (!array_key_exists($firstkey, $target)) {
      $target[$firstkey] = [];
    }
    
    setMultiple($keys, $value, $target[$firstkey]);
}

$food = array (
  'food' => array (
          'apple' => array 
               (
               'price' => 17,
               'kkal' => 88,
               'color' => 'green',
               ),
          'pineapple' => array 
               (
               'price' => 19,
               'kkal' => 844,
               'color' => 'orange',
               ),
          'pineapplepen' => array 
               (
               'price' => 139,
               'kkal' => 8434,
               'color' => '???',
               )
  )   ,
    
  'Doublefood' => array (
          'apple' => array 
               (
               'price' => 17,
               'kkal' => 88,
               'color' => 'green',
               ),
          'pineapple' => array 
               (
               'price' => 19,
               'kkal' => 844,
               'color' => 'orange',
               ),
          'pineapplepen' => array 
               (
               'price' => 139,
               'kkal' => 8434,
               'color' => '???',
               )
  )   
);

$lineararray = array('food' => array ('apple' => ' green'));

setMultiple(['Doublefood','apple','kkal'], '2000', $food);
print_r($food);

echo 'NEXT </br>';
setMultiple(['food','apple'], 'red', $lineararray);
print_r($lineararray);
