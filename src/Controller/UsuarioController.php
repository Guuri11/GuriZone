<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Usuario;
use App\Form\UsuarioType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UsuarioController extends AbstractController
{
    /**
     * @Route("/dashboard/usuario", name="usuario_index", methods={"GET"})
     */
    public function index(): Response
    {
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        $usuarios = $this->getDoctrine()
            ->getRepository(Usuario::class)
            ->findAll();

        return $this->render('usuario/index.html.twig', [
            'usuarios' => $usuarios,
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/dashboard/usuario/nuevo", name="usuario_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $usuario = new Usuario();
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($usuario);
            $entityManager->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/new.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/dashboard/editar/{idCli}", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario): Response
    {
        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/dashboard/usuario/{IdCli}", name="usuario_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Usuario $usuario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usuario->getIdCli(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($usuario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(){
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();


        return $this->render('usuario/dashboard.html.twig', [
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/contacto", name="contacto")
     */
    public function contact(){
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();


        return $this->render('usuario/contact.html.twig', [
            'ultimoProducto'=>$ultimoProducto
        ]);
    }
}
