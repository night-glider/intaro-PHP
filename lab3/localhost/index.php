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

    <div class="feedback-form" id="feedback-form">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Обратная связь</h4>
            </div>
            <div class="feedback-body">
              <p>Представляем вам новую технологию отправки обратной связи! Команда Microsoft очень долго трудилась над этой новой фичей.</p>
              <p>Теперь вы можете отправлять свои комментарии прямо по воздуху! Всё, что вам нужно - это заполнить форму ниже и нажать кнопку "отправить"! Будьте уверены, команда обязательно увидит ваше сообщение.</p>
              <label for="FIO">ФИО:</label><br>
              <input type="text" class="form-95" id="FIO" name="FIO"><br>
              <label for="email">Электронная почта:</label><br>
              <input type="text" class="form-95" id="email" name="email">
              <label for="phone">Телефон:</label><br>
              <input type="text" class="form-95" id="phone" name="phone">
              <label for="comment">Комментарий:</label><br>
              <textarea type="text" class="form-95" id="comment" name="comment" style="resize: vertical;"></textarea>
              <p id="feedback-error-message" style="color:red"></p>
              <button class="btn btn-primary" id="feedback-send-button">Отправить</button>
            </div>
        </div>
    </div>

    <div class="feedback-form" id="feedback-form-completed">
        <div class="card">
            <div class="card-header">
                <h4 class="my-0 font-weight-normal">Обратная связь</h4>
            </div>
            <div class="feedback-body" id="feedback-form-completed-body">
            </div>
        </div>
    </div>

    <div class="ui-icon" id="feedback-icon">
        <div class="ui-icon-container">
            <img width="32" height="32" src="feedback_icon.png">
            <span style="color:white;">Обратная связь</span>
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