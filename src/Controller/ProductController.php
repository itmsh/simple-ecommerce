<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('OMG');
    }

    /**
     * @Route("/تست/{productName}", options={"utf8": true})
     */
    public function show($productName)
    {
        return $this->render('product/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $productName)),
        ]);
    }
} 