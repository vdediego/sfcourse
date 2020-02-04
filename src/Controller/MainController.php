<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('post/post-listing.html.twig');
    }

    /**
     * @Route("/custom", name="custom")
     */
    public function custom(): Response
    {
        return $this->render('post-listing.html.twig');
    }
}
