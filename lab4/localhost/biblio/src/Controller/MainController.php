<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Book;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'root')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Book::class);

        // look for *all* book objects
        $images = $repository->findBy(array(), array('id' => 'ASC'));

        return $this->render('main.html.twig', ['images' => $images]);
    }
}