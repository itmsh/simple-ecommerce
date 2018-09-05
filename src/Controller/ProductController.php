<?php

namespace App\Controller;

use FOS\ElasticaBundle\FOSElasticaBundle;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use FOS\ElasticaBundle\Manager\RepositoryManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductController extends AbstractController
{
    /**
     * @Route("suggestions/{query}", name="suggestions")
     */
    public function suggestions($query,RepositoryManagerInterface $manager){

        $finder = $manager->getRepository('App:Product');                
        $results = $finder->findHybrid($query);

        $data = [];
        foreach($results as $value){
            $data[] = $value->getResult()->getHit()['_source'];
        }

        return new JsonResponse($data);

    }
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