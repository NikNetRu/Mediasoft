
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head> 
        <div id ="AddTxt">
            <form enctype="multipart/form-data" method="POST">
                <label>Загрузить текст</label> <input id = "loadTxt" name = "loadTxt" type="file"> <br>
                <button type = "submit">Отправить</button> <br>
            </form>
        </div>

<?php
include_once 'Counter.php';

if (array_key_exists('loadTxt', $_FILES))
{
$text = $_FILES['loadTxt'];
$text = file_get_contents($_FILES['loadTxt']['tmp_name']);
$text = mb_convert_encoding($text, 'utf-8');  //на всякий случай меняем кодировку
$text = str_replace(PHP_EOL, ' ', $text);     //удаляем переносы строк
echo '</br> Искомый текст :' . $text;

CounterText($text);
}