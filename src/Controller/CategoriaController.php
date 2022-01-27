<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/categoria", name="categoria")
     */
    public function index(): Response
    {
        return $this->render('categoria/index.html.twig', [
            'controller_name' => 'CategoriaController',
        ]);
    }

    /**
     * @Route("/creacategoria", name="create_categoria")
     */
    public function createCategoria(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $categoria = new Categoria();
        $categoria->setNombre("Limpieza");

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($categoria);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new categoria with id '.$categoria->getId());
    }
}
