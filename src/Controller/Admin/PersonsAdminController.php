<?php

namespace App\Controller\Admin;

use App\Entity\Persons;
use App\Form\PersonsType;
use App\manager\PersonService;
use App\Repository\PersonsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/person", name="admin_person_")
 */
class PersonsAdminController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(PersonsRepository $personsRepository): Response
    {
        $persons = $personsRepository->findAll();
        /*if (!$personnes) {
            throw $this->createNotFoundException("Not Found");
        }*/
        return $this->render('admin/persons/list.html.twig', [
            'persons' => $persons,
        ]);
    }
    /**
     * @Route("/create", name="create")
     */
      public function create(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, PersonService $personService) : Response
      {
            $persons = new Persons();
            $form = $this->createForm(PersonsType::class, $persons);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();
                $photoFile = $form->get('photo')->getData();
                $newFilename = $personService->postPhoto($photoFile);
                $persons->setPhoto($newFilename);
                $manager->persist($persons);
                $manager->flush();
                $this->addFlash('message', 'personnel crée avec succés');
                return $this->redirectToRoute('admin_person_list');
            }

            return $this->renderForm('admin/persons/create.html.twig', [
                'form' => $form
            ]);
      }

    /**
     * @Route("/edit/{id}", name="edit", requirements={"id"="\d+"})
     * @return Response
     */
      public function edit(Persons $persons, Request $request, EntityManagerInterface $manager) : Response
      {
          $form = $this->createForm(PersonsType::class, $persons);
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              $data = $form->getData();
              $manager->persist($data);
              $manager->flush();
              $this->addFlash('message', 'Profil mis à jour');
              return $this->redirectToRoute('admin_person_list');
          }
          return $this->renderForm('admin/persons/edit.html.twig', [
              'form' => $form,
              'person' => $persons
          ]);
      }

    /**
     * @Route("/delete/{id}", name="delete", requirements={"id"="\d+"})
     * @param Persons $persons
     * @param EntityManagerInterface $manager
     * @return Response
     */
      public function delete($id, EntityManagerInterface $manager, PersonsRepository $personsRepository) : Response
      {
          $persons = $personsRepository->find($id);
          if ($persons) {
              $manager->remove($persons);
              $manager->flush();
              $this->addFlash('message', 'Profil supprimer avec succès');
          }
          return $this->redirectToRoute('admin_person_list');
      }

    /**
     * @Route("/detail/{id}", name="detail",  requirements={"id"="\d+"})
     * @return Response
     */
      public function detail($id, PersonsRepository $personsRepository) : Response
      {
            $person = $personsRepository->find($id);
         if ($person) {
             return $this->render('/admin/persons/detail.html.twig', [
                 'person' => $person
             ]);
         } else {
//             throw $this->createNotFoundException("Not Found");
             return $this->redirectToRoute("admin_person_list");
         }
      }

    /**
     * @Route("/subordinate/{id}", name="subordinate", requirements={"id"="\d+"})
     * @return void
     */
      public function subordinate(Persons $persons, PersonsRepository $personsRepository)
      {
          $persons = $personsRepository->getSubordinate($persons);
          return $this->render('admin/persons/equipe.html.twig', [
              'persons' => $persons,
          ]);
      }
}
