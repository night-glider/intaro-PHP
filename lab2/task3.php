<?php

function task3($string) {
	$pattern = "/'[0-9]'/"; //находим все цифры в апострофах
	$matches = array(); //массив совпадений
	preg_match_all($pattern, $string, $matches); //находим все совпадения и сохраняем их в массиве
	preg_match_all($pattern, $string, $pattern); //находим все совпадения и сохраняем их в массиве pattern для того чтобы использовать похже
	foreach ($pattern[0] as &$element) { //превращаем наш массив совпадений в массив регулярных выражений, по которым мы будем потом заменять значения
		$element = "/" . $element . "/";
	}

	foreach ($matches[0] as &$element) { //распаковываем, умножаем на 2 каждое число, запаковываем обратно
		$element = trim($element, "'");
		$element = intval($element) * 2;
		$element = "'" . $element . "'";
	}
	return preg_replace($pattern[0], $matches[0], $string, 1); //заменяем каждую цифру на новую. Каждой регулярке свое число
}

echo task3("2aaa'3'bbb'4'");