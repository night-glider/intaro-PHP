<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use App\Form\CreateBookType;
use App\Form\EditBookType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

/*
Контроллер книг
*/
class BookController extends AbstractController
{
    //Создание книги
    #[Route('createbook')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $book = new Book(); //Инициализация новой книги
        
        //Устанавливаем значения по умолчанию
        $book->SetName("Название книги");
        $book->SetAuthor("Автор");
        $book->SetCoverUrl("https://media.moddb.com/images/mods/1/31/30119/Test.png");
        $book->SetFileUrl("https://logomama.ru/res/%D0%BA%D0%BE%D0%BB%D0%BE%D0%B1%D0%BE%D0%BA.pdf");

        //Создаём новую форму создания книги
        $form = $this->createForm(CreateBookType::class, $book);

        //Здесь происходит обработка ответа от пользователя (т.е. заполненной формы)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { //Если форма заполнена и валидна...
            $book = $form->getData(); //Получаем данные из формы

            $entityManager = $doctrine->getManager(); //Получаем доступ к БД
            $entityManager->persist($book); //Загружаем новую книгу в БД
            $entityManager->flush(); //Применяем изменения к БД

            return $this->redirectToRoute('root'); //И после всех этих действий отправляем пользователя на главную страницу
        }

        //рендерим форму и отправляем пользователю
        return $this->renderForm('createbook.html.twig', [
            'form' => $form,
        ]);
    }

    //Редактирование книги
    #[Route('editbook')]
    public function edit(ManagerRegistry $doctrine, Request $request): Response
    {
        //Если пользователь не авторизован, то запрещаем доступ
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY'); 
        
        //Здесь мы получаем данные о книге по её id (id отправляется в качестве аргумента HTTP запроса)
        $repository = $doctrine->getRepository(Book::class);
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $book = $repository->find($id);

        //Создаём новую форму и загружаем туда уже существующие данные книги
        $form = $this->createForm(EditBookType::class, $book);

        //Здесь происходит обработка ответа от пользователя (т.е. заполненной формы)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) { //Если форма заполнена и валидна...
            $book = $form->getData(); //Получаем данные из формы

            $entityManager = $doctrine->getManager(); //Получаем доступ к БД
            $entityManager->persist($book); //Обновляем данные о книге
            $entityManager->flush(); //Подтверждаем изменения

            return $this->redirectToRoute('root'); //Перенаправляем пользователя на главную страницу
        }

        //рендерим форму и отправляем пользователю
        return $this->renderForm('createbook.html.twig', [
            'form' => $form,
        ]);
    }

    //Сраница просмотра/скачивания книги
    #[Route("/book/")]
    public function get_book(ManagerRegistry $doctrine): Response
    {
        //Здесь мы получаем данные о книге по её id (id отправляется в качестве аргумента HTTP запроса)
        $repository = $doctrine->getRepository(Book::class);
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $book = $repository->find($id);

        //Рендерим страничку с передачей туда данных о книге.
        return $this->render('get_book_main.html.twig', ['book' => $book]);
    }
}