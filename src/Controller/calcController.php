<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class calcController extends AbstractController
{
    /**
     * @Route("/calc/suma/{n}", name="suma", requirements={"n"="\d+"})
     */
    public function number(int $n=4): Response
    {
        $resul = $n + 9;
        return $this->render('calc/calc.html.twig', [
            'resul' => $resul,
        ]);
    }

    /**
     * @Route("/calc/suma/{n}", name="suma", requirements={"n"="\w+"})
     */
    public function letra(): Response
    {
        $resul = 0;
        return $this->render('calc/calc.html.twig', [
            'resul' => $resul,
        ]);
    }
}