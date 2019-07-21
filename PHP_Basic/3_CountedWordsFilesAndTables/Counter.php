
<?php
/*
 * На входе текст
 * На выходе массив  слов [слово=>количество]
 */
include_once 'exeTables.php';


function textToWords ($text)
{   
    $summaryWords = 0; //общее число слов
    $preText = strtolower($text); //приводим к нижнему регистру
    $preWords = explode(' ', $preText);  //разбиваем текст на слова со спец символами
    $words = str_replace(['.',',','-','?','"','(',')','«'], [], $preWords);  //удаляем ненужные символы

    foreach ($words as $key => $value){  //удаляем из массива пустые значения и приводим их к нижнему регистру  
        if ($value === ''){
        unset($words[$key]);
        }
    }
    
    return $words;
}

/*
 * На входе массив слов
 * На выходе массив[слово=>количество]
 */
function counterWord (array $words) 
{   
    $resultArray = array_count_values($words);
    return $resultArray;
}

/*
 * На входе массив ключ-значение на выходе файл ключ-значение /r....
 */
function createCSVFile (array $words, string $filename)
{  
    foreach ($words as $key => $value){
        file_put_contents($filename, "$key;$value \r", FILE_APPEND);
    }
}

function putToLinkedTables (pdoTables $PDO, array $words, $id)
{
    foreach ($words as $key => $value){
        $PDO->insertLinkedRow($id,$key, $value);
    }
}

function putContentToUser ()
{  
    file_get_contents('send.php');
}


 
if (is_uploaded_file($_FILES['loadTxt']['tmp_name'])){
    $text = $_FILES['loadTxt'];
    $tables = new pdoTables('text','tableMain','tableLinked'); //создаём PDO для главной и зависимой таблицы
    $tables->createLinkedTable(); //если не существуют создаём
    $textOriginal = file_get_contents($_FILES['loadTxt']['tmp_name']);
    $text = mb_convert_encoding($textOriginal, 'utf-8');  //на всякий случай меняем кодировку
    $text = str_replace(PHP_EOL, ' ', $text);     //удаляем переносы строк
    $result = textToWords($text);
    $numberWords = count($result);
    $result = counterWord($result);
    $numberRowMain = $tables->insertMainRow($textOriginal, $numberWords);
    putToLinkedTables ($tables, $result, $numberRowMain);
    createCSVFile($result, 'resultLoadedFile.csv');
    setcookie('numTable', $numberRowMain);
    setcookie('filename', 'resultTypedText.csv');
    $tables->drawRowTable($numberRowMain);
    putContentToUser('resultLoadedFile.csv');
    if (file_exists('resultLoadedFile.csv')){
    unlink('resultLoadedFile.csv');
    }
}

$typingText = filter_input(INPUT_POST, "typingTxt");
if ($typingText != null){
    $tables = new pdoTables('text','tableMain','tableLinked'); //создаём PDO для главной и зависимой таблицы
    $tables->createLinkedTable(); //если не существуют создаём
    $result = $typingText;
    $result = textToWords($typingText);
    $numberWords = count($result);
    $result = counterWord($result);
    $numberRowMain = $tables->insertMainRow($typingText, $numberWords);
    putToLinkedTables ($tables, $result, $numberRowMain);
    createCSVFile($result, 'resultTypedText.csv');
    setcookie('numTable', $numberRowMain);
    setcookie('filename', 'resultTypedText.csv');
    $tables->drawRowTable($numberRowMain);
    putContentToUser('resultTypedText.csv');
    if (file_exists('resultTypedText.csv')){
    unlink('resultTypedText.csv');
    }
}

echo filter_input(INPUT_COOKIE, 'filename');

