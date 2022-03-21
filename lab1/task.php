<?php 
function init($file_path){
    $input = fopen($file_path, "r") or die("Unable to open file!");
    $betCount = intval( fgets($input) ); //считываем кол-во ставок
    $betsID = array();
    $betsBet = array();
    $betsTeam = array();

    for($i = 0; $i <  $betCount; $i++ ){
        $line = str_word_count( fgets( $input ), 1, "1234567890"); //считываем одну строку, а потом разбиваем их на массив отдельных слов (цифры тоже считаем за части слов)
        $betsID[$i] = intval( $line[0] );
        $betsBet[$i] = intval( $line[1] );
        $betsTeam[$i] = $line[2];
    }

    $gameCount = intval(fgets($input)); //считываем кол-во игр
    $gamesID = array();
    $gamesLKoeff = array();
    $gamesRKoeff = array();
    $gamesDKoeff = array();
    $gamesWinner = array();

    for($i = 0; $i < $gameCount; $i++ ){
        $line = str_word_count( fgets( $input ), 1, "1234567890."); //аналогично 10ой строке
        $gamesID[$i] = intval( $line[0] ); 
        //Далее индексация идёт по ID игры
        $gamesLKoeff[$gamesID[$i]] = floatval( $line[1] );
        $gamesRKoeff[$gamesID[$i]] = floatval( $line[2] );
        $gamesDKoeff[$gamesID[$i]] = floatval( $line[3] );
        $gamesWinner[$gamesID[$i]] = $line[4];
    }

    $result = 0;

    for($i = 0; $i < $betCount; $i++ ){ //теперь проверяем каждую ставку по порядку
        $game_id = $betsID[$i];
        $result -= $betsBet[$i]; //вычитываем деньги на ставку
        if ($gamesWinner[$game_id] == "L" and $gamesWinner[$game_id] == $betsTeam[$i] ) //проверка на то, что ставка на L зашла
            $result += $betsBet[$i] * $gamesLKoeff[$game_id]; //возвращаем деньги, но с коэффициентом
        elseif ($gamesWinner[$game_id] == "R" and $gamesWinner[$game_id] == $betsTeam[$i] )
            $result += $betsBet[$i] * $gamesRKoeff[$game_id];
        elseif ($gamesWinner[$game_id] == "D" and $gamesWinner[$game_id] == $betsTeam[$i] )
            $result += $betsBet[$i] * $gamesDKoeff[$game_id];
    }

    return $result;
}
?>
