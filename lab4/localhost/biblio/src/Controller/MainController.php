<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use Symfony\Component\Routing\Annotation\Route;

/*
Контроллер главной страницы
*/
class MainController extends AbstractController
{
    //Главная страница
    #[Route('/', name: 'root')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Book::class); //Получаем доступ к БД

        //Получаем список всех книг с сортировкой по их id
        $books = $repository->findBy(array(), array('id' => 'ASC'));

        //Рендерим главную страницу в соответствии с полученным списком книг
        return $this->render('main.html.twig', ['images' => $books]);
    }
}