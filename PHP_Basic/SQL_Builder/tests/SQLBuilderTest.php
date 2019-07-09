<?php
require_once '..\SQLBuilder.php';

class SQLBuilderTest extends SQLBuilder
{ 
    private $resultTest = null;
    
    function insertTest () 
    {   //Позитивный тесткейс
        $expectedresult = "INSERT INTO MyTable (name,age,sex) VALUES ('Andrey','28','male')";
        $result = new SQLBuilder();
        $result->insert('MyTable');
        $result->condition(['name = Andrey','age = 28', 'sex = male']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['INSERT','1','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['INSERT','1','FALSE',$querry];
        }
        //Негативный тесткейс
        $expectedresult = "INSERT INTO MyTable222 (125,0,) VALUES ('','28','male')";
        $result = new SQLBuilder();
        $result->insert('MyTable222');
        $result->condition(['125 = <<','0 = 28', '<> = male']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['INSERT','2','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['INSERT','2','FALSE',$querry];
        }  
    }
    
    function deleteTest () 
    {   //Позитивный тесткейс
        $expectedresult = "DELETE FROM MyTable WHERE name='Andrey' AND age>'28' AND sex!='male' OR colors!='blue' OR flowers!='rose'";
        $expectedresult = trim($expectedresult);
        $result = new SQLBuilder();
        $result->delete('MyTable');
        $result->condition(['name = Andrey','age > 28', 'sex != male']);
        $result->whereOr(['colors != blue', 'flowers != rose']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['DELETE','1','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['DELETE','1','FALSE',$querry];
        }
        //Негативный тесткейс
        $expectedresult = "DELETE FROM MyTable WHERE name=<<'' AND 0='28' AND !='male'";
        $result = new SQLBuilder();
        $result->delete('MyTable');
        $result->condition(['name =<<','0 = 28', '<> != male']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['DELETE','2','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['DELETE','2','FALSE',$querry];
        }  
    }

    function SelectTest () 
    {   //Позитивный тесткейс
        $expectedresult = "SELECT name, age, email FROM MyTable WHERE name='Andrey' AND age>'28' AND sex!='male' GROUP BY name, age,family ORDER BY name, age";
        $expectedresult = trim($expectedresult);
        $result = new SQLBuilder();
        $result->select('MyTable');
        $result->condition(['name, age, email']);
        $result->where(['name=Andrey','age>28', 'sex!=male']);
        $result->orderBy(['name, age']);
        $result->groupBy(['name, age','family']);
        $result->get();
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['SELECT','1','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['SELECT','1','FALSE',$querry];
        }
        //Негативный тесткейс
        $expectedresult = "SELECT email, email, emma,, FROM MyTable";
        $expectedresult = trim($expectedresult);
        $result = new SQLBuilder();
        $result->select('MyTable');
        $result->condition(['email, email, emma,,']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['SELECT','2','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['SELECT','2','FALSE',$querry];
        }  
    }
    
    function updateTest () 
    {   //Позитивный тесткейс
        $expectedresult = "UPDATE MyTable SET name='error37' WHERE name='Andrey' AND age>'28' AND sex!='male'";
        $expectedresult = trim($expectedresult);
        $result = new SQLBuilder();
        $result->update('MyTable');
        $result->condition(['name=error37']);
        $result->where(['name = Andrey','age > 28', 'sex != male']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['UPDATE','1','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['UPDATE','1','FALSE',$querry];
        }
        //Негативный тесткейс
        $expectedresult = "UPDATE table SET cash='99'";
        $result = new SQLBuilder();
        $result->update('table');
        $result->condition(['cash = 99']);
        $querry = $result->get();
        if ($querry === $expectedresult){
            $this->resultTest[] = ['UPDATE','2','SUCESS',$querry];
        }
        else {
            $this->resultTest[] = ['UPDATE','2','FALSE',$querry];
        }  
    }
    
    function drawTable ()
    {
        $rows = count($this->resultTest); // количество строк
        $cols = 4;
        echo '<table border="1">';
            for ($tr=0; $tr<$rows; $tr++){ 
            echo '<tr>';
                for ($td=0; $td<$cols; $td++){ 
                echo '<td>'. $this->resultTest[$tr][$td] .'</td>';
                }
            echo '</tr>';
            }
        echo '</table>';
    }
}

$test = new SQLBuilderTest();
$test->insertTest();
$test->deleteTest();
$test->selectTest();
$test->updateTest();
$test->drawTable();