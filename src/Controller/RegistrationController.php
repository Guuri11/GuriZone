<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Entity\Roles;
use App\Entity\Usuario;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Usuario();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $repository = $this->getDoctrine()->getRepository(Producto::class);
        $repoRole = $this->getDoctrine()->getRepository(Roles::class);
        $ultimoProducto = $repository->getLatest();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user
                ->setRol($repoRole->findOneBy(['tipoRol' => 'ROLE_CLIENTE']))
                ->setFotoPerfil('imgs/default_profile.jpg')
                ->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute('homepage');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
            'ultimoProducto'=>$ultimoProducto
        ]);
    }
}
