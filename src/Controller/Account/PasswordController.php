<?php

namespace App\Controller\Account;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\PasswordUserType;



final class PasswordController extends AbstractController
{
    // pour eviter de mettre entityManager dans chaque route
    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }


    //  nous avons déja un User existant en BD  pour modifier son PWD
    #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function index(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
    {
        //  on cible le user connecté
        $user = $this->getUser();
        //  création de form
        $form = $this->createForm(PasswordUserType::class, $user, [
            'passwordHasher' => $passwordHasher
        ]);
        // Ecoute la requette si le formulaire est soumis
        $form->handleRequest($request);

        //  si le form est soumis et valid
        if ($form->isSubmitted() && $form->isValid()) {
            //  le user existe déja , on le met a jour sur la BD
            $this->entityManager->flush();
            $this->addFlash(
                type:'success',
                message:'Votre motre passe est correctement mis à jour avec success !'
            );

        }
        return $this->render('account/password/index.html.twig', [
            'modifyPwd' => $form->createView()
        ]);
    }

}
