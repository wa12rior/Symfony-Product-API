<?php

namespace App\Controller;

use App\Entity\Product;
use App\Message\NewProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products/add", name="products_add", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        $this->dispatchMessage(
            new NewProduct(new Product($request->get('name'), $request->get('ptu'), $request->get('description')))
        );

        return new JsonResponse();
    }

    /**
     * @Route("/products/update/{product}", name="products_update", methods={"PUT"})
     */
    public function updateAction(Product $product): Response
    {
        $this->dispatchMessage(new NewProduct($product));

        return new JsonResponse();
    }

    /**
     * @Route("/products/", name="products_list", methods={"GET"})
     */
    public function listAction(): Response
    {
        return new JsonResponse();
    }

    /**
     * @Route("/product/{product}", name="products_single", methods={"GET"})
     */
    public function getSingleAction(Product $product): Response
    {
        return new JsonResponse();
    }
}