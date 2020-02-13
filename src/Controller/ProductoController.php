<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Producto;
use App\Form\ProductoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoController extends AbstractController
{

    /**
     * @Route("/dashboard/producto", name="producto_index", methods={"GET"})
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();
        $productos =$repository->findAll();

        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/tienda", name="producto_shop", methods={"GET"})
     */
    public function shop(){

        // get the Producto repository (it is like our model)
        $repository = $this->getDoctrine()->getRepository(Producto::class);

        $productos = $repository->findAll();
        $ultimoProducto = $repository->getLatest();


        return $this->render('producto/shop.html.twig', [
            'productos'=>$productos,
            'ultimoProducto'=>$ultimoProducto
        ]);
    }
    /**
     * @Route("/dashboard/producto/nuevo", name="producto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            if (empty($producto->getFotoProd()))
                $producto->setFotoProd('../imgs/productos/default_product_image.png');
            $producto->setColorDisp($producto->getStockProd());
            $producto->setTallaDisp($producto->getStockProd());
            $producto->setFechaSalida(new \DateTime(date('Y-m-d H:i:s')));

            $entityManager->persist($producto);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/tienda/{idProd}", name="producto_show", methods={"GET"})
     */
    public function show(Producto $producto): Response
    {

        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/dashboard/producto/editar/{idProd}", name="producto_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Producto $producto): Response
    {
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/dashboard/producto/borrar/{idProd}", name="producto_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Producto $producto): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getIdProd(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producto_index');
    }
}
