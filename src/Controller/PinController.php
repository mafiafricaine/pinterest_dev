<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\PinType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;


class PinController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(PinRepository $repo): Response
    {
        return $this->render('pin/index.html.twig', ['pins' => $repo->findAll()]);
        /*
        return $this->render('pin/index.html.twig', [
            'controller_name' => 'PinController',
        ]);*/
        //return new Response("Hello Julien Dunia");
        //return $this->json(['message' => 'Hello World']);
    }


    /* PHP 8 
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine, PinRepository $repo): Response
    {
        $pin = new Pin;
        $pin->setTitle("Pin 1");
        $pin->setDescription("Description Pin 1");

        $em = $doctrine->getManager();
        $em->persist($pin); 
        $em->flush(); 
        
        return $this->render('pin/index.html.twig', ['pins' => $repo->findAll()]);
    }*/

    /**
     * @Route("/pin/{id<[0-9]+>}", name="app_pin_show", methods="GET")
     */
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', compact('pin'));
    }

    /**
     * @Route("/pin/create", name="app_pin_create", methods= {"GET","POST"})
     */
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $pin = new Pin;
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pin);
            $em->flush();
            $this->addFlash('success', 'Pin successfully created !');
            return $this->redirectToRoute('app_home');
        }
        return $this->render('pin/create.html.twig', ['monForm' => $form->createView()]);
    }






    /**
     * @Route("/pin/{id<[0-9]+>}/edit", name="app_pin_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pin $pin, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Pin successfully updated !'); 
            return $this->redirectToRoute('app_home');
        }

        return $this->render('pin/edit.html.twig', [
            'pin' => $pin,
            'monForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/pin/{id<[0-9]+>}/delete", name="app_pin_delete")
     */
    public function delete(Pin $pin, EntityManagerInterface $em): Response
    {
        $em->remove($pin);
        $em->flush();
        $this->addFlash('info', 'Pin successuly deleted!'); 
        return $this->redirectToRoute('app_home');
    }
}
