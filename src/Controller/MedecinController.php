<?php

namespace App\Controller;

use App\Entity\Docteur;
use App\Form\MedecinType;
use App\Repository\DocteurRepository;
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
    public function index(DocteurRepository $docteurRepository): Response
    {
        $medecins = $docteurRepository->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins
        ]);
    }

    /**
     * @Route("/medecin/{id<\d+>}", name="medecin_view")
     */
    public function view(int $id,DocteurRepository $docteurRepository): Response
    {
        $medecin = $docteurRepository->find($id);
        return $this->render('medecin/view.html.twig', [
            'medecin'=>$medecin
            
        ]);
    }

    /**
     * @Route("/medecinAdd", name="medecin_add")
     * @IsGranted("ROLE_USER")
     */
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $medecin = new Docteur();
        $form = $this->createForm(MedecinType::class,$medecin);

        $manager = $doctrine->getManager();  
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $medecin->setNom("Dr. " . $medecin->getNom());
            $medecin = $form->getData();
            $manager->persist($medecin);
            $manager->flush();
            dump($medecin);
            return $this->redirectToRoute('medecin_view',array("id"=> $medecin->getId()));
        }

        return $this->renderForm('medecin/add.html.twig',[
            'form'=> $form
        ]);
    }


}
