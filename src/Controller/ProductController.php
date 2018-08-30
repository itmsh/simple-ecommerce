<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController
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
        return new Response(sprintf(
            'Product name: "%s"',
            $productName
        ));
    }
} 