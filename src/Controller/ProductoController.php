<?php

namespace App\Controller;

use App\Entity\Categorias;
use App\Entity\Producto;
use App\Form\DateFilterType;
use App\Form\ProductoType;
use App\Form\SearchType;
use App\Repository\ProductoRepository;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class ProductoController extends AbstractController
{

    /**
     * @Route("/dashboard/producto", defaults={"page": "1"}, name="producto_index", methods={"GET","POST"})
     * @Route("/dashboard/producto/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="producto_index_paginated")
     */
    public function index(Request $request,int $page, ProductoRepository $productos): Response
    {
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        // Formulario de filtro de fecha
        $date_filter_form = $this->createForm(DateFilterType::class);
        $date_filter_form->handleRequest($request);
        // Variables de filtro
        $category = null;
        $startDate = null;
        $endDate = null;
        $usuario = null;
        $data = [];
        if ($request->query->has('categoria'))
            $category = $request->query->get('categoria');

        if ($date_filter_form->isSubmitted() && $date_filter_form->isValid()){
            $data = $date_filter_form->getData();
            $startDate = $data['fecha_inicial'];
            $endDate = $data['fecha_final'];
        }
        if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN'){
            $usuario = $this->getUser();
        }


        $productos = $productos->getAll($page,null,$category,$startDate,$endDate,$usuario);
        if ($productos->getNumResults()===0)
            $results = false;
        else
            $results = true;
        $ultimoProducto = $repository->getLatest();


        return $this->render('producto/index.html.twig', [
            'paginator' => $productos,
            'ultimoProducto'=>$ultimoProducto,
            'form_date_filter'=>$date_filter_form->createView(),
            'query'=>$request->query->all(),
            'results'=>$results,
            'user'=>$this->getUser()->getIdCli()
        ]);
    }

    /**
     * @Route("/tienda", defaults={"page": "1"}, name="producto_shop", methods={"GET","POST"})
     * @Route("/tienda/page/{page<[1-9]\d*>}", defaults={"_format"="html"}, methods="GET", name="producto_shop_paginated")
     */
    public function shop(Request $request, int $page, ProductoRepository $productos): Response{

        // get the Producto repository (it is like our model)
        $repository = $this->getDoctrine()->getRepository(Producto::class);

        // Formulario de filtro de fecha
        $date_filter_form = $this->createForm(DateFilterType::class);
        $date_filter_form->handleRequest($request);

        // Variables de filtro
        $search = null;
        $category = null;
        $startDate = null;
        $endDate = null;
        $data = [];

        if ($request->query->has('categoria'))
            $category = $request->query->get('categoria');

        if ($date_filter_form->isSubmitted() && $date_filter_form->isValid()){
            $data = $date_filter_form->getData();
            $startDate = $data['fecha_inicial'];
            $endDate = $data['fecha_final'];
        }

        if ($request->query->has('search'))
            $search = $request->query->getAlnum('search');

        $productos = $productos->getAll($page,$search,$category,$startDate,$endDate);

        if ($productos->getNumResults()===0)
            $results = false;
        else
            $results = true;

        $ultimoProducto = $repository->getLatest();

        return $this->render('producto/shop.html.twig', [
            'paginator'=>$productos,
            'ultimoProducto'=>$ultimoProducto,
            'form_date_filter'=>$date_filter_form->createView(),
            'query'=>$request->query->all(),
            'results'=>$results
        ]);
    }
    /**
     * @Route("/dashboard/producto/nuevo", name="producto_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $producto = new Producto();
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        if ($form->isSubmitted()){
            if ($form->isValid()) {
              $producto->setFechaSalida(\DateTime::createFromFormat('Y-m-d H:i:s',date('Y-m-d H:i:s')));
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($producto);
              $entityManager->flush();

              return $this->redirectToRoute('homepage');
          }
        }

        return $this->render('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form->createView(),
            'ultimoProducto'=>$ultimoProducto,
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
        if ($this->getUser()->getRoles()[0] === 'ROLE_ADMIN' or $this->getUser() === $producto->getIdEmpleado()){
            if ($this->isCsrfTokenValid('delete'.$producto->getIdProd(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($producto);
                $entityManager->flush();
            }
        }


        return $this->redirectToRoute('producto_index');
    }
}
