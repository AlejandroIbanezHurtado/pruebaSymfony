<?php

namespace App\Controller;

use App\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class UsuarioController extends AbstractController
{
    /**
     * @Route("/usuario", name="usuario")
     */
    public function index(): Response
    {
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }

    /**
     * @Route("/listar/todosusuarios/", name="listar_usuarios")
     */
    public function listarUsuarios(ManagerRegistry $doctrine): Response
    {
        $user = $doctrine->getRepository(Usuario::class)->findAll();
        return $this->render('usuario/listado.html.twig', [
            'resul' => $user, "tipo" => "Usuarios"
        ]);
    }

    /**
     * @Route("/usuario/crear/", name="crear_usuario")
     */
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $usu = new Usuario();
        // $usu->setNombre('');

        $form = $this->createFormBuilder($usu)
            ->add('nombre', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Crear usuario'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $use = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($use);
            $entityManager->flush();

            // return $this->redirectToRoute('usuario_success');
        }

        return $this->renderForm('usuario/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("/usuario/editar/{id}", name="editar_usuario")
     */
    public function editar(Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $usuarioEditar = $doctrine->getRepository(Usuario::class)->findOneBy(['id'=>$id]);
        $usu = new Usuario();
        $usu->setNombre($usuarioEditar->getNombre());
        $usu->setId($usuarioEditar->getId());

        $form = $this->createFormBuilder($usu)
            ->add('nombre', TextType::class)
            ->add('id', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Crear usuario'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $use = $form->getData();

            // ... perform some action, such as saving the task to the database
            $entityManager->persist($use);
            $entityManager->flush();

            // return $this->redirectToRoute('usuario_success');
        }

        return $this->renderForm('usuario/new.html.twig', [
            'form' => $form,
        ]);
    }
}
