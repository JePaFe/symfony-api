<?php

namespace App\Controller;

use App\Entity\Book;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LibraryController extends AbstractController
{
    /**
     * @Route("/books", name="books.index")
     */

    public function index(Request $request, BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();

        $booksArray = [];

        foreach ($books as $book) {
            $booksArray[] = [
                'id' => $book->getId(),
                'title' => $book->getTitle()
            ];
        }

        $response = new JsonResponse();
        $response->setData($booksArray);
        return $response;
    }

    /**
     * @Route("/books/create", name="books.create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $book = new Book();
        $book->setTitle('Un libro');
        $entityManager->persist($book);
        $entityManager->flush();

        $response = new JsonResponse();
        $response->setData([
            'id' => $book->getId(),
            'title' => $book->getTitle()
        ]);
        return $response;
    }
}