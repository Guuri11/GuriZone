<?php

namespace App\Controller;

use App\Entity\Producto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        // get the Link repository (it is like our model)
        $repository = $this->getDoctrine()->getRepository(Producto::class);

        // retrieve all links
        $productos = $repository->findAll();

        // now pass the array of link object to the view
        return $this->render('default/index.html.twig', [
            'productos' => $productos,
        ]);
    }

}
