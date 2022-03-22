<?php
require_once "task1.php";
header('Content-type: text/plain'); //нужно чтобы браузер не воспринимал это как HTML Документ
// Считываем данные тестов
$inputFiles = glob('1test/*.dat');
$outputFiles = glob('1test/*.ans');
$num=0;
foreach(array_combine($inputFiles,$outputFiles) as $input => $output) {
    $inputFile = fopen($input, 'r');
    $outputFile = fopen($output, 'r');
    echo "\nТест $num: ";
    $time_start = microtime(true); //запоминаем время запуска теста

    while (true) {
        $inputLine = fgets($inputFile);
        if ($inputLine == false) {
            break;
        }
        $inputLine = trim($inputLine, " \n\r\t");
        $right_answer = trim(fgets($outputFile), " \n\r\t");
        $prog_answer = task1($inputLine);

        if ($right_answer == $prog_answer) {
            echo "Ок\n";
        } else {
            echo "Ошибка\nВерный ответ: $right_answer\nОтвет программы: $prog_answer\n";
        }
    }

    echo("\nВремя работы программы: " . (microtime(true) - $time_start) . " секунд\n" ); //вычисление времени работы и вывод
    $num++;
}