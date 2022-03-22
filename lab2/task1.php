<?php

function task1( $ip ){
	$chars = 4; //количество оставшихся символов в блоке
	$blocks = 0; //пройденные блоки
	$result = "";
	$array = str_split($ip); //строка, по которой происходит итерация
	$array2 = str_split($ip); //стек из которого мы будем постепенно брать символы в результирующую строку

	$blocksCount = 1; //количество блоков в исходной записи
	foreach ($array as $element) { //подсчёт блоков в исходной записи
		if ($element == ":" ) {
			$blocksCount+=1;
		}
	}

	$lastElement = ""; //предыдущий символ
	foreach ($array as $element) {
		if($element == ":" and $element == $lastElement){ //проверка на ::
			for( $i = 0; $i < 8 - $blocksCount; $i+=1 ) { //вставляем столько нулевых блоков, сколько нужно
				$result = $result . "0000:";
			}
		}
		

		if ($element == ":" ) { 
			for($i = 0; $i < $chars; $i++){ //компенсируем нули
				$result = $result . "0"; 
			}

			for($i = 0; $i < (4 - $chars); $i++ ) { //вставляем в результирующую строку значащие символы
				$result = $result . array_shift($array2);
			}
			$chars = 5;
			$result = $result . array_shift($array2);
			$blocks+=1;
		}
		$lastElement = $element;
		$chars-=1;
	}
	
	//компенсируем последний блок
	for($i = 0; $i < $chars; $i++){
		$result = $result . "0";
	}

	for($i = 0; $i < (4 - $chars); $i++ ){
		$result = $result . array_shift($array2);
	}
	$blocks+=1;

	return $result;
}

