<?php
require_once "task.php";
header('Content-type: text/plain'); //нужно чтобы браузер не воспринимал это как HTML Документ
// Считываем данные тестов
$inputFiles = glob('test/*.dat');
$outputFiles = glob('test/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $readStr = fopen($output, 'r');
    $right_answer = trim(fgets($readStr), " \n\r\t"); //убираем лишние символы
    echo "\nТест $num: ";
    $time_start = microtime(true); //запоминаем время запуска теста
    $prog_answer = init($input);
    echo("\nВремя работы программы: " . (microtime(true) - $time_start) . " секунд\n" ); //вычисление времени работы и вывод
    
    if ($right_answer == $prog_answer) {
        echo "Ок\n";
    } else {
        echo "Ошибка\nВерный ответ: $right_answer\nОтвет программы: $prog_answer\n";
    }
    $num++;
}