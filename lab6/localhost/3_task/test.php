<?php
require_once "task.php";
// Считываем данные тестов
$inputFiles = glob('data/*.dat');
$outputFiles = glob('data/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $read = fopen($output, 'r');
    $right_answer="";
    while(!feof($read)){
        $str = trim(fgets($read), " \r");   //считываем правильный ответ и обрезаем перенос каретки
        if(!empty($str)){
            $right_answer.=trim($str,"\r\t\n")."\n";
        } 
    }
    $prog_answer = getResult($input); //получаем результат программы
    echo "<br>Тест $num: <br>";
    echo "Заготовленный текст: <br>$right_answer<br>";
    echo "Ответ программы: <br>$prog_answer<br>";
    $num++;
}