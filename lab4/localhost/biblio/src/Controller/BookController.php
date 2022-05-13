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

class BookController extends AbstractController
{
    #[Route('createbook')]
    public function create(ManagerRegistry $doctrine, Request $request): Response
    {
        $book = new Book();
        $book->SetName("Название книги");
        $book->SetAuthor("Автор");
        $book->SetCoverUrl("https://media.moddb.com/images/mods/1/31/30119/Test.png");
        $book->SetFileUrl("https://logomama.ru/res/%D0%BA%D0%BE%D0%BB%D0%BE%D0%B1%D0%BE%D0%BA.pdf");

        $form = $this->createForm(CreateBookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$book` variable has also been updated
            $book = $form->getData();

            // ... perform some action, such as saving the book to the database
            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('root');
        }

        return $this->renderForm('createbook.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('editbook')]
    public function edit(ManagerRegistry $doctrine, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $repository = $doctrine->getRepository(Book::class);
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        $book = $repository->find($id);

        $form = $this->createForm(EditBookType::class, $book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$book` variable has also been updated
            $book = $form->getData();

            // ... perform some action, such as saving the book to the database
            $entityManager = $doctrine->getManager();
            $entityManager->persist($book);
            $entityManager->flush();

            return $this->redirectToRoute('root');
        }

        return $this->renderForm('createbook.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route("/book/")]
    public function get_book(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Book::class);
        $request = Request::createFromGlobals();
        $id = $request->query->get('id');
        // look for *all* book objects
        $book = $repository->find($id);

        return $this->render('get_book_main.html.twig', ['book' => $book]);
    }
}