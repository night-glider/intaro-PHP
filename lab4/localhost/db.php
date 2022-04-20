<?php
$user = "root";
$pass = "";
    //подключаемся к БД "feedback"
    try {
        $connection = new PDO('mysql:host=127.0.0.1;dbname=intaro_books', $user, $pass);
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>"; //в случае ошибки оставляем сообщение об ошибке
        die();
    }