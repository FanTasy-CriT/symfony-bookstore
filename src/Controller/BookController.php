<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    private $doctrine;

    private $authorRepository;

    private $entityManager;


    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $this->doctrine->getManager();
        $this->authorRepository = $this->entityManager->getRepository(Author::class);
    }


    #[Route('/book/{name?}', name: 'app_book')]
    public function index($name): Response
    {
        // Use $this->doctrine to access Doctrine
        $authors = $this->authorRepository->findAll(); // Fetch all authors
        $AddAuthor=new Author();
        $AddAuthor->setName("joey bugeston");
        $AddAuthor->setAge(15);
        //$this->entityManager->persist($AddAuthor);
        //$this->entityManager->flush();
        return $this->render('book/index.html.twig', [
            'name' => $name,
            'authors' => $authors, // Pass the authors data to the template
        ]);
    }


    #[Route('/delete_author/{id?}', name: 'delete_author')]
    public function delete_author($id){
        $author = $this->authorRepository->find($id);

        if (!$author) {
            // Handle the case where the author is not found (e.g., show an error message).
        } else {
            $this->entityManager->remove($author);
            $this->entityManager->flush();
    }
    return $this->redirectToRoute('app_book');
    }

}

