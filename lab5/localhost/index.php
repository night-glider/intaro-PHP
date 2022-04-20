<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>PHP интаро</title>

    <link rel="stylesheet" href="win95.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>

    <div class="metro-form" id="metro-form">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Ближайшее метро</h4>
            </div>
            <div class="metro-body">
              <p>Команда microsoft торжественно представляет вам новую программу для нахождения ближайшего метро!</p>
              <p>Просто введите свой текущий адрес и наш новейший суперкомпьютер проверит все возможные варианты и выдаст вам ближайшее метро!</p>
              <label for="place">Я сейчас нахожусь в:</label><br>
              <input type="text" class="form-95" id="place" name="place">
              <button class="btn btn-primary" id="send-button">Готово</button>
              <p id="metro-result-message" style="color:green"></p>
            </div>
        </div>
    </div>

    <div class="ui-icon" id="metro-icon">
        <div class="ui-icon-container">
            <img width="32" height="32" src="metro_icon.png">
            <span style="color:white;">Ближайшее метро</span>
        </div>
    </div>
    <div class="ui-icon" id="author-icon">
        <div class="ui-icon-container">
            <a href="https://vk.com/zhidkov_ivan1">
                <img width="32" height="32" src="author_icon.png">
                <span style="color:white;">Автор</span>
            </a>
        </div>
    </div>
    <div class="ui-icon" id="github-icon">
        <div class="ui-icon-container">
            <a href="https://github.com/night-glider">
                <img width="32" height="32" src="github_icon.png">
                <span style="color:white;">github</span>
            </a>
        </div>
    </div>

</body>

<script src="main.js"></script>

</html>