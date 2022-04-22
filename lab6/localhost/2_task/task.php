<?php

/*
Функция нахождения раздела с искомым left key
raw_node_data - словарь с информацией по разделам
left_key - искомый left key
Возвращает id раздела
*/
function findLeftKey($raw_node_data, $left_key){
    //проходимся последовательно по всем разделам и проверяем ключ
    foreach ($raw_node_data as $key => $value){
        if ( $value["left_key"] == $left_key){
            return $key;
        }
    }
    //Если не смогли найти ключ, то возвращаем false
    return False;
}

/*
Функция нахождения корней дерева
raw_node_data - словарь с информацией по разделам
left_key - искомый left key
Возвращает массив id разделов
*/
function findRoots($raw_node_data, $left_key){
    $result = [];
    while(True){
        //находим id c искомым left_key
        $id = findLeftKey($raw_node_data, $left_key);
        //если не удалось найти раздел, то выходим из цикла
        if( $id === False){
            break;
        }
        //указываем следующий left key.
        $left_key = $raw_node_data[$id]["right_key"] + 1;
        //добавляем id раздела в массив
        array_push($result, $id);
    }
    return $result;
}

/*
рекурсивная функция отображения дерева
id - id корня дерева
node_data - словарь прямых потомков разделов. Ключ - id раздела. Значение - массив прямых потомков.
raw_node_data - словарь с информацией по разделам
level - уровень вложенности
string - указатель на строку, в которую будем печатать дерево
*/
function printTree($id, $node_data, $raw_node_data, $level, &$string){
    $string.=str_repeat("-", $level); //Печатаем знак "-" в соответствии с уровнем вложенности 
    $string.=$raw_node_data[$id]["name"]; //Печатаем название раздела
    $string.="\n"; //Перевод строки
    //А теперь проходимся по прямым потомкам и вызываем эту же функцию с каждым.
    foreach ($node_data[$id] as $key => $value) {
        printTree($value, $node_data, $raw_node_data, $level+1, $string);
    }
}

/*
Функция, которая находит прямых потомков для узла дерева.
id - id раздела, для которого находим потомков
node_data - указатель на словарь прямых потомков разделов
raw_node_data - словарь с информацией по разделам
*/
function getChilds($id, &$node_data, $raw_node_data){
    $left_key = $raw_node_data[$id]["left_key"]+1;
    $childs = findRoots($raw_node_data, $left_key);
    $node_data[$id] = $childs;
}

/*
file_path - путь к файлу с информацией о разделах.
Возвращает отформатированную строку
*/
function getResult($file_path){
    $file=fopen($file_path, 'r'); //открываем файл на чтение
    $raw_node_data = []; //словарь с информацией о разделах

    //Последовательно считываем информацию о разделах
    while(!feof($file)){
        $str=trim(fgets($file));
        $data = explode(" ", $str);

        $id = $data[0];
        $raw_node_data[$id]["name"] = $data[1];
        $raw_node_data[$id]["left_key"] = $data[2];
        $raw_node_data[$id]["right_key"] = $data[3];
    }
    $node_data = []; //словарь с прямыми потомками
    foreach ($raw_node_data as $key => $value) {
        getChilds( $key, $node_data, $raw_node_data );
    }
    //находим корни дерева(их может быть много)
    $roots = findRoots($raw_node_data, 1);
    $result = "";
    //последовательно печатаем каждое дерево
    foreach ($roots as $key => $value) {
        printTree($value, $node_data, $raw_node_data, 0, $result);
    }
    return $result;
}