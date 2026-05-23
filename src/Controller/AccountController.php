<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\PasswordUserType;
use App\Entity\Address;
use App\Repository\AddressRepository;
use App\Form\AddressUserType;

final class AccountController extends AbstractController
{
    // pour eviter de mettre entityManager dans chaque route
    private $entityManager ;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }




    #[Route('/compte', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig');
    }


    //  nous avons déja un User existant en BD  pour modifier son PWD
    #[Route('/compte/modifier-mot-de-passe', name: 'app_account_modify_pwd')]
    public function password(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): Response
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

        return $this->render('account/password.html.twig', [
            'modifyPwd' => $form->createView()
        ]);
    }
    //  Création de la route Affichage du template (adresse)
    #[Route('/compte/adresses', name: 'app_account_addresses')]
    public function addresses(): Response
    {
        return $this->render('account/addresses.html.twig');
    }

    //  Ajout de l'adresse en utilisant btn , en utilise defaults pour faire l'exception , meme si id est null la requette passera
    #[Route('/compte/adresses/ajout/{id}', name: 'app_account_address_form', defaults:['id' => null])]
    public function addressForm(Request $request, $id, AddressRepository $addressRepository): Response
    {
        //  si id de l'user connecté
        if ($id) {
            //  l'addresse en Bd , on récupere
            $address = $addressRepository->findOneById($id);
            //  on compare entre bdd et user adress
            if (!$addresses or $address->getUser() != $this->getUser()) {
                //  si ce sont pas identique , redirige vers la page pour qu'il remet l'adresse correct
                return $this->redirectToRoute('app_account_addresses');
            }
        } else {
            //  j'instancié
            $address = new Address();
            //  je stocke
            $address->setUser($this->getUser());
        }
        $form = $this->createForm(AddressUserType::class, $address);

        //  ecoute la requette si formulaire est soumis
        $form->handleRequest($request);
        //  si le form est soumis et valid
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($address);
            $this->entityManager->flush();
            $this->addFlash(
                type:'success',
                message:'Votre adresse a été ajoutée avec success !'
            );
            return $this->redirectToRoute('app_account_addresses');
        }
        return $this->render('account/addressForm.html.twig', [
            'addressForm' => $form
        ]);
    }
    //  suppression de l'adresse
    #[Route('/compte/adresses/suppression/{id}', name: 'app_account_address_delete', defaults:['id' => null])]
    public function deleteForm(request $request, AddressRepository $addressRepository): Response
    {
        $address = $addressRepository->findOneById();
        //  on compare entre bdd et user adress
        if (!$addresses or $address->getUser() != $this->getUser()) {
            //  si ce sont pas identique , redirige vers la page pour qu'il remet l'adresse correct
            return $this->redirectToRoute('app_account_addresses');
        }
        $this->addFlash(
            type:'success',
            message:'Votre adresse a été supprimé avec success !'
        );
        $this->entityManager->remove($address);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_account_addresses');


    }

}
