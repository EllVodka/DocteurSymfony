<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\MedecinType;
use App\Form\NewUserMedecinType;
use App\Repository\DocteurRepository;
use App\Repository\RDVRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin")
     */
    public function index(DocteurRepository $docteurRepository, RDVRepository $rDVRepository): Response
    {
        $medecins = $docteurRepository->findAll();
        $nbRdv = $rDVRepository->findNbRdvInCurrentMonth();
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
            'nbRdvs' => $nbRdv
        ]);
    }

    /**
     * @Route("/medecin/{id<\d+>}", name="medecin_view")
     */
    public function view(int $id, DocteurRepository $docteurRepository): Response
    {
        $medecin = $docteurRepository->find($id);
        return $this->render('medecin/view.html.twig', [
            'medecin' => $medecin

        ]);
    }

    /**
     * @Route("/medecinAdd", name="medecin_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $medecin = new Docteur();
        $form = $this->createForm(MedecinType::class, $medecin);

        $manager = $doctrine->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $medecin->setNom("Dr. " . $medecin->getNom());
            $medecin = $form->getData();
            $manager->persist($medecin);
            $manager->flush();
            return $this->redirectToRoute('medecin_view', array("id" => $medecin->getId()));
        }

        return $this->renderForm('medecin/add.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/medecinAdd/{userId}", name="medecin_add_user")
     * @IsGranted("ROLE_MEDECIN")
     */
    public function addByUser(int $userId, ManagerRegistry $doctrine, Request $request, UserRepository $userRepository): Response
    {
        $medecin = new Docteur();
        $manager = $doctrine->getManager();

        $form = $this->createForm(NewUserMedecinType::class, $medecin);
        $form->handleRequest($request);
        $user = $userRepository->find($userId);

        $medecin->setNom("Dr. " . $user->getNom());
        $medecin->setTelephone($user->getTelephone());
        $medecin->setUser($user);

        if ($form->isSubmitted() && $form->isValid()) {
            $medecin = $form->getData();
            $manager->persist($medecin);
            $manager->flush();
            return $this->redirectToRoute('medecin_view', array("id" => $medecin->getId()));
        }

        return $this->render('medecin/new-user.html.twig', [
            'medecinForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{medecinId}", name="medecin_edit")
     * @IsGranted("ROLE_MEDECIN")
     */
    public function edit(int $medecinId, Request $request,  DocteurRepository $docteurRepository): Response
    {
        $medecin = $docteurRepository->find($medecinId);
        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $docteurRepository->add($medecin, true);
            return $this->redirectToRoute('medecin_view', array("id" => $medecin->getId()));
        }

        return $this->render('medecin/edit.html.twig', [
            'form' => $form->createView(),
            'medecin'=>$medecin,
        ]);
    }
}
