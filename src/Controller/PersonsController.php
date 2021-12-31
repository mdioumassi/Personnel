<?php

namespace App\Controller;

use App\Entity\Persons;
use App\Repository\PersonsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class PersonsController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function listPerso(PersonsRepository $personsRepository)
    {
        $persons = $personsRepository->findAll([], ['created_at' => 'DESC']);
        return $this->render('/persons/index.html.twig', [
            'persons' => $persons
        ]);
    }

    /**
     * @Route("/profile/{id}", name="profile_detail", requirements={"id"="\d+"})
     */
    public function detail(Persons $persons)
    {
        if ($persons) {
            return $this->render('/persons/detail.html.twig', [
                'person' => $persons
            ]);
        }
    }
}
