<?php

namespace App\Controller;

use App\Entity\EventLocalisation;
use App\Form\EventType;
use App\Service\LocalisationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AddLocalisationController extends AbstractController
{
    private $localisationService;

    public function __construct(LocalisationService $localisationService)
    {
        $this->localisationService = $localisationService;
    }

    /**
     * @Route("/add/localisation", name="add_localisation")
     */
    public function index(Request $request)
    {
        $eventLocalisation = new EventLocalisation();
        $form = $this->createForm(EventType::class, $eventLocalisation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->localisationService->handle($form->getData());
            return $this->redirectToRoute('show_localisation');
        }

        return $this->render('add_localisation/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
