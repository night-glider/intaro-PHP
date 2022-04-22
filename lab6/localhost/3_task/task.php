<?php

/*
Функция, которая эмулирует показ рекламы на баннере.
ad_data - словарь с данными о рекламе. Ключ - id рекламы. Значение - вес рекламы.
count - Сколько раз показать рекламу
Возвращает статистику показа. Ключ - id рекламы. Значение - частота появления рекламы
*/
function showAllAds($ad_data, $count){
    $statistic = []; //словарь для статистики
    $max = 0; //Сумма всех весов реклам
    foreach ($ad_data as $key => $value) {
        $max+=$value;
        $statistic[$key] = 0; //обнуляем статистику.
    }
    
    $rand = 0; //случайное значение
    for($i = 0; $i < $count; $i++){
        //Здесь мы генерируем случайную дробь. От 0 до max 
        $rand = mt_rand() / mt_getrandmax();
        $rand *= $max;
        $last_val = 0;
        //сопоставляем случайное число соответствующей рекламе
        foreach ($ad_data as $key => $value) {
            if ( $rand >= $last_val and $rand <= ($last_val + $value) ){
                $statistic[$key] += 1; //обновляем статистику для соответствующей рекламы
                break;
            }
            $last_val += $value;
        }
    }
    //Получаем частоту появления каждой рекламы.
    foreach ($statistic as $key => $value) {
        $statistic[$key] = $value/$count;
    }
    return $statistic;
}

/*
file_path - путь к файлу, в котором находится информация о рекламе.
Возвращает строку со статистикой показа
*/
function getResult($file_path){
    $file=fopen($file_path, 'r'); //открываем файл на чтение
    $ad_data = []; //словарь рекламных данных
    //Получаем информацию о рекламе
    while(!feof($file)){
        $str=trim(fgets($file));
        $data = explode(" ", $str);
        $ad_id = $data[0];
        $ad_freq = $data[1];
        $ad_data[$ad_id] = $ad_freq;
    }
    $statistic = showAllAds($ad_data, 1000000); //эмулируем показ 1000000 реклам и получаем статистику 
    $result_str = "";
    //выводим статистику в строку.
    foreach ($statistic as $key => $value) {
        $result_str.= "$key $value\n";
    }
    return $result_str;
}