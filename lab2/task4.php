<?php

function replace_link($string){ //замена ссылки. Возвращает новую ссылку
	$pattern = "/[0-9]{1,10}[-][0-9]{1,10}/"; //находим номер законопроекта
	preg_match($pattern, $string, $match);
	return "http://sozd.parlament.gov.ru/bill/" . $match[0]; //генерируем новую ссылку
}

function task4($string) {
	$pattern = "/http:\/\/asozd.duma.gov.ru\/main.nsf\/\(Spravka\)\?OpenAgent&RN=[0-9]{1,10}[-][0-9]{1,10}&[0-9]{1,10}/"; //находим ссылки
	preg_match_all($pattern, $string, $matches); //находим совпадения и сохраняем в массиве
	preg_match_all($pattern, $string, $pattern); //находим совпадения и сохраняем в массиве pattern чтобы потом использовать как маску для замены
	
	foreach($pattern[0] as &$element) { //маски для замены содержат специальные символы... заменяем их
		$element = str_replace("/", "\/", $element);
		$element = str_replace("?", "\?", $element);
		$element = str_replace("(", "\(", $element);
		$element = str_replace(")", "\)", $element);
		$element = "/" . $element . "/";
	}

	foreach ($matches[0] as &$element) { // заменяем все ссылки на новые
		$element = replace_link($element);
	}
	return preg_replace($pattern[0], $matches[0], $string); //теперь вставляем новые ссылки в документ
}

echo task4("test test test http://asozd.duma.gov.ru/main.nsf/(Spravka)?OpenAgent&RN=31990-6&2 test test test ");