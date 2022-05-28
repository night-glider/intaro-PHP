<?php

//Функция, выполняющая задание
//Принимает Путь к файлу с входными данными
//Возвращает строку-результат
function getResult($file_path){
    $file=fopen($file_path, 'r'); //открываем файл на чтение
    $counts = []; //словарь с кол-вом показов банера. Ключ - id банера. Значение - кол-во показов
    $last_date = []; //словарь с датой последнего показа. Ключ - id банера. Значение - дата последнего показа
    while(!feof($file)) {
        $line = fgets($file);
        $data = explode("\t", $line);
        $id = $data[0];
        $data[1] = trim($data[1]);

        //Превращаем строку с датой в объект DateTime
        $date = date_create_from_format("d.m.Y H:i:s", $data[1]);
        //Считаем показы рекламы.
        if (array_key_exists($id, $counts) ){
            $counts[$id] += 1; //Если в словаре уже есть ID этой рекламы, то инкрементируем
        }else{
            $counts[$id] = 1; //Если в словаре нет ID этой рекламы, то приравниваем 1.
        }
        //Считаем дату последнего показа
        if (array_key_exists($id, $last_date) ){
            //Если текущая дата позже, то записываем текущую дату
            if ( $last_date[$id] < $date ){
                $last_date[$id] = $date;
            }
        }else{
            $last_date[$id] = $date; //Если в словаре нет ID этой рекламы, то приравниваем текущую дату
        }
    }
    $result_string = ""; //Строка с результатом
    foreach ($counts as $key => $value){
        //Превращаем объект DateTime в строку
        $date = date_format($last_date[$key], "d.m.Y H:i:s");
        $result_string.="$value $key $date\n";
    }
    return $result_string;
}
