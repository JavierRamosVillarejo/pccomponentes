<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categoria;
use App\Entity\Articulo;

class CategoriaController extends AbstractController
{
    /**
     * @Route("/categoria/{id}", name="ver_categoria")
     */
    public function ver_categoria(Categoria $categoria): Response
    {
        return $this->render('categoria/index.html.twig', [
            'categoria' => $categoria
        ]);
    }
}
