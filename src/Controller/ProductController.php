<?php

namespace App\Controller;

use App\Entity\Product;
use App\Message\NewProduct;
use App\Message\UpdatedProduct;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProductController extends AbstractController
{
    private Serializer $serializer;
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $repository)
    {
        $this->serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $this->productRepository = $repository;
    }

    /**
     * @Route("/products/add", name="products_add", methods={"POST"})
     */
    public function createAction(Request $request): JsonResponse
    {
        $this->dispatchMessage(
            new NewProduct(new Product($request->get('name'), $request->get('ptu'), $request->get('description')))
        );

        return new JsonResponse(['result' => 'ok'], Response::HTTP_OK);
    }

    /**
     * @Route("/products/update/{product}", name="products_update", methods={"POST"})
     */
    public function updateAction(Request $request, Product $product): JsonResponse
    {
        $this->dispatchMessage(new UpdatedProduct($product, [
            'name' => $request->get('name'),
            'ptu' => $request->get('ptu'),
            'description' => $request->get('description'),
        ]));

        return new JsonResponse(['result' => 'ok'], Response::HTTP_OK);
    }

    /**
     * @Route("/products/", name="products_list", methods={"GET"})
     */
    public function listAction(): JsonResponse
    {
        $products = [];
        foreach ($this->productRepository->findAll() as $product) {
            $products[] = $this->serializer->serialize($product, 'json');
        }
        return new JsonResponse($products, Response::HTTP_OK);
    }

    /**
     * @Route("/product/{product}", name="products_single", methods={"GET"})
     */
    public function getSingleAction(Product $product): JsonResponse
    {
        return new JsonResponse($this->serializer->serialize($product, 'json'), Response::HTTP_OK);
    }
}