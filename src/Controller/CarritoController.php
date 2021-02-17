<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articulo;
use App\Entity\Carrito;

class CarritoController extends AbstractController
{
    /**
     * @Route("/carrito/add/{id}", name="add_articulo_carrito")
     */
    public function add_articulo(Articulo $articulo): Response
    {
        $em = $this->getDoctrine()->getManager();
        $carrito = $this->getDoctrine()->getRepository(Carrito::class)->find(1);
        $carrito->addArticulo($articulo);
        $em->persist($carrito);
        $em->flush();
        return $this->redirectToRoute('inicio');
        
    }
}
