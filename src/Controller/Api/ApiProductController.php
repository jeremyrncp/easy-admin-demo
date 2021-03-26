<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiProductController extends AbstractController
{
    /**
     * @Route("/api/product/{id}", name="api_product_update", methods={"POST"})
     */
    public function update(Product $product, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['price'])) {
            return JsonResponse::fromJsonString(json_encode(['error' => 'Price must be defined']), Response::HTTP_NOT_FOUND);
        }

        $product->setPrice((float) $data['price']);
        $entityManager->persist($product);
        $entityManager->flush();

        return JsonResponse::fromJsonString(json_encode(['result' => $product->toArray()]), Response::HTTP_OK);
    }

    /**
     * @Route("/api/product/search", name="api_product_search", methods={"GET"})
     */
    public function search(Request $request, ProductRepository $productRepository): Response
    {
        if (!$request->query->has('ean') || strlen($request->query->get('ean')) != 13) {
            return JsonResponse::fromJsonString(json_encode(['error' => 'EAN missing or malformed']), Response::HTTP_BAD_REQUEST);
        }

        $product = $productRepository->findOneBy(['ean' => $request->query->get('ean')]);

        if (is_null($product)) {
            return JsonResponse::fromJsonString(json_encode(['error' => 'Product not exist']), Response::HTTP_NOT_FOUND);
        }

        return JsonResponse::fromJsonString(json_encode(['result' => $product->toArray()]), Response::HTTP_OK);
    }
}
