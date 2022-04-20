<?php require 'db.php' ?>
<?php

$query = "SELECT * FROM `books` LIMIT 5";
$result = $connection->query($query);
$result = $result->fetchAll();

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

    <?php foreach ($result as $row) : ?>
        <div class="book_card">
            <div class="card">
                <div class="card-header">
                    <a href="google.com">
                        <h4 class="my-0 font-weight-normal"><?= $row["name"]?></h4>
                    </a>
                </div>
                <img class= "detailed_book_cover" src="<?= $row["cover_url"]?>" >
            </div>
        </div>
    <?php
    endforeach;
    ?>
</body>

</html>