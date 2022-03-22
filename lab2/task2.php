<?php

function Svalidation( $string, $n, $m) { //валидация типа S
	$pattern = "/^[a-zA-Z _']{" . $n . "," . $m . "}$/";
	return preg_match($pattern, $string);
}

function Nvalidation( $string, $n, $m ) { //валидация типа N
	$pattern = "/^[-0-9][0-9']{0,10}$/"; //сначала проверим число ли это
	if (preg_match($pattern, $string) === 1) {
		$val = intval($string);
		return $n <= $val and $val <= $m; //проверка на интервал
	}
	else
		return false;
	
}

function Pvalidation( $string) { //валидация типа P
	$pattern = "/^[+][7][ ][(][0-9]{3}[)][ ][0-9]{3}[-][0-9]{2}[-][0-9]{2}$/";
	return preg_match($pattern, $string);
}

function Dvalidation( $string) { //валидация типа D
	$pattern = "^[0-9]{1,2}.[0-9]{1,2}.[0-9]{4} [0-9]{1,2}:[0-9]{1,2}^"; //проверка на правильный формат
	if (preg_match($pattern, $string) === 1){ 
		//считываем дату и время в удобном формате
		$date = explode(" ", $string)[0];
		$time = explode(" ", $string)[1];
		$date = explode(".", $date);
		$time = explode(":", $time);

		if ( checkdate($date[1], $date[0], $date[2]) == false ) //проверяем дату
			return false; 
		if ( intval($time[0]) >= 24 ) //проверяем часы
			return false;
		if ( intval($time[1]) >= 60 ) //проверяем минуты
			return false;

		return true;
	}
	else
		return false;
	
}

function Evalidation( $string) { ////валидация типа E 
	$pattern = "/^[a-zA-Z][a-zA-Z0-9_]{3,29}@[a-zA-Z]{2,30}[.][a-z]{2,10}$/";
	return preg_match($pattern, $string);
}

function validate($input) { //общая функция для валидации
	$input = trim($input, "<"); //убираем первую угловую скобку для удобства чтения
	$params = array(); //параметры валидации в виде массива
	$inputArray = str_split($input); //исходная строка
	$index = 0; //индекс для params
	foreach ($inputArray as $element) { //считываем входные данные символ за символом
		if ($index == 0) { //первый аргумент считываем полностью до закрывающейся скобки
			if ($element == ">") {
				$index = 1;
			}
			else {
				$params[$index] .= $element;
			}
		}
		else {
			if ($element == " ") {
				$index+=1;
			}
			else {
				$params[$index] .= $element;
			}
		}
	}

	$answer = 0; //результат валидации
	switch ($params[2]) { //каждому паттерну своя функция
		case 'S':
			$answer = Svalidation($params[0], $params[3], $params[4]);
			break;
		case 'N':
			$answer = Nvalidation($params[0], $params[3], $params[4]);
			break;
		case 'P':
			$answer = Pvalidation($params[0]);
			break;
		case 'D':
			$answer = Dvalidation($params[0]);
			break;
		case 'E':
			$answer = Evalidation($params[0]);
			break;
		
		default: //если такого паттерна нет, то выдаём FAIL
			return "FAIL";
	}

	if ($answer === 1 or $answer === true) //Из-за preg_match вместо true может быть 1 в некоторых случаях
		return "OK";
	else
		return "FAIL";
}

