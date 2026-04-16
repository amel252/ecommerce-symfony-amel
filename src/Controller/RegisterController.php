<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\RegisterUserType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    //  pour ce servir de doctrine on passant par EntityManager pour qu'on puisse manipuler la BD
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();

        // pour créer notre form 
        $form = $this->createForm(RegisterUserType::class, $user);

        // Ecoute la requette si le formulaire est soumis
        $form->handleRequest($request);
        //  si le form est soumis et valid 
        if($form->isSubmitted() && $form->isValid()){
        // dire à Doctrine que je veux save le user dans la BD
        $entityManager->persist($user);

        // envoyer les données en BD
        $entityManager->flush();
            
        }

        return $this->render('register/index.html.twig',[
            'registerForm' =>$form->createView()
        ]);
    }
}
