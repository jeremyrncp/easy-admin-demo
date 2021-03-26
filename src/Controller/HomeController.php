<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use CodeItNow\BarcodeBundle\Utils\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $qrCode = (new QrCode())
            ->setText('https://demo.jeveuxmon.app/scancode')
            ->setSize(300)
            ->setPadding(10)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setImageType(QrCode::IMAGE_TYPE_PNG)
            ->setLabel("SCAN PRODUCT PRICE")
        ;


        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $productRepository->findLastEnabledProducts(3),
            'qrCode' => $qrCode
        ]);
    }
}
