<?php require 'db.php' ?>
<?php

$id = htmlspecialchars($_GET["id"]);
$query = "SELECT * FROM `books` WHERE book_id = $id";
$result = $connection->query($query);
$result = $result->fetchAll()   ;

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>get_book</title>

    <link rel="stylesheet" href="win95.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    {{ id }}
    <div class="detailed_book_card">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal"><?= $result[0]["name"]?></h4>
            </div>
            <img class= "detailed_book_cover" src="<?= $result[0]["cover_url"]?>" >
            <p>Автор: <?= $result[0]["author"]?></p>
            <a href="<?= $result[0]["pdf_url"]?>" download>Скачать книгу</a>
        </div>
    </div>
</body>

</html>