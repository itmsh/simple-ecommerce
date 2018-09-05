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
    public function suggestions($query,RepositoryManagerInterface $manager, AdapterInterface $cache){
            
        //get from cache
        $item = $cache->getItem('suggestion_'.md5($query));
        if (!$item->isHit()) {

            //find index in elasticsearch
            $finder = $manager->getRepository('App:Product');
            $results = $finder->findHybrid($query);

            $item->set($results);
            $cache->save($item);

            $fromCache = false;
        }else{
            $fromCache = true;
        }
        $results = $item->get();

        
        //making response
        $data = [];
        foreach($results as $value){
            $data[] = $value->getResult()->getHit()['_source'];
        }

        return new JsonResponse([
            'success'=>true,
            'fromCache'=>$fromCache,
            'data'=>$data
        ]);

    }
    
} 