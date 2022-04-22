<?php

/*
Функция минимизации данных о margin или padding.
str:String - определяет первое слово свойства(margin или padding)
margin_top, margin_right, margin_bottom, margin_left - соответствующие параметры.
Возвращает минимизированную строку
*/
function minifyMargin($str, $margin_top, $margin_right, $margin_bottom, $margin_left){
    //Если данные пусты, то возвращаем пустую строку
    if( $margin_top == "" and $margin_right == "" and $margin_bottom == "" and $margin_left == "" ){
        return "";
    }
    //Если все данные одинаковые, то возвращаем margin:<значение>;
    if ($margin_top == $margin_right and $margin_bottom == $margin_left){
        return $str . ":" . $margin_left . ";";
    }
    //Делаем проверку на то, что все данные не равны пустой строке.
    if ($margin_left != "" and $margin_top != "" and $margin_bottom != "" and $margin_right != ""){
        //Возвращаем соответствующий margin:<знач1> <знач2> <знач3> <знач4>;
        return $str . ":$margin_top $margin_right $margin_bottom $margin_left;";
    }
    //На случай того, что какое-то из значений отсутствует(к примеру margin_bottom), собираем новую строку
    $result = ""; //строка-результат

    //добавляем к названию свойства приписку "-custom". Это нужно для того чтобы наше свойство потом не удалил парсер.
    $str.="-custom"; 

    //Если margin_top не равен пустой строке (есть значение), то добавляем к результату строку вида margin-custom-top:<знач>:
    if ($margin_top != ""){
        $result .= $str . "-top:$margin_top;";
    }
    if ($margin_right != ""){
        $result .= $str . "-right:$margin_right;";
    }
    if ($margin_bottom != ""){
        $result .= $str . "-bottom:$margin_bottom;";
    }
    if ($margin_left != ""){
        $result .= $str . "-left:$margin_left;";
    }
    return $result;
}

/*
Функция нахождения слова. Словом считается любая последовательность символов кроме : и }
str - строка, в которой находим слово
offset - позиция, с которой начинаем поиск
Возвращает слово(Строка)
*/
function getWord($str, $offset){
    $result = ""; //строка-результат
    //начинаем проход по строке с нужной позиции
    for ($i=$offset; $i < 99999; $i++) { 
        //Если встречаем : или } то выходим из цикла и возвращаем слово
        if ($str[$i] == ":" or $str[$i] == "}"){
            break;
        }
        $result.= $str[$i];
    }
    return $result;
}


/*
Функция минимизации CSS в соответствии с заданием
file_path - путь к файлу, который необходимо минимизировать
Возвращает строку
*/
function getResult($file_path){
    $hexes = ["#CD853F",'#FFC0CB','#DDA0DD','#FF0000','#FFFAFA','#D2B48C']; //Массив 16ричных значений цветов
    $colors = ["peru", "pink", "plum", "red","snow", "tan"]; //Массив названий HTML цветов
    $file=fopen($file_path, 'r'); //открываем файл на чтение
    $is_in_comment = false; //специальный флаг, который определяет находимся ли мы сейчас в комментарии
    $result = ""; //строка-результат

    $text = file_get_contents($file_path); //считываем весь текст в одну строку

    $text = preg_replace('/[ \n\t]/', "", $text); //убираем все пробелы, табуляцию и переводы строки
    $text = str_replace(":0px", ":0", $text); //заменяем все 0px на 0
    $text = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $text); //Удаляем все пустые стили.
    $text = str_replace($hexes, $colors, $text); //Заменяем все заранее заготовленные 16ричные цвета на соответствующие HTML цвета
    //Если в 16ричном представление цвета символы в каждом из трёх разрядов по два символа совпадают, то сокращаем до трёх разрядов по одному символу
    $text = preg_replace('/#([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]([0-9A-z])[0-9A-z]/', "#$1$2$3", $text);
    //Убираем лишние ;
    $text = preg_replace('/;}/', "}", $text);

    $text_array = str_split($text); //для итерации по строке сначала разбиваем её на массив символов
    $new_text = ""; //новый текст CSS
    foreach ($text_array as $key => $value) {
        //Если встречаем /*, то переключаем флаг is_in_comment на true
        if( $text_array[$key] == "/" and $text_array[$key+1] == "*"){
            $is_in_comment = true;
            continue;
        }
        //Если встречаем */, то переключаем флаг is_in_comment на false
        if( $text_array[$key] == "/" and $text_array[$key-1] == "*"){
            $is_in_comment = false;
            continue;
        }
        //Если мы сейчас находимся в комментарии, то пропускаем итерацию
        if ($is_in_comment == true){
            continue;
        }
        //Если нам на пути встретился {, значит это новый блок. А значит нужно обнулить значения margin'ов и padding'ов
        if ( $value == "{" ){
            $margin_top = "";
            $margin_right = "";
            $margin_bottom = "";
            $margin_left = "";

            $padding_top = "";
            $padding_right = "";
            $padding_bottom = "";
            $padding_left = "";
        }
        //Если на пути встретился }, значит это конец блока. А значит нужно вставить минимизированные magin'ы и padding'и
        if ( $value == "}" ){
            //Добавляем в конец блока минимизированный magin
            $new_text.=minifyMargin("margin", $margin_top, $margin_right, $margin_bottom, $margin_left);
            //Добавляем в конец блока минимизированный padding
            $new_text.=minifyMargin("padding", $padding_top, $padding_right, $padding_bottom, $padding_left);
        }

        //Если следующее слово "margin-top" то находим его значение и записываем в соответствующую переменную
        if (getWord($text, $key) == "margin-top"){
            preg_match('/margin-top:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $margin_top = $matches[1];
        }
        if (getWord($text, $key) == "margin-right"){
            preg_match('/margin-right:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $margin_right = $matches[1];
        }
        if (getWord($text, $key) == "margin-bottom"){
            preg_match('/margin-bottom:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $margin_bottom = $matches[1];
        }
        if (getWord($text, $key) == "margin-left"){
            preg_match('/margin-left:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $margin_left = $matches[1];
        }

        //Если следующее слово "padding-top" то находим его значение и записываем в соответствующую переменную
        if (getWord($text, $key) == "padding-top"){
            preg_match('/padding-top:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $padding_top = $matches[1];
        }
        if (getWord($text, $key) == "padding-right"){
            preg_match('/padding-right:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $padding_right = $matches[1];
        }
        if (getWord($text, $key) == "padding-bottom"){
            preg_match('/padding-bottom:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $padding_bottom = $matches[1];
        }
        if (getWord($text, $key) == "padding-left"){
            preg_match('/padding-left:([0-9]{1,10}p?x?)/', substr($text, $key-1), $matches);
            $padding_left = $matches[1];
        }
        //добавляем в текущий символ
        $new_text.= $value;
    }

    $result.=$new_text; //записываем в result новый текст
    //массив regex'ов по которым мы будем удалять ненужные margin'ы и padding'и
    $regexes = [
        '/margin-top:[0-9]{1,10}p?x?;?/',
        '/margin-right:[0-9]{1,10}p?x?;?/',
        '/margin-bottom:[0-9]{1,10}p?x?;?/',
        '/margin-left:[0-9]{1,10}p?x?;?/',
        '/padding-top:[0-9]{1,10}p?x?;?/',
        '/padding-right:[0-9]{1,10}p?x?;?/',
        '/padding-bottom:[0-9]{1,10}p?x?;?/',
        '/padding-left:[0-9]{1,10}p?x?;?/'
    ];
    $result = preg_replace($regexes, "", $result); //удаляем ненужные margin'ы и padding'и
    //Т.к. функция minifyMargin может вернуть набор margin-custom параметров, то нам нужно их заменить на обычные margin
    $result = preg_replace('/margin-custom/', 'margin', $result);
    //Т.к. функция minifyMargin может вернуть набор padding-custom параметров, то нам нужно их заменить на обычные padding
    $result = preg_replace('/padding-custom/', 'padding', $result);
    $result = preg_replace('/;}/', "}", $result); //После всех манипуляций могут остаться лишние ; Убираем их
    //После всех манипуляций могут остаться пустые стили. Удаляем их.
    $result = preg_replace('/[#.]?[a-zA-Z0-9]{1,10}>?[#.]?[a-zA-Z0-9]{1,10}{}/', "", $result);

    return $result;
}