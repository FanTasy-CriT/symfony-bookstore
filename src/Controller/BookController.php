<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;


class BookController extends AbstractController
{
    
    #[Route('/book/{name?}', name: 'app_book')]
    public function index($name,$authorRepository,$entityManager): Response
    {
        // Get the author data using Doctrine
        $authorRepository = $entityManager->getRepository(Author::class);
        $authors = $authorRepository->findAll(); // Fetch all authors
        return $this->render('book/index.html.twig', [
            'name' => $name,
            'authors' => $authors, // Pass the authors data to the template
        ]);
    }
}

