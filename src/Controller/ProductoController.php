<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Producto;
use App\Entity\Categoria;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class ProductoController extends AbstractController
{
    /**
     * @Route("/producto", name="producto")
     */
    public function index(): Response
    {
        return $this->render('producto/index.html.twig', [
            'controller_name' => 'ProductoController',
        ]);
    }

    /**
     * @Route("/creaproducto/{id}", name="create_producto" , requirements={"id"="\d+"})
     */
    public function createProducto(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $product = new Producto();
        $product->setNombre('Cepillo');
        $product->setPrecio(5);

        $categoria = $doctrine->getRepository(Categoria::class)->find($id);
        $product->setCategoria($categoria);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @Route("/busca_productos_por_categoria/{id}", name="categoria_producto", requirements={"id"="\d+"})
     */
    public function buscaProductosPorCategoria(ManagerRegistry $doctrine, $id): Response
    {
        $producto = $doctrine->getRepository(Producto::class)->findBy(['categoria' => $id]);
        return $this->render('producto/prodcat.html.twig', [
            'resul' => $producto
        ]);
    }

    /**
     * @Route("/listar/todosproductos/", name="listar_productos")
     */
    public function listarProductos(ManagerRegistry $doctrine): Response
    {
        $producto = $doctrine->getRepository(Producto::class)->findAll();
        return $this->render('listados/listadoProd.html.twig', [
            'resul' => $producto, "tipo" => "Productos"
        ]);
    }

    /**
     * @Route("/listar/producto/{id}", name="listar_producto")
     */
    public function listarProducto(ManagerRegistry $doctrine, $id): Response
    {
        $producto = $doctrine->getRepository(Producto::class)->findOneBy(['id'=>$id]);
        return $this->render('producto/only.html.twig', [
            'resul' => $producto, 'tipo' => $producto->getNombre()
        ]);
    }

    public function new(Request $request): Response
    {
        $prod = new Producto();
        $prod->setNombre('Write a blog post');
        $prod->setDueDate(new \DateTime('tomorrow'));

        $form = $this->createFormBuilder($prod)
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Crear producto'])
            ->getForm();
    }
}
