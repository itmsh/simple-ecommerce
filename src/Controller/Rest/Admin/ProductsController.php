<?php

namespace App\Controller\Rest\Admin;

use App\Entity\Product;
use App\Entity\Variants;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ProductsController  extends FOSRestController
{
    public function getProductsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $products = $repository->findAll();
        
        $listResult = [];
        foreach($products as $value){
            $listResult[] = array(
                'id'=> $value->getId(),
                'title' => $value->getTitle(),
                'description' => $value->getDescription()
            );
        }

        $view = $this->view($listResult, Response::HTTP_OK);
        return $this->handleView($view);

    } // "get_products"            [GET] /products

    public function postProductsAction(Request $request)
    {
        $product = new Product();
        $product->setTitle($request->get('title'));
        $product->setDescription($request->get('description'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        $view = $this->view($product, Response::HTTP_CREATED);
        return $this->handleView($view);

    } // "post_products"           [POST] /products

    public function putProductAction(int $prodcutId, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($prodcutId);

        $product->setTitle($request->get('title'));
        $product->setDescription($request->get('description'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($product);
        $em->flush();

        $view = $this->view($product, Response::HTTP_OK);
        return $this->handleView($view);

    } // "put_product"             [PUT] /products/{productId}

    public function deleteProductAction($prodcutId)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($prodcutId);

        $em = $this->getDoctrine()->getManager();

        $em->remove($product);
        $em->flush();

        $view = $this->view([], Response::HTTP_NO_CONTENT);
        return $this->handleView($view);

    } // "delete_product"          [DELETE] /products/{prodcutId}

    public function getProductVariantsAction($prodcutId)
    {
        $repository = $this->getDoctrine()->getRepository(Product::class);
        $product = $repository->find($prodcutId);

        $variants = $product->getVariants();

        $listResult = [];
        foreach($variants as $value){
            $listResult[] = array(
                'id'=> $value->getId(),
                'color' => $value->getColor(),
                'price' => $value->getPrice()
            );
        }

        $view = $this->view($listResult, Response::HTTP_OK);
        return $this->handleView($view);

    } // "get_product_variants"    [GET] /products/{prodcutId}/variants

    public function postProductVariantsAction($productId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $product = $em
        ->getRepository(Product::class)
        ->find($productId);

        $variants = new Variants();
        $variants->setProduct($product);
        $variants->setPrice($request->get('price'));
        $variants->setColor($request->get('color'));

        $em->persist($variants);
        $em->flush();

        //TODO: fix this to automatically update elasticsearch
        //force elasticasearch to update index
        $tmpTitle = $product->getTitle();
        $product->setTitle('##*##');
        $em->persist($product);
        $em->flush();
        $product->setTitle($tmpTitle);
        $em->persist($product);
        $em->flush();
        //end force

        $view = $this->view([], Response::HTTP_CREATED);
        return $this->handleView($view);
    } // "post_product_variants"   [POST] /products/{prodcutId}/variants

    public function putProductVariantAction($productId, $variantsId, Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Variants::class);
        $variants = $repository->find($variantsId);

        $variants->setColor($request->get('color'));
        $variants->setPrice($request->get('price'));

        $em = $this->getDoctrine()->getManager();

        $em->persist($variants);
        $em->flush();

        //TODO: fix this to automatically update elasticsearch
        //force elasticasearch to update index
        $tmpTitle = $product->getTitle();
        $product->setTitle('##*##');
        $em->persist($product);
        $em->flush();
        $product->setTitle($tmpTitle);
        $em->persist($product);
        $em->flush();
        //end force

        $view = $this->view([], Response::HTTP_OK);
        return $this->handleView($view);
    } // "put_product_variant"     [PUT] /products/{productId}/variants/{variantsId}

    public function deleteProductVariantAction($productId, $variantsId)
    {
        $repository = $this->getDoctrine()->getRepository(Variants::class);
        $variants = $repository->find($variantsId);

        $em = $this->getDoctrine()->getManager();

        $em->remove($variants);
        $em->flush();

        //TODO: fix this to automatically update elasticsearch
        //force elasticasearch to update index
        $tmpTitle = $product->getTitle();
        $product->setTitle('##*##');
        $em->persist($product);
        $em->flush();
        $product->setTitle($tmpTitle);
        $em->persist($product);
        $em->flush();
        //end force

        $view = $this->view([], Response::HTTP_NO_CONTENT);
        return $this->handleView($view);
    } // "delete_product_variant"  [DELETE] /products/{productId}/variants/{variantsId}

}