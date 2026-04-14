<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    // /home c'est la route et son nom est 'app_home'
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
