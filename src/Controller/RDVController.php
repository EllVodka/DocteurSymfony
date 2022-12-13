<?php

namespace App\Controller;

use App\Entity\RDV;
use App\Entity\TypeConsultation;
use App\Form\MedecinType;
use App\Form\RDVFormType;
use App\Repository\DocteurRepository;
use App\Repository\RDVRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\TypeConsultationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/rdv")
 */
class RDVController extends AbstractController
{
    /**
     * @Route("/", name="app_rdv")
     * @IsGranted("ROLE_USER")
     */
    public function index(TypeConsultationRepository $typeConsultationRepository): Response
    {
        return $this->render('rdv/index.html.twig', [
            'typeConsultationRepositorys' => $typeConsultationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/view-all", name="app_rdv_view_all")
     * @IsGranted("ROLE_USER")
     */
    public function viewAll(RDVRepository $rdvRepository): Response
    {
        return $this->render('rdv/viewall.html.twig', [
            'rdvRepository' => $rdvRepository->findBy(['user'=>$this->getUser()]),
        ]);
    }

    /**
     * @Route("/{id<\d+>}", name="app_rdv_view")
     */
    public function view(int $id, RDVRepository $rdvRepository): Response
    {
        $rdv = $rdvRepository->find($id);
        return $this->render('rdv/view.html.twig', [
            'rdv' => $rdv

        ]);
    }

    /**
     * @Route("/add/{idConsult}", name="app_rdv_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(int $idConsult, ManagerRegistry $doctrine, Request $request, TypeConsultationRepository $typeConsult): Response
    {
        $rdv = new RDV();
        $typeC = $typeConsult->find($idConsult);
        $form = $this->createForm(RDVFormType::class, $rdv,['medecins' => $typeC->getMedecin()]);
        $manager = $doctrine->getManager();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $rdv = $form->getData();
            $rdv->setTypeConsultation($typeC);
            $rdv->setUser($this->getUser());
            $manager->persist($rdv);
            $manager->flush();

            return $this->redirectToRoute('app_rdv_view', array("id" => $rdv->getId()));
        }

        return $this->renderForm('rdv/add.html.twig', [
            'form' => $form,
        ]);
    }
}
