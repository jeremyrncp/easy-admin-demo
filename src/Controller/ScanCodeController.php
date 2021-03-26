<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScanCodeController extends AbstractController
{
    /**
     * @Route("/scancode", name="scan_code")
     */
    public function index(): Response
    {
        return $this->render('scan_code/index.html.twig', [
            'controller_name' => 'ScanCodeController',
        ]);
    }
}
