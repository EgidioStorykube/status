<?php

namespace App\Controller;

use App\Repository\IpStatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IpStatusController extends AbstractController
{
    #[Route('/ip/status', name: 'app_ip_status')]
    public function index(IpStatusRepository $ipStatus): Response
    {
        return $this->render('ip_status/index.html.twig', [
            'ipStatus' => $ipStatus->findAll(),
        ]);
    }
}
