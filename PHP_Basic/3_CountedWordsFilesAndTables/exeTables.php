<?php

class pdoTables 
{   
    private $namePDO = null;
    private $nameMain = null;
    private $nameLinked = null;
    private $pdoObject = null;
    function __construct($namePDO, $nameMain, $nameLinked) 
    {   
        $this->namePDO = $namePDO;
        $this->nameMain = $nameMain;
        $this->nameLinked = $nameLinked;
        $this->pdoObject = new PDO("mysql:host=127.0.0.1; dbname=$this->namePDO", 'root', '');
    }
    
    function createMainTable()
    {
        
        $this->pdoObject->query("CREATE TABLE $this->nameMain (
                id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                text TEXT,
                numberWords INT(4),
                date TIMESTAMP);");
    }
    
    function createLinkedTable () 
    {
        $this->pdoObject->query("CREATE TABLE $this->nameLinked (
                id INT(4) REFERENCES $this->nameMain(id),
                word VARCHAR(20),
                numberWord INT(4)
                );");
    }
    
    function insertMainRow ($text, $numberWords)
    {
        $this->pdoObject->query("INSERT INTO $this->nameMain (text, numberWords) 
                VALUES ('$text', '$numberWords');");
        return $this->pdoObject->lastInsertId('id');
    }
    
    function insertLinkedRow ($id, $word, $numberWord)
    {
        $this->pdoObject->query("INSERT INTO $this->nameLinked (id, word, numberWord) 
                VALUES ('$id','$word', '$numberWord');");        
    }
    
    function drawRowTable ($id) 
    {   
        $count = "SELECT COUNT(id) FROM $this->nameLinked WHERE id = '$id'";
        $rows = $this->pdoObject->query($count)->fetchAll();
        $rows  = $rows[0][0];
        $cols = 2;
        $summaryWords = "SELECT numberWords,text FROM $this->nameMain WHERE id = '$id'";
        $result = $this->pdoObject->query($summaryWords);
        $result = $result->fetchAll();
        echo 'Общее число слов '.$result[0]['numberWords'].'.</br> Искомый текст '.$result[0]['text'];
        echo '</br>';
        echo '<table border="1">';
        $querryDetails = "SELECT word,numberWord FROM $this->nameLinked";
        $result = $this->pdoObject->query($querryDetails)->fetchAll();
            for ($tr=0; $tr<$rows; $tr++){ 
            echo '<tr>';
                for ($td=0; $td<$cols; $td++){ 
                echo '<td>'. $result[$tr][$td] .'</td>';
                }
            echo '</tr>';
            }
        echo '</table>';
    }
    
    
}