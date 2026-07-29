<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\OrderType;
use App\Classe\Cart;

final class OrderController extends AbstractController
{
    #[Route('/commande/livraison', name: 'app_order')]
    public function index(): Response
    {
        
        $addresses = $this->getUser()->getAddresses();
        //  si l'adresse n'existe pas 
        if(count($addresses) == 0){
            return $this->redirectToRoute('app_account_address_form');
        }
        $form = $this->createForm(OrderType::class, null, [
            "addresses" => $addresses,
            'action'=> $this->generateUrl('app_order_summary'),
        ]);
    
    
    
        return $this->render('order/index.html.twig', [
            'deliverForm'=> $form->createView(),
        ]);
    }
    //  route pour voir le panier , pour que soit envoyer en BD (doctrine entityManager)
    #[Route('/commande/resume-panier', name: 'app_order_summary')]
    public function add(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        if($request->getMethod() != 'POST'){
            return $this->redirectToRoute('app_cart');
        }
        //  on apprend l'adresse de la personne 
        $form = $this->createForm(OrderType::class, null,[
            'addresses' => $this->getUser()->getAddresses(),
            
        ]);
        // Très important
        // $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // dd
        }
        return $this->render('order/summary.html.twig',[
            'choices'=> $form->getData(),
            'cart'=>$cart->getCart(),
            'totalWt'=>$cart->getTotalPrice()
        ]);
    }
    // return $this->redirectToRoute('app_order'),
}


//  CHAT GPT 
// #[Route('/commande/resume-panier', name: 'app_order_summary', methods: ['POST'])]
// public function add(
//     Request $request,
//     Cart $cart,
//     EntityManagerInterface $entityManager
// ): Response {
//     $form = $this->createForm(OrderType::class, null, [
//         'addresses' => $this->getUser()->getAddresses()
//     ]);

//     $form->handleRequest($request);

//     if (!$form->isSubmitted() || !$form->isValid()) {
//         return $this->redirectToRoute('app_order');
//     }

//     $choices = $form->getData();

//     return $this->render('order/summary.html.twig', [
//         'choices' => $choices,
//         'cart' => $cart->getCart(),
//         'totalWt' => $cart->getTotalPrice()
//     ]);
// }