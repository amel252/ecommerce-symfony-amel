<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Classe\Cart;
use App\Repository\ProductRepository;

final class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'app_cart')]
    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            //  on récupere ce qu'on a fait dans Cart.php
            'cart' => $cart->getCart()
        ]);
    }
    // la route qui permet l'ajout un produit dans le panier
    #[Route('/panier-ajout/{id}', name: 'app_cart_add')]
    public function add($id, Cart $cart, ProductRepository $productRepository, Request $request): Response
    {
        //  récup les produit depuis la BD
        $product = $productRepository->findOneById($id);
        // ajout dans le panier
        $cart->add($product);
        // msg pour dire que le produit est ajouté
        $this->addFlash(
            type:'success',
            message:'Votre produit a été ajouté avec succès'
        );

        return $this->render('cart/index.html.twig', [
            //  on récupere ce qu'on a fait dans Cart.php
            'slug' => $product->getSlug()
        ]);
    }
}
