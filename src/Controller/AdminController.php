<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Variants;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/new-product/{title}/{description}", name="admin")
     */
    public function newProduct($title, $description, EntityManagerInterface $em)
    {

        dump($title, $description);

        $product = new Product();

        $product->setTitle($title);

        $product->setDescription($description);

        $em->persist($product);
        $em->flush();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/new-variants/{productId}/{color}/{price}")
     */
    public function newVariants($productId, $color, $price, EntityManagerInterface $em){

        dump($productId, $color, $price);

        $product = $em
        ->getRepository(Product::class)
        ->find($productId);

        $variants = new Variants();

        $variants->setProduct($product)
            ->setColor($color)
            ->setPrice($price);

        $em->persist($variants);
        $em->flush();

        //force elasticasearch to update index
        $tmpTitle = $product->getTitle();
        $product->setTitle('#*#');
        $em->persist($product);
        $em->flush();
        $product->setTitle($tmpTitle);
        $em->persist($product);
        $em->flush();
        //end force

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);


    }

}
