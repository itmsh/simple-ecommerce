<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Cache\Adapter\AdapterInterface;


class ProductController extends AbstractController
{
    /**
     * @Route("/تست/{productName}", options={"utf8": true})
     */
    public function show($productName, AdapterInterface $cache)
    {

        $item = $cache->getItem('markdown_'.md5($productName));
        if (!$item->isHit()) {
            $item->set($productName);
            $cache->save($item);
        }
        $productName = $item->get();

        return $this->render('product/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $productName)),
        ]);
    }
} 