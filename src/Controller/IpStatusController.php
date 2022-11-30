<?php

namespace App\Controller;

use DateTime;
use App\Entity\IpStatus;
use App\Form\IpStatusType;
use App\Repository\IpStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IpStatusController extends AbstractController
{
    #[Route('/ip/status', name: 'app_ip_status')]
    public function index(IpStatusRepository $ipsStatus): Response
    {
        return $this->render('ip_status/index.html.twig', [
            'ipsStatus' => $ipsStatus->findAll(),
        ]);
    }
    #[Route('/ip/status/{ipStatus}', name: 'app_ip_status_show')]
    public function showOne(IpStatus $ipStatus): Response
    {

        return $this->render('ip_status/show.html.twig', [
            'ipStatus' => $ipStatus,
        ]);

    }

    #[Route('/ip/status/add', name: 'app_ip_status_add', priority: 2)]
    public function add(Request $request, IpStatusRepository $ipsStatus):Response
    {
        $form = $this -> createForm(IpStatusType::class, new IpStatus());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ipsStatus = $form->getData();
            $ipsStatus->setCreated_at(new DateTime());
            $ipsStatus->save($ipsStatus, true);

            //add a flash
            $this->addFlash('success', 'Your ip have been created');

            //redirect
            return $this->redirectToRoute('app_ip_status');
        }

        return $this->renderForm('ip_status/add.html.twig', [
            'form' => $form,
        ]);

    }

    #[Route('/ip/status/{ipStatus}/edit', name: 'app_ip_status_edit')]
    public function edit(IpStatus $ipStatus, Request $request, IpStatusRepository $ipsStatus):Response
    {
        $form = $this -> createForm(IpStatusType::class, $ipStatus);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ipStatus = $form->getData();
            $ipsStatus->save($ipStatus, true);

            //add a flash
            $this->addFlash('success', 'Your ip have been Updated');

            //redirect
            return $this->redirectToRoute('app_ip_status');
        }

        return $this->renderForm('ip_status/edit.html.twig', [
            'form' => $form,
        ]);

    }


}
