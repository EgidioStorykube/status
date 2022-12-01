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
use Symfony\Component\Validator\Constraints\Length;

use function PHPSTORM_META\type;

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
            $ipStatus = $form->getData();
            $ipStatus->setCreatedAt(new DateTime());
            $ipsStatus->save($ipStatus, true);

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

    #[Route('/ip/status/{ipStatus}/delete', name: 'app_ip_status_delete')]
    public function remove(IpStatus $ipStatus, Request $request, IpStatusRepository $ipsStatus):Response
    {
        $form = $this -> createForm(IpStatusType::class, $ipStatus);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ipStatus = $form->getData();
            $ipsStatus->remove($ipStatus, true);

            //add a flash
            $this->addFlash('success', 'Your Url have been Deleted');

            //redirect
            return $this->redirectToRoute('app_ip_status');
        }

        return $this->renderForm('ip_status/delete.html.twig', [
            'form' => $form,
        ]);

    }



}
