<?php require 'db.php' ?>

<?php
//получаем данные заявки из параметров запроса.
$fio = htmlspecialchars($_GET['FIO']);
$email = htmlspecialchars($_GET['email']);
$phone = htmlspecialchars($_GET['phone']);
$comment = htmlspecialchars($_GET['comment']);

$time = date("y-m-d H:i:s"); //текущее время в формате UNIX

//SQL запрос на определение времени последней заявки с соответствующим email
$query = "SELECT MAX(time) FROM `entries` WHERE email LIKE '$email'"; 
$latest_date = $connection->query($query);

foreach ($latest_date as $row)
{
    $time_from_last = time() - strtotime($row["MAX(time)"]); //разница между текущим временем и временем последней заявки
    if ($time_from_last < 3600) //если с момента последней заявки прошло меньше часа.
    {
    	echo "Заявки можно отправлять раз в час. Подождите ещё " . strval( round((3600 - $time_from_last)/60) ) . " минут.";
    	die();
    }
}

$is_fio_valid = preg_match("/[А-я]{3,25} [А-я]{3,25} [А-я]{3,25}/", $fio); //валидация ФИО
$is_email_valid = preg_match("/[a-zA-Z._]{3,25}@[a-z]{3,20}\.[a-z]{2,3}/", $email); //валидация email
$is_phone_valid = preg_match("/\+?[0-9]{11}/", $phone); //валидация телефона

if ( $is_fio_valid and $is_email_valid and $is_phone_valid ) //в случае успешной валидации
{
    //SQL запрос на добавление записи в БД
	$query = "INSERT INTO `entries`(`FIO`, `email`, `phone`, `comment`, `time`) VALUES ('$fio','$email','$phone','$comment','$time')";
	$connection->query($query);

    //составляем текст e-mail'a
    $message = "ФИО: $fio\nE-mail: $email\nТелефон: $phone\nКомментарий: $comment\nВремя отправки: $time";
    $success = mail('nightgliderdev@gmail.com', 'PHP INTARO TEST', $message); //отправка e-mail'a
    //в случае ошибки выводим сообщение об ошибке и умираем
    if (!$success) {
        $errorMessage = error_get_last()['message'];
        echo $errorMessage;
        die();
    }

    $callback_time = date("H:i:s d.m.Y", time() + 5400); //время, после которого должны связаться (текущее + 1.5 часа)

    //составляем ответное сообщение
    echo "Спрасибо за обращение!<br>  ФИО: $fio<br>E-mail: $email<br>Телефон: $phone<br>С вами свяжутся после $callback_time";
}
else //в случае ошибки валидации отправляем сообщение об ошибке
{
	echo "VALIDATION ERROR";
}

?>
