<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Usuario;
use App\Form\ContactType;
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
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

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
            'ultimoProducto'=>$ultimoProducto
        ]);
    }


    /**
     * @Route("/dashboard/editar/{idCli}", name="usuario_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Usuario $usuario): Response
    {
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        $form = $this->createForm(UsuarioType::class, $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_index');
        }

        return $this->render('usuario/edit.html.twig', [
            'usuario' => $usuario,
            'form' => $form->createView(),
            'ultimoProducto'=>$ultimoProducto
        ]);
    }

    /**
     * @Route("/dashboard/usuario/borrar/{idCli}", name="usuario_delete", methods={"DELETE"})
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
    public function contact(Request $request, \Swift_Mailer $mailer){
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();

        $contact_form = $this->createForm(ContactType::class);
        $contact_form->handleRequest($request);
        $nombre = null;
        $email = null;
        $asunto = null;
        $mensaje = null;
        if ($contact_form->isSubmitted() && $contact_form->isValid()){
            $datos = $contact_form->getData();
            $nombre = $datos['nombre'];
            $email = $datos['email'];
            $asunto = $datos['asunto'];
            $mensaje = $datos['mensaje'];

            $send_email = (new \Swift_Message($asunto))
            ->setFrom($email)
            ->setTo('sergio.gurillo11@gmail.com')
            ->setBody(
                $this->renderView('email/contact.html.twig',
                    [
                        'nombre'=>$nombre,
                        'email'=>$email,
                        'asunto'=>$asunto,
                        'mensaje'=>$mensaje
                    ]),
                'text/html'
            );
            $mailer->send($send_email);
        }


        return $this->render('usuario/contact.html.twig', [
            'ultimoProducto'=>$ultimoProducto,
            'contacto'=>$contact_form->createView()
        ]);
    }

    /**
     * @Route("/mi-perfil", name="profile")
     */
    public function profile(){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $ultimoProducto = $repository->getLatest();


        return $this->render('usuario/profile.html.twig', [
            'ultimoProducto'=>$ultimoProducto
        ]);
    }
}
