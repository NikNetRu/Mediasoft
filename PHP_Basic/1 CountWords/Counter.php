<?php
function CounterText ($text)
{   
    $summaryWords = 0; //общее число слов
    $preText = strtolower($text); //приводим к нижнему регистру
    $preWords = explode(' ', $preText);  //разбиваем текст на слова со спец символами
    $words = str_replace(['.',',','-','?','"','(',')','«'], [], $preWords);  //удаляем ненужные символы

    foreach ($words as $key => $value)  //удаляем из массива пустые значения и приводим их к нижнему регистру
    {  
        if ($value === '')
        {
        unset($words[$key]);
        }
        
    }

    $summaryWords = count($words); //число слов в тексте
    echo '<br>Общее число слов :'.$summaryWords;

//Возвращает число совпадений слов в искомом массиве строк
        function countWord (array $words) 
    {
            $counter =1;
            sort($words);
            $countedWords = count($words);
            For ($i = 0; $i<$countedWords; $i++)
            {  
                if ($i === $countedWords-1) 
                {
                    echo '</br>'.$words[$i] . ':' . $counter;
                    return;
                }
                
                if ($words[$i] === $words[$i+1])
                {
                $counter++;
                }
                else 
                {
                echo '</br>'.$words[$i] . ':' . $counter;
                $counter = 1;
                }
             }
     }
     countWord($words);
 }