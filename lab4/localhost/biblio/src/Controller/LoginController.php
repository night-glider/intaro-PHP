<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


/*
Контроллер авторизации
*/
class LoginController extends AbstractController
{
    //Авторизация
    //Функция, которая вызывается каждый раз, когда пользователь переходит по адресу /login
    //Аргумент AuthenticationUtils $authenticationUtils указывает Symfony, что нужно использовать инструменты для авторизации пользователя
    //Возвращает Response т.е. ответ сервера
    #[Route('login', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Получаем последнюю ошибку логина
        $error = $authenticationUtils->getLastAuthenticationError();

        // Получаем последнее имя пользователя
        $lastUsername = $authenticationUtils->getLastUsername();

        //Рендерим форму авторизации с передачей в темплейт последней ошибки и последнего имени
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
