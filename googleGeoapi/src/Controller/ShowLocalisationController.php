<?php

namespace App\Controller;

use App\Repository\EventLocalisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowLocalisationController extends AbstractController
{
    private $eventLocalisationRepository;

    public function __construct(EventLocalisationRepository $eventLocalisationRepository)
    {
        $this->eventLocalisationRepository = $eventLocalisationRepository;
    }

    /**
     * @Route("/show/localisation", name="show_localisation")
     */
    public function index()
    {
        return $this->render('show_localisation/index.html.twig');
    }

    /**
     * @Route("/show/localisation/data", name="get_data")
     */
    public function getData(): JsonResponse
    {
        return new JsonResponse(json_encode($this->eventLocalisationRepository->getData()));
    }

    /**
     * @Route("/show/localisation/data/{searchQuery}", name="get_data_by_query")
     */
    public function getDataByQuery($searchQuery): JsonResponse
    {
        return new JsonResponse(json_encode($this->eventLocalisationRepository->getDataByQuery((string)$searchQuery)));
    }

    /**
     * @Route("/show/localisation/event/{id}", name="get_event_details")
     */
    public function getEventDetails($id): Response
    {
        $data = $this->eventLocalisationRepository->getDetailDataById((int)$id);
        return $this->render('detail_localisation/index.html.twig', [
            'data' => $data
        ]);
    }
}
