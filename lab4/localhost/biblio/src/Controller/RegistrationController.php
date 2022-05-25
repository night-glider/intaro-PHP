<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


/*
Контроллер регистрации
*/
class RegistrationController extends AbstractController
{
    //Регистрация
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User(); //Создаём нового пользователя
        $form = $this->createForm(RegistrationFormType::class, $user); //Создаём новую форму регистрации

        //Здесь происходит обработка ответа от пользователя (т.е. заполненной формы)
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) { //Если форма заполнена и валидна...
            //Здесь мы хэшируем пароль пользователя и сохраняем его в экземпляре
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                        $user,
                        $form->get('plainPassword')->getData()
                    )
                );

            $entityManager->persist($user); //Загружаем нового пользователя в БД
            $entityManager->flush(); //Применяем изменения

            return $this->redirectToRoute('root'); //Перенаправляем на главноую страницу
        }

        //рендерим форму и отправляем пользователю
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
