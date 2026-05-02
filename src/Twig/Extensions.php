<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use App\Repository\CategoryRepository;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class Extensions extends AbstractExtension implements GlobalsInterface
{
    private $categoryRepository;
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        // Creation de la variable global
        return
        [
         'allCategories' => $this->categoryRepository->findAll()
        ];
    }
}
