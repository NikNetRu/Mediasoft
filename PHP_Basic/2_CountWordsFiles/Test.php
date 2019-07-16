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

$test = 'Main test words test main';
$test = textToWords($test);
$test = counterWord($test);
print_r($test); 