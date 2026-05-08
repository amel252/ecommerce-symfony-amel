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
        $cart = $this->requestStack->getSession()->get('cart', []);
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
        return $this->requestStack->getSession()->get('cart', []);
    }
    //  function qui permet de supprimer le panier
    public function removeCart()
    {
        return $this->requestStack->getSession()->remove('cart', []);
    }
    //  function qui permet de retiré un produit dans  le panier
    public function decreaseCart($id)
    {
        //  récup le panier stocké en session
        $cart = $this->requestStack->getSession()->get('cart', []);
        //  si qty est inf à 1 on diminué
        if ($cart[$id]['qty'] > 1) {
            $cart[$id]['qty'] = $cart[$id]['qty'] - 1 ;
        } else {
            unset($cart[$id]);
        }
        // sauvegarder le panier (calcul de tout)
        $this->requestStack->getSession()->set('cart', $cart);
    }
    //  function qui permet de retourné le nombre total de nos produit dans le panier
    public function fullQuantity()
    {
        //  récup le panier stocké en session
        $cart = $this->requestStack->getSession()->get('cart', []);
        //  si le panier n'existe pas qty est 0
        $quantity = 0 ;
        if (!isset($cart)) {
            return $quantity;
        }
        foreach ($cart as $product) {
            // quantity = l'ancienne quantité + le nouveau produit ajouté
            $quantity = $quantity + $product['qty'];
        }
        return $quantity;
    }
    //  function qui permet de retourné le prix total de nos produit dans le panier (avec livraison)
    public function getTotalPrice()
    {
        //  récup le panier stocké en session
        $cart = $this->requestStack->getSession()->get('cart', []);
        //  si le panier n'existe pas le prix est 0
        $price = 0 ;
        if (!isset($cart)) {
            return $price;
        }
        //  je prends la variable vide de $price et je rajoute le prixavecTaxe x le nombre de produits
        foreach ($cart as $product) {
            $price = $price + ($product['object']->getPriceWithTaxe() * $product['qty']);
        }
        return $price;
    }
}
