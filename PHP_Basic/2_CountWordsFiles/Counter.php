<?php
/*
 * На входе текст
 * На выходе массив  слов [слово=>количество]
 */
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
    unlink($filename);
    foreach ($words as $key => $value){
        file_put_contents($filename, "$key;$value \r", FILE_APPEND);
    }
}

function putContentToUser ($filename)
{
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filename).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filename));
    readfile($filename);
}

 
if (is_uploaded_file($_FILES['loadTxt']['tmp_name'])){
    $text = $_FILES['loadTxt'];
    $text = file_get_contents($_FILES['loadTxt']['tmp_name']);
    $text = mb_convert_encoding($text, 'utf-8');  //на всякий случай меняем кодировку
    $text = str_replace(PHP_EOL, ' ', $text);     //удаляем переносы строк
    $result = textToWords($text);
    $result = counterWord($result);
    createCSVFile($result, 'resultLoadedFile.csv');
    putContentToUser('resultLoadedFile.csv');
}

$typingText = filter_input(INPUT_POST, "typingTxt");
if ($typingText != null){
    $result = $typingText;
    $result = textToWords($typingText);
    $result = counterWord($result);
    createCSVFile($result, 'resultTypedText.csv');
    putContentToUser('resultTypedText.csv');
}