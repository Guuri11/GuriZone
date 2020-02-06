<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
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
        // get the Producto repository (it is like our model)
        $repository = $this->getDoctrine()->getRepository(Producto::class);

        // retrieve all productos
        $productos = $repository->findAll();

        // Obtener productos mas vendidos y nuevos
        $productosTT = $repository->findBy([],['numVentasProd'=>'DESC'],5);
        $novedades = $repository->findBy([],['fechaSalida'=>'DESC'],5);

        // ultimo producto
        $ultimoProducto = $repository->getLatest();

        // now pass the array of link object to the view
        return $this->render('default/index.html.twig', [
            'productos' => $productos,
            'productosTT'=>$productosTT,
            'novedades'=>$novedades,
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

}
