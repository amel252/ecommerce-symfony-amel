<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Repository\CategoryRepository;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;
use App\Classe\Cart;

class Extensions extends AbstractExtension implements GlobalsInterface
{
    private $categoryRepository;
    private $cart;

    public function __construct(CategoryRepository $categoryRepository, Cart $cart)
    {
        $this->categoryRepository = $categoryRepository;
        $this->cart = $cart;
    }

    public function getFilters()
    {
        return
        [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];
    }


    // Fonction pour formater le prix avec 2 décimales et le symbole €
    public function formatPrice($num)
    {
        return number_format($num, 2, ',', ' ') . ' €';
    }

    //  function permettant d'afficher toutes les categories
    public function getGlobals(): array
    {
        // Creation de la variable global qu'on peut utiliser partout
        return
        [
         'allCategories' => $this->categoryRepository->findAll(),
         'fullCartQuantity' => $this->cart->fullQuantity(),
        ];
    }
}
