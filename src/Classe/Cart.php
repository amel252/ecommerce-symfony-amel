<?php

// namespace sert a dire le fichier se trouve dans quel fichier

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart
{
    // request stack permet d'acceder a la session de l'utilisateur
    public function __construct(private RequestStack $requestStack)
    {
    }
    //  function qui permet d'ajouter un produit en plus si existe sinon redirect
    public function add($product)
    {
        //  récup le panier stocké en session
        $cart = $this->requestStack->getSession()->get('cart');
        //  vérifie si produit déja existe dans le panier , avec isset (le contenu)
        if (isset($cart[$product->getId()])) {
            //  si produit existe on augmente la quantité
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => $cart[$product->getId()]['qty'] + 1
            ];
        } else {
            //  si produit n'existe pas, on l'ajoute
            $cart[$product->getId()] = [
                'object' => $product,
                'qty' => 1
            ];
        }
        // sauvegarder le panier (calcul de tout)
        $this->requestStack->getSession()->set('cart', $cart);
    }
    //  function qui retourne le panier en cours
    public function getCart()
    {
        return $this->requestStack->getSession()->getCart('cart');
    }
}
